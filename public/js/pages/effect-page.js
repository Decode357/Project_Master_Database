/**
 * Effect Page Functions
 */

function effectPage() {
    return {
        EffectDetailModal: false,
        CreateEffectModal: false,
        EditEffectModal: false,
        DeleteEffectModal: false,
        effectIdToDelete: null,
        effectToEdit: {},
        itemCodeToDelete: '',
        
        openEditModal(effect) {
            // แปลง approval_date format (ถ้ามี)
            if (effect.approval_date) {
                const date = new Date(effect.approval_date);
                if (!isNaN(date.getTime())) {
                    effect.approval_date = date.toISOString().split('T')[0];
                }
            }

            this.effectToEdit = JSON.parse(JSON.stringify(effect)); // clone กัน reactive bug
            
            // เตรียม selectedColors array จาก colors relationship
            this.effectToEdit.selectedColors = [];
            if (effect.colors && Array.isArray(effect.colors)) {
                this.effectToEdit.selectedColors = effect.colors.map(color => color.id.toString());
            }
            
            this.EditEffectModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditEffectModal');
                let effectToEdit = this.effectToEdit; // เก็บ reference ไว้

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
                        if (effectToEdit.selectedColors && effectToEdit.selectedColors.length > 0) {
                            $this.val(effectToEdit.selectedColors).trigger('change');
                        }
                        
                        // sync กลับ Alpine
                        $this.on('change', function () {
                            effectToEdit.selectedColors = $(this).val() || [];
                        });
                    } else {
                        // set ค่า default ตาม effectToEdit สำหรับฟิลด์อื่น
                        if (effectToEdit[name] !== undefined && effectToEdit[name] !== null) {
                            $this.val(effectToEdit[name]).trigger('change');
                        }

                        // sync กลับ Alpine
                        $this.on('change', function () {
                            effectToEdit[name] = $(this).val();
                        });
                    }
                });
            });
        },   
        openDetailModal(effect) {
            this.effectToView = JSON.parse(JSON.stringify(effect)); // clone data
            this.EffectDetailModal = true;
        },
        openCreateModal() {
            this.CreateEffectModal = true;
            // Select2 initialization is handled by create-shape-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteEffect() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/effect/${this.effectIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteEffectModal = false;
                
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
window.effectPage = effectPage;