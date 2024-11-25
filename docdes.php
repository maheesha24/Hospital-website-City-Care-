<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portfolio</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/doctor-portfolio.css">
</head>
<body>
<?php include 'header.php';?>
    <section class="doctor-profile py-5">
        <div class="container">
            <div class="row">
                <!-- Doctor Image and Info -->
                <div class="col-lg-4 text-center">
                    <img src="https://via.placeholder.com/200" alt="Doctor Image" class="rounded-circle img-fluid mb-3">
                    <h1 class="doctor-name">Dr. Sarah Johnson</h1>
                    <p class="specialization">Cardiologist</p>
                    <ul class="list-inline social-icons">
                        <li class="list-inline-item">
                            <a href="#" class="text-primary"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-info"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-danger"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-dark"><i class="fab fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>

                <!-- Doctor's Bio -->
                <div class="col-lg-8">
                    <h2 class="mb-3">About Dr. Sarah Johnson</h2>
                    <p>Dr. Sarah Johnson is a leading cardiologist with over 15 years of experience in treating complex heart conditions. She is dedicated to improving the heart health of her patients and is known for her compassionate approach to care.</p>
                    <p id="doctor-email">Email: sarah.johnson@example.com</p>
                    <h3>Key Achievements</h3>
                    <ul class="list-unstyled achievements">
                        <li><i class="fas fa-check-circle text-primary"></i> Awarded "Best Cardiologist 2022"</li>
                        <li><i class="fas fa-check-circle text-primary"></i> Volunteered for heart health awareness camps</li>
                        <li><i class="fas fa-check-circle text-primary"></i> Published over 20 research papers in cardiology</li>
                    </ul>

                    <h3>Skills & Expertise</h3>
                    <div class="skills">
                        <div class="d-flex justify-content-between">
                            <p>Heart Surgery</p>
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Patient Care</p>
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Cardiac Rehabilitation</p>
                            <i class="fas fa-check-circle text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include 'footer.php';?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
