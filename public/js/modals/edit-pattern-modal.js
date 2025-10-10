// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editPatternModal', () => ({
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
            formData.append('pattern_code', this.patternToEdit.pattern_code || '');
            formData.append('pattern_name', this.patternToEdit.pattern_name || '');
            formData.append('status_id', this.patternToEdit.status_id || '');
            formData.append('customer_id', this.patternToEdit.customer_id || '');
            formData.append('requestor_id', this.patternToEdit.requestor_id || '');
            formData.append('designer_id', this.patternToEdit.designer_id || '');
            formData.append('duration', this.patternToEdit.duration || '');
            formData.append('approval_date', this.patternToEdit.approval_date || '');
            
            // Boolean fields
            formData.append('in_glaze', this.patternToEdit.in_glaze ? '1' : '0');
            formData.append('on_glaze', this.patternToEdit.on_glaze ? '1' : '0');
            formData.append('under_glaze', this.patternToEdit.under_glaze ? '1' : '0');

            fetch(`/pattern/${this.patternToEdit.id}`, {
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
                this.EditPatternModal = false;
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
            initializeSelect2('#EditPatternModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditPatternModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.patternToEdit) {
                    this.patternToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.patternToEdit).forEach(key => {
                $(`#EditPatternModal select[name="${key}"]`).val(this.patternToEdit[key]).trigger('change');
            });
        }
    }));
});
