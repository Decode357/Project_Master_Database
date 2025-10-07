/**
 * Product Page Functions
 */

function productPage() {
    return {
        ProductDetailModal: false,
        CreateProductModal: false,
        EditProductModal: false,
        DeleteProductModal: false,
        productIdToDelete: null,
        productToEdit: {},
        productToView: {},
        itemCodeToDelete: '',

        openEditModal(product) {
            this.productToEdit = JSON.parse(JSON.stringify(product)); // clone กัน reactive bug
            this.EditProductModal = true;
            this.$nextTick(() => {
                let $modal = $('#EditProductModal');
                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม productToEdit
                    if (product[name] !== undefined && product[name] !== null) {
                        $this.val(product[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        product[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(product) {
            this.productToView = JSON.parse(JSON.stringify(product)); // clone data
            this.ProductDetailModal = true;
        },
        openCreateModal() {
            this.CreateProductModal = true;
            // Select2 initialization is handled by create-product-modal.js
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
window.productPage = productPage;