// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editGlazeModal', () => ({
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

            formData.append('glaze_code', this.glazeToEdit.glaze_code || '');
            formData.append('status_id', this.glazeToEdit.status_id || '');
            formData.append('fire_temp', this.glazeToEdit.fire_temp || '');
            formData.append('approval_date', this.glazeToEdit.approval_date || '');
            formData.append('glaze_inside_id', this.glazeToEdit.glaze_inside_id || '');
            formData.append('glaze_outer_id', this.glazeToEdit.glaze_outer_id || '');
            formData.append('effect_id', this.glazeToEdit.effect_id || '');


            fetch(`/glaze/${this.glazeToEdit.id}`, {
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
                this.EditGlazeModal = false;
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
            initializeSelect2('#EditGlazeModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditGlazeModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.glazeToEdit) {
                    this.glazeToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.glazeToEdit).forEach(key => {
                $(`#EditGlazeModal select[name="${key}"]`).val(this.glazeToEdit[key]).trigger('change');
            });
        }
    }));
});
