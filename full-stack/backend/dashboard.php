<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            height: 100vh;
            margin: 0;
        }
        .dashboard {
            display: flex;
            justify-content: space-between;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .dashboard h2 {
            margin: 0 0 15px;
            color: #007bb5;
        }
        .dashboard a {
            background: #007bb5;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }
        .dashboard a:hover {
            background: #005f8b;
        }
        .options{
            width: 90vw;
            height: auto;
            border: 1px solid grey;
            margin: auto;
            margin-top: 5vh;
             
        }
        .option {
            margin: 30px;
        }
        .option a{
            text-decoration: none;
            color: black;
            padding: 10px;
            margin: 10px;
            border: 1px solid grey;
            border-radius: 5px;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <a href="adminlogout.php">Logout</a>
    </div>
    <div class="options">
        <h3 class="option"><a href="upload_product.php">Upload Product</a></h3>
        <h3 class="option"><a href="products.php">See Product</a></h3>
        <h3 class="option"><a href="orders.php">See Orders</a></h3>
        <h3 class="option"><a href="customers.php">Customer History</a></h3>
        <h3 class="option"><a href="contacts.php">Contact Form Data</a></h3>
    </div>
</body>
</html>
