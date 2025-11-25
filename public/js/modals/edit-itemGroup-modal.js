// Alpine.js component for Edit Modal
document.addEventListener('alpine:init', () => {
    Alpine.data('editItemGroupModal', () => ({
        init() {
            this.$nextTick(() => {
                this.initSelect2();
            });
        },
        
        submitEditForm() {
            const form = document.querySelector('#EditItemGroupModal form');
            const formData = new FormData(form);
            
            this.loading = true;
            this.errors = {};

            formData.append('_method', 'PUT');
            formData.append('item_group_name', this.itemGroupToEdit.item_group_name || '');

            fetch(`/item-group/${this.itemGroupToEdit.id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                return response.json().then(data => Promise.reject(data));
            })
            .then(data => {
                this.EditItemGroupModal = false;
                this.errors = {};
                this.imagePreview = null;
                
                showToast(data.message, 'success');
                
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
            initializeSelect2('#EditItemGroupModal');

            $('#EditItemGroupModal .select2').on('change', (e) => {
                const fieldName = e.target.name;
                if (fieldName && this.itemGroupToEdit) {
                    this.itemGroupToEdit[fieldName] = e.target.value;
                }
            });
        },
        
        updateSelect2Values() {
            Object.keys(this.itemGroupToEdit).forEach(key => {
                $(`#EditItemGroupModal select[name="${key}"]`).val(this.itemGroupToEdit[key]).trigger('change');
            });
        }
    }));
});
