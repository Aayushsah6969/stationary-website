<?php
// Start session
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Include database connection
require 'db.php';

// Fetch all contacts from the database
$sql = "SELECT * FROM contacts";
$result = $conn->query($sql);
$contacts = [];

if ($result->num_rows > 0) {
    // Store each contact in an array
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- Load DataTables second -->
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="back">
        <a href="dashboard.php">Back</a>
    </div>
    <h1>Contact Messages</h1>
    <table id="myTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?php echo $contact['name']; ?></td>
                <td><?php echo $contact['email']; ?></td>
                <td><?php echo $contact['message']; ?></td>
                <td><?php echo $contact['submitted_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>
