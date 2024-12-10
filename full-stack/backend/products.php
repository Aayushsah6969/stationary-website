
<?php
// products.php

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}


require 'db.php';

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    // Store each product in an array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
        .back a {
            background: #007bb5;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin: 10px;
        }
        .button {
            background-color: #007bb5;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-right: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <!-- Load DataTables second -->
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <div class="back">
        <a href="dashboard.php">Back</a>
    </div>
    <h1>Products</h1>

    <table id='myTable'>
        <thead>

       
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Price</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

       
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['product_id']; ?></td>
                <td><?php echo $product['product_name']; ?></td>
                <td><?php echo $product['product_description']; ?></td>
                <td><?php echo $product['product_brand']; ?></td>
                <td><?php echo $product['product_category']; ?></td>
                <td>Rs.<?php echo number_format($product['product_price'], 2); ?></td>
                <td><img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>"></td>
                <td>
                    <button class="button edit-button" data-id="<?php echo $product['product_id']; ?>" data-name="<?php echo $product['product_name']; ?>" data-description="<?php echo $product['product_description']; ?>" data-brand="<?php echo $product['product_brand']; ?>" data-category="<?php echo $product['product_category']; ?>" data-price="<?php echo $product['product_price']; ?>" data-image="<?php echo $product['product_image']; ?>">Edit</button>
                    <button class="button delete-button" data-id="<?php echo $product['product_id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Product</h2>
            <form id="editForm">
                <input type="hidden" id="editProductId">
                <label for="editProductName">Name:</label>
                <input type="text" id="editProductName" required><br><br>
                <label for="editProductDescription">Description:</label>
                <textarea id="editProductDescription" required></textarea><br><br>
                <label for="editProductBrand">Brand:</label>
                <input type="text" id="editProductBrand" required><br><br>
                <label for="editProductCategory">Category:</label>
                <input type="text" id="editProductCategory" required><br><br>
                <label for="editProductPrice">Price:</label>
                <input type="number" id="editProductPrice" required><br><br>
                <label for="editProductImage">Image URL:</label>
                <input type="text" id="editProductImage" required><br><br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Get modal element
        var modal = document.getElementById("editModal");
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Handle edit button click
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                var productId = this.getAttribute('data-id');
                var productName = this.getAttribute('data-name');
                var productDescription = this.getAttribute('data-description');
                var productBrand = this.getAttribute('data-brand');
                var productCategory = this.getAttribute('data-category');
                var productPrice = this.getAttribute('data-price');
                var productImage = this.getAttribute('data-image');

                document.getElementById('editProductId').value = productId;
                document.getElementById('editProductName').value = productName;
                document.getElementById('editProductDescription').value = productDescription;
                document.getElementById('editProductBrand').value = productBrand;
                document.getElementById('editProductCategory').value = productCategory;
                document.getElementById('editProductPrice').value = productPrice;
                document.getElementById('editProductImage').value = productImage;

                modal.style.display = "block";
            });
        });

        // Handle form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var productId = document.getElementById('editProductId').value;
            var productName = document.getElementById('editProductName').value;
            var productDescription = document.getElementById('editProductDescription').value;
            var productBrand = document.getElementById('editProductBrand').value;
            var productCategory = document.getElementById('editProductCategory').value;
            var productPrice = document.getElementById('editProductPrice').value;
            var productImage = document.getElementById('editProductImage').value;

            // Send updated data to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_product.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('Product updated successfully');
                    window.location.reload();
                }
            };
            xhr.send("product_id=" + productId + "&product_name=" + productName + "&product_description=" + productDescription + "&product_brand=" + productBrand + "&product_category=" + productCategory + "&product_price=" + productPrice + "&product_image=" + productImage);
        });

        // Handle delete button click
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this product?')) {
                    var productId = this.getAttribute('data-id');

                    // Send delete request to the server
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete_product.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            alert('Product deleted successfully');
                            window.location.reload();
                        }
                    };
                    xhr.send("product_id=" + productId);
                }
            });
        });


        let table = new DataTable('#myTable');
    </script>
</body>
</html>
