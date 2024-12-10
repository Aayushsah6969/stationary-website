<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}


require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_brand = $_POST['product_brand'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $sql = "UPDATE products SET 
                product_name='$product_name',
                product_description='$product_description',
                product_brand='$product_brand',
                product_category='$product_category',
                product_price='$product_price',
                product_image='$product_image'
            WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>
