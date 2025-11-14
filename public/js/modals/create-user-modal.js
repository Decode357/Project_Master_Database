/**
 * Create User Modal Functions
 */

function submitUserForm() {
    // ต้องเข้าถึง Alpine context
    const alpineData = Alpine.$data(document.getElementById('CreateUserForm'));
    
    alpineData.loading = true;
    alpineData.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    
    // Get form element
    const form = document.getElementById('CreateUserForm');
    const formElements = form.elements;
    
    // Add basic form fields (name, email, password)
    for (let element of formElements) {
        if (element.name && element.type !== 'submit' && 
            !element.name.includes('[]') && 
            element.name !== 'role' && 
            !element.name.includes('_id')) {
            formData.append(element.name, element.value || '');
        }
    }

    // เพิ่มข้อมูลจาก AlpineJS
    formData.set('role', alpineData.role || 'user');
    formData.set('department_id', alpineData.newUser.department_id || '');
    formData.set('requestor_id', alpineData.newUser.requestor_id || '');
    formData.set('customer_id', alpineData.newUser.customer_id || '');
    
    // เพิ่ม permissions
    if (alpineData.permissions && alpineData.permissions.length > 0) {
        alpineData.permissions.forEach(permission => {
            formData.append('permissions[]', permission);
        });
    }

    fetch('/user', {
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
        alpineData.CreateUserModal = false;
        alpineData.errors = {};
        
        // Reset form
        form.reset();
        resetSelect2('#CreateUserForm');
        
        // Show toast notification
        showToast(data.message, 'success');
        
        // Reload page after short delay
        setTimeout(() => {
            window.location.reload();
        }, 300);
    })
    .catch(error => {
        alpineData.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        alpineData.loading = false;
    });
}

// Initialize Create User Modal
function initCreateUserModal() {
    // Observer สำหรับดูการเปลี่ยนแปลงของ modal
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.querySelector('[x-show="CreateUserModal"]');
                if (modal && modal.style.display !== 'none') {
                    // Modal เปิด - initialize Select2 พร้อม tags: true
                    setTimeout(() => {
                        // ✅ Destroy old instances first
                        $('#CreateUserForm .select2').each(function() {
                            if ($(this).hasClass('select2-hidden-accessible')) {
                                $(this).select2('destroy');
                            }
                        });
                        
                        // ✅ Init with tags: true
                        $('#CreateUserForm .select2').each(function() {
                            const $this = $(this);
                            $this.select2({
                                tags: true,
                                width: '100%',
                                dropdownParent: $this.closest('.fixed')
                            });
                        });
                        
                        // Sync Select2 กับ Alpine.js
                        $('#CreateUserForm .select2').on('change', function() {
                            const fieldName = this.name;
                            const value = this.value;
                            const alpineData = Alpine.$data(document.getElementById('CreateUserForm'));
                            
                            if (fieldName && alpineData.newUser) {
                                alpineData.newUser[fieldName] = value;
                                console.log(`✅ Updated ${fieldName}: ${value}`);
                            }
                        });
                    }, 100);
                }
            }
        });
    });

    // เฝ้าดู modal container
    const modalContainer = document.querySelector('[x-show="CreateUserModal"]');
    if (modalContainer) {
        observer.observe(modalContainer, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateUserModal);

// Make functions available globally
window.submitUserForm = submitUserForm;
