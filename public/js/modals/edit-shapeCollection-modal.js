// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editShapeCollectionModal', () => ({
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
            formData.append('collection_code', this.shapeCollectionToEdit.collection_code || '');
            formData.append('collection_name', this.shapeCollectionToEdit.collection_name || '');

            fetch(`/shape-collection/${this.shapeCollectionToEdit.id}`, {
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
                this.EditShapeCollectionModal = false;
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
            initializeSelect2('#EditShapeCollectionModal');

            // Sync Select2 changes with Alpine.js
            $('#EditShapeCollectionModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.shapeCollectionToEdit) {
                    this.shapeCollectionToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.shapeCollectionToEdit).forEach(key => {
                $(`#EditShapeCollectionModal select[name="${key}"]`).val(this.shapeCollectionToEdit[key]).trigger('change');
            });
        }
    }));
});
