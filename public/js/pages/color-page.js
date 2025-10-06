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
        }
    }
}

// Make function available globally
window.colorPage = colorPage;