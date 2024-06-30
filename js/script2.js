function openModal(bookId) {
    var modal = document.getElementById('modalOverlay_' + bookId);
    modal.style.display = 'flex';

    // Tutup modal saat tombol close-modal diklik
    const closeModalButton = modal.querySelector('.close-modal');
    closeModalButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Untuk menutup modal saat di luar area modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}