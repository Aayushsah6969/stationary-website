<?php
// session_start();
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
require 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_brand = $_POST['product_brand'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $error = "File is not an image.";
    }

    // Check file size
    if ($_FILES["product_image"]["size"] > 500000) {
        $uploadOk = 0;
        $error = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error = isset($error) ? $error : "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Insert the product into the database
            $stmt = $conn->prepare("INSERT INTO products (product_name, product_image, product_description, product_brand, product_category, product_price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssd", $product_name, $target_file, $product_description, $product_brand, $product_category, $product_price);

            if ($stmt->execute()) {
                $success = "The product has been uploaded successfully.";
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            display:flex;
            flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    .upload-form {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        width: 60vw;
    }
    @media only screen and (max-width:600px){
        .upload-form{
            width: 80vw;
        }
    } 
    .upload-form h2 {
        margin: 0 0 15px;
        color: #007bb5;
        text-align: center;
    }
    .upload-form input[type="text"], .upload-form input[type="file"], .upload-form textarea, .upload-form input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .upload-form input[type="submit"] {
        background: #007bb5;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }
    .upload-form input[type="submit"]:hover {
        background: #005f8b;
    }
    .success {
        color: green;
        text-align: center;
    }
    .error {
        color: red;
        text-align: center;
    }
    .back a{
        background: #007bb5;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin: 10px;
    }
    </style>
</head>
<body>
    <div class="back">
        <a href="dashboard.php">Back</a>
    </div>
    <div class="upload-form">
        <h2>Upload Product</h2>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="upload_product.php" method="post" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="file" name="product_image" required>
            <textarea name="product_description" placeholder="Product Description" rows="4" required></textarea>
            <input type="text" name="product_brand" placeholder="Product Brand" required>
            <input type="text" name="product_category" placeholder="Product Category" required>
            <input type="number" step="0.01" name="product_price" placeholder="Product Price" required>
            <input type="submit" value="Upload">
        </form>
    </div>
</body>
</html>
