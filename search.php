<?php

include 'koneksi.php';

session_start();

// jika belum login maka diarahkan ke halaman login
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Ambil data buku yang dipinjam
    $id_buku = $_POST['id_buku'];
    $id_user = $_SESSION['id_user']; // Misalnya disimpan dalam session
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));
    
    // Query untuk memasukkan data peminjaman ke tabel peminjaman
    $query = "INSERT INTO peminjaman (id_buku, id_user, tanggal_pinjam, tanggal_kembali) 
              VALUES ('$id_buku', '$id_user', '$tanggal_pinjam', '$tanggal_kembali')";
        
    if (mysqli_query($conn, $query)) {
        // Jika berhasil meminjam, update stok buku (opsional)
        // Misalnya, mengurangi stok
        $update_stok_query = "UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku";
        if (!mysqli_query($conn, $update_stok_query)) {
            echo "Error updating book stock: " . mysqli_error($conn);
            exit;
        };
    
        // Redirect atau pesan sukses
        setcookie('message', json_encode(['The book has been successfully borrowed!']), time() + 10, "/");

        header('Location: loans.php');
        exit;
    } else {
        setcookie('message', json_encode(['Failed to borrow the book!']), time() + 10, "/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Book</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>

</head>
<body>
   
<?php include 'header.php'; ?>
<div class="main-content">
    <div class="heading">
        <h3>search page</h3>
    </div>
    
    <section class="search-form" id="search-form">
        <form action="" method="post">
            <input type="text" name="search" id="search" placeholder="search books..." class="box">
            <input type="submit" name="submit" id="submit" value="search" class="btn">
        </form>
    </section>
    
    <section class="books" id="container" style="padding-top: 0;">
    
        <div class="box-container">
    
            <p class="empty">search something!</p>
    
        </div>
    </section>

</div>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/search-ajax.js"></script>

</body>
</html>