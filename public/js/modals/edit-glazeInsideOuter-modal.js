// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    // Edit Glaze Inside Modal
    Alpine.data('editGlazeInsideModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
                this.setSelectedColors();
            });
        },
        
        setSelectedColors() {
            // แปลง colors relationship เป็น array ของ IDs
            if (this.glazeInsideToEdit.colors && Array.isArray(this.glazeInsideToEdit.colors)) {
                this.glazeInsideToEdit.selectedColors = this.glazeInsideToEdit.colors.map(color => color.id.toString());
                
                // Set Select2 values
                setTimeout(() => {
                    $('#EditGlazeInsideModal select[name="colors[]"]').val(this.glazeInsideToEdit.selectedColors).trigger('change');
                }, 100);
            } else {
                this.glazeInsideToEdit.selectedColors = [];
            }
        },
        
        submitEditGlazeInsideForm() {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'PUT');
            
            // Add all form fields
            formData.append('glaze_inside_code', this.glazeInsideToEdit.glaze_inside_code || '');
            
            // Add selected colors
            if (this.glazeInsideToEdit.selectedColors && Array.isArray(this.glazeInsideToEdit.selectedColors)) {
                this.glazeInsideToEdit.selectedColors.forEach(colorId => {
                    formData.append('colors[]', colorId);
                });
            }

            fetch(`/glaze-inside/${this.glazeInsideToEdit.id}`, {
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
                this.EditGlazeInsideModal = false;
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
            initializeSelect2('#EditGlazeInsideModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditGlazeInsideModal select[name="colors[]"]').on('change', (e) => {
                this.glazeInsideToEdit.selectedColors = $(e.target).val() || [];
            });
        }
    }));

    // Edit Glaze Outer Modal
    Alpine.data('editGlazeOuterModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
                this.setSelectedColors();
            });
        },
        
        setSelectedColors() {
            // แปลง colors relationship เป็น array ของ IDs
            if (this.glazeOuterToEdit.colors && Array.isArray(this.glazeOuterToEdit.colors)) {
                this.glazeOuterToEdit.selectedColors = this.glazeOuterToEdit.colors.map(color => color.id.toString());
                
                // Set Select2 values
                setTimeout(() => {
                    $('#EditGlazeOuterModal select[name="colors[]"]').val(this.glazeOuterToEdit.selectedColors).trigger('change');
                }, 100);
            } else {
                this.glazeOuterToEdit.selectedColors = [];
            }
        },
        
        submitEditGlazeOuterForm() {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'PUT');
            
            // Add all form fields
            formData.append('glaze_outer_code', this.glazeOuterToEdit.glaze_outer_code || '');
            
            // Add selected colors
            if (this.glazeOuterToEdit.selectedColors && Array.isArray(this.glazeOuterToEdit.selectedColors)) {
                this.glazeOuterToEdit.selectedColors.forEach(colorId => {
                    formData.append('colors[]', colorId);
                });
            }

            fetch(`/glaze-outer/${this.glazeOuterToEdit.id}`, {
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
                this.EditGlazeOuterModal = false;
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
            initializeSelect2('#EditGlazeOuterModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditGlazeOuterModal select[name="colors[]"]').on('change', (e) => {
                this.glazeOuterToEdit.selectedColors = $(e.target).val() || [];
            });
        }
    }));
});
