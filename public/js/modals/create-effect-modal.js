/**
 * Create Effect Modal Functions
 */

function submitEffectForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    
    // Get form element
    const form = document.querySelector('#CreateEffectModal form');
    const formElements = form.elements;
    
    // Add all form fields to FormData
    for (let element of formElements) {
        if (!element.name || element.type === 'submit') continue;

        if (element.name === 'colors[]') {
            // Handle multiple select for colors
            const selectedOptions = Array.from(element.selectedOptions);
            if (selectedOptions.length > 0) {
                selectedOptions.forEach(option => {
                    formData.append('colors[]', option.value);
                });
            }
            // If no colors selected, don't append anything (nullable)
        } else {
            formData.append(element.name, element.value || '');
        }
    }

    fetch('/effect', {
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
        this.CreateEffectModal = false;
        this.errors = {};
        
        // Reset form
        form.reset();
        resetSelect2('#CreateEffectModal');

        window.location.reload();
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

// Initialize Create Effect Modal
function initCreateEffectModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateEffectModal');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2
                    setTimeout(() => {
                        initializeSelect2('#CreateEffectModal');
                    }, 100);
                }
            }
        });
    });

    const modal = document.getElementById('CreateEffectModal'); // แก้ไข typo
    if (modal) {
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateEffectModal);

// Make functions available globally
window.submitEffectForm = submitEffectForm;
