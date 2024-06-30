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
    <title>Search Book</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
    <h3>search page</h3>
</div>

<section class="search-form">
    <form action="" method="post">
        <input type="text" name="search" placeholder="search books..." class="box">
        <input type="submit" name="submit" value="search" class="btn">
    </form>
</section>

<section class="books" style="padding-top: 0;">

    <div class="box-container">
        <?php
        if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_books = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_books) > 0){
                while($data = mysqli_fetch_assoc($select_books)){
        ?>
        <form action="books.php" method="post" class="box">
            <img class="image" src="uploaded_img/<?php echo $data['foto']; ?>" alt="">
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
                echo '<p class="empty">no result found!</p>';
            }
        }else{
            echo '<p class="empty">search something!</p>';
        }
        ?>
    </div>
</section>


<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>