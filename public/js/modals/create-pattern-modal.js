window.patternModal = function () {
    return {
        errors: {},
        loading: false,
        
        handleImageUpload(event) {
            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        if (file.size <= 5 * 1024 * 1024) {
                            this.newImages.push(file);
                        } else {
                            showToast('Image file size must be less than 5MB', 'error');
                        }
                    } else {
                        showToast('Please select only image files', 'error');
                    }
                });
            }
            event.target.value = '';
        },
        
        removeNewImage(index) {
            this.newImages.splice(index, 1);
        },

        submitPatternForm(event) {
            this.loading = true;
            this.errors = {};

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'));
            
            const form = event.target;
            const formElements = form.elements;
            for (let element of formElements) {
                if (element.name && element.type !== 'submit') {
                    // จัดการ checkbox แยกต่างหาก
                    if (element.type === 'checkbox') {
                        if (element.checked) {
                            formData.append(element.name, '1');
                        }
                        // ถ้าไม่ checked ก็ไม่ต้องส่งค่าไปเลย
                    } else {
                        formData.append(element.name, element.value || '');
                    }
                }
            }

            this.newImages.forEach((file, index) => {
                formData.append(`new_images[${index}]`, file);
            });

            fetch('/pattern', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) return response.json();
                return response.json().then(data => Promise.reject(data));
            })
            .then(data => {
                this.CreatePatternModal = false;
                this.errors = {};
                this.newImages = [];
                form.reset();
                if (typeof resetSelect2 === 'function') resetSelect2('#CreatePatternModal');
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 300);
            })
            .catch(error => {
                if (error.errors) {
                    this.errors = error.errors;
                } else {
                    showToast(error.message || 'เกิดข้อผิดพลาด', 'error');
                }
            })
            .finally(() => {
                this.loading = false;
            });
        }
    };
};