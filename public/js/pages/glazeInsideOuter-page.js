/**
 * Effect Page Functions
 */

function glazeInsideOuterPage() {
    return {
        // CreateGlazeInsideOuterModal: false,
        // EditGlazeInsideOuterModal: false,

        DeleteGlazeInsideModal: false,
        DeleteGlazeOuterModal: false,
        glazeInsideIdToDelete: null,
        glazeOuterIdToDelete: null,
        glazeInsideOuterToEdit: {},
        itemCodeToDelete: '',
        
        openEditModal(glazeInsideOuter) {
            // แปลง approval_date format (ถ้ามี)
            if (glazeInsideOuter.approval_date) {
                const date = new Date(glazeInsideOuter.approval_date);
                if (!isNaN(date.getTime())) {
                    glazeInsideOuter.approval_date = date.toISOString().split('T')[0];
                }
            }

            this.glazeInsideOuterToEdit = JSON.parse(JSON.stringify(glazeInsideOuter)); // clone กัน reactive bug

            // เตรียม selectedColors array จาก colors relationship
            this.glazeInsideOuterToEdit.selectedColors = [];
            if (glazeInsideOuter.colors && Array.isArray(glazeInsideOuter.colors)) {
                this.glazeInsideOuterToEdit.selectedColors = glazeInsideOuter.colors.map(color => color.id.toString());
            }
            
            this.EditGlazeInsideOuterModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditGlazeInsideOuterModal');
                let glazeInsideOuterToEdit = this.glazeInsideOuterToEdit; // เก็บ reference ไว้

                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // สำหรับ colors[] ให้ใช้ selectedColors
                    if (name === 'colors[]') {
                        if (glazeInsideOuterToEdit.selectedColors && glazeInsideOuterToEdit.selectedColors.length > 0) {
                            $this.val(glazeInsideOuterToEdit.selectedColors).trigger('change');
                        }
                        
                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeInsideOuterToEdit.selectedColors = $(this).val() || [];
                        });
                    } else {
                        // set ค่า default ตาม glazeInsideOuterToEdit สำหรับฟิลด์อื่น
                        if (glazeInsideOuterToEdit[name] !== undefined && glazeInsideOuterToEdit[name] !== null) {
                            $this.val(glazeInsideOuterToEdit[name]).trigger('change');
                        }

                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeInsideOuterToEdit[name] = $(this).val();
                        });
                    }
                });
            });
        },   
        openCreateModal() {
            this.CreateGlazeInsideOuterModal = true;
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
window.glazeInsideOuterPage = glazeInsideOuterPage;