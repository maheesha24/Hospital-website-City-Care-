<?php
// Include Twilio SDK
require 'vendor/autoload.php'; // Ensure Twilio SDK is included

use Twilio\Rest\Client;
use Twilio\Http\CurlClient; // Import the CurlClient for custom cURL options

// Assuming you are using PDO for database connection
$dsn = "mysql:host=localhost;dbname=hospital_db";
$username = "root";
$password = "";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    // Create PDO instance
    $pdo = new PDO($dsn, $username, $password, $options);

    // Check if order_id is set via GET
    if (isset($_GET['order_id'])) {
        $orderId = $_GET['order_id'];

        // Begin a transaction to ensure data consistency
        $pdo->beginTransaction();

        // Fetch the order details (including customer phone and name)
        $phoneSql = "SELECT phone, full_name FROM orders WHERE id = :order_id";
        $phoneStmt = $pdo->prepare($phoneSql);
        $phoneStmt->execute(['order_id' => $orderId]);
        $order = $phoneStmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            // Update the order status to 'canceled'
            $updateSql = "UPDATE orders SET status = 'canceled' WHERE id = :order_id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute(['order_id' => $orderId]);

            // Commit the transaction
            $pdo->commit();

            // Get customer information
            $customerPhone = $order['phone'];
            $customerName = $order['full_name'];

            // Format the phone number to E.164 (for Sri Lanka, replacing leading 0 with +94)
            if (substr($customerPhone, 0, 1) === '0') {
                $customerPhone = '+94' . substr($customerPhone, 1); // Replace leading 0 with +94 (for Sri Lanka)
            }

            // Prepare the cancellation message
            $orderDetails = "Hello {$customerName}, your order has been canceled. We apologize for the inconvenience.";

            // Twilio credentials
            $sid = ''; // Replace with your Twilio Account SID
            $token = ''; // Replace with your Twilio Auth Token
            $from = ''; // Replace with your Twilio phone number

            // Use CurlClient to set custom cURL options for SSL verification
            $httpClient = new CurlClient([ 
                CURLOPT_SSL_VERIFYHOST => 0, // Disable SSL verification
                CURLOPT_SSL_VERIFYPEER => 0  // Disable SSL peer verification
            ]);

            // Create Twilio client with custom CurlClient
            $client = new Client($sid, $token, null, null, $httpClient);

            try {
                // Send SMS via Twilio API
                $message = $client->messages->create(
                    $customerPhone,
                    [
                        'from' => $from,
                        'body' => $orderDetails
                    ]
                );

                // Success message
                echo "<div class='alert alert-success'>Order canceled and SMS sent successfully to {$customerPhone}.</div>";

            } catch (Exception $e) {
                // If sending SMS fails, catch the error and display it
                echo "<div class='alert alert-warning'>SMS sending failed: " . $e->getMessage() . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Order not found.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No order ID provided.</div>";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
