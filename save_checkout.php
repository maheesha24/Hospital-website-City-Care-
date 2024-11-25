<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hospital_db"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$shipping_cost = $_POST['shipping_cost'];
$total = $_POST['total'];
$order_date = $_POST['order_date'];

// Insert data into the database
$sql = "INSERT INTO checkout (name, quantity, price, shipping_cost, total, order_date) 
        VALUES ('$name', '$quantity', '$price', '$shipping_cost', '$total', '$order_date')";

if ($conn->query($sql) === TRUE) {
    echo "Checkout details saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
