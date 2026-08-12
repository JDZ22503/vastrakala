<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateToSupabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-to-supabase {--skip-migrations : Skip running artisan migrate first}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from local MySQL to Supabase PostgreSQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting MySQL to Supabase PostgreSQL Migration...');

        // 1. Check MySQL connection (try mysql_local, fallback to mysql)
        $mysqlConn = 'mysql_local';
        try {
            DB::connection($mysqlConn)->getPdo();
            $this->info('✓ Connected to local MySQL database (mysql_local).');
        } catch (\Exception $e) {
            try {
                $mysqlConn = 'mysql';
                DB::connection($mysqlConn)->getPdo();
                $this->info('✓ Connected to local MySQL database (mysql).');
            } catch (\Exception $e2) {
                $this->error('Failed to connect to local MySQL: ' . $e2->getMessage());
                return 1;
            }
        }

        // 2. Check Supabase Postgres connection
        try {
            DB::connection('pgsql')->getPdo();
            $this->info('✓ Connected to Supabase PostgreSQL database.');
        } catch (\Exception $e) {
            $this->error('Failed to connect to Supabase PostgreSQL: ' . $e->getMessage());
            $this->warn('Tip: If Supabase reports "(ENOTFOUND) tenant/user not found", make sure your Supabase project is UNPAUSED in the Supabase Dashboard and your DB password in .env is correct.');
            return 1;
        }

        // 3. Run migrations on pgsql if requested
        if (!$this->option('skip-migrations')) {
            $this->info('Running migrations on Supabase PostgreSQL connection...');
            $this->call('migrate', ['--database' => 'pgsql', '--force' => true]);
        }

        // 4. Get list of tables from MySQL
        try {
            $tables = Schema::connection($mysqlConn)->getTableListing();
        } catch (\Exception $e) {
            $tables = array_map(function ($t) {
                return array_values((array)$t)[0];
            }, DB::connection($mysqlConn)->select('SHOW TABLES'));
        }

        // Turn off foreign key checks temporarily in pgsql during data load
        DB::connection('pgsql')->statement('SET session_replication_role = \'replica\';');

        foreach ($tables as $rawTableName) {
            // Strip database prefix if present
            $parts = explode('.', $rawTableName);
            $tableName = end($parts);

            if (in_array($tableName, ['migrations'])) {
                continue;
            }

            if (!Schema::connection('pgsql')->hasTable($tableName)) {
                $this->warn("Table '{$tableName}' does not exist on PostgreSQL. Skipping.");
                continue;
            }

            $count = DB::connection($mysqlConn)->table($tableName)->count();
            if ($count === 0) {
                $this->info("Table '{$tableName}' is empty. Skipping data copy.");
                continue;
            }

            $this->info("Migrating table '{$tableName}' ({$count} rows)...");
            
            // Truncate postgres table first to prevent duplicate key errors
            DB::connection('pgsql')->table($tableName)->truncate();

            $query = DB::connection($mysqlConn)->table($tableName);
            if (Schema::connection($mysqlConn)->hasColumn($tableName, 'id')) {
                $query->orderBy('id');
            }

            $query->chunk(500, function ($rows) use ($tableName) {
                $data = json_decode(json_encode($rows), true);
                
                foreach ($data as &$row) {
                    foreach ($row as $col => &$val) {
                        if (is_array($val)) {
                            $val = json_encode($val);
                        }
                    }
                }
                
                DB::connection('pgsql')->table($tableName)->insert($data);
            });

            // Reset sequence ID for Postgres auto-increment columns
            if (Schema::connection('pgsql')->hasColumn($tableName, 'id')) {
                try {
                    $seqQuery = "SELECT setval(pg_get_serial_sequence('{$tableName}', 'id'), COALESCE(MAX(id), 1), true) FROM \"{$tableName}\";";
                    DB::connection('pgsql')->statement($seqQuery);
                } catch (\Exception $seqEx) {
                    // Ignore if not an auto-increment sequence
                }
            }

            $this->info("  ✓ '{$tableName}' migrated successfully.");
        }

        // Re-enable foreign key constraints
        DB::connection('pgsql')->statement('SET session_replication_role = \'origin\';');

        $this->info('🎉 MySQL to Supabase PostgreSQL Migration Completed Successfully!');
        return 0;
    }
}
