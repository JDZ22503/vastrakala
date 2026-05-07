<x-app-layout>


    <div class="admin-dashboard-container">
        <x-slot name="header">
            <div class="admin-header-inline">
                <span class="admin-header-title">
                    Admin Analytics Dashboard
                </span>
                <div class="admin-live-badge">
                    <i class="fa-solid fa-signal" style="margin-right: 0.5rem; font-size: 10px;"></i> Real-time Traffic
                </div>
            </div>
        </x-slot>

        <div class="admin-dashboard-wrapper">
            
            <!-- Dashboard Stats Overview -->
            <div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                <!-- Total Visits -->
                <div class="admin-stat-card admin-stat-primary">
                    <div class="admin-stat-card-icon-bg">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <p class="stat-label" style="color: var(--white-80);">Total Visits</p>
                    <h4 class="stat-value">{{ number_format($totalVisits ?? 0) }}</h4>
                    <div class="stat-footer" style="color: var(--white-60);">
                         <i class="fa-solid fa-database stat-icon"></i> Global Count
                    </div>
                </div>
                
                <!-- Unique Guests -->
                <div class="admin-stat-card admin-stat-secondary">
                    <div class="admin-stat-card-icon-bg">
                        <i class="fa-solid fa-fingerprint"></i>
                    </div>
                    <p class="stat-label">Unique Guests</p>
                    <h4 class="stat-value">{{ number_format($uniqueVisitors ?? 0) }}</h4>
                    <div class="stat-footer" style="color: var(--primary-dark); opacity: 0.5;">
                         <i class="fa-solid fa-user-tag stat-icon"></i> Individual Reach
                    </div>
                </div>
                
                <!-- Visits Today -->
                <div class="admin-stat-card admin-stat-secondary">
                    <div class="admin-stat-card-icon-bg">
                        <i class="fa-solid fa-bolt-lightning"></i>
                    </div>
                    <p class="stat-label">Visits Today</p>
                    <h4 class="stat-value">{{ number_format($todayVisits ?? 0) }}</h4>
                    <div class="stat-footer" style="color: rgba(74,63,53,0.5);">
                         <i class="fa-solid fa-clock-rotate-left stat-icon"></i> Past 24h
                    </div>
                </div>

                <!-- Platform Card -->
                <div class="admin-stat-card admin-stat-secondary cursor-pointer hover:scale-[1.02] active:scale-95 transition-all duration-300" onclick="showIdentityDetails()">
                    <div class="admin-stat-card-icon-bg">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <p class="stat-label">OVERALL DEVICES</p>
                    <h4 class="stat-value" style="font-size: 1.5rem; margin-bottom: 1.5rem; margin-top: 0.5rem; font-weight: 800;">Top Device: {{ $topDevice->device ?? 'Awaiting' }}</h4>
                    <div class="stat-footer" style="color: var(--primary-dark); opacity: 0.5;">
                         <i class="fa-solid fa-microchip stat-icon"></i> TOP PLATFORM: {{ $topOS->os ?? 'Legacy' }}
                    </div>
                </div>

                <!-- Growth Score -->
                <div class="admin-stat-card admin-stat-dark">
                    <div class="admin-stat-card-icon-bg">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p class="stat-label">Brand Popularity</p>
                    <h4 class="stat-value text-white">{{ ceil(($totalVisits ?? 0) / max(1, now()->diffInDays(now()->startOfMonth()))) }}+</h4>
                    <div class="stat-footer" style="color: var(--white-60);">
                         <i class="fa-solid fa-arrow-trend-up stat-icon"></i> Avg. Impact
                    </div>
                </div>
            </div>

            <div class="admin-content-grid">
                <!-- Visitor Trend Chart -->
                <div class="admin-chart-section">
                    <div class="admin-header-inline" style="margin-bottom: 2rem;">
                        <div>
                            <h3 class="admin-section-title">Visitor Engagement</h3>
                            <p class="admin-section-subtitle">
                                Last 7 Days Activity
                            </p>
                        </div>
                    </div>
                    <div class="admin-chart-container">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>

                <!-- Top Performing Content -->
                <div class="admin-top-content-section">
                    <h3 class="admin-section-title" style="margin-bottom: 0.5rem;">Top Content</h3>
                    <p class="admin-section-subtitle" style="margin-bottom: 2.5rem;">Pages winning hearts</p>
                    
                    <div class="admin-pages-list">
                        @forelse(is_iterable($topPages) ? $topPages : [] as $page)
                        @if(is_object($page))
                        <div class="admin-page-item">
                            <div class="admin-page-header">
                                <span class="admin-page-url">
                                    {{ str_replace(url('/'), '', $page->url) ?: 'Homepage' }}
                                </span>
                                <span class="admin-page-views">
                                    {{ number_format($page->total) }} Views
                                </span>
                            </div>
                            <div class="admin-progress-track border-0">
                                <div class="admin-progress-fill" style="width: {{ min(100, ($page->total / max(1, $totalVisits)) * 100) }}%"></div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <div class="admin-empty-state">
                             <i class="fa-solid fa-hourglass-start admin-empty-icon"></i>
                             <p class="admin-empty-text">Awaiting Traffic...</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Management Suite -->
            <div class="admin-management-suite">
                <div class="admin-suite-bg-icon">
                     <i class="fa-solid fa-palette"></i>
                </div>
                
                <div class="admin-suite-content">
                    <h2 class="admin-suite-title">
                        Experience Suite
                    </h2>
                    <p class="admin-suite-subtitle">Master Management Center</p>
                    
                    <div class="admin-suite-grid">
                        @php
                            $actions = [
                                ['route' => 'admin.categories.index', 'icon' => 'fa-layer-group', 'title' => 'Collections', 'desc' => 'Manage product tags', 'cta' => 'Organize Tags'],
                                ['route' => 'admin.testimonials.index', 'icon' => 'fa-comments', 'title' => 'Client Love', 'desc' => 'Customer feedback', 'cta' => 'View Feedback'],
                                ['route' => 'admin.gallery.index', 'icon' => 'fa-images', 'title' => 'Photo Gallery', 'desc' => 'Curate creations', 'cta' => 'Update Library'],
                                ['route' => 'admin.referrals.index', 'icon' => 'fa-gift', 'title' => 'Referrals', 'desc' => 'Track winners & prizes', 'cta' => 'Manage Prizes'],
                                ['route' => 'settings.index', 'icon' => 'fa-sliders', 'title' => 'Core Settings', 'desc' => 'Brand & Socials', 'cta' => 'Adjust Core'],
                            ];
                        @endphp

                        @foreach($actions as $action)
                        <a href="{{ route($action['route']) }}" class="admin-suite-card">
                            <div class="admin-suite-card-icon-bg">
                                <i class="fa-solid {{ $action['icon'] }}"></i>
                            </div>
                            <div class="admin-suite-icon-box">
                                <i class="fa-solid {{ $action['icon'] }}"></i>
                            </div>
                            <h3 class="admin-suite-card-title">{{ $action['title'] }}</h3>
                            <p class="admin-suite-card-desc">{{ $action['desc'] }}</p>
                            
                            <div class="admin-suite-card-cta">
                                {{ $action['cta'] }} <i class="fa-solid fa-chevron-right admin-suite-cta-icon"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Analytics Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function showIdentityDetails() {
            const visitors = {!! json_encode($visitorList ?? []) !!};
            const isMobile = window.innerWidth <= 768;
            
            let html = `
                <div style="max-height: 450px; overflow-y: auto; overflow-x: auto; text-align: left; padding: 5px; -webkit-overflow-scrolling: touch;">
                    <table style="width: 100%; min-width: ${isMobile ? '500px' : 'auto'}; border-collapse: collapse; font-family: 'Outfit', sans-serif;">
                        <thead>
                            <tr style="background: var(--primary); color: var(--white); text-transform: uppercase; font-size: 9px; font-weight: 900; letter-spacing: 1px;">
                                <th style="padding: 10px; border-bottom: 2px solid var(--primary); white-space: nowrap;">USER (ID)</th>
                                <th style="padding: 10px; border-bottom: 2px solid var(--primary); white-space: nowrap;">DEVICE</th>
                                <th style="padding: 10px; border-bottom: 2px solid var(--primary); white-space: nowrap;">PLATFORM</th>
                                <th style="padding: 10px; border-bottom: 2px solid var(--primary); white-space: nowrap;">BROWSER</th>
                                <th style="padding: 10px; border-bottom: 2px solid var(--primary); white-space: nowrap;">LAST SEEN</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            if (visitors.length === 0) {
                html += `<tr><td colspan="5" style="padding: 20px; text-align: center; color: #7E635A; font-weight: 900;">Awaiting new visitors...</td></tr>`;
            } else {
                visitors.forEach(v => {
                    const dateObj = new Date(v.visited_at);
                    const formattedDate = dateObj.toLocaleDateString([], {day: '2-digit', month: '2-digit'}) + ' ' + dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    
                    html += `
                        <tr style="border-bottom: 1px solid rgba(209,163,146,0.1); font-size: 11px; color: #4A3F35; font-weight: bold;">
                            <td style="padding: 10px; font-family: monospace; color: #D1A392; white-space: nowrap;">${v.ip_address}</td>
                            <td style="padding: 10px; white-space: nowrap;">${v.device || 'Desktop'}</td>
                            <td style="padding: 10px; white-space: nowrap;">${v.os || 'Analysing...'}</td>
                            <td style="padding: 10px; white-space: nowrap;">${v.browser || 'Legacy'}</td>
                            <td style="padding: 10px; color: #7E635A; font-size: 10px; white-space: nowrap;">${formattedDate}</td>
                        </tr>
                    `;
                });
            }
            
            html += `</tbody></table></div>`;
            
            Swal.fire({
                title: 'AUDIENCE IDENTITY BREAKDOWN',
                html: html,
                width: isMobile ? '95%' : '850px',
                padding: isMobile ? '10px' : '20px',
                background: 'var(--bg-cream)',
                confirmButtonColor: 'var(--primary-dark)',
                confirmButtonText: 'CLOSE REPORT',
                customClass: {
                    title: 'admin-modal-title',
                    popup: 'admin-modal-rounded'
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const chartElement = document.getElementById('trafficChart');
            if (!chartElement) return;

            const ctx = chartElement.getContext('2d');
            
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(209, 163, 146, 0.4)');
            gradient.addColorStop(1, 'rgba(209, 163, 146, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($days ?? []) !!},
                    datasets: [{
                        label: 'Visitors',
                        data: {!! json_encode($counts ?? []) !!},
                        borderColor: '#D1A392',
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4A403A',
                        pointBorderWidth: 4,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        backgroundColor: gradient,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#4A403A',
                            titleFont: { size: 14, family: 'Playfair Display', weight: 'black' },
                            bodyFont: { size: 12, weight: 'bold' },
                            padding: 15,
                            cornerRadius: 15,
                            displayColors: false,
                            bodySpacing: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(74, 64, 58, 0.05)', drawBorder: false },
                            ticks: { color: '#7E635A', font: { weight: 'bold', size: 11 }, padding: 10 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#7E635A', font: { weight: 'bold', size: 11 }, padding: 10 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
