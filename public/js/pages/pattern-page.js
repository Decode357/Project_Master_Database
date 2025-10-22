/**
 * Pattern Page Functions
 */

function patternPage() {
    return {
        PatternDetailModal: false,
        CreatePatternModal: false,
        EditPatternModal: false,
        DeletePatternModal: false,
        patternIdToDelete: null,
        patternToEdit: {},
        patternToView: {},
        itemCodeToDelete: '',

        openEditModal(pattern) {
            // แปลง approval_date format
            if (pattern.approval_date) {
                const date = new Date(pattern.approval_date);
                if (!isNaN(date.getTime())) {
                    pattern.approval_date = date.toISOString().split('T')[0];
                }
            }
            
            this.patternToEdit = JSON.parse(JSON.stringify(pattern)); // clone กัน reactive bug
            this.EditPatternModal = true;
            this.$nextTick(() => {
                let $modal = $('#EditPatternModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม patternToEdit
                    if (pattern[name] !== undefined && pattern[name] !== null) {
                        $this.val(pattern[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        pattern[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(pattern) {
            this.patternToView = JSON.parse(JSON.stringify(pattern)); // clone data
            this.PatternDetailModal = true;
        },
        openCreateModal() {
            this.CreatePatternModal = true;
            // Select2 initialization is handled by create-pattern-modal.js
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deletePattern() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/pattern/${this.patternIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeletePatternModal = false;
                
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
window.patternPage = patternPage;