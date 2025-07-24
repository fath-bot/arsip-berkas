<!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const footer = document.querySelector('.footer');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            function toggleSidebar() {
                sidebar.classList.toggle('sidebar-collapsed');
                mainContent.classList.toggle('main-content-collapsed');
                footer.classList.toggle('footer-collapsed');
            }
            
            sidebarToggle.addEventListener('click', toggleSidebar);

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
                    labels: ['di pinjam', 'Sudah Dikembalikan', 'Belum Diambil'],
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