<?php
session_start();

include 'koneksi.php';

// jika belum login maka diarahkan ke halaman login
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `peminjaman` WHERE id_peminjaman = '$delete_id'") or die('Query failed');
    header('Location: admin_peminjaman.php');
    exit;
}

// Handle update action
if (isset($_POST['update_peminjaman'])) {
    $update_id = $_POST['id_peminjaman'];
    $id_buku = $_POST['id_buku'];
    $id_user = $_POST['id_user'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    mysqli_query($conn, "UPDATE `peminjaman` SET id_buku = '$id_buku', id_user = '$id_user', tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali' WHERE id_peminjaman = '$update_id'") or die('Query failed');
    header('Location: admin_peminjaman.php');
    exit;
}

// Fetch peminjaman data if update is requested
if (isset($_GET['update'])) {
    $update_id = $_GET['update'];
    $update_query = mysqli_query($conn, "SELECT * FROM `peminjaman` WHERE id_peminjaman = '$update_id'") or die('Query failed');
    if (mysqli_num_rows($update_query) > 0) {
        $peminjaman_data = mysqli_fetch_assoc($update_query);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Peminjaman</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link  -->
   <link rel="stylesheet" href="css/style_admin.css">
   <link rel="icon" type="image/png" href="images/books.png">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="admin-section">

   <h1 class="title">Peminjaman</h1>
<div class="container_table">
   <table class="admin-table">
      <thead>
         <tr>
            <th>ID Peminjaman</th>
            <th>Nama Buku</th>
            <th>Nama User</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tbody>
         <?php
            $select_peminjaman = mysqli_query($conn, "SELECT peminjaman.id_peminjaman, buku.judul, user.nama, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali FROM `peminjaman` JOIN `buku` ON peminjaman.id_buku = buku.id_buku JOIN `user` ON peminjaman.id_user = user.id_user") or die('Query failed');
            while($row = mysqli_fetch_assoc($select_peminjaman)){
         ?>
         <tr>
            <td><?php echo $row['id_peminjaman']; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['tanggal_pinjam']; ?></td>
            <td><?php echo $row['tanggal_kembali']; ?></td>
            <td>
               <a href="admin_peminjaman.php?update=<?php echo $row['id_peminjaman']; ?>" class="action-btn update-btn">Update</a>
               <a href="admin_peminjaman.php?delete=<?php echo $row['id_peminjaman']; ?>" onclick="return confirm('Delete this entry?');" class="action-btn delete-btn">Delete</a>
            </td>
         </tr>
         <?php
            }
         ?>
      </tbody>
   </table>
   </div>

   <?php if (isset($peminjaman_data)) { ?>
      <div class="update-form-container">
         <form action="admin_peminjaman.php" method="post" class="update-form">
            <input type="hidden" name="id_peminjaman" value="<?php echo $peminjaman_data['id_peminjaman']; ?>">
            <p> ID Buku: <input type="text" name="id_buku" value="<?php echo $peminjaman_data['id_buku']; ?>" required> </p>
            <p> ID User: <input type="text" name="id_user" value="<?php echo $peminjaman_data['id_user']; ?>" required> </p>
            <p> Tanggal Pinjam: <input type="date" name="tanggal_pinjam" value="<?php echo $peminjaman_data['tanggal_pinjam']; ?>" required> </p>
            <p> Tanggal Kembali: <input type="date" name="tanggal_kembali" value="<?php echo $peminjaman_data['tanggal_kembali']; ?>" required> </p>
            <input type="submit" name="update_peminjaman" value="Update Peminjaman" class="btn">
         </form>
      </div>
   <?php } ?>

</section>

<!-- Custom admin JS file link -->
<script src="js/admin_script.js"></script>

</body>
</html>
