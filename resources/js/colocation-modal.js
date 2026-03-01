
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.toggle('hidden');
        // Optional: Prevent scrolling on the body when modal is open
        document.body.classList.toggle('overflow-hidden');
    }
}

window.addEventListener('click', function(event) {
    const modal = document.getElementById('colocationModal');
    if (event.target === modal) {
        toggleModal('colocationModal');
    }
});
