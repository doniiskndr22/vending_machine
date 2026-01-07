<?php
// Pastikan koneksi ke database benar
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan 'id' diterima. Jika ID kosong, UPDATE tidak akan berjalan.
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        die("Error: ID Produk tidak ditemukan.");
    }

    $id    = $_POST['id'];
    $slot  = mysqli_real_escape_string($conn, $_POST['slot_code']);
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Query UPDATE. Pastikan nama tabel adalah 'products'
    $query = "UPDATE products SET 
              slot_code = '$slot', 
              name = '$name', 
              price = '$price', 
              stock = '$stock' 
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Berhasil, kembali ke dashboard
        header("Location: ../dashboard.php?status=success");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>