/**
 * Customer Page Functions
 */

function customerPage() {
    return {
        CreateCustomerModal: false,
        EditCustomerModal: false,
        DeleteCustomerModal: false,
        customerIdToDelete: null,
        customerToEdit: {},
        itemCodeToDelete: '',

        openEditModal(customer) {
            this.customerToEdit = JSON.parse(JSON.stringify(customer)); // clone กัน reactive bug
            this.EditCustomerModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditCustomerModal');
                let customerToEdit = this.customerToEdit; // เก็บ reference ไว้
                
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม customerToEdit
                    if (customerToEdit[name] !== undefined && customerToEdit[name] !== null) {
                        $this.val(customerToEdit[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        customerToEdit[name] = $(this).val();
                    });
                });
            });
        },

        openCreateModal() {
            this.CreateCustomerModal = true;
        },
        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        },

        deleteCustomer() {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('_method', 'DELETE');

            fetch(`/customer/${this.customerIdToDelete}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.DeleteCustomerModal = false;
                
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
window.customerPage = customerPage;