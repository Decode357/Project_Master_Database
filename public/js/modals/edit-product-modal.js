// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editProductModal', () => ({
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
            formData.append('product_sku', this.productToEdit.product_sku || '');
            formData.append('product_name', this.productToEdit.product_name || '');
            formData.append('product_category_id', this.productToEdit.product_category_id || '');
            formData.append('status_id', this.productToEdit.status_id || '');
            formData.append('shape_id', this.productToEdit.shape_id || '');
            formData.append('glaze_id', this.productToEdit.glaze_id || '');
            formData.append('pattern_id', this.productToEdit.pattern_id || '');
            formData.append('backstamp_id', this.productToEdit.backstamp_id || '');
            formData.append('image_id', this.productToEdit.image_id || '');

            fetch(`/product/${this.productToEdit.id}`, {
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
                this.EditProductModal = false;
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
            initializeSelect2('#EditProductModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditProductModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.productToEdit) {
                    this.productToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.productToEdit).forEach(key => {
                $(`#EditProductModal select[name="${key}"]`).val(this.productToEdit[key]).trigger('change');
            });
        }
    }));
});
