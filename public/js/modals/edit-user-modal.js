/**
 * Edit User Modal Functions
 */

function submitEditForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    formData.append('_method', 'PUT');
    
    // Add all form fields
    formData.append('name', this.userToEdit.name || '');
    formData.append('email', this.userToEdit.email || '');
    formData.append('role', this.role || 'user');
    formData.append('department_id', this.userToEdit.department_id || '');
    formData.append('requestor_id', this.userToEdit.requestor_id || '');
    formData.append('customer_id', this.userToEdit.customer_id || '');

    // Add permissions
    if (this.permissions && this.permissions.length > 0) {
        this.permissions.forEach(permission => {
            formData.append('permissions[]', permission);
        });
    }

    fetch(`/user/${this.userToEdit.id}`, {
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
        this.EditUserModal = false;
        this.errors = {};
        // Show toast notification
        showToast(data.message, 'success');
        
        // Reload page after short delay
        setTimeout(() => {
            window.location.reload();
        }, 300);
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'อัพเดทข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editUserModal', () => ({
        init() {
            
            this.$nextTick(() => {
                this.initSelect2();
            });
        },
        
        initSelect2() {
            initializeSelect2('#EditUserModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditUserModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.userToEdit) {
                    this.userToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.userToEdit).forEach(key => {
                $(`#EditUserModal select[name="${key}"]`).val(this.userToEdit[key]).trigger('change');
            });
            
        }
    }));
});

// Make functions available globally
window.submitEditForm = submitEditForm;
