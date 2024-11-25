<?php 
session_start();

// Database connection
$host = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "hospital_db"; // Replace with your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts from each table
$tables = [
    'blogs' => 'Blogs',
    'contact_messages' => 'Contact Messages',
    'doctors' => 'Doctors',
    'faqs' => 'FAQs',
    'job_postings' => 'Job Postings',
    'products' => 'Products',
    'reviews' => 'Reviews',
    'users' => 'Users',
    'appointments' => 'Appointments',
    'doctor_schedule' => 'Schedule',
    'orders' => 'Manage Orders',
    
     // Corrected to match "Appointments"

];



$counts = [];
foreach ($tables as $table => $label) {
    $result = $conn->query("SELECT COUNT(*) AS count FROM $table");
    $row = $result->fetch_assoc();
    $counts[$label] = $row['count'];
}
$counts['Charts Appointments'] = '';
$counts['Charts Orders'] = '';
// Define the links for each card
$links = [
    'Blogs' => 'add_blog.php',
    'Contact Messages' => 'contact-us admin.php',
    'Doctors' => 'adddoctors.php',
    'FAQs' => 'addfaq.php',
    'Job Postings' => 'add-job.php',
    'Products' => 'product_management.php',
    'Reviews' => 'admin _reviews.php',
    'Users' => 'user_add.php',
    'Appointments' => 'admin_appoiment.php',
    'Charts Appointments' => 'view_appointment_chart copy.php',

    'Schedule' => 'manage_schedule.php',
'Manage Orders'=>'admin_orders.php',
'Charts Orders' => 'view_orders_chart.php',

];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .welcome-message {
            margin: 30px 0;
            color: #333;
            font-size: 24px;
            text-align: center;
            font-weight: 600;
        }
        .dashboard-container {
            margin-top: 50px;
        }
        .dashboard-card {
            border-radius: 10px;
            border: 1px solid #ddd;
            background: white;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            height: 250px; /* Ensure all cards are the same size */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .dashboard-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        .dashboard-icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .dashboard-count {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .dashboard-link {
            text-decoration: none;
            color: inherit;
        }
        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }
        .card-body p {
            color: #666;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            color: #888;
            margin-top: 30px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logout Button -->
        <a href="logout.php" class="logout-btn">Logout</a>

        <div class="welcome-message">
            <h1>Welcome, Admin!</h1>
            <p>Your admin dashboard is ready to manage the hospital efficiently.</p>
        </div>

        <div class="dashboard-container">
            <div class="row">
                <?php 

$icons = [
    'Blogs' => 'fas fa-blog',
    'Contact Messages' => 'fas fa-envelope',
    'Doctors' => 'fas fa-user-md',
    'FAQs' => 'fas fa-question-circle',
    'Job Postings' => 'fas fa-briefcase',
    'Products' => 'fas fa-box-open',
    'Reviews' => 'fas fa-star',
    'Users' => 'fas fa-users',
    'Appointments' => 'fas fa-calendar-check',
    'Charts Appointments' => 'fas fa-chart-pie',
  'Schedule' => 'fas fa-calendar-alt',
  'Manage Orders' => 'fas fa-shopping-cart',
  'Charts Orders' => 'fas fa-chart-pie'
];

                foreach ($counts as $label => $count): 
                ?>
                    <div class="col-md-3 mb-4">
                        <a href="<?php echo $links[$label]; ?>" class="dashboard-link">
                            <div class="card dashboard-card">
                                <div class="card-body">
                                    <i class="dashboard-icon <?php echo $icons[$label]; ?>"></i>
                                    <div class="dashboard-count"><?php echo $count; ?></div>
                                    <h5 class="card-title"><?php echo $label; ?></h5>
                                    <p>Manage your <?php echo strtolower($label); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 City Care Hospital. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
