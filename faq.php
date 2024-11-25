<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all FAQs from the database
$sql = "SELECT question, answer FROM faqs ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="css/faq.css">
</head>
<body>
<?php include 'Header.php'; ?>

 <!-- Page Title Section -->
<section class="page-title page-title-layout5">
  <div class="bg-img">
    <img src="assets/images/backgrounds/6.jpg" alt="background" class="img-fluid">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 d-flex justify-content-between flex-wrap align-items-center">
        <h1 class="pagetitle__heading my-3 text-light">FAQs</h1>
        <nav>
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a href="index.html" class="text-light">Home</a></li>
            <li class="breadcrumb-item"><a href="about-us.html" class="text-light">About</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">FAQs</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="faq-section pt-80 pb-70">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-4">
        <aside class="sidebar">
          <!-- Emergency Cases Widget -->
          <div class="widget widget-help mb-4">
            <div class="widget-content">
              <div class="widget__icon mb-3 text-danger">
                <i class="fas fa-phone-alt fa-2x"></i>
              </div>
              <h4 class="widget__title">Emergency Cases</h4>
              <p class="widget__desc">Feel free to contact us for any medical emergencies.</p>
              <a href="tel:+201061245741" class="phone__number d-block font-weight-bold text-primary">
                <i class="fas fa-phone-alt"></i> <span>+94 762863425</span>
              </a>
            </div>
          </div>
          <!-- Opening Hours Widget -->
          <div class="widget widget-schedule">
            <div class="widget-content">
              <div class="widget__icon mb-3 text-info">
                <i class="fas fa-clock fa-2x"></i>
              </div>
              <h4 class="widget__title">Opening Hours</h4>
              <ul class="time__list list-unstyled mb-0">
                <li><span>Monday - Friday:</span><span>8.00 am - 12:00 pm</span></li>
                <li><span>Saturday:</span><span>9.00 am - 10:00 pm</span></li>
                <li><span>Sunday:</span><span>10.00 am - 12:00 pm</span></li>
              </ul>
            </div>
          </div>
        </aside>
      </div>

      <!-- FAQ Accordion Section -->
      <div class="col-lg-8" id="accordion">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($faq = $result->fetch_assoc()): 
                // Generate unique identifier using md5 hash of the question
                $uniqueId = md5($faq['question']);
            ?>
                <div class="accordion-item mb-3">
                  <div class="accordion-header" id="heading<?= $uniqueId; ?>">
                    <h2 class="mb-0">
                      <button class="btn btn-link faq-btn" type="button" data-toggle="collapse" data-target="#collapse<?= $uniqueId; ?>">
                        <i class="fas fa-chevron-right mr-2"></i>
                        <?= htmlspecialchars($faq['question']); ?>
                      </button>
                    </h2>
                  </div>
                  <div id="collapse<?= $uniqueId; ?>" class="collapse" aria-labelledby="heading<?= $uniqueId; ?>" data-parent="#accordion">
                    <div class="accordion-body">
                      <p><?= htmlspecialchars($faq['answer']); ?></p>
                    </div>
                  </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No FAQs available.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php include 'Footer.php'; ?>

<!-- Initialize AOS -->
<script>
  AOS.init();
</script>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

</body>
</html>
