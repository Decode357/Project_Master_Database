class LanguageManager {
    constructor() {
        this.currentLanguage = localStorage.getItem('language') || 'en';
    }

    setLanguage(lang) {
        if (this.currentLanguage === lang) return;

        localStorage.setItem('language', lang);
        window.location.href = `/language/${lang}`; // reload หน้าใหม่กับ locale ใหม่
    }

    toggle() {
        const newLang = this.currentLanguage === 'th' ? 'en' : 'th';
        this.setLanguage(newLang);
    }

    getCurrentLanguage() {
        return this.currentLanguage;
    }

    getLanguageText() {
        return this.currentLanguage === 'th' ? 'ไทย' : 'ENG';
    }
}

window.languageManager = new LanguageManager();
