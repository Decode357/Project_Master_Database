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

        openEditModal(glaze) {
            // แปลง approval_date format
            if (glaze.approval_date) {
                const date = new Date(glaze.approval_date);
                if (!isNaN(date.getTime())) {
                    glaze.approval_date = date.toISOString().split('T')[0];
                }
            }

            this.glazeToEdit = JSON.parse(JSON.stringify(glaze)); // clone กัน reactive bug
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
window.glazePage = glazePage;