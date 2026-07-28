<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateToPgsql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-to-pgsql {--fresh : Migrate database from scratch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from local MySQL to remote PostgreSQL (Supabase)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting data migration from MySQL to PostgreSQL...');

        // Ensure we can connect to both
        try {
            DB::connection('mysql')->getPdo();
            $this->info('Connected to MySQL successfully.');
            
            DB::connection('pgsql')->getPdo();
            $this->info('Connected to PostgreSQL successfully.');
        } catch (\Exception $e) {
            $this->error('Connection failed: ' . $e->getMessage());
            $this->error('Make sure you have DATABASE_URL set in your .env for the Supabase connection.');
            return 1;
        }

        if ($this->option('fresh')) {
            $this->warn('Running migrations on PostgreSQL...');
            $this->call('migrate:fresh', ['--database' => 'pgsql', '--force' => true]);
        } else {
            $this->warn('Running migrations on PostgreSQL (non-destructive)...');
            $this->call('migrate', ['--database' => 'pgsql', '--force' => true]);
        }

        // Get all tables from MySQL
        $tables = DB::connection('mysql')->select('SHOW TABLES');
        $dbName = DB::connection('mysql')->getDatabaseName();
        $tableKey = 'Tables_in_' . $dbName;

        // Optionally, define tables to skip (e.g. migrations table if you want to keep it fresh, 
        // but actually we just migrated so it exists. It's safe to skip it, but let's copy it anyway).
        $skipTables = [];

        foreach ($tables as $tableObj) {
            // Depending on the PDO driver, the property might just be an array or object property
            // A reliable way is to convert to array and get the first value
            $tableArr = (array) $tableObj;
            $tableName = array_values($tableArr)[0];

            if (in_array($tableName, $skipTables)) {
                continue;
            }

            $this->info("Migrating table: {$tableName}");

            // Count rows for progress
            $totalRows = DB::connection('mysql')->table($tableName)->count();
            if ($totalRows === 0) {
                $this->line(" - Skipped (empty)");
                continue;
            }

            $bar = $this->output->createProgressBar($totalRows);
            $bar->start();

            // Delete existing data in postgres to avoid unique constraint violations
            DB::connection('pgsql')->table($tableName)->delete();

            // Chunk the data to avoid memory exhaustion
            DB::connection('mysql')->table($tableName)->orderByRaw('1')->chunk(500, function ($rows) use ($tableName, $bar) {
                $insertData = [];
                foreach ($rows as $row) {
                    $insertData[] = (array) $row;
                    $bar->advance();
                }

                // Insert into Postgres
                DB::connection('pgsql')->table($tableName)->insert($insertData);
            });

            $bar->finish();
            $this->newLine();

            // After inserting, we MUST update the Postgres sequence for auto-increment columns (usually 'id')
            // Otherwise next inserts will fail with duplicate key errors
            $this->updateSequence($tableName);
        }

        $this->info('Data migration completed successfully!');
        return 0;
    }

    private function updateSequence($tableName)
    {
        // Try to update sequence assuming standard 'id' column and standard sequence name
        try {
            $hasId = Schema::connection('pgsql')->hasColumn($tableName, 'id');
            if ($hasId) {
                $sequenceName = "{$tableName}_id_seq";
                DB::connection('pgsql')->statement("SELECT setval('{$sequenceName}', (SELECT MAX(id) FROM \"{$tableName}\"))");
                $this->line(" - Updated sequence for {$tableName}");
            }
        } catch (\Exception $e) {
            $this->warn(" - Could not update sequence for {$tableName}: " . $e->getMessage());
        }
    }
}
