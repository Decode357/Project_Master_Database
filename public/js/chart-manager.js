class ChartManager {
    constructor() {
        this.chart = null;
        this.isDarkMode = false;
        this.init();
    }

    init() {
        // รอให้ DOM โหลดเสร็จ
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        // รอให้ Chart.js โหลดเสร็จ
        this.waitForChart();
        // ติดตาม theme changes
        this.observeThemeChanges();
    }

    waitForChart() {
        const checkChart = () => {
            if (typeof Chart !== 'undefined') {
                console.log('✅ Chart.js loaded, creating chart...');
                this.createChart();
            } else {
                console.log('⏳ Waiting for Chart.js...');
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
        console.log('🎨 Current theme:', this.isDarkMode ? 'dark' : 'light');
        
        return {
            text: this.isDarkMode ? '#e5e7eb' : '#374151',
            grid: this.isDarkMode ? '#4b5563' : '#e5e7eb',
            border: this.isDarkMode ? '#6b7280' : '#d1d5db',
            background: this.isDarkMode ? '#1f2937' : '#ffffff',
        };
    }

    createChart() {
        const ctx = document.getElementById('productChart');
        if (!ctx) {
            console.error('❌ Canvas element not found!');
            return;
        }

        const data = this.getChartData();
        if (!data) {
            console.error('❌ Chart data not found!');
            return;
        }

        const colors = this.getThemeColors();

        // ลบ chart เก่าถ้ามี
        if (this.chart) {
            console.log('🗑️ Destroying previous chart');
            this.chart.destroy();
        }
        
        console.log('📊 Creating new chart...');

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
                        tension: 0.3,
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
                        tension: 0.3,
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
                        tension: 0.3,
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
                        tension: 0.3,
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
                                return  LANG.date + ': ' + context[0].label;
                            }
                        }
                    }
                }
            }
        });

        console.log('✅ Chart created successfully!');
    }

    observeThemeChanges() {
        // ใช้ MutationObserver เพื่อติดตาม class changes บน html element
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    const newIsDark = document.documentElement.classList.contains('dark');
                    if (newIsDark !== this.isDarkMode) {
                        console.log('🌙 Theme changed to:', newIsDark ? 'dark' : 'light');
                        setTimeout(() => this.createChart(), 100);
                    }
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // ฟัง custom events หากมี
        window.addEventListener('themeChanged', () => {
            console.log('🎨 Custom theme event received');
            this.createChart();
        });

        console.log('👀 Theme observer setup complete');
    }

    // Method สำหรับ manual refresh
    refresh() {
        this.createChart();
    }

    // Method สำหรับทำลาย chart
    destroy() {
        if (this.chart) {
            this.chart.destroy();
            this.chart = null;
        }
    }
}

// สร้าง instance และเก็บไว้ใน global scope
window.chartManager = new ChartManager();