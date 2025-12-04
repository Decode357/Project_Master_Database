/**
 * Item  Group Page Functions
 */

function itemGroupPage() {
    return {
        CreateItemGroupModal: false,
        EditItemGroupModal: false,
        DeleteItemGroupModal: false,
        itemGroupIdToDelete: null,
        itemGroupToEdit: {},
        itemCodeToDelete: '',
        deleteImage: false,
        currentImage: null,
        imagePreview: null,

        openEditModal(itemGroup) {
            this.itemGroupToEdit = JSON.parse(JSON.stringify(itemGroup));
            this.imagePreview = null;
            this.EditItemGroupModal = true;
            this.deleteImage = false;
            this.currentImage = this.itemGroupToEdit.image;
            this.$nextTick(() => {
                let $modal = $('#EditItemGroupModal');
                let itemGroupToEdit = this.itemGroupToEdit;
                
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    if (itemGroupToEdit[name] !== undefined && itemGroupToEdit[name] !== null) {
                        $this.val(itemGroupToEdit[name]).trigger('change');
                    }

                    $this.on('change', function () {
                        itemGroupToEdit[name] = $(this).val();
                    });
                });
            });
        },

        openCreateModal() {
            this.CreateItemGroupModal = true;
        },

        initSelect2() {
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteItemGroup() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/item-group/${this.itemGroupIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteItemGroupModal = false;
                showToast(data.message || 'รายการถูกลบเรียบร้อยแล้ว', 'success');
                
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            })
            .catch(error => {
                handleAjaxError(error, 'ลบข้อมูล');
            });
        }
    }
}

window.itemGroupPage = itemGroupPage;