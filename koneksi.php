<?php
// isi nama host, username mysql, dan password mysql
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "perpustakaan";

// isikan dengan nama database yang akan dihubungkan
$conn = mysqli_connect("$server", "$user", "$password", "$nama_database");

if (!$conn) {
    die("Gagal terhubung dengan database: ". mysqli_connect_error());
}
?>