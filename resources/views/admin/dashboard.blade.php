@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <!-- User Stats (if available) -->
        @if(isset($user))
        <div class="mb-6">
            @foreach($transaksiChartItems as $item)
                @if($item['user_name'] == $user->name)
                <div class="d-flex align-items-center bg-light-primary rounded p-4 mb-2">
                    <span class="fw-bold me-2">{{ $item['label'] ?? 'No label' }}:</span>
                    <span class="badge badge-light-success">{{ $item['count'] ?? 0 }}</span>
                </div>
                @endif
            @endforeach
        </div>
        @endif

        <!-- Main Content Area -->
        <div class="md:ml-64 p-4">
            <!-- Stats Cards Row -->
            <div class="row g-5 g-xl-8 mb-6">
                <!-- Peminjaman Berkas Card -->
                <div class="col-xl-4">
                    <a href="{{ route('admin.transaksis.index') }}" class="card bg-primary hoverable card-xl-stretch mb-xl-8 h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-5">
                                <span class="svg-icon svg-icon-white svg-icon-3x me-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="currentColor" />
                                        <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="currentColor" />
                                        <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="currentColor" />
                                        <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="currentColor" />
                                    </svg>
                                </span>
                                <div class="d-flex flex-column">
                                    <span class="text-white fw-bolder fs-2">{{ $transaksiCount }}</span>
                                    <span class="text-white-50 fw-bold fs-6">Data Peminjaman Berkas</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Chart Section -->
                <div class="col-xl-8">
                    <div class="card h-100">
                        <div class="card-header border-0 pt-6">
                            <h3 class="card-title fw-bold">Grafik Peminjaman Berkas</h3>
                        </div>
                        <div class="card-body pt-0 d-flex flex-column">
                            @php
                                $count4 = $transaksiChartItems[4]['count'] ?? 0;
                                $count5 = $transaksiChartItems[5]['count'] ?? 0;
                                
                                if ($count5 >= $count4) {
                                    $color = 'success';
                                    if ($count5 > 0) {
                                        $percentage = 100 - ($count4 / $count5) * 100;
                                    } else {
                                        $percentage = 0;
                                    }
                                    
                                    if ($percentage == 0) {
                                        $color = 'warning';
                                    }
                                } else {
                                    $color = 'danger';
                                    $percentage = 100 - ($count5 / $count4) * 100;
                                }
                                
                                $value = $transaksiChartItems->get(5)['count'] ?? 0;
                            @endphp

                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
                                <div class="d-flex flex-column">
                                    <span class="fs-3 fw-bold text-gray-800">{{ number_format($value    ) }}</span>
                                    <span class="fs-6 text-gray-400">Peminjaman Arsip Bulan Ini</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-light-{{ $color }} fs-base">
                                        @if($color == 'success')
                                        <span class="svg-icon svg-icon-5 svg-icon-{{ $color }} me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        @else
                                        <span class="svg-icon svg-icon-5 svg-icon-{{ $color }} me-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        @endif
                                        {{ round($percentage, 2) }}%
                                    </span>
                                </div>
                            </div>

                            <div id="transaksi_chart" style="height: 300px; min-height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chart data
        var chartData = {!! json_encode($transaksiChartItems->pluck('count')->toArray()) !!};
        var chartLabels = {!! json_encode($transaksiChartItems->pluck('label')->toArray()) !!};

        // Chart element
        var chartElement = document.getElementById("transaksi_chart");
        var chartHeight = parseInt(KTUtil.css(chartElement, "height"));
        
        // Colors
        var textColor = KTUtil.getCssVariableValue("--bs-gray-500");
        var gridColor = KTUtil.getCssVariableValue("--bs-gray-200");
        var primaryColor = KTUtil.getCssVariableValue("--bs-info");
        var lightPrimaryColor = KTUtil.getCssVariableValue("--bs-light-info");

        // Chart options
        var options = {
            series: [{
                name: 'Peminjaman',
                data: chartData
            }],
            chart: {
                fontFamily: "inherit",
                type: "area",
                height: chartHeight,
                toolbar: {
                    show: true
                },
                locales: [{
                    name: 'id',
                    options: {
                        months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                        shortMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                        days: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                        shortDays: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        toolbar: {
                            download: 'Unduh SVG',
                            selection: 'Seleksi',
                            selectionZoom: 'Zoom Seleksi',
                            zoomIn: 'Perbesar',
                            zoomOut: 'Perkecil',
                            pan: 'Geser',
                            reset: 'Atur Ulang Zoom'
                        }
                    }
                }],
                defaultLocale: 'id'
            },
            plotOptions: {},
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: "solid",
                opacity: 1
            },
            stroke: {
                curve: "smooth",
                show: true,
                width: 3,
                colors: [primaryColor]
            },
            xaxis: {
                categories: chartLabels,
                labels: {
                    style: {
                        colors: textColor,
                        fontSize: "12px"
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    position: "front",
                    stroke: {
                        color: primaryColor,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: void 0,
                    offsetY: 0,
                    style: {
                        fontSize: "12px"
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: textColor,
                        fontSize: "12px"
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: "none",
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: "none",
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: "none",
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: "12px"
                },
                y: {
                    formatter: function(value) {
                        return value;
                    }
                }
            },
            colors: [lightPrimaryColor],
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: primaryColor,
                strokeWidth: 3
            }
        };

        // Initialize chart
        var chart = new ApexCharts(chartElement, options);
        chart.render();
    });
</script>
@endsection