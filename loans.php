<?php

include 'koneksi.php';

session_start();

// jika belum login maka diarahkan ke halaman login
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - Borrowed Books</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
    <h3>Borrowed Books</h3>
</div>

<section class="about3">

    <div class="content">
        <h4>Jangan lupa mengembalikan buku sebelum batas pengembalian!</h4>
        <p>Atau akan terkena denda sebesar <span>RP. 5.000</span> untuk setiap hari keterlambatan.</p>
    </div>

</section>

<section class="borrow-books">

    <h1 class="title">List of Books</h1>

    <div class="box-container">
        <?php
        $select_peminjaman = mysqli_query($conn, "SELECT * FROM peminjaman, buku WHERE peminjaman.id_buku = buku.id_buku AND id_user = '$id_user'") or die('query failed');
        if(mysqli_num_rows($select_peminjaman) > 0){
            while($fetch_peminjaman = mysqli_fetch_assoc($select_peminjaman)){   
                $tanggal_pinjam = $fetch_peminjaman['tanggal_pinjam'];
                $batas_pengembalian = $fetch_peminjaman['tanggal_kembali'];
                $current_date = date('Y-m-d');
                $denda = 0;
                if($current_date > $batas_pengembalian) {
                    $date1 = new DateTime($current_date);
                    $date2 = new DateTime($batas_pengembalian);
                    $interval = $date1->diff($date2);
                    $denda = $interval->days * 5000; // Assuming a fine of 5000 per day
                }
        ?>
        <div class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch_peminjaman['foto']; ?>" alt="">
            <div class="name"><?php echo $fetch_peminjaman['judul']; ?></div>
            <input type="hidden" name="id_peminjaman" value="<?php echo $fetch_peminjaman['id_peminjaman']; ?>">
            <div class="details">
                <div class="tanggal">
                    <div><span>Tanggal Pinjam:</span> <?php echo $tanggal_pinjam; ?></div>
                    <div><span>Batas Pengembalian:</span> <?php echo $batas_pengembalian; ?></div>
                </div>
                <div class="status">
                    <?php
                    if($denda == 0) {
                        echo '<span>Anda <span class="bold">aman</span> dari denda.</span>';
                    } else {
                        echo '<span class="red">Anda harus membayar denda sebesar: <span class="red2">Rp ' . $denda.'</span></span>';
                    }
                    ?>
                </div>
            </div>

            <a href="return.php?id_buku=<?= $fetch_peminjaman['id_buku']; ?>&id_peminjaman=<?= $fetch_peminjaman['id_peminjaman']; ?>&denda=<?= $denda; ?>" class="delete-btn" onclick="return confirmReturn();">Kembalikan</a>
        </div>
        <?php
                }
        }else{
            echo '<p class="empty">No books borrowed</p>';
        }
        ?>
    </div>

    <div class="short-link">
        <div class="flex">
            <a href="index.php" class="option-btn">return home</a>
            <a href="books.php" class="btn">others book</a>
        </div>
    </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>