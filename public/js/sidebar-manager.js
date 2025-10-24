function sidebarManager() {
    return {
        sidebarOpen: false,
        isMobile: window.innerWidth < 768,
        themeIcon: 'light_mode',
        
        init() {
            this.checkScreenSize();
            this.updateThemeIcon();
            window.addEventListener('resize', () => this.checkScreenSize());
            window.addEventListener('themeChanged', () => this.updateThemeIcon());
        },
        
        checkScreenSize() {
            const wasMobile = this.isMobile;
            this.isMobile = window.innerWidth < 768;
            if (wasMobile && !this.isMobile) {
                this.sidebarOpen = false;
                document.body.style.overflow = 'auto';
            }
        },
        
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            if (this.isMobile) {
                document.body.style.overflow = this.sidebarOpen ? 'hidden' : 'auto';
            }
        },
        
        toggleTheme() {
            window.themeManager.toggle();
            this.updateThemeIcon();
        },
        
        toggleLanguage() {
            window.languageManager.toggle();
        },
        
        updateThemeIcon() {
            this.themeIcon = window.themeManager.getCurrentTheme() === 'dark' ? 'dark_mode' : 'light_mode';
        },
        
        get sidebarClass() {
            return this.isMobile ? (this.sidebarOpen ? 'translate-x-0' : '-translate-x-full') : 'translate-x-0';
        },
        
        get headerClass() {
            return this.isMobile ? 'left-0' : 'left-64';
        }
    }
}