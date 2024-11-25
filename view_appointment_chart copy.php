<?php
require 'db_connect.php'; // Update with your database connection file

// Initialize variables
$appointments = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];

    // Query to get appointments data by doctor for the selected date
    $query = "
        SELECT doctor, COUNT(*) AS count 
        FROM appointments 
        WHERE DATE(appointment_date) = ?
        GROUP BY doctor";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $selected_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Charts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 45%; /* Adjust the width to make the charts appear side by side */
            margin: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .header-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="header-title">
        <h2>View Appointments by Day</h2>
    </div>

    <!-- Filter Form -->
    <div class="form-container">
        <form method="POST" action="">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="selected_date" class="form-label">Select Date:</label>
                    <input type="date" id="selected_date" name="selected_date" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-custom mt-3">View Charts</button>
        </form>
    </div>

    <?php if (!empty($appointments)): ?>
        <!-- Display Charts -->
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-md-6 chart-container">
                <canvas id="appointmentPieChart"></canvas>
            </div>
            
            <!-- Bar Chart -->
            <div class="col-md-6 chart-container">
                <canvas id="appointmentBarChart"></canvas>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
<?php if (!empty($appointments)): ?>
    // Prepare data for the charts
    const labels = <?php echo json_encode(array_column($appointments, 'doctor')); ?>;
    const counts = <?php echo json_encode(array_column($appointments, 'count')); ?>;
    const total = counts.reduce((sum, val) => sum + val, 0);
    const percentages = counts.map(count => Math.round((count / total) * 100)); // Remove decimals and round the percentages

    // Create Pie Chart
    const pieCtx = document.getElementById('appointmentPieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Appointment Percentages',
                data: percentages,
                backgroundColor: [
                    'rgba(255, 0, 0, 0.7)',     // Bold Red
                    'rgba(0, 0, 255, 0.7)',     // Bold Blue
                    'rgba(0, 255, 0, 0.7)',     // Bold Green
                    'rgba(255, 255, 0, 0.7)',   // Bold Yellow
                    'rgba(255, 165, 0, 0.7)',   // Bold Orange
                    'rgba(128, 0, 128, 0.7)'    // Bold Purple
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)',       // Red Border
                    'rgba(0, 0, 255, 1)',       // Blue Border
                    'rgba(0, 255, 0, 1)',       // Green Border
                    'rgba(255, 255, 0, 1)',     // Yellow Border
                    'rgba(255, 165, 0, 1)',     // Orange Border
                    'rgba(128, 0, 128, 1)'      // Purple Border
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}%`;
                        }
                    }
                }
            }
        }
    });

    // Create Bar Chart
    const barCtx = document.getElementById('appointmentBarChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Appointments Count',
                data: counts,
                backgroundColor: [
                    'rgba(255, 0, 0, 0.7)',     // Bold Red
                    'rgba(0, 0, 255, 0.7)',     // Bold Blue
                    'rgba(0, 255, 0, 0.7)',     // Bold Green
                    'rgba(255, 255, 0, 0.7)',   // Bold Yellow
                    'rgba(255, 165, 0, 0.7)',   // Bold Orange
                    'rgba(128, 0, 128, 0.7)'    // Bold Purple
                ],
                borderColor: [
                    'rgba(255, 0, 0, 1)',       // Red Border
                    'rgba(0, 0, 255, 1)',       // Blue Border
                    'rgba(0, 255, 0, 1)',       // Green Border
                    'rgba(255, 255, 0, 1)',     // Yellow Border
                    'rgba(255, 165, 0, 1)',     // Orange Border
                    'rgba(128, 0, 128, 1)'      // Purple Border
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
<?php endif; ?>
</script>
</body>
</html>
