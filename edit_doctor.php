<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctor details for editing
if (isset($_GET['id'])) {
    $doctor_id = (int)$_GET['id'];
    $sql = "SELECT * FROM doctors WHERE id = $doctor_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
    } else {
        die("Doctor not found.");
    }
}

// Handle form submission for editing doctor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_doctor'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $email = $conn->real_escape_string($_POST['email']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $qualifications = $conn->real_escape_string($_POST['qualifications']);
    $experience = (int)$_POST['experience'];
    $languages = $conn->real_escape_string($_POST['languages']);
    $about_me = $conn->real_escape_string($_POST['about_me']);
    $profile_image = $_POST['current_profile_image'];

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $upload_dir = "uploads/profile_images/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $profile_image = $upload_dir . basename($_FILES["profile_image"]["name"]);
        if (!move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image)) {
            die("Failed to upload profile image.");
        }
    }

    // Update doctor details
    $sql = "UPDATE doctors 
            SET name='$name', specialization='$specialization', email='$email', bio='$bio', 
                qualifications='$qualifications', experience=$experience, languages='$languages', 
                about_me='$about_me', profile_image='$profile_image' 
            WHERE id=$doctor_id";

    if ($conn->query($sql) === TRUE) {
        // Step 1: Remove old qualification documents
        $delete_sql = "SELECT image_path FROM doctor_qualifications WHERE doctor_id = $doctor_id";
        $result = $conn->query($delete_sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $file_path = $row['image_path'];
                if (file_exists($file_path)) {
                    unlink($file_path); // Delete the file from the server
                }
            }
        }

        // Delete old database records
        $conn->query("DELETE FROM doctor_qualifications WHERE doctor_id = $doctor_id");

        // Step 2: Upload new qualification documents
        if (isset($_FILES['qualification_documents']) && $_FILES['qualification_documents']['error'][0] != 4) {
            $upload_dir = "uploads/qualification_images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            foreach ($_FILES['qualification_documents']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['qualification_documents']['error'][$key] == 0) {
                    $file_name = basename($_FILES['qualification_documents']['name'][$key]);
                    $file_path = $upload_dir . $file_name;

                    if (move_uploaded_file($tmp_name, $file_path)) {
                        $sql = "INSERT INTO doctor_qualifications (doctor_id, image_path) VALUES ($doctor_id, '$file_path')";
                        $conn->query($sql);
                    }
                }
            }
        }

        // Feedback message without redirection
        $update_message = "Doctor updated successfully.";
    } else {
        $update_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Doctor</h2>
    <?php if (isset($update_message)): ?>
        <p class="message"><?php echo $update_message; ?></p>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="current_profile_image" value="<?= $doctor['profile_image'] ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="<?= htmlspecialchars($doctor['name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization:</label>
            <input type="text" class="form-control" id="specialization" name="specialization" 
                   value="<?= htmlspecialchars($doctor['specialization'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?= htmlspecialchars($doctor['email'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio:</label>
            <textarea class="form-control" id="bio" name="bio" rows="3" required><?= htmlspecialchars($doctor['bio'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="qualifications" class="form-label">Qualifications:</label>
            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" required><?= htmlspecialchars($doctor['qualifications'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="experience" class="form-label">Experience (in years):</label>
            <input type="number" class="form-control" id="experience" name="experience" 
                   value="<?= htmlspecialchars($doctor['experience'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="languages" class="form-label">Languages:</label>
            <input type="text" class="form-control" id="languages" name="languages" 
                   value="<?= htmlspecialchars($doctor['languages'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="about_me" class="form-label">About Me:</label>
            <textarea class="form-control" id="about_me" name="about_me" rows="3" required><?= htmlspecialchars($doctor['about_me'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image:</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
            <?php if (!empty($doctor['profile_image'])): ?>
                <img src="<?= $doctor['profile_image'] ?>" alt="Profile Image" width="100" class="mt-2">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="qualification_documents" class="form-label">Qualification Documents:</label>
            <input type="file" class="form-control" id="qualification_documents" name="qualification_documents[]" accept="image/*" multiple>
        </div>
        <button type="submit" class="btn btn-primary" name="edit_doctor">Save Changes</button>
        <a href="manage_doctors.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
