/**
 * Shape Page Functions
 */

function shapePage() {
    return {
        ShapeDetailModal: false,
        CreateShapeModal: false,
        EditShapeModal: false,
        DeleteShapeModal: false,
        shapeIdToDelete: null,
        shapeToEdit: {},
        shapeToView: {},
        itemCodeToDelete: '',
        newImages: [],
        deletedImages: [],
        openEditModal(shape) {
            this.shapeToEdit = JSON.parse(JSON.stringify(shape)); // clone กัน reactive bug
            this.newImages = [];
            this.deletedImages = [];
            this.EditShapeModal = true;
            this.$nextTick(() => {
                let $modal = $('#EditShapeModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        tags: true,
                        width: '100%'
                    });

                    // set ค่า default ตาม shapeToEdit
                    if (shape[name] !== undefined && shape[name] !== null) {
                        $this.val(shape[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        shape[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(shape) {
            this.shapeToView = JSON.parse(JSON.stringify(shape)); // clone data
            this.ShapeDetailModal = true;
        },
        openCreateModal() {
            this.newImages = [];
            this.CreateShapeModal = true;
            // Select2 initialization is handled by create-shape-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                tags: true,
                width: '100%'
            });
        },

        deleteShape() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');
            
            fetch(`/shape/${this.shapeIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteShapeModal = false;
                
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
window.shapePage = shapePage;