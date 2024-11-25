<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all active doctors (deactivated ones are excluded)
$sql = "SELECT * FROM doctors WHERE status = 'active'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="css/doctorsgrid.css">
</head>
<body>
    <?php include 'Header.php'; ?>

    <section class="page-title page-title-layout5" data-aos="fade-up">

      <div class="container">
        <div class="row">
          <div class="col-12 d-flex justify-content-between flex-wrap align-items-center">
            <h1 class="pagetitle__heading my-3 text-light">Our Doctors</h1>
            <nav>
              <ol class="breadcrumb my-3">
                <li class="breadcrumb-item"><a href="index.html" class="text-light">Home</a></li>
                <li class="breadcrumb-item"><a href="about-us.html" class="text-light">Doctors</a></li>
                <li class="breadcrumb-item active text-light" aria-current="page">Our Doctors</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section>

    <section class="team-layout3 pb-40">
      <div class="container">
        <div class="row">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($doctor = $result->fetch_assoc()): ?>
              <div class="col-sm-6 col-md-4 col-lg-4" data-aos="fade-up">
                <div class="member">
                  <div class="member__img">
                    <a href="doctor-details.php?id=<?= htmlspecialchars($doctor['id']) ?>">
                      <img src="<?= htmlspecialchars($doctor['profile_image']) ?>" 
                           alt="<?= htmlspecialchars($doctor['name']) ?>" 
                           class="img-fluid">
                    </a>
                  </div>
                  <div class="member__info">
                    <h5 class="member__name">
                      <a href="doctor-details.php?id=<?= htmlspecialchars($doctor['id']) ?>">
                        <?= htmlspecialchars($doctor['name']) ?>
                      </a>
                    </h5>
                    <p class="member__job"><?= htmlspecialchars($doctor['specialization']) ?></p>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="text-center">No doctors found.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <?php include 'Footer.php'; ?>

    <script>
      AOS.init();
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
</body>
</html>

<?php $conn->close(); ?>
