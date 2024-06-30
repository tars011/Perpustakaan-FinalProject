// Header - START
document.addEventListener('DOMContentLoaded', function() {
    let userBox = document.querySelector('.header .header-2 .user-box');
    let navbar = document.querySelector('.header .header-2 .navbar');
    
    document.querySelector('#user-btn').onclick = () =>{
        userBox.classList.toggle('active');
        navbar.classList.remove('active');
    }
    
    document.querySelector('#menu-btn').onclick = () =>{
        navbar.classList.toggle('active');
        userBox.classList.remove('active');
    }
    
    window.onscroll = () =>{
        userBox.classList.remove('active');
        navbar.classList.remove('active');
    
        if(window.scrollY > 60){
            document.querySelector('.header .header-2').classList.add('active');
        }else{
            document.querySelector('.header .header-2').classList.remove('active');
        }
    }
    
    // Tambahkan event listener untuk menutup userBox saat mengklik di luar kotak
    window.addEventListener('click', function(event) {
        if (!userBox.contains(event.target) && !document.querySelector('#user-btn').contains(event.target)) {
            userBox.classList.remove('active');
        }
        if (!navbar.contains(event.target) && !document.querySelector('#menu-btn').contains(event.target)) {
            navbar.classList.remove('active');
        }
    });
});
// Header - END




// Detail Deskripsi Buku - START
document.addEventListener('DOMContentLoaded', function() {
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
});
// Detail Deskripsi Buku - END


// Fungsi on-click - START
function confirmSubmit() {
    return confirm('Apakah Anda yakin ingin meminjam buku ini?');
}

function confirmReturn() {
    return confirm('Kembalikan buku ini?');
}
// Fungsi on-click - END