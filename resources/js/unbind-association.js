import {openModal, closeModal} from './modal.js';
import axios from "axios";

function unbindAssociation(associationId) {
    const url = `/unbind/${associationId}`;

    axios.post(url)
        .then(response => {
            if (response.status === 200) {
                // Handle success
                console.log('Association unbound successfully');
                closeModal();
                const bindCard = document.getElementById('bind-card-' + associationId);
                if (bindCard) {
                    bindCard.remove();
                }
            }
        })
        .catch(error => {
            // Handle error
            console.error('Error unbinding association:', error);
        });


}

function openUnbindModal(associationId, associationName) {
    document.querySelector('.unbind-association-modal #association_name').innerHTML = associationName;
    document.querySelector('.unbind-association-modal input[name=association_id]').value = associationId;

    const unbindButton = document.querySelector('.unbind-association-modal .unbind-button');
    unbindButton.addEventListener('click', function () {
        unbindAssociation(associationId);
    });

    openModal('unbind-association-modal');
}

const unbindAssociationButtons = document.querySelectorAll('.unbind-association-button');

unbindAssociationButtons.forEach(button => {
    button.addEventListener('click', function () {
        const associationId = button.getAttribute('data-association-id');
        const associationName = button.getAttribute('data-association-name');
        openUnbindModal(associationId, associationName);
    });
});
