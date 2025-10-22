/**
 * Effect Page Functions
 */

function glazeInsideOuterPage() {
    return {
        CreateGlazeInsideModal: false,
        CreateGlazeOuterModal: false,

        EditGlazeInsideModal: false,
        EditGlazeOuterModal: false,

        DeleteGlazeInsideModal: false,
        DeleteGlazeOuterModal: false,

        glazeInsideIdToDelete: null,
        glazeOuterIdToDelete: null,

        glazeInsideToEdit: {},
        glazeOuterToEdit: {},

        itemCodeToDelete: '',
        
        openEditInsideModal(glazeInside) {
            this.glazeInsideToEdit = JSON.parse(JSON.stringify(glazeInside));
            
            // เตรียม selectedColors array จาก colors relationship
            this.glazeInsideToEdit.selectedColors = [];
            if (glazeInside.colors && Array.isArray(glazeInside.colors)) {
                this.glazeInsideToEdit.selectedColors = glazeInside.colors.map(color => color.id.toString());
            }
            
            this.EditGlazeInsideModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditGlazeInsideModal');
                let glazeInsideToEdit = this.glazeInsideToEdit; // เก็บ reference ไว้

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
                        if (glazeInsideToEdit.selectedColors && glazeInsideToEdit.selectedColors.length > 0) {
                            $this.val(glazeInsideToEdit.selectedColors).trigger('change');
                        }
                        
                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeInsideToEdit.selectedColors = $(this).val() || [];
                        });
                    } else {
                        // set ค่า default ตาม glazeInsideToEdit สำหรับฟิลด์อื่น
                        if (glazeInsideToEdit[name] !== undefined && glazeInsideToEdit[name] !== null) {
                            $this.val(glazeInsideToEdit[name]).trigger('change');
                        }

                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeInsideToEdit[name] = $(this).val();
                        });
                    }
                });
            });
        },

        openEditOuterModal(glazeOuter) {
            this.glazeOuterToEdit = JSON.parse(JSON.stringify(glazeOuter));
            
            // เตรียม selectedColors array จาก colors relationship
            this.glazeOuterToEdit.selectedColors = [];
            if (glazeOuter.colors && Array.isArray(glazeOuter.colors)) {
                this.glazeOuterToEdit.selectedColors = glazeOuter.colors.map(color => color.id.toString());
            }
            
            this.EditGlazeOuterModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditGlazeOuterModal');
                let glazeOuterToEdit = this.glazeOuterToEdit; // เก็บ reference ไว้

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
                        if (glazeOuterToEdit.selectedColors && glazeOuterToEdit.selectedColors.length > 0) {
                            $this.val(glazeOuterToEdit.selectedColors).trigger('change');
                        }
                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeOuterToEdit.selectedColors = $(this).val() || [];
                        });
                    } else {
                        // set ค่า default ตาม glazeOuterToEdit สำหรับฟิลด์อื่น
                        if (glazeOuterToEdit[name] !== undefined && glazeOuterToEdit[name] !== null) {
                            $this.val(glazeOuterToEdit[name]).trigger('change');
                        }
                        // sync กลับ Alpine
                        $this.on('change', function () {
                            glazeOuterToEdit[name] = $(this).val();
                        });
                    }
                });
            });
        },
        
        openCreateInsideModal() {
            this.CreateGlazeInsideModal = true;
        },
        
        openCreateOuterModal() {
            this.CreateGlazeOuterModal = true;
        },
        initSelect2() {
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteGlazeInside() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');
            
            fetch(`/glaze-inside/${this.glazeInsideIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteGlazeInsideModal = false;
                
                // ใช้ข้อความจาก response แทนข้อความที่กำหนดเอง
                showToast(data.message || 'รายการถูกลบเรียบร้อยแล้ว', 'success');
                
                setTimeout(() => {
                    window.location.reload();
                }, 300);
            })
            .catch(error => {
                handleAjaxError(error, 'ลบข้อมูล');
            });
        },

        deleteGlazeOuter() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/glaze-outer/${this.glazeOuterIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteGlazeOuterModal = false;

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
window.glazeInsideOuterPage = glazeInsideOuterPage;