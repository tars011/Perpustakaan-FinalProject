<?php
print_r($_SESSION); print_r($_COOKIE);  // to check cookie and session

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
?>

<header class="header">
    <div class="header-2">
        <div class="flex">
            <a href="index.php" class="logo">Library</a>

            <nav class="navbar">
                <a href="index.php">home</a>
                <a href="books.php">books</a>
                <a href="loans.php">orders</a>
                <a href="about.php">about us</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search.php" class="fas fa-search"></a>
                <div id="user-btn" class="fas fa-user"></div>
                <?php
                if ((isset($_SESSION['id_user'])) && (isset($_SESSION['login']))) {
                    $id_user = $_SESSION['id_user'];
                    $select_loans_number = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_user = $id_user") or die('query failed');
                    $loans_rows_number = mysqli_num_rows($select_loans_number); 
                ?>
                <a href="loans.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $loans_rows_number; ?>)</span> </a>
                <?php } else { ?>
                <a href="loans.php"> <i class="fas fa-shopping-cart"></i> </a>
                <?php } ?>
                
            </div>

                <?php if((!isset($_SESSION['id_user'])) && (!isset($_SESSION['login']))) { ?>
            <div class="out user-box">
                <p>Sudah punya akun? <a href="login.php?section=signin">sign in</a></p>
                <div class="separator"></div>
                <p>Belum punya akun? <a href="login.php?section=signup">sign up</a></p>
            </div>
                <?php } else {?>
            <div class="user-box">
                <?php
                $nama = $_SESSION['name'];
                $fnama = ucwords(strtolower($nama));
                ?>
                <p><b>Selamat Datang, <span><?php echo $fnama; ?></span> (<span><?php echo $_SESSION['username']; ?>)</b></p>
                <p>Email : <span><?php echo $_SESSION['email']; ?></span></p>
                <a href="logout.php" class="delete-btn"><span>logout</span></a>
            </div>
                <?php } ?>
        </div>
    </div>

</header>