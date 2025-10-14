// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editEffectModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
                this.setSelectedColors();
            });
        },
        
        setSelectedColors() {
            // แปลง colors relationship เป็น array ของ IDs
            if (this.effectToEdit.colors && Array.isArray(this.effectToEdit.colors)) {
                this.effectToEdit.selectedColors = this.effectToEdit.colors.map(color => color.id.toString());
                
                // Set Select2 values
                $('#EditEffectModal select[name="colors[]"]').val(this.effectToEdit.selectedColors).trigger('change');
            }
        },
        
        submitEditForm() {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'PUT');
            
            // Add all form fields
            formData.append('effect_code', this.effectToEdit.effect_code || '');
            formData.append('effect_name', this.effectToEdit.effect_name || '');
            
            // Add selected colors
            if (this.effectToEdit.selectedColors && Array.isArray(this.effectToEdit.selectedColors)) {
                this.effectToEdit.selectedColors.forEach(colorId => {
                    formData.append('colors[]', colorId);
                });
            }

            fetch(`/effect/${this.effectToEdit.id}`, {
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
                this.EditEffectModal = false;
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
            initializeSelect2('#EditEffectModal');
            
            // Sync Select2 changes with Alpine.js
            $('#EditEffectModal select[name="colors[]"]').on('change', (e) => {
                this.effectToEdit.selectedColors = $(e.target).val() || [];
            });
        },
        
        updateSelect2Values() {
            // Update Select2 values when Alpine data changes
            Object.keys(this.effectToEdit).forEach(key => {
                if (key !== 'selectedColors') {
                    $(`#EditEffectModal select[name="${key}"]`).val(this.effectToEdit[key]).trigger('change');
                }
            });
        }
    }));
});
