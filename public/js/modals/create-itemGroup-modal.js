/**
 * Create ItemGroup Modal Functions
 */

function submitItemGroupForm(event) {
    const form = event.target;
    const formData = new FormData(form);
    const context = Alpine.raw(this);
    
    context.loading = true;
    context.errors = {};

    fetch('/item-group', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        context.CreateItemGroupModal = false;
        context.errors = {};
        context.imagePreview = null;
        form.reset();
        
        showToast(data.message, 'success');
        
        setTimeout(() => {
            window.location.reload();
        }, 300);
    })
    .catch(error => {
        context.errors = handleAjaxError(error, 'สร้างข้อมูล');
    })
    .finally(() => {
        context.loading = false;
    });
}

// Initialize Create ItemGroup Modal
function initCreateItemGroupModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateItemGroupModal');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2
                    setTimeout(() => {
                        initializeSelect2('#CreateItemGroupModal');
                    }, 100);
                }
            }
        });
    });

    const modal = document.getElementById('CreateItemGroupModal');
    if (modal) {
        observer.observe(modal, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateItemGroupModal);

// Make functions available globally
window.submitItemGroupForm = submitItemGroupForm;
