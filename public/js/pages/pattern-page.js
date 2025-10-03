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
        itemCodeToDelete: '',
        
        openCreateModal() {
            this.CreatePatternModal = true;
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
window.patternPage = patternPage;