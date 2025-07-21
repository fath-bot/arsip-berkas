@extends('components.apps')

@section('title', 'Dashboard')

@section('content')
<div class="main-content" id="mainContent">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang {{ session('user_name', 'Admin') }} </h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
        
        <!-- Stats Cards Row -->
        <div class="row g-3 g-xl-8 mb-4">
            @php
                $stats = [
                    [
                        'count' => $belumDiambil ?? 0,
                        'label' => 'Berkas Belum Diambil',
                        'route' => route('admin.transaksis.index'),
                        'icon' => 'fa-box-open',
                        'color' => 'primary'
                    ],
                    [
                        'count' => $belumDikembalikan ?? 0,
                        'label' => 'Berkas Belum Dikembalikan',
                        'route' => route('admin.transaksis.index'),
                        'icon' => 'fa-exchange-alt',
                        'color' => 'warning'
                    ],
                    [
                        'count' => $sudahDikembalikan ?? 0,
                        'label' => 'Berkas Sudah Dikembalikan',
                        'route' => route('admin.transaksis.index'),
                        'icon' => 'fa-check-circle',
                        'color' => 'success'
                    ],
                    [
                        'count' => $transaksis->count() ?? 0,
                        'label' => 'Total Transaksi',
                        'route' => route('admin.transaksis.index'),
                        'icon' => 'fa-clipboard-list',
                        'color' => 'info'
                    ]
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ $stat['route'] }}" class="card border-left-{{ $stat['color'] }} text-decoration-none hover hover: shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                    {{ $stat['label'] }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['count'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas {{ $stat['icon'] }} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <!-- Charts Row -->
        <div class="row">
            <!-- Transaction Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Peminjaman Berkas</h6>
                    </div>
                    <div class="card-body">
                        <div id="transaksi_chart"></div>
                    </div>
                </div>
            </div>
            
            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Perbandingan Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <canvas id="myPieChart"></canvas>
                        </div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-warning"></i> Belum Dikembalikan
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Sudah Dikembalikan
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-danger"></i> Belum Diambil
                            </span>
                        </div>
                    </div>
                </div>
                <div><br></div>
            </div>
        </div>
    </div>
@endsection

<!-- Scripts -->
     <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            

            // Initialize Transaction Chart (ApexCharts)
            const transactionChartOptions = {
                series: [{
                    name: 'Total Peminjaman',
                    data: {!! json_encode($transaksiChartItems->pluck('count')->toArray()) ?? [] !!}
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                colors: ['#4e73df'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: {!! json_encode($transaksiChartItems->pluck('label')->toArray()) ?? [] !!},
                    labels: {
                        style: {
                            colors: '#6c757d'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#6c757d'
                        }
                    }
                },
                tooltip: {
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        const total = series[seriesIndex][dataPointIndex];
                        const date = w.globals.categoryLabels[dataPointIndex];
                        return `
                            <div class="apexcharts-tooltip-custom">
                                <div class="tooltip-header">${date}</div>
                                <div class="tooltip-body">
                                    <div class="tooltip-item">
                                        <span class="tooltip-label">Total Peminjaman:</span>
                                        <span class="tooltip-value">${total}</span>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                }
            };
            
            const transactionChart = new ApexCharts(
                document.querySelector("#transaksi_chart"), 
                transactionChartOptions
            );
            transactionChart.render();

            // Initialize Pie Chart (Chart.js)
            const pieCtx = document.getElementById('myPieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Belum Dikembalikan', 'Sudah Dikembalikan', 'Belum Diambil'],
                    datasets: [{
                        data: [
                            {{ $belumDikembalikan ?? 0 }},
                            {{ $sudahDikembalikan ?? 0 }},
                            {{ $belumDiambil ?? 0 }}
                        ],
                        backgroundColor: [
                            'rgba(246, 194, 62, 0.8)',
                            'rgba(28, 200, 138, 0.8)',
                            'rgba(231, 74, 59, 0.8)'
                        ],
                        borderColor: [
                            'rgba(246, 194, 62, 1)',
                            'rgba(28, 200, 138, 1)',
                            'rgba(231, 74, 59, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // Handle window resize
            function handleResize() {
                transactionChart.updateOptions({
                    chart: {
                        width: document.querySelector('#transaksi_chart').clientWidth
                    }
                });
            }

            window.addEventListener('resize', function() {
                setTimeout(handleResize, 200);
            });
        });
    </script>