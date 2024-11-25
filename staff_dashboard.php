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
    
    'contact_messages' => 'Contact Messages',
   
    'faqs' => 'FAQs',
    'job_postings' => 'Job Postings',
    'products' => 'Products',
'doctor_schedule' => 'Schedule',
'orders' => 'Manage Orders',
    'appointments' => 'Appointments'
];

$counts = [];
foreach ($tables as $table => $label) {
    $result = $conn->query("SELECT COUNT(*) AS count FROM $table");
    $row = $result->fetch_assoc();
    $counts[$label] = $row['count'];
}

// Define the links for each card
$links = [
 
    'Contact Messages' => 'contact-us admin.php',

    'FAQs' => 'addfaq.php',
    'Job Postings' => 'add-job.php',
    'Products' => 'product_management.php',
 'Schedule' => 'manage_schedule.php',
    'Appointments' => 'admin_appoiment.php',
      'Manage Orders'=>'admin_orders.php'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-container {
            margin: 50px auto;
        }
        .dashboard-card {
            border: none;
            background: linear-gradient(to bottom right, #ffffff20, #ffffff10);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 220px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        .dashboard-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .dashboard-count {
            font-size: 30px;
            font-weight: bold;
        }
        .dashboard-title {
            font-size: 18px;
            font-weight: 600;
        }
        .dashboard-link {
            text-decoration: none;
            color: inherit;
        }
        .navbar {
            background: #ffffff10;
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
            color: white;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #e63e3e;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container d-flex justify-content-between">
            <h1>Staff Dashboard</h1>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container dashboard-container">
        <div class="row">
            <?php 
            $icons = [
                'Contact Messages' => 'fas fa-envelope',
                'FAQs' => 'fas fa-question-circle',
                'Job Postings' => 'fas fa-briefcase',
                'Products' => 'fas fa-box',
                'Appointments' => 'fas fa-calendar-check',
                'Manage Orders' => 'fas fa-shopping-cart',
                'Schedule' => 'fas fa-calendar-alt'
            ];

            foreach ($counts as $label => $count): 
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="<?php echo $links[$label]; ?>" class="dashboard-link">
                        <div class="dashboard-card">
                            <i class="dashboard-icon <?php echo $icons[$label]; ?>"></i>
                            <div class="dashboard-count"><?php echo $count; ?></div>
                            <div class="dashboard-title"><?php echo $label; ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 City Care Hospital. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
