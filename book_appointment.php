<?php
// Include database and required libraries
require 'db_connect.php'; // Your database connection script

// Include PHPMailer libraries
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

$message = ''; // Variable to hold feedback messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and validate inputs
    $specialization = $_POST['specialization'] ?? '';
    $doctor = $_POST['doctor'] ?? '';
    $name = $_POST['contact-name'] ?? '';
    $phone = $_POST['contact-phone'] ?? '';
    $email = $_POST['contact-email'] ?? '';
    $age = $_POST['contact-age'] ?? 0;
    $gender = $_POST['contact-gender'] ?? '';

    // Validate required fields
    if (empty($specialization) || empty($doctor) || empty($name) || empty($phone) || empty($email)) {
        $message = '<div class="alert alert-danger">Please fill in all required fields.</div>';
    } else {
        // Insert appointment details into the database
        $sql = "INSERT INTO appointments (specialization, doctor, name, phone, email, age, gender) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssis", $specialization, $doctor, $name, $phone, $email, $age, $gender);

        if ($stmt->execute()) {
            $appointmentId = $stmt->insert_id;

            // Send email notification
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@gmail.com'; // Your email
                $mail->Password = 'your_email_password'; // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('hospital@example.com', 'City Care Hospital');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Appointment Confirmation';
                $mail->Body = "<p>Dear $name,</p>
                               <p>Your appointment with Dr. $doctor under the specialization $specialization is confirmed.</p>
                               <p>Thank you for choosing City Care Hospital.</p>";

                $mail->send();
            } catch (Exception $e) {
                $message .= '<div class="alert alert-warning">Email sending failed: ' . $mail->ErrorInfo . '</div>';
            }

            // Send SMS notification
            $account_sid = 'your_account_sid'; // Replace with your Twilio SID
            $auth_token = 'your_auth_token';   // Replace with your Twilio Auth Token
            $twilio_number = '+1234567890';    // Replace with your Twilio phone number

            $client = new Client($account_sid, $auth_token);
            try {
                $client->messages->create(
                    $phone,
                    [
                        'from' => $twilio_number,
                        'body' => "Dear $name, your appointment with Dr. $doctor under the specialization $specialization is confirmed. - City Care Hospital"
                    ]
                );
            } catch (Exception $e) {
                $message .= '<div class="alert alert-warning">SMS sending failed: ' . $e->getMessage() . '</div>';
            }

            $message .= '<div class="alert alert-success">Appointment booked successfully!</div>';
        } else {
            $message .= '<div class="alert alert-danger">Error inserting appointment details: ' . $conn->error . '</div>';
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    }
}
?>