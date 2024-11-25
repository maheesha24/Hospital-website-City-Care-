<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission for adding new doctor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_doctor'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $email = $conn->real_escape_string($_POST['email']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $qualifications = $conn->real_escape_string($_POST['qualifications']);
    $experience = (int)$_POST['experience'];
    $languages = $conn->real_escape_string($_POST['languages']);
    $about_me = $conn->real_escape_string($_POST['about_me']);
    $profile_image = "";

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

    // Insert doctor details into the database
    $sql = "INSERT INTO doctors (name, specialization, email, bio, qualifications, experience, languages, about_me, profile_image) 
            VALUES ('$name', '$specialization', '$email', '$bio', '$qualifications', $experience, '$languages', '$about_me', '$profile_image')";

    if ($conn->query($sql) === TRUE) {
        $doctor_id = $conn->insert_id;

        // Handle qualification images upload (Optional)
        if (isset($_FILES['qualification_images']) && $_FILES['qualification_images']['error'][0] != 4) { // Check if there are any files uploaded
            $upload_dir = "uploads/qualification_images/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            foreach ($_FILES['qualification_images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['qualification_images']['error'][$key] == 0) {
                    $file_name = basename($_FILES['qualification_images']['name'][$key]);
                    $file_path = $upload_dir . $file_name;

                    if (move_uploaded_file($tmp_name, $file_path)) {
                        $sql = "INSERT INTO doctor_qualifications (doctor_id, image_path) VALUES ($doctor_id, '$file_path')";
                        $conn->query($sql);
                    }
                }
            }
        }

        echo "<p>Doctor added successfully.</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Handle editing doctor
if (isset($_POST['edit_doctor'])) {
    $doctor_id = (int)$_POST['doctor_id'];
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
    $sql = "UPDATE doctors SET name='$name', specialization='$specialization', email='$email', bio='$bio', qualifications='$qualifications', experience=$experience, languages='$languages', about_me='$about_me', profile_image='$profile_image' WHERE id=$doctor_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Doctor updated successfully.</p>";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Handle activating/deactivating doctor
if (isset($_GET['action']) && isset($_GET['doctor_id'])) {
    $doctor_id = (int)$_GET['doctor_id'];
    $action = $_GET['action'];
    $status = ($action == 'activate') ? 'active' : 'inactive';

    // Update status of doctor
    $sql = "UPDATE doctors SET status='$status' WHERE id=$doctor_id";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Doctor status updated successfully.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Display current doctors
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Doctors</h2>

    <!-- Add Doctor Form -->
    <h3>Add a New Doctor</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization:</label>
            <select class="form-control" id="specialization" name="specialization" required>
                <option value="General Practitioner">General Practitioner</option>
                <option value="Obstetrician and Gynecologist">Obstetrician and Gynecologist</option>
                <option value="Cardiologist">Cardiologist</option>
                <option value="Otolaryngologist">Otolaryngologist (ENT Specialist)</option>
                <option value="Psychiatrist">Psychiatrist</option>
                <option value="Dentist">Dentist</option>
                <option value="Orthopedic Surgeon">Orthopedic Surgeon</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Bio:</label>
            <textarea class="form-control" id="bio" name="bio" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="qualifications" class="form-label">Qualifications:</label>
            <textarea class="form-control" id="qualifications" name="qualifications" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="experience" class="form-label">Experience (in years):</label>
            <input type="number" class="form-control" id="experience" name="experience" required>
        </div>
        <div class="mb-3">
            <label for="languages" class="form-label">Languages:</label>
            <input type="text" class="form-control" id="languages" name="languages" required>
        </div>
        <div class="mb-3">
            <label for="about_me" class="form-label">About Me:</label>
            <textarea class="form-control" id="about_me" name="about_me" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image:</label>
            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="qualification_images" class="form-label">Qualification Documents:</label>
            <input type="file" class="form-control" id="qualification_images" name="qualification_images[]" accept="image/*" multiple>
        </div>
        <button type="submit" name="add_doctor" class="btn btn-primary">Add Doctor</button>
    </form>

    <hr>

    <!-- Display Doctors Table -->
    <h3>Current Doctors</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($doctor = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['specialization']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                    <td><?php echo htmlspecialchars($doctor['status']); ?></td>
                    <td>
                        <a href="?action=activate&doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-success">Activate</a>
                        <a href="?action=deactivate&doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-danger">Deactivate</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php $conn->close(); ?>
