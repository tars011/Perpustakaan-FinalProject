<?php
session_start();

include 'koneksi.php';

if( isset($_SESSION["login"]) ) {
    if ($_SESSION['id_user'] === '1') {
        header("Location: admin-page/admin.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
<?php print_r($_SESSION); print_r($_COOKIE); ?>
<?php include 'header.php'; ?>

<section class="home">

    <div class="content">
        <h3>Books Carefully Selected for Your Enjoyment.</h3>
        <p>Explore our extensive collection of literature, science, history, and more. Dive into a world of knowledge and imagination at your local library.</p>
        <a href="books.php" class="white-btn">lihat buku</a>
    </div>

</section>

<section class="books">

    <h1 class="title">latest books</h1>

    <div class="box-container">

        <?php  
        $select_books = mysqli_query($conn, "SELECT * FROM buku ORDER BY buku.tahunterbit DESC LIMIT 6") or die('query failed');
        if(mysqli_num_rows($select_books) > 0){
                while($data = mysqli_fetch_assoc($select_books)){
        ?>

        <form action="books.php" method="post" class="box">
            <img class="image" src="uploaded_img/<?php echo $data['foto']; ?>" alt="" onclick="openModal(<?php echo $data['id_buku']; ?>)">
            <div class="name"><?php echo $data['judul']; ?></div>
            <input type="hidden" name="id_buku" value="<?php echo $data['id_buku']; ?>">
            <div class="details">
                <div class="info">
                    <div class="author"><span>Penulis:</span> <?php echo $data['penulis']; ?></div>
                    <div class="publisher"><span>Penerbit:</span> <?php echo $data['penerbit']; ?></div>
                    <div class="year"><span>Terbit:</span> <?php echo $data['tahunterbit']; ?></div>
                </div>
                <div class="description"><span>Detail:</span>
                    <button class="desc_title">Klik</button>
                    <div class="modal-overlay" id="modalOverlay_<?php echo $data['id_buku']; ?>">
                        <div class="modal">
                            <span class="close-modal" data-modal-id="modalOverlay_<?php echo $data['id_buku']; ?>">&times;</span>
                            <div class="modal-content">
                                <h2>Detail:</h2>
                                <p class="desc_detail"><span>Judul:</span> <?php echo $data['judul']; ?></p>
                                <p class="desc_detail"><span>Penulis:</span> <?php echo $data['penulis']; ?></p>
                                <p class="desc_detail"><span>Penjelasan Singkat:</span></p>
                                <p class="desc_detail"><?php echo $data['keterangan']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="stock">Stok: 
                    <?php if ($data['stok'] > 0) {
                        echo "<span>Tersedia</span>";
                    } else {
                        echo "<span class='kosong'>Kosong</span>";
                    }
                    ?>
                </div>
            </div>
            <input type="submit" value="Pinjam" name="submit" class="<?php if ($data['stok'] < 1) {echo "clean-btn btn-disabled"; } else {echo "btn"; } ?>" onclick="return confirmSubmit();">
        </form>
        <?php
        }
        } else {
         echo '<p class="empty">no books added yet!</p>';
        }
        ?>
    </div>

    <div class="load-more" style="margin-top: 6rem; text-align:center">
        <a href="books.php" class="option-btn">load more</a>
    </div>

</section>

<section class="about">

    <div class="flex">
        <div class="member" style="max-width: 100%;">
            <div class="content" style="width: 100%; gap: 0;">
                <h3>about us</h3>
                <p>Website ini dibuat untuk memberikan layanan terbaik kepada anda agar dapat dengan mudah meminjam buku di Library ini.</p>
                <a href="about.php" class="btn">read more</a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/script2.js"></script>

</body>
</html>