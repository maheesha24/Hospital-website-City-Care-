<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get doctor ID from URL
$doctor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch doctor details from the doctors table
$sql = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if doctor exists
if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
} else {
    echo "Doctor not found.";
    exit;
}

// Fetch qualifications images from the doctor_qualifications table
$qualification_sql = "SELECT image_path FROM doctor_qualifications WHERE doctor_id = ?";
$qualification_stmt = $conn->prepare($qualification_sql);
$qualification_stmt->bind_param("i", $doctor_id);
$qualification_stmt->execute();
$qualification_result = $qualification_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details - <?= htmlspecialchars($doctor['name']) ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .doctor-detail-container {
            margin-top: 50px;
        }

        .doctor-image {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .doctor-info {
            margin-top: 20px;
        }

        .doctor-info h2 {
            font-size: 2rem;
            color: #007bff;
        }

        .doctor-info p {
            font-size: 1.1rem;
        }

        .doctor-info strong {
            color: #333;
        }

        .bio-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .qualification-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .qualification-gallery .qualification-card {
            width: 300px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .qualification-gallery .qualification-card:hover {
            transform: scale(1.05);
        }

        .qualification-gallery .qualification-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #007bff;
        }

        /* Carousel styling */
        .carousel-inner {
            padding-bottom: 20px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <?php include 'Header.php'; ?>

    <div class="container doctor-detail-container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?= !empty($doctor['profile_image']) ? htmlspecialchars($doctor['profile_image']) : 'default-profile.jpg' ?>" alt="<?= htmlspecialchars($doctor['name']) ?>" class="img-fluid doctor-image">
            </div>
            <div class="col-md-8">
                <div class="doctor-info">
                    <h2><?= !empty($doctor['name']) ? htmlspecialchars($doctor['name']) : 'Name not provided' ?></h2>
                    <p><strong>Specialization:</strong> <?= !empty($doctor['specialization']) ? htmlspecialchars($doctor['specialization']) : 'Not provided' ?></p>
                    <p><strong>Email:</strong> <?= !empty($doctor['email']) ? htmlspecialchars($doctor['email']) : 'Not provided' ?></p>
                    <p><strong>Registration Date:</strong> <?= !empty($doctor['reg_date']) ? date("Y-m-d", strtotime($doctor['reg_date'])) : 'Not provided' ?></p>

                    <div class="bio-section">
                        <p><strong>Bio:</strong></p>
                        <p><?= !empty($doctor['bio']) ? nl2br(htmlspecialchars($doctor['bio'])) : 'Not provided' ?></p>
                    </div>

                    <div class="bio-section">
                        <p><strong>About Me:</strong></p>
                        <p><?= !empty($doctor['about_me']) ? nl2br(htmlspecialchars($doctor['about_me'])) : 'Not provided' ?></p>
                    </div>

                    <div class="bio-section">
                        <p><strong>Experience:</strong></p>
                        <p><?= !empty($doctor['experience']) ? nl2br(htmlspecialchars($doctor['experience'])) : 'Not provided' ?></p>
                    </div>

                    <div class="bio-section">
                        <p><strong>Languages:</strong></p>
                        <p><?= !empty($doctor['languages']) ? nl2br(htmlspecialchars($doctor['languages'])) : 'Not provided' ?></p>
                    </div>

                    <div class="bio-section">
                        <?php if ($qualification_result->num_rows > 0) { ?>
                            <div id="qualificationCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $first = true;
                                    while ($qualification = $qualification_result->fetch_assoc()) {
                                        $activeClass = $first ? 'active' : '';
                                        $first = false;
                                    ?>
                                        <div class="carousel-item <?= $activeClass ?>">
                                            <div class="card qualification-card">
                                                <img src="<?= !empty($qualification['image_path']) ? htmlspecialchars($qualification['image_path']) : 'default-qualification.jpg' ?>" alt="Qualification Image" class="card-img-top">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <a class="carousel-control-prev" href="#qualificationCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#qualificationCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        <?php } else { ?>
                            <p>Images Not Provided.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'Footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
