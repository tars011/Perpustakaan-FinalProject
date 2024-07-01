// Header - START
document.addEventListener('DOMContentLoaded', function() {
   let accountBox = document.querySelector('.header .account-box');
   let navbar = document.querySelector('.header .navbar');
   
   document.querySelector('#user-btn').onclick = () =>{
       accountBox.classList.toggle('active');
       navbar.classList.remove('active');
   }
   
   document.querySelector('#menu-btn').onclick = () =>{
       navbar.classList.toggle('active');
       accountBox.classList.remove('active');
   }
   
   window.onscroll = () =>{
       accountBox.classList.remove('active');
       navbar.classList.remove('active');
   
       if(window.scrollY > 60){
           document.querySelector('.header').classList.add('active');
       }else{
           document.querySelector('.header').classList.remove('active');
       }
   }
   
   // Tambahkan event listener untuk menutup accountBox saat mengklik di luar kotak
   window.addEventListener('click', function(event) {
       if (!accountBox.contains(event.target) && !document.querySelector('#user-btn').contains(event.target)) {
           accountBox.classList.remove('active');
       }
       if (!navbar.contains(event.target) && !document.querySelector('#menu-btn').contains(event.target)) {
           navbar.classList.remove('active');
       }
   });
});
// Header - END