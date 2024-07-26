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


document.addEventListener('DOMContentLoaded', function() {
    // Get the button:
    let mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
    }
});

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

document.addEventListener('DOMContentLoaded', (event) => {
    const messageContainer = document.querySelector('.message-container');
    const closeButton = document.querySelector('.message i');
    
    // Fungsi untuk menampilkan pesan
    const showMessage = () => {
       messageContainer.classList.remove('hide');
    };
    
    // Fungsi untuk menyembunyikan pesan
    const hideMessage = () => {
       messageContainer.classList.add('hide');
    };
    
    // Tambahkan event listener untuk menghapus elemen setelah animasi selesai
    messageContainer.addEventListener('animationend', (event) => {
        if (event.animationName === 'slideOut') {
            messageContainer.remove();
        }
    });

    // Tambahkan event listener pada tombol tutup
    closeButton.addEventListener('click', hideMessage);
    
    // Contoh penggunaan: tampilkan pesan setelah 1 detik
    setTimeout(showMessage, 1000);
    
    // Contoh penggunaan: sembunyikan pesan setelah 5 detik
    setTimeout(hideMessage, 6000);
});    