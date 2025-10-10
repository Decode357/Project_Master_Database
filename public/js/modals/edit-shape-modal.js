// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editShapeModal', () => ({
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
            formData.append('item_code', this.shapeToEdit.item_code || '');
            formData.append('item_description_thai', this.shapeToEdit.item_description_thai || '');
            formData.append('item_description_eng', this.shapeToEdit.item_description_eng || '');
            formData.append('shape_type_id', this.shapeToEdit.shape_type_id || '');
            formData.append('status_id', this.shapeToEdit.status_id || '');
            formData.append('shape_collection_id', this.shapeToEdit.shape_collection_id || '');
            formData.append('process_id', this.shapeToEdit.process_id || '');
            formData.append('item_group_id', this.shapeToEdit.item_group_id || '');
            formData.append('customer_id', this.shapeToEdit.customer_id || '');
            formData.append('requestor_id', this.shapeToEdit.requestor_id || '');
            formData.append('designer_id', this.shapeToEdit.designer_id || '');
            formData.append('volume', this.shapeToEdit.volume || '');
            formData.append('weight', this.shapeToEdit.weight || '');
            formData.append('long_diameter', this.shapeToEdit.long_diameter || '');
            formData.append('short_diameter', this.shapeToEdit.short_diameter || '');
            formData.append('height_long', this.shapeToEdit.height_long || '');
            formData.append('height_short', this.shapeToEdit.height_short || '');
            formData.append('body', this.shapeToEdit.body || '');
            formData.append('approval_date', this.shapeToEdit.approval_date || '');

            fetch(`/shape/${this.shapeToEdit.id}`, {
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
                this.EditShapeModal = false;
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
            initializeSelect2('#EditShapeModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditShapeModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.shapeToEdit) {
                    this.shapeToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.shapeToEdit).forEach(key => {
                $(`#EditShapeModal select[name="${key}"]`).val(this.shapeToEdit[key]).trigger('change');
            });
        }
    }));
});
