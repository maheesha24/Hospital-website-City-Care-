

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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<?php include 'Header.php'; ?>

<!-- Hero Section with Image Slider -->
<section id="hero">
    <div id="heroCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/background/main1.jpg" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to City Care Hospital</h5>
                    <p>Your health is our priority.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/background/main2.jpg" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5></h5>
                    <p>.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="image3.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Expert Doctors and Staff</h5>
                    <p>Care and compassion at every step.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-target="#heroCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-target="#heroCarousel" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </button>
    </div>
</section>
<!-- Section: Doctors with scrolling and background image -->
<section id="doctors" class="py-5">
  <div class="bg-img">

  </div>
  <div class="container">
    <div class="row text-center mb-5">
      <div class="col">
        <h2 class="heading__title">Our Professional Doctors</h2>
        <p>Meet our qualified and experienced medical professionals.</p>
      </div>
    </div>
    <div id="doctorWrapper" class="doctor-wrapper d-flex" style="overflow-x: auto; white-space: nowrap;">
      <!-- Doctor 1 -->
      <div class="doctor-card card text-center mx-3" style="display: inline-block;" data-aos="fade-up">
        <img src="assets/images/doctors/doctor1.jpg" class="card-img-top" alt="Doctor 1">
        <div class="card-body">
          <h5 class="card-title">Dr. John Doe</h5>
          <p class="card-text">Cardiologist Specialist</p>
          <p class="doctor-desc">Dr. John has over 20 years of experience in cardiology, specializing in heart disease treatments.</p>
          <div class="doctor-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
          </div>

        </div>
      </div>
      <!-- Doctor 2 -->
      <div class="doctor-card card text-center mx-3" style="display: inline-block;" data-aos="fade-up">
        <img src="assets/images/doctors/doctor2.jpg" class="card-img-top" alt="Doctor 2">
        <div class="card-body">
          <h5 class="card-title">Dr. Sarah Smith</h5>
          <p class="card-text">Pediatrician Specialist</p>
          <p class="doctor-desc">Dr. Sarah is dedicated to ensuring the health and well-being of infants and children.</p>
          <div class="doctor-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
          </div>

        </div>
      </div>
      <!-- Doctor 3 -->
      <div class="doctor-card card text-center mx-3" style="display: inline-block;" data-aos="fade-up">
        <img src="assets/images/doctors/doctor3.jpg" class="card-img-top" alt="Doctor 3">
        <div class="card-body">
          <h5 class="card-title">Dr. Emily Stone</h5>
          <p class="card-text">Neurologist Specialist</p>
          <p class="doctor-desc">Dr. Emily specializes in treating neurological disorders, providing expert care for brain and spine health.</p>
          <div class="doctor-social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
          </div>

        </div>
      </div>
      <!-- Add more doctors as needed -->
    </div>
  </div>
</section>


    <!-- Include AOS Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

<!-- ============================
    Contact Info
============================== -->
<section class="contact-info py-5">
  <div class="container">
    <div class="row row-no-gutter boxes-wrapper">
      <div class="col-sm-12 col-md-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="contact-box d-flex">
          <div class="contact__icon">
            <i class="icon-call3"></i>
          </div><!-- /.contact__icon -->
          <div class="contact__content">
            <h2 class="contact__title">Emergency Cases</h2>
            <p class="contact__desc">Please feel free to contact our friendly reception staff with any general or medical enquiry.</p>
            <a href="tel:+201061245741" class="phone__number">
              <i class="icon-phone"></i> <span>+94 762863425</span>
            </a>
          </div><!-- /.contact__content -->
        </div><!-- /.contact-box -->
      </div><!-- /.col-md-4 -->
      <div class="col-sm-12 col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
        <div class="contact-box d-flex">
          <div class="contact__icon">
            <i class="icon-health-report"></i>
          </div><!-- /.contact__icon -->
          <div class="contact__content">
            <h2 class="contact__title">Doctors Timetable</h2>
            <p class="contact__desc">Qualified doctors available six days a week, view our timetable to make an appointment.</p>
            <a href="doctorstimetb.php" class="btn btn__white btn__outlined btn__rounded">
              <span>View Timetable</span><i class="icon-arrow-right"></i>
            </a>
          </div><!-- /.contact__content -->
        </div><!-- /.contact-box -->
      </div><!-- /.col-md-4 -->
      <div class="col-sm-12 col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
        <div class="contact-box d-flex">
          <div class="contact__icon">
            <i class="icon-heart2"></i>
          </div><!-- /.contact__icon -->
          <div class="contact__content">
            <h2 class="contact__title">Opening Hours</h2>
            <ul class="time__list list-unstyled mb-0">
              <li><span>Monday - Friday</span><span>8.00 - 12:00 pm</span></li>
              <li><span>Saturday</span><span>9.00 - 10:00 pm</span></li>
              <li><span>Sunday</span><span>10.00 - 12:00 pm</span></li>
            </ul>
          </div><!-- /.contact__content -->
        </div><!-- /.contact-box -->
      </div><!-- /.col-md-4 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section><!-- /.contact-info -->

<!-- About Layout 2 Section -->
<section class="about-layout2 pb-0">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 offset-lg-1">
        <div class="heading-layout2">
          <h3 class="heading__title mb-60" data-aos="fade-up" data-aos-duration="1000">
            Improving The Quality Of Your <br> Life Through Better Health.
          </h3>
        </div><!-- /heading -->
      </div><!-- /.col-lg-7 -->
    </div><!-- /.row -->
    <div class="row">
      <div class="col-lg-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="text-with-icon">
          <div class="text__icon">
            <i class="fas fa-stethoscope"></i>
          </div>
          <div class="text__content">
            <p class="heading__desc font-weight-bold color-secondary mb-30">
              Our goal is to deliver quality of care in a courteous, respectful, and compassionate manner. We hope you will allow us to care for you and strive to be the first and best choice for healthcare.
            </p>

          </div>
        </div>
        <div class="video-banner-layout2 bg-overlay">
          <!-- Thumbnail Image -->
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg" alt="about" class="w-100 img-thumbnail">
            <!-- Play Button Overlay -->
            <a class="video__btn video__btn-white" data-toggle="modal" data-target="#videoModal">
              <div class="video__player">
                <i class="fas fa-play"></i>
              </div>
            </a>
          </div>
        </div><!-- /.video-banner -->
      </div><!-- /.col-lg-5 -->
      <div class="col-lg-7" data-aos="fade-up" data-aos-duration="1000">
        <div class="about__text bg-white p-4 p-md-5 rounded">
          <p class="heading__desc mb-30">
            Our goal is to deliver quality of care in a courteous, respectful, and compassionate manner. We hope you will allow us to care for you and to be the first and best choice for healthcare.
          </p>
          <p class="heading__desc mb-30">
            We will work with you to develop individualized care plans, including management of chronic diseases. We are committed to being the region’s premier healthcare network providing patient-centered care that inspires clinical and service excellence.
          </p>
          <ul class="list-items list-unstyled">
            <li><i class="fas fa-check-circle"></i> We conduct a range of tests to help us work out why you're not feeling well and determine the right treatment for you.</li>
            <li><i class="fas fa-check-circle"></i> Our expert doctors, nurses, and allied health professionals manage patients with a broad range of medical issues.</li>
            <li><i class="fas fa-check-circle"></i> We offer a wide range of care and support to our patients, from diagnosis to treatment and rehabilitation.</li>
          </ul>
        </div>
      </div><!-- /.col-lg-7 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section><!-- /.About Layout 2 -->

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModalLabel">Watch Our Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><div class="container">
    <div class="row">
<!-- ======================
    Features Layout 2
    ========================= -->
    <section class="features-layout2 pt-130 bg-overlay bg-overlay-primary">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="heading__layout2 mb-50">
          <h3 class="heading__title color-white" data-aos="fade-up">Our Exceptional Services That Make a Difference</h3>
        </div>
      </div><!-- /col-lg-8 -->
    </div><!-- /.row -->
    <div class="row">
      <!-- Feature item #1 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-stethoscope"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Comprehensive Medical Advice</h4>
            <p class="feature__desc">Get professional medical consultations and check-ups with our experienced doctors.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/1.avif" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #2 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-user-md"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Trusted Treatments</h4>
            <p class="feature__desc">Our treatments are reliable, based on the latest research and technology.</p>
          </div>
          <div class="feature__img">
            <img src="images/home/6.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #3 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-ambulance"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Emergency Care 24/7</h4>
            <p class="feature__desc">Available around the clock to handle urgent medical situations.</p>
          </div>
          <div class="feature__img">
            <img src="images/logo/emergency services.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #4 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-flask"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Cutting-Edge Research</h4>
            <p class="feature__desc">Engage with pioneering medical research and clinical trials.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/1.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #5 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="500">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-user-plus"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Qualified Professionals</h4>
            <p class="feature__desc">Our team consists of highly skilled and certified medical professionals.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/2.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #6 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="600">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-hospital"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">State-of-the-Art Facility</h4>
            <p class="feature__desc">Experience the highest standards of medical care with advanced equipment.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/3.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #7 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="700">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-dollar-sign"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Affordable Care</h4>
            <p class="feature__desc">Providing high-quality medical services at competitive prices.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/4.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
      <!-- Feature item #8 -->
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="800">
        <div class="feature-item">
          <div class="feature__icon">
            <i class="fas fa-bandage"></i>
          </div>
          <div class="feature__content">
            <h4 class="feature__title">Exceptional Patient Care</h4>
            <p class="feature__desc">Ensuring the best care and comfort for every patient.</p>
          </div>
          <div class="feature__img">
            <img src="images/Home/5.jpg" alt="service" class="img-responsive" loading="lazy">
          </div>
        </div><!-- /.feature-item -->
      </div><!-- /.col-lg-3 -->
    </div><!-- /.row -->

    <!-- Additional Section: Description and Button -->
    <div class="row">
      <div class="col-sm-9 col-md-9 col-lg-6 mx-auto text-center mt-5">
        <p class="heading__desc font-weight-bold color-white mb-30" data-aos="fade-up" data-aos-delay="900">
          City Care has been present in Europe since 2000, offering innovative solutions, specializing in medical services for treatment of medical infrastructure. With over 100 professionals actively participating in numerous initiatives aimed at creating sustainable change for patients!
        </p>

      </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section><!-- /.features-layout2 -->

  <!-- Inspiring Stories Section -->
  <section class="feedback-section">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-12">
          <h2 class="section-title">Inspiring Stories</h2>
          <p class="section-subtitle">What Our Patients Are Saying</p>
        </div>
      </div>
      <div class="row">
        <!-- Feedback Card #1 -->
        <div class="col-md-4 mb-4">
          <div class="card feedback-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="card-img-wrapper">
              <img src="assets/images/feedback/feedback1.jpg" class="card-img-top" alt="Jane Doe">
              <div class="overlay">
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Jane Doe</h5>
              <p class="feedback-location"><i class="fas fa-map-marker-alt"></i> New York, NY</p>
              <p class="card-text">"The care I received at City Care was exceptional. The staff was incredibly supportive and attentive to all my needs."</p>
            </div>
          </div>
        </div>
        <!-- Feedback Card #2 -->
        <div class="col-md-4 mb-4">
          <div class="card feedback-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="card-img-wrapper">
              <img src="assets/images/feedback/feedback2.jpg" class="card-img-top" alt="John Smith">
              <div class="overlay">
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">John Smith</h5>
              <p class="feedback-location"><i class="fas fa-map-marker-alt"></i> Los Angeles, CA</p>
              <p class="card-text">"I had a wonderful experience. The doctors are highly professional and the facilities are top-notch."</p>
            </div>
          </div>
        </div>
        <!-- Feedback Card #3 -->
        <div class="col-md-4 mb-4">
          <div class="card feedback-card" data-aos="fade-up" data-aos-duration="1000">
            <div class="card-img-wrapper">
              <img src="assets/images/feedback/feedback3.jpg" class="card-img-top" alt="Emily Johnson">
              <div class="overlay">
              </div>
            </div>
            <div class="card-body">
              <h5 class="card-title">Emily Johnson</h5>
              <p class="feedback-location"><i class="fas fa-map-marker-alt"></i> San Francisco, CA</p>
              <p class="card-text">"City Care exceeded my expectations. The personalized care and attention I received made a huge difference in my recovery."</p>
            </div>
          </div>
        </div>
        <!-- Add more feedback cards as needed -->
      </div>
    </div>
  </section>
<!-- Gallery Section -->
<section class="gallery-section py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">Our Gallery</h2>
                <p class="section-subtitle">Explore our hospital through these beautiful moments</p>
            </div>
        </div>
        <div class="row">
            <!-- Gallery Item #1 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="800">
                    <img src="images/Home/Operation-Theatre.jpg" class="card-img-top" alt="Gallery Image 1">
                    <div class="card-body">
                        <h5 class="card-title">Operation Theater</h5>
                        <p class="card-text">State-of-the-art equipment and technology in our operation theaters.</p>
                    </div>
                </div>
            </div>
            <!-- Gallery Item #2 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="900">
                    <img src="images/Home/patient-rooms-1.jpg" class="card-img-top" alt="Gallery Image 2">
                    <div class="card-body">
                        <h5 class="card-title">Patient Room</h5>
                        <p class="card-text">Comfortable, well-furnished rooms designed for patient care and recovery.</p>
                    </div>
                </div>
            </div>
            <!-- Gallery Item #3 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="1000">
                    <img src="images/Home/radiology-department.jpg" class="card-img-top" alt="Gallery Image 3">
                    <div class="card-body">
                        <h5 class="card-title">Radiology Department</h5>
                        <p class="card-text">Advanced radiology department for accurate diagnosis and treatment.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Gallery Item #4 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="1100">
                    <img src="images/Home/kids ward1.jpg" class="card-img-top" alt="Gallery Image 4">
                    <div class="card-body">
                        <h5 class="card-title">Children’s Ward</h5>
                        <p class="card-text">Specially designed children's ward, making young patients feel at home.</p>
                    </div>
                </div>
            </div>
            <!-- Gallery Item #5 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="1200">
                    <img src="images/about/Cafe1.jpeg" class="card-img-top" alt="Gallery Image 5">
                    <div class="card-body">
                        <h5 class="card-title">Cafeteria</h5>
                        <p class="card-text">Our hospital's cafeteria offers nutritious meals for patients and visitors.</p>
                    </div>
                </div>
            </div>
            <!-- Gallery Item #6 -->
            <div class="col-md-4 mb-4">
                <div class="card gallery-card" data-aos="fade-up" data-aos-duration="1300">
                    <img src="images/Home/doctors lounge.jpeg" class="card-img-top" alt="Gallery Image 6">
                    <div class="card-body">
                        <h5 class="card-title">Doctor’s Lounge</h5>
                        <p class="card-text">A relaxing space for our doctors during their breaks.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'livechatbot.php'; ?>

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



<script src="javascript/script.js"></script>
</body>
</html>
