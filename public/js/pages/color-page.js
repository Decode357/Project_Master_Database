/**
 * Color Page Functions
 */

function colorPage() {
    return {
        ColorDetailModal: false,
        CreateColorModal: false,
        EditColorModal: false,
        DeleteColorModal: false,
        colorIdToDelete: null,
        colorToEdit: {},
        itemCodeToDelete: '',
        
        openEditModal(color) {
            // แปลง approval_date format
            if (color.approval_date) {
                const date = new Date(color.approval_date);
                if (!isNaN(date.getTime())) {
                    color.approval_date = date.toISOString().split('T')[0];
                }
            }

            this.colorToEdit = JSON.parse(JSON.stringify(color)); // clone กัน reactive bug
            this.EditColorModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditColorModal');
                let colorToEdit = this.colorToEdit; // เก็บ reference ไว้

                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม colorToEdit
                    if (colorToEdit[name] !== undefined && colorToEdit[name] !== null) {
                        $this.val(colorToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        colorToEdit[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(color) {
            this.colorToView = JSON.parse(JSON.stringify(color)); // clone data
            this.ColorDetailModal = true;
        },
        openCreateModal() {
            this.CreateColorModal = true;
            // Select2 initialization is handled by create-shape-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteColor() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/color/${this.colorIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteColorModal = false;
                
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
window.colorPage = colorPage;