<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_index.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_index.php">Home</a>
         <a href="admin_buku.php">Daftar Buku</a>
         <a href="admin_user.php">User</a>
         <a href="admin_peminjaman.php">Peminjaman</a>
         <a href="admin_pengembalian.php">Pengembalian</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>username : <span><?php echo $_SESSION['username']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['email']; ?></span></p>
         <a href="logout.php" class="delete-btn">logout</a>
         <div>new <a href="login.php">login</a> | <a href="register.php">register</a></div>
      </div>

   </div>

</header>