// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editCustomerModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
            });
        },
        
        submitEditForm() {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'PUT');
            
            // Add all form fields
            formData.append('code', this.customerToEdit.code || '');
            formData.append('name', this.customerToEdit.name || '');
            formData.append('email', this.customerToEdit.email || '');
            formData.append('phone', this.customerToEdit.phone || '');

            fetch(`/customer/${this.customerToEdit.id}`, {
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
                this.EditCustomerModal = false;
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
        },
        
        initSelect2() {
            initializeSelect2('#EditCustomerModal');

            // Sync Select2 changes with Alpine.js
            $('#EditCustomerModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.customerToEdit) {
                    this.customerToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.customerToEdit).forEach(key => {
                $(`#EditCustomerModal select[name="${key}"]`).val(this.customerToEdit[key]).trigger('change');
            });
        }
    }));
});
