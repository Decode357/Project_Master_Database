class ChartManager {
    constructor() {
        this.chart = null;
        this.isDarkMode = false;
        this.currentPeriod = 30;
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        this.waitForChart();
        this.observeThemeChanges();
        this.setupPeriodSelector();
    }

    setupPeriodSelector() {
        const selector = document.getElementById('chart-period');
        if (selector) {
            selector.addEventListener('change', (e) => {
                this.currentPeriod = parseInt(e.target.value);
                this.fetchAndUpdateChart();
            });
        }
    }

    async fetchAndUpdateChart() {
        try {
            const response = await fetch(`/dashboard/chart-data?days=${this.currentPeriod}`);
            const data = await response.json();
            
            const element = document.getElementById('chart-data');
            if (element) {
                element.setAttribute('data-dates', JSON.stringify(data.dates));
                element.setAttribute('data-shape-counts', JSON.stringify(data.shapeCounts));
                element.setAttribute('data-glaze-counts', JSON.stringify(data.glazeCounts));
                element.setAttribute('data-pattern-counts', JSON.stringify(data.patternCounts));
                element.setAttribute('data-backstamp-counts', JSON.stringify(data.backstampCounts));
            }
            
            this.createChart();
        } catch (error) {
            console.error('Error fetching chart data:', error);
        }
    }

    waitForChart() {
        const checkChart = () => {
            if (typeof Chart !== 'undefined') {
                this.createChart();
            } else {
                setTimeout(checkChart, 100);
            }
        };
        checkChart();
    }

    getChartData() {
        const element = document.getElementById('chart-data');
        if (!element) return null;

        return {
            dates: JSON.parse(element.getAttribute('data-dates') || '[]'),
            shapeCounts: JSON.parse(element.getAttribute('data-shape-counts') || '[]'),
            glazeCounts: JSON.parse(element.getAttribute('data-glaze-counts') || '[]'),
            patternCounts: JSON.parse(element.getAttribute('data-pattern-counts') || '[]'),
            backstampCounts: JSON.parse(element.getAttribute('data-backstamp-counts') || '[]'),
        };
    }

    getThemeColors() {
        this.isDarkMode = document.documentElement.classList.contains('dark');
        
        return {
            text: this.isDarkMode ? '#e5e7eb' : '#374151',
            grid: this.isDarkMode ? '#4b5563' : '#e5e7eb',
            border: this.isDarkMode ? '#6b7280' : '#d1d5db',
            background: this.isDarkMode ? '#1f2937' : '#ffffff',
        };
    }

    createChart() {
        const ctx = document.getElementById('productChart');
        if (!ctx) return;

        const data = this.getChartData();
        if (!data) return;

        const colors = this.getThemeColors();

        if (this.chart) {
            this.chart.destroy();
        }

        this.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [
                    {
                        label: LANG.shapes,
                        data: data.shapeCounts,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0,
                        fill: false,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    },
                    {
                        label: LANG.glazes,
                        data: data.glazeCounts,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0,
                        fill: false,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    },
                    {
                        label: LANG.patterns,
                        data: data.patternCounts,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0,
                        fill: false,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    },
                    {
                        label: LANG.backstamps,
                        data: data.backstampCounts,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 2,
                        tension: 0,
                        fill: false,
                        pointRadius: 3,
                        pointHoverRadius: 6
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
                animation: {
                    duration: 100, // ระยะเวลา animation (มิลลิวินาที) ค่าเริ่มต้น = 1000
                    easing: 'easeInOutQuart' // รูปแบบ animation
                },
                scales: {
                    x: {
                        ticks: {
                            color: colors.text,
                            maxTicksLimit: 10
                        },
                        grid: {
                            color: colors.grid
                        },
                        border: {
                            color: colors.border
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: colors.text,
                            stepSize: 1
                        },
                        grid: {
                            color: colors.grid
                        },
                        border: {
                            color: colors.border
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: colors.text,
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: colors.background,
                        titleColor: colors.text,
                        bodyColor: colors.text,
                        borderColor: colors.border,
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            title: function(context) {
                                return LANG.date + ': ' + context[0].label;
                            }
                        }
                    }
                }
            }
        });
    }

    observeThemeChanges() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const newIsDark = document.documentElement.classList.contains('dark');
                    if (newIsDark !== this.isDarkMode) {
                        setTimeout(() => this.createChart(), 100);
                    }
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        window.addEventListener('themeChanged', () => {
            this.createChart();
        });
    }

    refresh() {
        this.createChart();
    }

    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}

window.chartManager = new ChartManager();