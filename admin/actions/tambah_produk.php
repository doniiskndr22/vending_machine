<?php
include '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slot  = $_POST['slot_code'];
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image'] ?: 'default.png';

    $query = "INSERT INTO products (slot_code, name, price, stock, image) 
              VALUES ('$slot', '$name', '$price', '$stock', '$image')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../dashboard.php");
    } else {
        echo "Gagal menambah data: " . mysqli_error($conn);
    }
}
?>