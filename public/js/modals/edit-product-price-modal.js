// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('EditProductPriceModal', () => ({
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
            formData.append('price', this.productPriceToEdit.price || '');
            formData.append('tier_id', this.productPriceToEdit.tier_id || '');
            formData.append('currency_id', this.productPriceToEdit.currency_id || '');
            formData.append('effective_date', this.productPriceToEdit.effective_date || '');
            formData.append('product_id', this.productPriceToEdit.product_id || '');
            

            fetch(`/product-price/${this.productPriceToEdit.id}`, {
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
                this.EditProductPriceModal = false;
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
            initializeSelect2('#EditProductPriceModal');

            // Sync Select2 changes with Alpine.js
            $('#EditProductPriceModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.productPriceToEdit) {
                    this.productPriceToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.productPriceToEdit).forEach(key => {
                $(`#EditProductPriceModal select[name="${key}"]`).val(this.productPriceToEdit[key]).trigger('change');
            });
        }
    }));
});
