<?php
require 'db_connect.php'; // Database connection
require 'vendor/autoload.php'; // Include PHPMailer and FPDF

use FPDF as GlobalFPDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use FPDF\FPDF;

// Initialize variables
$doctor = $appointment_date = "";
$appointments = [];
$sent_message = "";

// Fetch unique doctor names for the dropdown
$doctorQuery = "SELECT DISTINCT doctor FROM appointments";
$doctorResult = $conn->query($doctorQuery);
$doctors = $doctorResult->fetch_all(MYSQLI_ASSOC);

// Handle form submission for filtering appointments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filter'])) {
    $doctor = $_POST['doctor'] ?? null;
    $appointment_date = $_POST['appointment_date'] ?? null;

    $query = "SELECT id, specialization, doctor, name, phone, email, age, gender, appointment_date 
              FROM appointments 
              WHERE 1 = 1";

    $params = [];
    $types = '';

    if ($doctor) {
        $query .= " AND doctor = ?";
        $params[] = $doctor;
        $types .= 's';
    }

    if ($appointment_date) {
        $query .= " AND DATE(appointment_date) = ?";
        $params[] = $appointment_date;
        $types .= 's';
    }

    $query .= " ORDER BY appointment_date DESC";

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $appointments = $stmt->get_result();
}

// Handle email sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    if (isset($_POST['selected_patients']) && is_array($_POST['selected_patients'])) {
        $emails = $_POST['selected_patients'];
        $emergency_message = $_POST['emergency_message'] ?? "There is an emergency with your appointment. Please contact us for further details.";

        foreach ($emails as $email) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = ''; // Replace with your email
                $mail->Password = ''; // Replace with your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('admin@citycarehospital.com', 'City Care Hospital Admin');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Emergency with your Appointment';
                $mail->Body = "
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 0;
                            padding: 0;
                            background-color: #f9f9f9;
                            color: #333;
                        }
                        .email-container {
                            max-width: 600px;
                            margin: 20px auto;
                            background-color: #ffffff;
                            border: 1px solid #ddd;
                            border-radius: 8px;
                            overflow: hidden;
                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        }
                        .email-header {
                            background-color: #4CAF50;
                            color: #ffffff;
                            padding: 20px;
                            text-align: center;
                        }
                        .email-header h1 {
                            margin: 0;
                            font-size: 24px;
                        }
                        .email-body {
                            padding: 20px;
                        }
                        .email-body p {
                            margin: 10px 0;
                        }
                        .email-footer {
                            background-color: #f1f1f1;
                            color: #777;
                            padding: 10px;
                            text-align: center;
                            font-size: 12px;
                        }
                        .email-footer a {
                            color: #4CAF50;
                            text-decoration: none;
                        }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='email-header'>
                            <h1>Urgent: Appointment Emergency</h1>
                        </div>
                        <div class='email-body'>
                            <p>Dear Patient,</p>
                            <p>$emergency_message</p>
                            <p>We apologize for any inconvenience caused. Please contact us at your earliest convenience for further details or assistance.</p>
                            <p>Thank you,</p>
                            <p><strong>City Care Hospital</strong></p>
                        </div>
                        <div class='email-footer'>
                            <p>&copy; " . date("Y") . " City Care Hospital. All rights reserved.</p>
                            <p><a href='https://www.citycarehospital.com'>Visit our website</a> | <a href='mailto:support@citycarehospital.com'>Contact Support</a></p>
                        </div>
                    </div>
                </body>
                </html>";
                
                $mail->send();
                $sent_message = "Emails sent successfully.";
            } catch (Exception $e) {
                $sent_message = "Failed to send email to some patients. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}

// Handle PDF generation and download


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download'])) {
    $query = "SELECT id, specialization, doctor, name, phone, email, age, gender, appointment_date 
              FROM appointments 
              WHERE 1 = 1";

    if ($doctor) {
        $query .= " AND doctor = '$doctor'";
    }

    if ($appointment_date) {
        $query .= " AND DATE(appointment_date) = '$appointment_date'";
    }

    $appointments = $conn->query($query);

    if ($appointments->num_rows > 0) {
        // Initialize PDF in landscape mode
        $pdf = new GlobalFPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Title
        $pdf->Cell(0, 10, 'Appointments List', 0, 1, 'C');
        $pdf->Ln(5);

        // Set column widths
        $columnWidths = [
            'id' => 15,
            'specialization' => 50,
            'doctor' => 35,
            'name' => 45,
            'phone' => 30,
            'email' => 60,
            'appointment_date' => 40
        ];

        // Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($columnWidths['id'], 10, 'ID', 1);
        $pdf->Cell($columnWidths['specialization'], 10, 'Specialization', 1);
        $pdf->Cell($columnWidths['doctor'], 10, 'Doctor', 1);
        $pdf->Cell($columnWidths['name'], 10, 'Patient', 1);
        $pdf->Cell($columnWidths['phone'], 10, 'Phone', 1);
        $pdf->Cell($columnWidths['email'], 10, 'Email', 1);
        $pdf->Cell($columnWidths['appointment_date'], 10, 'Date', 1, 1);

        // Data rows
        $pdf->SetFont('Arial', '', 10);
        while ($row = $appointments->fetch_assoc()) {
            $pdf->Cell($columnWidths['id'], 10, $row['id'], 1);
            $pdf->Cell($columnWidths['specialization'], 10, $row['specialization'], 1);
            $pdf->Cell($columnWidths['doctor'], 10, $row['doctor'], 1);
            $pdf->Cell($columnWidths['name'], 10, $row['name'], 1);
            $pdf->Cell($columnWidths['phone'], 10, $row['phone'], 1);
            $pdf->Cell($columnWidths['email'], 10, $row['email'], 1);
            $pdf->Cell($columnWidths['appointment_date'], 10, date('d-m-Y', strtotime($row['appointment_date'])), 1, 1);
        }

        // Output PDF
        $pdf->Output('D', 'appointments.pdf');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>View Appointments</h2>

    <!-- Filter Form -->
    <form method="POST" action="" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="doctor" class="form-label">Doctor:</label>
                <select id="doctor" name="doctor" class="form-control">
                    <option value="">-- Select Doctor --</option>
                    <?php foreach ($doctors as $doc): ?>
                        <option value="<?= htmlspecialchars($doc['doctor'], ENT_QUOTES, 'UTF-8') ?>"
                            <?= ($doctor === $doc['doctor']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($doc['doctor'], ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="appointment_date" class="form-label">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" class="form-control"
                       value="<?= htmlspecialchars($appointment_date ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>
        <button type="submit" name="filter" class="btn btn-primary">Filter Appointments</button>
        <button type="submit" name="download" class="btn btn-success">Download Appointments (CSV)</button>
    </form>

    <!-- Success/Error Message -->
    <?php if (!empty($sent_message)): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($sent_message) ?>
        </div>
    <?php endif; ?>

    <!-- Appointment Table -->
    <form method="POST" action="">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Select</th>
                <th>#</th>
                <th>Specialization</th>
                <th>Doctor</th>
                <th>Patient Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Appointment Date</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($appointments) && $appointments->num_rows > 0): ?>
                <?php while ($row = $appointments->fetch_assoc()): ?>
                    <tr>
                        <td><input type="checkbox" name="selected_patients[]" value="<?= $row['email'] ?>"></td>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['specialization'] ?></td>
                        <td><?= $row['doctor'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['gender'] ?></td>
                        <td><?= $row['appointment_date'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No appointments found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Message Area -->
        <div class="mb-3">
            <label for="emergency_message" class="form-label">Emergency Message:</label>
            <textarea id="emergency_message" name="emergency_message" rows="3" class="form-control"
                      placeholder="Write the emergency message here..."></textarea>
        </div>
        <button type="submit" name="send_message" class="btn btn-danger">Send Emergency Message</button>
    </form>
</div>
</body>
</html>
