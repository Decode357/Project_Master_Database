/**
 * Backstamp Page Functions
 */

function backstampPage() {
    return {
        BackstampDetailModal: false,
        CreateBackstampModal: false,
        EditBackstampModal: false,
        DeleteBackstampModal: false,
        backstampIdToDelete: null,
        backstampToEdit: {},
        backstampToView: {},
        itemCodeToDelete: '',

        openEditModal(backstamp) {
            this.backstampToEdit = JSON.parse(JSON.stringify(backstamp)); // clone กัน reactive bug
            this.EditBackstampModal = true;
            this.$nextTick(() => {
                let $modal = $('#EditBackstampModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม backstampToEdit
                    if (this.backstampToEdit[name] !== undefined && this.backstampToEdit[name] !== null) {
                        $this.val(this.backstampToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        backstamp[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(backstamp) {
            this.backstampToView = JSON.parse(JSON.stringify(backstamp)); // clone data
            this.BackstampDetailModal = true;
        },
        openCreateModal() {
            this.CreateBackstampModal = true;
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
window.backstampPage = backstampPage;