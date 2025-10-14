// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editColorModal', () => ({
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
            formData.append('color_code', this.colorToEdit.color_code || '');
            formData.append('color_name', this.colorToEdit.color_name || '');
            formData.append('customer_id', this.colorToEdit.customer_id || '');

            fetch(`/color/${this.colorToEdit.id}`, {
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
                this.EditColorModal = false;
                this.errors = {};
                window.location.reload();
            })
            .catch(error => {
                this.errors = handleAjaxError(error, 'อัพเดทข้อมูล');
            })
            .finally(() => {
                this.loading = false;
            });
        },
        
        initSelect2() {
            initializeSelect2('#EditColorModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditColorModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.colorToEdit) {
                    this.colorToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.colorToEdit).forEach(key => {
                $(`#EditColorModal select[name="${key}"]`).val(this.colorToEdit[key]).trigger('change');
            });
        }
    }));
});
