<?php
include 'db_connect.php'; // Your DB connection file

// Check if doctor_id is passed in the request
if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];

    // Fetch specialization from doctors table
    $query = "SELECT specialization FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Return specialization
        echo $row['specialization'];
    } else {
        echo "Specialization not found";
    }
}
?>
