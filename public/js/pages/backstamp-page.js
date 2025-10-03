/**
 * Backstamp Page Functions
 */

function backstampPage() {
    return {
        BackstampDetailModal: false,
        CreateBackstampModal: false,
        EditBackstampModal: false,
        DeleteBackstampModal: false,
        backstampIdToDelete: null,
        backstampToEdit: {},
        itemCodeToDelete: '',

        openCreateModal() {
            this.CreateBackstampModal = true;
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
window.backstampPage = backstampPage;