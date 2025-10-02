/**
 * Common Modal Functions
 * ใช้ร่วมกันระหว่าง modals ต่างๆ
 */

// Initialize Select2 with common settings
function initializeSelect2(containerSelector, config = {}) {
    const defaultConfig = {
        width: '100%',
    };
    
    const finalConfig = { ...defaultConfig, ...config };
    
    if (containerSelector) {
        finalConfig.dropdownParent = $(containerSelector);
    }
    
    $(`${containerSelector} .select2`).select2(finalConfig);
}

// Reset Select2 values
function resetSelect2(containerSelector) {
    $(`${containerSelector} .select2`).val(null).trigger('change');
}

// Show loading state
function setLoadingState(button, isLoading = true) {
    const loadingText = button.dataset.loadingText || 'Loading...';
    const originalText = button.dataset.originalText || button.textContent;
    
    if (isLoading) {
        button.dataset.originalText = originalText;
        button.textContent = loadingText;
        button.disabled = true;
    } else {
        button.textContent = originalText;
        button.disabled = false;
    }
}

// Handle AJAX errors
function handleAjaxError(error, context = 'operation') {
    console.error(`Error in ${context}:`, error);
    
    if (error.errors) {
        return error.errors;
    } else if (error.message) {
        alert(`เกิดข้อผิดพลาด: ${error.message}`);
    } else {
        alert(`เกิดข้อผิดพลาดในการ${context}`);
    }
    
    return {};
}

// CSRF Token helper
function getCSRFToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.content : '';
}

// Make functions available globally
window.initializeSelect2 = initializeSelect2;
window.resetSelect2 = resetSelect2;
window.setLoadingState = setLoadingState;
window.handleAjaxError = handleAjaxError;
window.getCSRFToken = getCSRFToken;
