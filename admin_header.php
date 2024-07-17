<?php
// print_r($_SESSION); print_r($_COOKIE);  // to check cookie and session

//cek cookie
if ( !isset($_SESSION['username']) && !isset($_SESSION['name']) && !isset($_SESSION['email']) ) {
    if( isset($_COOKIE['login']) ) {
        if ( $_COOKIE['login'] == 'true' ) {
            $stmt = $conn->prepare("SELECT username, nama, email FROM user WHERE id_user = ?");
            $stmt->bind_param("s", $_COOKIE['id_user'],);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $_COOKIE['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['nama'];
            $_SESSION['email'] = $row['email'];
        } else {
            header("Location: login.php?section=signin");
        }
    }
}

if(isset($_COOKIE['message'])){
   $messages = json_decode($_COOKIE['message'], true);
   foreach($messages as $message){
       echo '
       <div class="message">
           <span>'.$message.'</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
   }
   // Delete the message cookie after displaying
   setcookie("message", "", time() - 3600, "/");
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_index.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        $nav_links = [
            'admin_index.php' => 'Dashboard',
            'admin_buku.php' => 'Buku',
            'admin_user.php' => 'User',
            'admin_peminjaman.php' => 'Peminjaman',
            'admin_pengembalian.php' => 'Pengembalian'
        ];
        foreach ($nav_links as $url => $title) {
            if ($current_page == $url) {
                echo '<span class="nav-link active">' . $title . '</span>';
            } else {
                echo '<a href="' . $url . '">' . $title . '</a>';
            }
        }
        ?>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <?php
         $nama = $_SESSION['name'];
         $fnama = ucwords(strtolower($nama));
         ?>
         <p><b>Selamat Datang, <span><?php echo $fnama; ?></span> (<span><?php echo $_SESSION['username']; ?>)</b></p>
         <p>Email : <span><?php echo $_SESSION['email']; ?></span></p>
         <a href="logout.php" class="delete-btn"><span>logout</span></a>
      </div>

   </div>

   
    <?php include 'top.html'; ?>
</header>