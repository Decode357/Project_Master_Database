/**
 * Create GlazeInside Modal Functions
 */

function submitGlazeInsideForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    
    const form = document.querySelector('#CreateGlazeInsideModal form');
    const formElements = form.elements;
    
    for (let element of formElements) {
        if (!element.name || element.type === 'submit') continue;

        if (element.name === 'colors[]') {
            const selectedOptions = Array.from(element.selectedOptions);
            if (selectedOptions.length > 0) {
                selectedOptions.forEach(option => {
                    formData.append('colors[]', option.value);
                });
            }
        } else {
            formData.append(element.name, element.value || '');
        }
    }

    fetch('/glaze-inside', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        this.CreateGlazeInsideModal = false;
        this.errors = {};
        form.reset();
        resetSelect2('#CreateGlazeInsideModal');
        window.location.reload();
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

/**
 * Create GlazeOuter Modal Functions
 */

function submitGlazeOuterForm() {
    this.loading = true;
    this.errors = {};

    const formData = new FormData();
    formData.append('_token', getCSRFToken());
    
    const form = document.querySelector('#CreateGlazeOuterModal form');
    const formElements = form.elements;
    
    for (let element of formElements) {
        if (!element.name || element.type === 'submit') continue;

        if (element.name === 'colors[]') {
            const selectedOptions = Array.from(element.selectedOptions);
            if (selectedOptions.length > 0) {
                selectedOptions.forEach(option => {
                    formData.append('colors[]', option.value);
                });
            }
        } else {
            formData.append(element.name, element.value || '');
        }
    }

    fetch('/glaze-outer', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        this.CreateGlazeOuterModal = false;
        this.errors = {};
        form.reset();
        resetSelect2('#CreateGlazeOuterModal');
        window.location.reload();
    })
    .catch(error => {
        this.errors = handleAjaxError(error, 'บันทึกข้อมูล');
    })
    .finally(() => {
        this.loading = false;
    });
}

// Initialize Create Modals
function initCreateGlazeInsideOuterModals() {
    // Observer สำหรับ GlazeInside Modal
    const observerInside = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateGlazeInsideModal');
                if (modal && modal.style.display !== 'none') {
                    setTimeout(() => {
                        initializeSelect2('#CreateGlazeInsideModal');
                    }, 100);
                }
            }
        });
    });

    // Observer สำหรับ GlazeOuter Modal
    const observerOuter = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const modal = document.getElementById('CreateGlazeOuterModal');
                if (modal && modal.style.display !== 'none') {
                    setTimeout(() => {
                        initializeSelect2('#CreateGlazeOuterModal');
                    }, 100);
                }
            }
        });
    });

    const modalInside = document.getElementById('CreateGlazeInsideModal');
    const modalOuter = document.getElementById('CreateGlazeOuterModal');
    
    if (modalInside) {
        observerInside.observe(modalInside, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
    
    if (modalOuter) {
        observerOuter.observe(modalOuter, {
            attributes: true,
            attributeFilter: ['style']
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initCreateGlazeInsideOuterModals);

// Make functions available globally
window.submitGlazeInsideForm = submitGlazeInsideForm;
window.submitGlazeOuterForm = submitGlazeOuterForm;
