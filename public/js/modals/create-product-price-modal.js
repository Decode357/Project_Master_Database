/**
 * Create Shape Modal Functions
 */

function submitProductPriceForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    // Get form element
    const form = document.querySelector('#CreateProductPriceModal form');
    const formElements = form.elements;
    
    // Add all form fields to FormData
    for (let element of formElements) {
        if (element.name && element.type !== 'submit') {
            formData.append(element.name, element.value || '');
        }
    }

    fetch('/product-price', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        // Success
        this.CreateProductPriceModal = false;
        this.errors = {};
        
        // Reset form
        form.reset();
        resetSelect2('#CreateProductPriceModal');

        window.location.reload();
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

// Initialize Create Product Price Modal
function initCreateProductPriceModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateProductPriceModal');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2
                    setTimeout(() => {
                        initializeSelect2('#CreateProductPriceModal');
                    }, 100);
                }
            }
        });
    });

    const modal = document.getElementById('CreateProductPriceModal');
    if (modal) {
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateProductPriceModal);

// Make functions available globally
window.submitProductPriceForm = submitProductPriceForm;
