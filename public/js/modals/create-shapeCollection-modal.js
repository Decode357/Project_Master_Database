/**
 * Create ShapeCollection Modal Functions
 */

function submitShapeCollectionForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    
    // Get form element
    const form = document.querySelector('#CreateShapeCollectionModal form');
    const formElements = form.elements;
    
    // Add all form fields to FormData
    for (let element of formElements) {
        if (element.name && element.type !== 'submit') {
            formData.append(element.name, element.value || '');
        }
    }

    fetch('/shape-collection', {
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
        this.CreateShapeCollectionModal = false;
        this.errors = {};
        
        // Reset form
        form.reset();
        resetSelect2('#CreateShapeCollectionModal');

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

// Initialize Create ShapeCollection Modal
function initCreateShapeCollectionModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateShapeCollection    Modal');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2
                    setTimeout(() => {
                        initializeSelect2('#CreateShapeCollectionModal');
                    }, 100);
                }
            }
        });
    });

    const modal = document.getElementById('CreateShapeCollectionModal');
    if (modal) {
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateShapeCollectionModal);

// Make functions available globally
window.submitShapeCollectionForm = submitShapeCollectionForm;
