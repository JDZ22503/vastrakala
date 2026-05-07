<x-app-layout>
    <div class="admin-dashboard-container">
        <x-slot name="header">
            <div class="admin-header-inline">
                <span class="admin-header-title">
                    Referral Management
                </span>
                <div class="admin-live-badge">
                    <i class="fa-solid fa-gift" style="margin-right: 0.5rem; font-size: 10px;"></i> Prize Tracker
                </div>
            </div>
        </x-slot>

        <div class="admin-dashboard-wrapper">
            <div class="admin-top-content-section" style="width: 100%; max-width: 100%;">
                <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-4">
                 
                    <div class="header-actions">
                        <div class="custom-search-wrapper">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" id="custom-search" class="form-control rounded-pill border-0 shadow-sm" placeholder="Search Coupon, ID or Note...">
                        </div>
                    </div>
                </div>

                <div class="table-container p-0">
                    <table class="table table-hover mb-0 admin-custom-table w-100" id="referrals-table">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">Sharer (IP/ID)</th>
                                <th class="px-3 py-3">Progress</th>
                                <th class="px-3 py-3">Reward Code</th>
                                <th class="px-3 py-3 text-center">Status</th>
                                <th class="px-3 py-3">Admin Notes</th>
                                <th class="px-3 py-3">Redeemed At</th>
                                <th class="px-3 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <style>
        .admin-dashboard-container {
            padding: 2rem 1.5rem;
            background: var(--surface-main);
            min-height: 100vh;
        }
        .admin-dashboard-wrapper {
            width: 100%;
            margin: 0 auto;
        }
        .admin-header-title {
            font-size: 2.5rem;
            font-family: var(--font-heading);
            font-weight: 800;
            color: var(--text-header);
            letter-spacing: -0.5px;
        }
        .admin-section-title {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 2rem;
            color: var(--text-header);
            margin-bottom: 0.25rem;
        }
        .admin-section-subtitle {
            font-weight: 500;
            color: var(--text-muted);
            font-size: 1.1rem;
        }
        .admin-top-content-section {
            background: white;
            border-radius: 40px;
            padding: 3rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--glass-border);
            width: 100%;
        }

        /* Custom Table Styling */
        .admin-custom-table {
            border-collapse: separate;
            border-spacing: 0 15px;
            margin-top: -15px !important;
            width: 100% !important;
        }
        .admin-custom-table thead {
            background: transparent;
        }
        .admin-custom-table th {
            border: none !important;
            color: var(--text-header);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            padding: 1rem !important;
            opacity: 0.5;
            background: transparent !important;
        }

        /* Remove DataTables Sorting Icons */
        table.dataTable thead th.sorting::after,
        table.dataTable thead th.sorting_asc::after,
        table.dataTable thead th.sorting_desc::after,
        table.dataTable thead th.sorting::before,
        table.dataTable thead th.sorting_asc::before,
        table.dataTable thead th.sorting_desc::before {
            display: none !important;
        }

        .admin-custom-table td {
            background: white;
            border-top: 1px solid var(--glass-border) !important;
            border-bottom: 1px solid var(--glass-border) !important;
            vertical-align: middle;
            padding: 1.2rem 1rem !important;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            white-space: nowrap;
        }

        /* Search Wrapper */
        .custom-search-wrapper {
            position: relative;
            min-width: 320px;
        }
        .custom-search-wrapper .search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-main);
            opacity: 0.6;
            z-index: 5;
        }
        .custom-search-wrapper input {
            background: var(--surface-main);
            padding: 0.85rem 1rem 0.85rem 3.2rem;
            font-size: 0.95rem;
            font-weight: 500;
            border: 1px solid var(--glass-border) !important;
            box-shadow: var(--shadow-soft) !important;
        }
        .custom-search-wrapper input:focus {
            background: white !important;
            border-color: var(--accent-main) !important;
            box-shadow: 0 10px 25px rgba(209, 163, 146, 0.15) !important;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_filter { display: none; }
        .dataTables_wrapper .dataTables_length { display: none; }
        
        .dataTables_wrapper .dataTables_info {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            padding-top: 1.5rem !important;
            opacity: 0.7;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem !important;
        }

        .pagination {
            display: flex !important;
            flex-direction: row !important;
            justify-content: flex-end;
            gap: 5px;
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 !important;
        }

        .pagination .page-link {
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: var(--bg-cream) !important;
            color: #916649 !important;
            font-weight: 800 !important;
            padding: 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            font-size: 0.95rem;
            text-decoration: none !important;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent-main) !important;
            color: #996363 !important;
            box-shadow: 0 5px 15px rgba(126, 98, 88, 0.2);
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.4;
            background: transparent;
        }

        /* Premium Buttons */
        .btn-primary-themed {
            background-color: var(--accent-main) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(126, 98, 88, 0.25) !important;
        }
        .btn-primary-themed:hover {
            background-color: var(--text-header) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(126, 98, 88, 0.35) !important;
        }
        .btn-outline-secondary {
            border: 1.5px solid var(--glass-border) !important;
            color: var(--text-muted) !important;
            background: transparent !important;
        }
        .btn-outline-secondary:hover {
            background: var(--bg-cream) !important;
            color: var(--accent-main) !important;
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .admin-note-input {
            border: 1px solid var(--glass-border) !important;
            transition: all 0.3s ease;
        }
        .admin-note-input:focus {
            background: white !important;
            box-shadow: 0 0 0 3px var(--accent-light) !important;
            border-color: var(--accent-main) !important;
        }
        
        /* Badge fixes */
        .badge {
            letter-spacing: 0.5px;
            font-size: 0.7rem !important;
        }
        
        /* Reward code scale */
        code {
            font-family: 'Courier New', Courier, monospace;
        }
    </style>

    <script>
        $(document).ready(function() {
            var table = $('#referrals-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.referrals.index') }}",
                autoWidth: false,
                columns: [
                    { data: 'sharer', name: 'referral_code', width: '15%' },
                    { data: 'progress', name: 'visits_count', searchable: false, width: '15%' },
                    { data: 'reward', name: 'reward_code', width: '15%' },
                    { data: 'status', name: 'is_used', className: 'text-center', width: '10%' },
                    { data: 'note', name: 'admin_note', width: '20%' },
                    { data: 'redeemed', name: 'used_at', width: '15%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-end', width: '10%' }
                ],
                order: [[1, 'desc']], 
                pageLength: 20,
                dom: 'trpi',
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                drawCallback: function() {
                    $('.toggle-claim-btn').off('click').on('click', function() {
                        var sharerId = $(this).data('id');
                        var btn = $(this);
                        
                        $.post("{{ url('ayush-admin/referrals') }}/" + sharerId + "/toggle-used", {
                            _token: "{{ csrf_token() }}"
                        }, function(res) {
                            if(res.success) {
                                table.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Updated',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                            }
                        });
                    });

                    $('.admin-note-input').on('change', function() {
                        var sharerId = $(this).data('id');
                        var note = $(this).val();
                        
                        $.ajax({
                            url: "{{ url('ayush-admin/referrals') }}/" + sharerId + "/update-note",
                            type: 'PATCH',
                            data: {
                                _token: "{{ csrf_token() }}",
                                admin_note: note
                            },
                            success: function(res) {
                                if(res.success) {
                                    Swal.fire({
                                        text: 'Note Saved',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        background: '#FCF8F3'
                                    });
                                }
                            }
                        });
                    });
                }
            });

            // External Custom Search
            $('#custom-search').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</x-app-layout>
