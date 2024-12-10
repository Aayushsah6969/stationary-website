<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}



require 'db.php';

// Fetch all orders along with the product image from the database
$sql = "SELECT orders.*, products.product_image 
        FROM orders 
        JOIN products ON orders.product_id = products.product_id";
$result = $conn->query($sql);
$orders = [];

if ($result->num_rows > 0) {
    // Store each order in an array
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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
    <h1>Orders</h1>
    <table id="myTable">
        <thead>

       
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Customer Email</th>
            <th>Customer Contact Number</th>
            <th>Customer Address</th>
            <th>Product Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['customer_name']; ?></td>
                <td><?php echo $order['product_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['order_quantity']; ?></td>
                <td><?php echo $order['customer_email']; ?></td>
                <td><?php echo $order['customer_contact_number']; ?></td>
                <td><?php echo $order['customer_address']; ?></td>
                <td><img src="<?php echo $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>"></td>
                <td>
                    <button class="button delete-button" data-id="<?php echo $order['order_id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        // Handle delete button click
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this order?')) {
                    var orderId = this.getAttribute('data-id');

                    // Send delete request to the server
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete_order.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            alert('Order deleted successfully');
                            window.location.reload();
                        }
                    };
                    xhr.send("order_id=" + orderId);
                }
            });
        });
        let table = new DataTable('#myTable');

    </script>
</body>
</html>
 