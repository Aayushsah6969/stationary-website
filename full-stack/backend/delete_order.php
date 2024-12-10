<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['order_id'])) {
        $order_id = $_POST['order_id'];

        $sql = "DELETE FROM orders WHERE order_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $order_id);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("message" => "Order deleted successfully."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete order."));
            }

            $stmt->close();
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Database error."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Order ID is required."));
    }
}

$conn->close();
?>
