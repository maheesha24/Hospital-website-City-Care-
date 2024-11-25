<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form inputs
$title = $location = $description = $deadline = $qualifications = $type = $file_path = '';
$edit_job_id = '';
$message = '';

// Handle adding a new job posting
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use null coalescing operator to provide default values
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $location = $conn->real_escape_string($_POST['location'] ?? '');
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $deadline = $conn->real_escape_string($_POST['deadline'] ?? '');
    $qualifications = $conn->real_escape_string($_POST['qualifications'] ?? '');
    $type = $conn->real_escape_string($_POST['type'] ?? '');
    $file_path = '';

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = basename($_FILES['file']['name']);
        $file_path = "uploads/" . $file_name; // Ensure the uploads directory exists
        
        if (move_uploaded_file($file_tmp, $file_path)) {
            $message = "File uploaded successfully.";
        } else {
            $message = "File upload failed.";
        }
    }

    // Check if it's an edit or add
    if (isset($_POST['edit_job_id']) && !empty($_POST['edit_job_id'])) {
        // Update job posting
        $job_id = $_POST['edit_job_id'];
        $sql = "UPDATE job_postings SET 
                title='$title', 
                location='$location', 
                description='$description', 
                deadline='$deadline', 
                qualifications='$qualifications', 
                job_type='$type', 
                file_path='$file_path' 
                WHERE id='$job_id'";
    } else {
        // Insert new job posting
        $sql = "INSERT INTO job_postings (title, location, description, deadline, qualifications, job_type, file_path) 
                VALUES ('$title', '$location', '$description', '$deadline', '$qualifications', '$type', '$file_path')";
    }
    
    if ($conn->query($sql)) {
        $message = !empty($edit_job_id) ? "Job updated successfully." : "Job added successfully.";
        
        // Clear the form fields
        $title = $location = $description = $deadline = $qualifications = $type = '';
    } else {
        $message = "Error: " . $conn->error;
    }
}



// Handle deleting a job posting
if (isset($_GET['delete_id'])) {
    $job_id = $_GET['delete_id'];
    $sql = "DELETE FROM job_postings WHERE id='$job_id'";
    if ($conn->query($sql)) {
        $message = "Job deleted successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch all job postings
$sql = "SELECT * FROM job_postings";
$result = $conn->query($sql);

// Handle editing job postings
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_result = $conn->query("SELECT * FROM job_postings WHERE id='$edit_id'");
    if ($edit_result->num_rows > 0) {
        $edit_job = $edit_result->fetch_assoc();
        $title = $edit_job['title'] ?? ''; 
        $location = $edit_job['location'] ?? '';
        $description = $edit_job['description'] ?? '';
        $deadline = $edit_job['deadline'] ?? '';
        $qualifications = $edit_job['qualifications'] ?? '';
        $type = $edit_job['job_type'] ?? '';
        $file_path = $edit_job['file_path'] ?? '';
        $edit_job_id = $edit_job['id'] ?? ''; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Job Applications | City Care Hospital</title>
    <link rel="stylesheet" href="css/job-application.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .fade-out {
            transition: opacity 0.5s ease;
            opacity: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Manage Job Postings</h1>

        <?php if ($message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert" id="message">
                <?= htmlspecialchars($message); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                setTimeout(function() {
                    const message = document.getElementById('message');
                    if (message) {
                        message.classList.add('fade-out');
                        setTimeout(function() {
                            message.remove();
                        }, 500);
                    }
                }, 5000);
            </script>
        <?php endif; ?>

        <!-- Form for Adding or Editing Job Postings -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_job_id" value="<?= htmlspecialchars($edit_job_id); ?>">
            <div class="form-group">
                <label for="title">Job Title</label>
                <input type="text" class="form-control" name="title" required value="<?= htmlspecialchars($title); ?>">
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" name="location" required value="<?= htmlspecialchars($location); ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" required><?= htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-group">
                <label for="deadline">Application Deadline</label>
                <input type="date" class="form-control" name="deadline" required value="<?= htmlspecialchars($deadline); ?>">
            </div>
            <div class="form-group">
                <label for="qualifications">Required Qualifications</label>
                <input type="text" class="form-control" name="qualifications" required value="<?= htmlspecialchars($qualifications); ?>">
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <select class="form-control" name="type" required>
                    <option value="" disabled <?= empty($type) ? 'selected' : ''; ?>>Select Job Type</option>
                    <option value="Full Time" <?= $type == 'Full Time' ? 'selected' : ''; ?>>Full Time</option>
                    <option value="Part Time" <?= $type == 'Part Time' ? 'selected' : ''; ?>>Part Time</option>
                </select>
            </div>
            <div class="form-group">
                <label for="file">Upload PDF</label>
                <input type="file" class="form-control-file" name="file" accept="application/pdf">
            </div>
            <button type="submit" class="btn btn-primary">
                <?= !empty($edit_job_id) ? 'Update Job' : 'Add Job'; ?>
            </button>
        </form>

        <hr>

        <!-- Display Job Postings -->
        <h2 class="text-center mb-4">Current Job Postings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Application Deadline</th>
                    <th>Qualifications</th>
                    <th>Job Type</th>
                    <th>File</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['title']); ?></td>
                        <td><?= htmlspecialchars($job['location']); ?></td>
                        <td><?= htmlspecialchars($job['description']); ?></td>
                        <td><?= htmlspecialchars($job['deadline']); ?></td>
                        <td><?= htmlspecialchars($job['qualifications']); ?></td>
                        <td><?= htmlspecialchars($job['job_type']); ?></td>
                        <td>
                            <?php if ($job['file_path']): ?>
                                <a href="<?= htmlspecialchars($job['file_path']); ?>" target="_blank">View PDF</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?edit_id=<?= $job['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete_id=<?= $job['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job posting?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
