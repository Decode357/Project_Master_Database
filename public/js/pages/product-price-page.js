/**
 * Product Price Page Functions
 */

function productPricePage() {
    return {
        ProductPriceDetailModal: false,
        CreateProductPriceModal: false,
        EditProductPriceModal: false,
        DeleteProductPriceModal: false,
        productPriceIdToDelete: null,
        productPriceToEdit: {},
        productPriceToView: {},
        itemCodeToDelete: '',

        openEditModal(product_price) {
            // แปลง Effective_date format
            if (product_price.effective_date) {
                const date = new Date(product_price.effective_date);
                if (!isNaN(date.getTime())) {
                    product_price.effective_date = date.toISOString().split('T')[0];
                }
            }
            
            this.productPriceToEdit = JSON.parse(JSON.stringify(product_price)); // clone กัน reactive bug
            this.EditProductPriceModal = true;

            this.$nextTick(() => {
                let $modal = $('#EditProductPriceModal');
                let product_price = this.productPriceToEdit; // เก็บ reference ไว้

                $modal.find('.select2').each(function () {
                    let $this = $(this);
                    let name = $this.attr('name');

                    // init select2 ใหม่ทุกครั้ง
                    $this.select2({
                        dropdownParent: $modal,
                        width: '100%'
                    });

                    // set ค่า default ตาม productPriceToEdit
                    if (product_price[name] !== undefined && product_price[name] != null) {
                        $this.val(product_price[name]).trigger('change');
                    }

                    // sync กลับ Alpine
                    $this.on('change', function () {
                        product_price[name] = $(this).val();
                    });
                });
            });
        },
        openDetailModal(product_price) {
            this.productPriceToView = JSON.parse(JSON.stringify(product_price)); // clone data
            this.ProductPriceDetailModal = true;
        },
        openCreateModal() {
            this.CreateProductPriceModal = true;
            // Select2 initialization is handled by create-product-price-modal.js
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
window.productPricePage = productPricePage;