<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require 'db.php';

// Fetch all customer orders details from the database
$sql = "SELECT orders.*, products.product_name, products.product_image, orders.order_date 
        FROM orders 
        JOIN products ON orders.product_id = products.product_id";
$result = $conn->query($sql);
$customerOrders = [];

if ($result->num_rows > 0) {
    // Store each order in an array
    while ($row = $result->fetch_assoc()) {
        $customerOrders[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer History </title>
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

        th,
        td {
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
    </style>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- Load DataTables second -->
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="back">
        <a href="dashboard.php">Back</a>
    </div>
    <h1>Customer History</h1>
    <table id="myTable">
        <thead>

            <tr>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Contact Number</th>
                <th>Customer Address</th>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Product Image</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($customerOrders as $order): ?>
            <tr>
                <td><?php echo $order['customer_name']; ?></td>
                <td><?php echo $order['customer_email']; ?></td>
                <td><?php echo $order['customer_contact_number']; ?></td>
                <td><?php echo $order['customer_address']; ?></td>
                <td><?php echo $order['product_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['order_quantity']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><img src="<?php echo $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
    <script>
         let table = new DataTable('#myTable');
    </script>
</body>

</html>