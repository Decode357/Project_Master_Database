/**
 * Create Shape Modal Functions
 */

function submitPatternForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());

    const form = document.querySelector('#CreatePatternModal form');
    const formElements = form.elements;
    
    for (let element of formElements) {
        if (!element.name || element.type === 'submit') continue;

        if (element.type === 'checkbox') {
            // ส่งค่า "1" ถ้าเลือก, "0" ถ้าไม่เลือก
            formData.set(element.name, element.checked ? "1" : "0");
        } else {
            formData.set(element.name, element.value || '');
        }
    }

    fetch('/pattern', {
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
        this.CreatePatternModal = false;
        this.errors = {};
        
        // Reset form
        form.reset();
        resetSelect2('#CreatePatternModal');
        
        // Show toast notification
        showToast(data.message, 'success');
        
        // Reload page after short delay
        setTimeout(() => {
            window.location.reload();
        }, 300);
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

// Initialize Create Pattern Modal
function initCreatePatternModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreatePatternModal');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2
                    setTimeout(() => {
                        initializeSelect2('#CreatePatternModal');
                    }, 100);
                }
            }
        });
    });
    
    const modal = document.getElementById('CreatePatternModal');
    if (modal) {
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreatePatternModal);

// Make functions available globally
window.submitPatternForm = submitPatternForm;
