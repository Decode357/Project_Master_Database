// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editGlazeModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
            });
        },
        handleImageUpload(event) {
            const files = event.target.files;
            if (files) {
                // Add new images while checking file type and size
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        if (file.size <= 5 * 1024 * 1024) { // 5MB limit
                            this.newImages.push(file);
                        } else {
                            showToast('Image file size must be less than 5MB', 'error');
                        }
                    } else {
                        showToast('Please select only image files', 'error');
                    }
                });
            }
            event.target.value = ''; // Reset input
        },

        removeImage(index) {
            const image = this.glazeToEdit.images[index];
            this.deletedImages.push(image.id);
            this.glazeToEdit.images.splice(index, 1);
        },

        removeNewImage(index) {
            this.newImages.splice(index, 1);
        },
        submitEditForm() {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', getCSRFToken());
            formData.append('_method', 'PUT');
            
            // Add all form fields
            Object.keys(this.glazeToEdit).forEach(key => {
                if (key !== 'images') {
                    formData.append(key, this.glazeToEdit[key] || '');
                }
            });
            // Add new images
            this.newImages.forEach((file, index) => {
                formData.append(`new_images[${index}]`, file);
            });

            // Add deleted image IDs
            formData.append('deleted_images', JSON.stringify(this.deletedImages));

            // Add remaining images
            formData.append('existing_images', JSON.stringify(this.glazeToEdit.images));

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
                this.newImages = [];
                this.deletedImages = [];
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
