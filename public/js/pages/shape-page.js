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
        itemCodeToDelete: '',

        openEditModal(shape) {
            this.shapeToEdit = JSON.parse(JSON.stringify(shape)); // clone กัน reactive bug
            this.EditShapeModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditShapeModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
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
            this.CreateShapeModal = true;
            // Select2 initialization is handled by create-shape-modal.js
        },

        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        }
    }
}

// Make function available globally
window.shapePage = shapePage;