<?php
// Database connection
include 'db_connect.php';

// Capture POST data from JSON input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Customer details
    $fullName = $data['fullName'];
    $address = $data['address'];
    $city = $data['city'];
    $postalCode = $data['postalCode'];
    $country = $data['country'];
    $phone = $data['phone'];
    
    // Order details
    $subtotal = $data['subtotal'];
    $shipping = $data['shipping'];
    $total = $data['total'];
    $cartItems = json_decode($data['cartItems'], true);

    // Insert order summary (no card details stored)
    $stmt = $conn->prepare("
        INSERT INTO orders (full_name, address, city, postal_code, country, phone, subtotal, shipping, total) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssssddd", $fullName, $address, $city, $postalCode, $country, $phone, $subtotal, $shipping, $total);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id; // Get the ID of the inserted order

        // Insert cart items
        $cartStmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_name, quantity, price, total) 
            VALUES (?, ?, ?, ?, ?)
        ");

        foreach ($cartItems as $item) {
            $cartStmt->bind_param("isidd", $orderId, $item['name'], $item['quantity'], $item['price'], $item['total']);
            $cartStmt->execute();
        }

        $cartStmt->close();
        echo json_encode(['success' => true, 'message' => 'Order placed successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error placing the order.', 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
