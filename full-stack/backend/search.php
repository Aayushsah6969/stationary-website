<?php
// Allow requests from specific origin
header("Access-Control-Allow-Origin: http://localhost:5173");
// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// Allow specific HTTP headers
header("Access-Control-Allow-Headers: Content-Type");

// Database configuration
require 'db.php';


// Retrieve the search query if provided
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Construct the SQL query with a WHERE clause for the search
$sql = "SELECT product_id, product_name, product_description, product_brand, product_category, product_price, CONCAT('http://192.168.0.183/STATIONARY/backend/', product_image) AS product_image_url FROM products WHERE product_name LIKE '%$search%' OR product_description LIKE '%$search%' OR product_brand LIKE '%$search%' OR product_category LIKE '%$search%'";

$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Fetch products and store in an array
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    // If no products found, return an empty array
    $products = [];
}

// Close connection
$conn->close();

// Set response content type to JSON
header('Content-Type: application/json');

// Return products as JSON
echo json_encode($products);
?>
