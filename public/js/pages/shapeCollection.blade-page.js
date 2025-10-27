/**
 * Shape Page Functions
 */

function shapeCollectionPage() {
    return {
        CreateShapeCollectionModal: false,
        EditShapeCollectionModal: false,
        DeleteShapeCollectionModal: false,
        shapeCollectionIdToDelete: null,
        shapeCollectionToEdit: {},
        itemCodeToDelete: '',

        openEditModal(shapeCollection) {
            this.shapeCollectionToEdit = JSON.parse(JSON.stringify(shapeCollection)); // clone กัน reactive bug
            this.EditShapeCollectionModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditShapeCollectionModal');
                let shapeCollectionToEdit = this.shapeCollectionToEdit; // เก็บ reference ไว้
                
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม shapeCollectionToEdit
                    if (shapeCollectionToEdit[name] !== undefined && shapeCollectionToEdit[name] !== null) {
                        $this.val(shapeCollectionToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        shapeCollectionToEdit[name] = $(this).val();
                    });
                });
            });
        },

        openCreateModal() {
            this.CreateShapeCollectionModal = true;
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteShapeCollection() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/shape-collection/${this.shapeCollectionIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteShapeCollectionModal = false;
                
                // ใช้ข้อความจาก response แทนข้อความที่กำหนดเอง
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

// Make function available globally
window.shapeCollectionPage = shapeCollectionPage;