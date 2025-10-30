// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editBackstampModal', () => ({
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
            formData.append('backstamp_code', this.backstampToEdit.backstamp_code || '');
            formData.append('name', this.backstampToEdit.name || '');
            formData.append('requestor_id', this.backstampToEdit.requestor_id || '');
            formData.append('customer_id', this.backstampToEdit.customer_id || '');
            formData.append('status_id', this.backstampToEdit.status_id || '');
            formData.append('in_glaze', this.backstampToEdit.in_glaze ? '1' : '0');
            formData.append('on_glaze', this.backstampToEdit.on_glaze ? '1' : '0');
            formData.append('under_glaze', this.backstampToEdit.under_glaze ? '1' : '0');
            formData.append('air_dry', this.backstampToEdit.air_dry ? '1' : '0');
            formData.append('organic', this.backstampToEdit.organic ? '1' : '0');
            formData.append('approval_date', this.backstampToEdit.approval_date || '');

            fetch(`/backstamp/${this.backstampToEdit.id}`, {
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
                this.EditBackstampModal = false;
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
            initializeSelect2('#EditBackstampModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditBackstampModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.backstampToEdit) {
                    this.backstampToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.backstampToEdit).forEach(key => {
                $(`#EditBackstampModal select[name="${key}"]`).val(this.backstampToEdit[key]).trigger('change');
            });
        }
    }));
});
