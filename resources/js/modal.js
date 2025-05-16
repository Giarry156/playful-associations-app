const modalLayers = document.querySelectorAll('.modal-layer');
modalLayers.forEach(modalLayer => {
    modalLayer.addEventListener('click', function (event) {
        if (event.target === modalLayer) {
            closeModal();
        }
    });
});

function openModal(className) {
    const modalLayer = document.querySelector(`.${className}`);
    modalLayer.classList.add('active');
    const body = document.querySelector('body');
    body.classList.add('no-scroll');
    const cancelButton = document.querySelector('.cancel');
    if (cancelButton) {
        cancelButton.addEventListener('click', closeModal);
    }
}

function closeModal() {
    const modalLayer = document.querySelector('.modal-layer');
    modalLayer.classList.remove('active');
    const body = document.querySelector('body');
    body.classList.remove('no-scroll');
    const cancelButton = document.querySelector('.cancel');
    if (cancelButton) {
        cancelButton.removeEventListener('click', closeModal);
    }
}

const closeModalButton = document.querySelector('.modal-button.cancel');
if (closeModalButton) {
    closeModalButton.addEventListener('click', closeModal);
}

export {openModal, closeModal};
