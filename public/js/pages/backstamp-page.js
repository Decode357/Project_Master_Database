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
        newImages: [],
        deletedImages: [],
        openEditModal(backstamp) {
            // แปลง approval_date format
            if (backstamp.approval_date) {
                const date = new Date(backstamp.approval_date);
                if (!isNaN(date.getTime())) {
                    backstamp.approval_date = date.toISOString().split('T')[0];
                }
            }
            
            this.backstampToEdit = JSON.parse(JSON.stringify(backstamp)); // clone กัน reactive bug
            this.newImages = [];
            this.deletedImages = [];
            this.EditBackstampModal = true;
            
            this.$nextTick(() => {
                let $modal = $('#EditBackstampModal');
                let backstampToEdit = this.backstampToEdit; // เก็บ reference ไว้
                
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม backstampToEdit
                    if (backstampToEdit[name] !== undefined && backstampToEdit[name] !== null) {
                        $this.val(backstampToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        backstampToEdit[name] = $(this).val(); // ใช้ backstampToEdit แทน backstamp
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
            this.newImages = [];
            // Select2 initialization is handled by create-shape-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteBackstamp() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/backstamp/${this.backstampIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteBackstampModal = false;
                
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
window.backstampPage = backstampPage;