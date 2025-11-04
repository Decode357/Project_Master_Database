/**
 * Glaze Page Functions
 */

function glazePage() {
    return {
        GlazeDetailModal: false,
        CreateGlazeModal: false,
        EditGlazeModal: false,
        DeleteGlazeModal: false,
        glazeIdToDelete: null,
        glazeToEdit: {},
        glazeToView: {},
        itemCodeToDelete: '',
        newImages: [],
        deletedImages: [],
        openEditModal(glaze) {
            // แปลง approval_date format
            if (glaze.approval_date) {
                const date = new Date(glaze.approval_date);
                if (!isNaN(date.getTime())) {
                    glaze.approval_date = date.toISOString().split('T')[0];
                }
            }

            this.glazeToEdit = JSON.parse(JSON.stringify(glaze)); // clone กัน reactive bug
            this.newImages = [];
            this.deletedImages = [];
            this.EditGlazeModal = true;
            
            this.$nextTick(() => {  
                let $modal = $('#EditGlazeModal');      
                let glazeToEdit = this.glazeToEdit; // เก็บ reference ไว้
                
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม glazeToEdit
                    if (glazeToEdit[name] !== undefined && glazeToEdit[name] !== null) {
                        $this.val(glazeToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        glazeToEdit[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(glaze) {
            this.glazeToView = JSON.parse(JSON.stringify(glaze)); // clone data
            this.GlazeDetailModal = true;
        },
        openCreateModal() {
            this.CreateGlazeModal = true;
            this.newImages = [];
            // Select2 initialization is handled by create-glaze-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteGlaze() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/glaze/${this.glazeIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteGlazeModal = false;
                
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
window.glazePage = glazePage;