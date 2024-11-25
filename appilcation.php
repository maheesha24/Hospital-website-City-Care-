<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Fetch all active job postings
$result = $conn->query("SELECT * FROM job_postings");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications | City Care Hospital</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/job-application.css">
</head>
<body>
    <!-- Header -->
    <?php include 'Header.php'; ?>

    <!-- Job Application Information -->
    <div class="container job-application-container">
        <h1 class="text-center mb-4">Job Applications</h1>
        <p class="text-center">Explore exciting career opportunities at City Care Hospital! Apply now for the positions listed below.</p>

        <!-- Dynamic Job Postings from the Database -->
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card job-posting mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Location: <?= htmlspecialchars($row['location']); ?></h6>
                        <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                        <ul class="job-details">
                            <li><i class="fas fa-calendar-alt"></i> Application Deadline: <?= htmlspecialchars($row['deadline']); ?></li>
                            <li><i class="fas fa-user-md"></i> Required Qualifications: <?= htmlspecialchars($row['qualifications']); ?></li>
                            <li><i class="fas fa-clock"></i> Job Type: <?= htmlspecialchars($row['job_type']); ?></li>
                        </ul>
                        <a href="<?= htmlspecialchars($row['file_path']); ?>" class="btn btn-download" download>
                            <i class="fas fa-file-download"></i> Download Application Form
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No job postings available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'Footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
