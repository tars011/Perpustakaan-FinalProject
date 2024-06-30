<?php

include 'koneksi.php';

session_start();

// jika belum login maka diarahkan ke halaman login
if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

$id_buku = $_GET["id_buku"];
$id_peminjaman = $_GET["id_peminjaman"];
$id_user = $_SESSION['id_user'];
$denda = $_GET["denda"];
$tanggal_pengembalian = date('Y-m-d');

$query = "DELETE FROM peminjaman WHERE id_peminjaman='$id_peminjaman'";

if (mysqli_query($conn, $query)) {
    // Jika berhasil mngembalikan, update stok buku (opsional)
    // Misalnya, mengembalikan stok
    $update_stok_query = "UPDATE buku SET stok = stok + 1 WHERE id_buku = $id_buku";
    if (!mysqli_query($conn, $update_stok_query)) {
        echo "Error updating book stock: " . mysqli_error($conn);
        exit;
    }

    // Input pengembalian
    $pengembalian = "INSERT INTO pengembalian (id_buku, id_user, tanggal_pengembalian, denda) 
              VALUES ('$id_buku', '$id_user', '$tanggal_pengembalian', '$denda')";
    if (!mysqli_query($conn, $pengembalian)) {
        echo "Error inserting return record: " . mysqli_error($conn);
        exit;
    }

    // Redirect atau pesan sukses
    header('Location: loans.php');
    exit;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

?>