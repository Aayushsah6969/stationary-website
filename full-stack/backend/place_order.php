<?php

// session_start();
// if (!isset($_SESSION['username'])) {
//     header('Location: index.php');
//     exit();
// }


header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Handle preflight request
    http_response_code(200);
    exit();
}

require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->customer_name) && !empty($data->product_id) && !empty($data->product_name) && !empty($data->order_quantity) && !empty($data->customer_email) && !empty($data->customer_contact_number) && !empty($data->customer_address)) {

    $customer_name = $data->customer_name;
    $product_id = $data->product_id;
    $product_name = $data->product_name;
    $order_quantity = $data->order_quantity;
    $customer_email = $data->customer_email;
    $customer_contact_number = $data->customer_contact_number;
    $customer_address = $data->customer_address;

    $sql = "INSERT INTO orders (customer_name, product_id, product_name, order_quantity, customer_email, customer_contact_number, customer_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sisisss", $customer_name, $product_id, $product_name, $order_quantity, $customer_email, $customer_contact_number, $customer_address);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("message" => "Order placed successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to place order."));
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Database error."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data."));
}

$conn->close();
?>
