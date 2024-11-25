<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/appoiment.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<?php include 'Header.php'; ?>
<?php
require 'db_connect.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;
use Twilio\Http\CurlClient;

$message = ''; // Message for form submission feedback

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $specialization = $_POST['specialization'] ?? '';
    $doctor = $_POST['doctor'] ?? ''; // Doctor's name or ID, should be a name if possible
    $name = $_POST['contact-name'] ?? '';
    $phone = $_POST['contact-phone'] ?? '';
    $email = $_POST['contact-email'] ?? '';
    $age = $_POST['contact-age'] ?? 0;
    $gender = $_POST['contact-gender'] ?? '';

    if (empty($specialization) || empty($doctor) || empty($name) || empty($phone) || empty($email)) {
        $message = '<div class="alert alert-danger">Please fill in all required fields.</div>';
    } else {
        // Fetch doctor's name if the provided doctor value is an ID
        $doctorName = $doctor; // If $doctor is already a name, this is fine. If it's an ID, fetch name from database.
        if (is_numeric($doctor)) {
            $stmt = $conn->prepare("SELECT name FROM doctors WHERE id = ?");
            $stmt->bind_param("i", $doctor);
            $stmt->execute();
            $stmt->bind_result($doctorName);
            $stmt->fetch();
            $stmt->close();
        }

        $sql = "INSERT INTO appointments (specialization, doctor, name, phone, email, age, gender) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssis", $specialization, $doctorName, $name, $phone, $email, $age, $gender);

        if ($stmt->execute()) {
            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = ''; // Replace with your email
                $mail->Password = ''; // Replace with your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('hospital@example.com', 'City Care Hospital');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Appointment Confirmation';
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                        <h2 style='color: #4CAF50;'>Appointment Confirmation</h2>
                        <p>Dear <strong>$name</strong>,</p>
                        <p>We are pleased to inform you that your appointment is confirmed with:</p>
                        <ul>
                            <li><strong>Doctor:</strong> Dr. $doctorName</li>
                            <li><strong>Specialization:</strong> $specialization</li>
                        </ul>
                        <p>Please make sure to arrive at least 15 minutes prior to your appointment time.</p>
                        <p>If you have any questions, feel free to contact us.</p>
                        <p style='color: #4CAF50;'>Thank you for choosing City Care Hospital!</p>
                        <p>Best regards,</p>
                        <p><strong>City Care Hospital Team</strong></p>
                    </div>";
                $mail->send();
            } catch (Exception $e) {
                $message .= '<div class="alert alert-warning">Email sending failed: ' . $mail->ErrorInfo . '</div>';
            }

            // Send SMS
            // Format the phone number to E.164
            if (substr($phone, 0, 1) === '0') {
                $phone = '+94' . substr($phone, 1); // Replace leading 0 with +94 (for Sri Lanka)
            }

            $account_sid = ''; // Replace with your Twilio account SID
            $auth_token = '';   // Replace with your Twilio auth token
            $twilio_number = '+';   // Replace with your Twilio phone number

            // Use CurlClient to set custom cURL options
            $httpClient = new CurlClient([
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ]);

            // Pass $httpClient as the fifth parameter to Client
            $client = new Client($account_sid, $auth_token, null, null, $httpClient);

            try {
                $client->messages->create(
                    $phone,
                    [
                        'from' => $twilio_number,
                        'body' => "Hello $name, your appointment with Dr. $doctorName ($specialization) is confirmed. Thank you for choosing City Care Hospital!"
                    ]
                );
            } catch (Exception $e) {
                $message .= '<div class="alert alert-warning">SMS sending failed: ' . $e->getMessage() . '</div>';
            }

            $message .= '<div class="alert alert-success">Appointment booked successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Failed to book appointment. Please try again later.</div>';
        }
    }
}
?>





<section class="contact-layout2 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?= $message ?>
                <form class="contact-panel__form bg-light p-4 rounded shadow-sm" method="post">
                    <h4 class="contact-panel__title">Book An Appointment</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <select class="form-select rounded-start" id="specialization-select" name="specialization" required>
                                    <option value="" disabled selected>Select Specialization</option>
                                    <option value="General Practitioner">General Practitioner</option>
                                    <option value="Obstetrician and Gynecologist">Obstetrician and Gynecologist</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Otolaryngologist">Otolaryngologist (ENT Specialist)</option>
                                    <option value="Psychiatrist">Psychiatrist</option>
                                    <option value="Dentist">Dentist</option>
                                    <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <select class="form-select rounded-start" id="doctor-select" name="doctor" required>
                                    <option value="" disabled selected>Select Doctor</option>
                                </select>
                            </div>
                        </div>
                        <!-- Add contact details fields -->
                        <div class="col-md-6 mb-3"><input type="text" class="form-control" name="contact-name" placeholder="Full Name" required></div>
                        <div class="col-md-6 mb-3"><input type="tel" class="form-control" name="contact-phone" placeholder="Contact Number" required></div>
                        <div class="col-md-6 mb-3"><input type="email" class="form-control" name="contact-email" placeholder="Email Address" required></div>
                        <div class="col-md-6 mb-3"><input type="number" class="form-control" name="contact-age" placeholder="Age" required></div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <label class="me-2"><input type="radio" name="contact-gender" value="Male" required> Male</label>
                                <label class="me-2"><input type="radio" name="contact-gender" value="Female" required> Female</label>
                                <label><input type="radio" name="contact-gender" value="Other" required> Other</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                        <a href="doctorstimetb.php" class="btn btn-primary" id="view-timetable-btn">View Doctor's Timetable</a>

 
                        </div>
                    </div>
                </form>
<div class="contact-panel__info bg-primary text-white rounded p-4 shadow-sm d-flex flex-column justify-content-center align-items-center text-center position-relative">
    <img src="images/background/contactus.jpg" alt="banner" class="position-absolute w-100 h-100 object-fit-cover filter-brightness-50">
    <div class="position-relative z-index-2">
        <h4 class="contact-panel__title">Quick Contacts</h4>
        <p class="contact-panel__desc mb-4">Please feel free to contact our friendly staff with any medical enquiry.</p>
        <ul class="contact__list list-unstyled mb-4">
            <li><i class="fas fa-phone"></i><a href="tel:+5565454117" class="text-white">Emergency Line: +94 762863425</a></li>
            <li><i class="fas fa-map-marker-alt"></i><a href="#" class="text-white">Location: City Care Hospital,Matara</a></li>
            <li><i class="fas fa-clock"></i><a href="contact-us.php" class="text-white">Mon - Fri: 8:00 am - 12:00 pm</a></li>
        </ul>
        <!-- Contact Us button should link to the contact page -->
        <a href="contact-us.php" class="btn btn-light rounded-pill">Contact Us</a>
    </div>
</div>
            </div>
        </div>
    </div>
</section>
<?php include 'Footer.php'; ?>

<!-- Add this script just before the closing </body> tag -->
<script>
    $(document).ready(function () {
        // Fade out messages after 5 seconds
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Reset form on successful submission
        <?php if (strpos($message, 'alert-success') !== false) : ?>
            $('form.contact-panel__form')[0].reset();
        <?php endif; ?>
    });

    // Fetch doctors based on specialization
    $('#specialization-select').change(function() {
        var specialization = $(this).val();
        if (specialization) {
            $.post('fetch_doctors.php', { specialization: specialization }, function(data) {
                var doctorSelect = $('#doctor-select');
                doctorSelect.empty().append('<option value="" disabled selected>Select Doctor</option>');
                $.each(JSON.parse(data), function(index, doctor) {
                    doctorSelect.append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                });
            });
        }
    });
</script>

</body>
</html>
