document.addEventListener('DOMContentLoaded', function() {
    function initializeModalEvents() {
        // Ambil semua tombol detail
        const descButtons = document.querySelectorAll('.desc_title');
        // Tambahkan event listener untuk setiap tombol detail
        descButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Menghindari aksi default dari tombol submit
        
                // Ambil modal overlay terkait
                const modalOverlay = button.parentElement.querySelector('.modal-overlay');
        
                // Tampilkan modal dengan mengubah display menjadi 'flex'
                modalOverlay.style.display = 'flex';
        
                // Tutup modal saat tombol close-modal diklik
                const closeModalButton = modalOverlay.querySelector('.close-modal');
                closeModalButton.addEventListener('click', function() {
                    modalOverlay.style.display = 'none';
                });
        
                // Tutup modal saat mengklik di luar modal
                window.addEventListener('click', function(event) {
                    if (event.target === modalOverlay) {
                        modalOverlay.style.display = 'none';
                    }
                });
            });
        });
    }

    // Panggil initializeModalEvents saat DOMContentLoaded
    initializeModalEvents();

    //menambahkan event listener untuk form submit
    document.getElementById("search-form").addEventListener("submit", function (event) {
        event.preventDefault();
        var keyword = document.getElementById("search").value;
        var container = document.getElementById("container");

        // Membuat objek ajax
        var xhr = new XMLHttpRequest();

        // Cek kesiapan ajax
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                container.innerHTML = xhr.responseText;
                // Panggil kembali initializeModalEvents setelah konten diubah
                initializeModalEvents();
            }
        };

        // Buat ajax
        xhr.open("GET", "ajax/search-ajax.php?search=" + encodeURIComponent(keyword), true);
        xhr.send();
    });
});