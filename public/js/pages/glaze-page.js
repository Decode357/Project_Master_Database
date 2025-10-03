/**
 * Glaze Page Functions
 */

function glazePage() {
    return {
        GlazeDetailModal: false,
        CreateGlazeModal: false,
        EditGlazeModal: false,
        DeleteGlazeModal: false,
        glazeIdToDelete: null,
        glazeToEdit: {},
        itemCodeToDelete: '',

        openCreateModal() {
            this.CreateGlazeModal = true;
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
window.glazePage = glazePage;