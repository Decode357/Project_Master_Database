function dashboardPage() {
    document.addEventListener('DOMContentLoaded', function () {
        // โหลด Chart.js library
        if (typeof Chart === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            script.onload = initChart;
            document.head.appendChild(script);
        } else {
            initChart();
        }

        function initChart() {
            const ctx = document.getElementById('productChart');
            if (!ctx) {
                console.error("❌ Canvas with id 'productChart' not found!");
                return;
            }

            // อ่านข้อมูลจาก data attributes
            const chartDataElement = document.getElementById('chart-data');
            if (!chartDataElement) {
                console.error("❌ Chart data element not found!");
                return;
            }

            const dates = JSON.parse(chartDataElement.getAttribute('data-dates') || '[]');
            const shapeCounts = JSON.parse(chartDataElement.getAttribute('data-shape-counts') || '[]');
            const patternCounts = JSON.parse(chartDataElement.getAttribute('data-pattern-counts') || '[]');
            const backstampCounts = JSON.parse(chartDataElement.getAttribute('data-backstamp-counts') || '[]');
            const glazeCounts = JSON.parse(chartDataElement.getAttribute('data-glaze-counts') || '[]');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Shapes',
                            data: shapeCounts,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 4
                        },
                        {
                            label: 'Glazes',
                            data: glazeCounts,
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 4
                        },                        
                        {
                            label: 'Patterns',
                            data: patternCounts,
                            borderColor: '#27a83a',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 4
                        },
                        {
                            label: 'Backstamps',
                            data: backstampCounts,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 4
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: { 
                        x: {
                            ticks: {
                                maxTicksLimit: 10 // จำกัดจำนวน label บนแกน X
                            }
                        },
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return 'Date: ' + context[0].label;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
}

// เรียกใช้ function
dashboardPage();
