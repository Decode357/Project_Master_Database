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

        initSelect2() {
            // Initialize any Select2 elements on page load if needed
            $('.select2').select2({
                width: '100%'
            });
        }
    }
}

// Make function available globally
window.userPage = userPage;