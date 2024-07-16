<?php

require "../koneksi.php";
?>
<section class="books" id="container" style="padding-top: 0;">

    <div class="box-container">
        <?php
        if(isset($_GET['search']) && ($_GET['search'] != "")){
            $search_item = $_GET['search'];
            $query = "SELECT * FROM buku WHERE judul LIKE '%{$search_item}%' OR penulis LIKE '%{$search_item}%' OR penerbit LIKE '%{$search_item}%' OR keterangan LIKE '%{$search_item}%'";
            $select_books = mysqli_query($conn, $query) or die('query failed');
            if(mysqli_num_rows($select_books) > 0){
                while($data = mysqli_fetch_assoc($select_books)){
        ?>
        <form action="search.php" method="post" class="box">
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
                    <button type="button" class="desc_title">Klik</button>
                    <div class="modal-overlay" id="modalOverlay_<?php echo $data['id_buku']; ?>">
                        <div class="modal">
                            <span class="close-modal" data-modal-id="modalOverlay_<?php echo $data['id_buku']; ?>">&times;</span>
                            <div class="modal-content">
                                <h2>Detail:</h2>
                                <p class="desc_detail"><span>Judul:</span> <?php echo $data['judul']; ?></p>
                                <p class="desc_detail"><span>Penulis:</span> <?php echo $data['penulis']; ?></p>
                                <p class="desc_detail"><span>Penjelasan Singkat:</span></p>
                                <p class="desc_detail"><?php echo nl2br($data['keterangan']); ?></p>
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