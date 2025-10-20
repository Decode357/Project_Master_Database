class ThemeManager {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        // ตั้งค่า theme เริ่มต้น
        this.applyTheme(this.currentTheme);
        
        // ฟัง system preference changes

        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');        mediaQuery.addListener((e) => {
            if (this.currentTheme === 'system') {
                this.applySystemTheme(e.matches);
            }
        });
    }

    applyTheme(theme) {
        const html = document.documentElement;
        const body = document.body;
        
        // ลบ theme classes เดิม
        html.classList.remove('light', 'dark');
        body.classList.remove('light', 'dark');
        
        if (theme === 'system') {
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            this.applySystemTheme(systemDark);
        } else {
            html.classList.add(theme);
            body.classList.add(theme);
        }
        
        this.currentTheme = theme;
        localStorage.setItem('theme', theme);
        
        // Dispatch event สำหรับ components อื่น
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }

    applySystemTheme(isDark) {
        const html = document.documentElement;
        const body = document.body;
        
        html.classList.remove('light', 'dark');
        body.classList.remove('light', 'dark');
        
        const appliedTheme = isDark ? 'dark' : 'light';
        html.classList.add(appliedTheme);
        body.classList.add(appliedTheme);
    }

    toggle() {
        const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
    }

    setTheme(theme) {
        this.applyTheme(theme);
    }

    getCurrentTheme() {
        return this.currentTheme;
    }
}

// Global instance
window.themeManager = new ThemeManager();