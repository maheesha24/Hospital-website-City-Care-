<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "hospital_db");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['specialization'])) {
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    
    // Query to fetch doctors based on specialization
    $sql = "SELECT id, name FROM doctors WHERE specialization = '$specialization' AND status = 'active'";
    $result = mysqli_query($conn, $sql);

    $doctors = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }

    // Return doctors in JSON format
    echo json_encode($doctors);
}
?>
