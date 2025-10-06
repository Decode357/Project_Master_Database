/**
 * Effect Page Functions
 */

function effectPage() {
    return {
        EffectDetailModal: false,
        CreateEffectModal: false,
        EditEffectModal: false,
        DeleteEffectModal: false,
        effectIdToDelete: null,
        effectToEdit: {},
        itemCodeToDelete: '',
        
        openDetailModal(effect) {
            this.effectToView = JSON.parse(JSON.stringify(effect)); // clone data
            this.EffectDetailModal = true;
        },
        openCreateModal() {
            this.CreateEffectModal = true;
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
window.effectPage = effectPage;