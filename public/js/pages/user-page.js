/**
 * User Page Functions
 */

function userPage() {
    return {
        CreateUserModal: false,
        DeleteUserModal: false,
        EditUserModal: false,
        userIdToDelete: null,
        userNameToDelete: '',
        userToEdit: {},
        role: 'user',
        permissions: ['view'],

        openEditModal(user) {
            console.log('📦 user received:', user);
            this.role = user.roles?.[0]?.name || 'user';
            this.permissions = user.userPermissions || ['view'];
            this.userToEdit = JSON.parse(JSON.stringify(user)); // clone กัน reactive bug
            // ลบ password เก่าออก (ไม่ให้แสดงในฟิลด์)
            delete this.userToEdit.password;
            
            this.EditUserModal = true;
            this.$nextTick(() => {
                let $modal = $('#EditUserModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม user
                    if (user[name] !== undefined && user[name] !== null) {
                        $this.val(user[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        user[name] = $(this).val();
                    });
                });
            });
        },

        openCreateModal() {
            this.CreateUserModal = true;
            // Select2 initialization is handled by create-shape-modal.js
        },
        
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteUser() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/user/${this.userIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteUserModal = false;
                
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
window.userPage = userPage;