<?php
session_start();

include 'koneksi.php';

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

        header('Location: books.php');
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
    <title>Library - Books</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
    <h3>Books</h3>
</div>

<section class="books">

    <h1 class="title">latest books</h1>

    <div class="box-container">

        <?php  
        $select_books = mysqli_query($conn, "SELECT * FROM buku ORDER BY buku.tahunterbit DESC") or die('query failed');
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
         echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>

    <div class="load-more" style="margin-top: 2rem; text-align:center">
        <a href="" class=""></a>
    </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/script2.js"></script>

</body>
</html>