<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
 <!-- Quicksand and Roboto Fonts from Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<!-- Fancybox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />

<!-- Fancybox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/pricing.css">
</head>
<body>

<?php include 'Header.php'; ?>

<!-- ========================
     Page Title 
=========================== -->
<section class="page-title page-title-layout3">
  <div class="bg-img">
    <img src="assets/images/page-titles/4.jpg" class="img-fluid" alt="background">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <h1 class="display-4">Providing Care for The Sickest In Community.</h1>
        <p class="lead">Medcity has been present in Europe since 1990, offering innovative solutions, specializing in medical services for treatment of medical infrastructure.</p>


          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ========================
    Pricing Section  
=========================== -->
<section class="pricing pt-0 pb-80">
  <div class="container">
    <div class="row packages-wrapper">
      <!-- Pricing Item #1 -->
      <div class="col-sm-12 col-md-4">
        <div class="pricing-package">
          <div>
            <h5 class="package__title">Starter Plan</h5>
            <p class="package__desc">We provide all aspects of medical practice for your family, including general
              check-ups.</p>
            <ul class="package__list list-unstyled">
              <li><i class="fa fa-check-circle"></i> Review your medical records.</li>
              <li><i class="fa fa-check-circle"></i> Check and test blood pressure.</li>
              <li><i class="fa fa-check-circle"></i> Run tests such as blood tests.</li>
            </ul>
          </div>
          <div class="package__footer">
            <div class="package__price">
              <span class="package__currency">LKR</span><span>2,000</span><span class="package__period">/Month</span>
            </div>
            <a href="payment.php?package=Starter%20Plan&price=2000" class="btn btn__primary btn__rounded btn-purchase">Purchase Now</a>

          </div>
        </div>
      </div>
      <!-- Pricing Item #2 -->
      <div class="col-sm-12 col-md-4">
        <div class="pricing-package">
          <div>
            <h5 class="package__title">Basic Plan</h5>
            <p class="package__desc">Fast project turnaround time, substantial cost savings & quality standards.</p>
            <ul class="package__list list-unstyled">
              <li><i class="fa fa-check-circle"></i> Review your medical records.</li>
              <li><i class="fa fa-check-circle"></i> Check and test blood pressure.</li>
              <li><i class="fa fa-check-circle"></i> Run tests such as blood tests.</li>
              <li><i class="fa fa-check-circle"></i> Check and test lung function.</li>
            </ul>
          </div>
          <div class="package__footer">
            <div class="package__price">
              <span class="package__currency">LKR</span><span>5,000</span><span class="package__period">/Month</span>
            </div>
            <a href="payment.php?package=Basic%20Plan&price=5000" class="btn btn__primary btn__rounded btn-purchase">Purchase Now</a>

          </div>
        </div>
      </div>
      <!-- Pricing Item #3 -->
      <div class="col-sm-12 col-md-4">
        <div class="pricing-package">
          <div>
            <h5 class="package__title">Advanced Plan</h5>
            <p class="package__desc">Fast project turnaround time, substantial cost savings & quality standards.</p>
            <ul class="package__list list-unstyled">
              <li><i class="fa fa-check-circle"></i> Review your medical records.</li>
              <li><i class="fa fa-check-circle"></i> Check and test blood pressure.</li>
              <li><i class="fa fa-check-circle"></i> Run tests such as blood tests.</li>
              <li><i class="fa fa-check-circle"></i> Check and test lung function.</li>
              <li><i class="fa fa-check-circle"></i> Narrowing of the arteries.</li>
              <li><i class="fa fa-check-circle"></i> Other specialized tests.</li>
            </ul>
          </div>
          <div class="package__footer">
            <div class="package__price">
              <span class="package__currency">LKR</span><span>10,000</span><span class="package__period">/Month</span>
            </div>
            <a href="payment.php?package=Advanced%20Plan&price=10000" class="btn btn__primary btn__rounded btn-purchase">Purchase Now</a>

          </div>
        </div>
      </div>
    </div>
    <!-- View Doctors' Timetable Link -->
    <div class="row">
      <div class="col-12 text-center">
        <p class="text__link mb-0">Delivering tomorrow’s health care for your family.
          <a href="doctors-timetable.html" class="btn btn__secondary btn__link mx-1">
            <span>View Doctors’ Timetable</span> <i class="icon-arrow-right icon-outlined"></i>
          </a>
        </p>
      </div>
    </div>
  </div>
</section>

    <?php include 'Footer.php'; ?>
<!-- Initialize AOS -->
<script>
  AOS.init();
</script>


<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>



<script src="script.js"></script>
</body>
</html>
