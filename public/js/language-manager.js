class LanguageManager {
    constructor() {
        // อ่านค่าจาก server ก่อน (จาก meta tag หรือ html lang attribute)
        const serverLocale = document.documentElement.getAttribute('lang') || 'en';
        const storedLanguage = localStorage.getItem('language');
        
        // ถ้า localStorage ไม่มีหรือไม่ตรงกับ server ให้ใช้ค่าจาก server
        if (!storedLanguage || storedLanguage !== serverLocale) {
            this.currentLanguage = serverLocale;
            localStorage.setItem('language', serverLocale);
        } else {
            this.currentLanguage = storedLanguage;
        }    }

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
