<?php
include 'db_connect.php'; // Ensure database connection

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['contact-name'];
    $email = $_POST['contact-email'];
    $phone = $_POST['contact-phone'];
    $subject = $_POST['subject'];
    $message = $_POST['contact-message'];

    // Generate new ID manually
    $result = mysqli_query($conn, "SELECT MAX(id) AS max_id FROM contact_messages");
    $row = mysqli_fetch_assoc($result);
    $new_id = $row['max_id'] + 1;

    // Insert the message into the database
    $sql = "INSERT INTO contact_messages (id, name, email, phone, subject, message) 
            VALUES ($new_id, '$name', '$email', '$phone', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Message submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)]);
    }
    exit; // Stop further execution after returning the AJAX response
}
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
    <link rel="stylesheet" href="css/contactus.css">
</head>
<body>
    
<?php include 'Header.php'; ?>
<!-- ========================= 
     Google Map
=========================  -->
<section class="google-map py-0">
  <iframe frameborder="0" height="500" width="100%" 
    src="https://maps.google.com/maps?q=Suite%20100%20San%20Francisco%2C%20LA%2094107%20United%20States&amp;t=m&amp;z=10&amp;output=embed&amp;iwloc=near" 
    class="w-100">
  </iframe>
</section><!-- /.Google Map -->
<!-- ========================== Contact Layout 1 ========================= -->
<section class="contact-layout1 pt-0 mt-n5">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="contact-panel d-flex flex-wrap shadow-lg rounded overflow-hidden">
          <!-- Contact Form -->
          <form class="contact-panel__form p-4 col-md-7" id="contactForm">
            <h4 class="contact-panel__title mb-4">How Can We Help?</h4>

            <!-- Message display area -->
            <div id="contact-result" style="display: none;"></div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="form-group position-relative">
                  <i class="fas fa-user position-absolute form-icon"></i>
                  <input type="text" class="form-control" placeholder="Your Name" id="contact-name" name="contact-name" required>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group position-relative">
                  <i class="fas fa-envelope position-absolute form-icon"></i>
                  <input type="email" class="form-control" placeholder="Your Email" id="contact-email" name="contact-email" required>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group position-relative">
                  <i class="fas fa-phone position-absolute form-icon"></i>
                  <input type="text" class="form-control" placeholder="Your Phone" id="contact-phone" name="contact-phone" required>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group position-relative">
                  <i class="fas fa-book position-absolute form-icon"></i>
                  <select class="form-control" name="subject" id="subject" required>
                    <option value="" disabled selected>Select Subject</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Medical Support">Medical Support</option>
                    <option value="Appointment">Appointment</option>
                  </select>
                </div>
              </div>
              <div class="col-12 mb-4">
                <div class="form-group position-relative">
                  <i class="fas fa-comment-dots position-absolute form-icon"></i>
                  <textarea class="form-control" placeholder="Your Message" id="contact-message" name="contact-message" rows="5" required></textarea>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block btn-lg">Submit Request <i class="fas fa-paper-plane ml-2"></i></button>
              </div>
            </div>
          </form>

          <!-- Quick Contact Info -->
          <div class="contact-panel__info p-5 col-md-5 text-white d-flex flex-column justify-content-between bg-primary position-relative">
            <div class="text-white z-index-1">
              <h4 class="contact-panel__title">Quick Contacts</h4>
              <p class="font-weight-bold mb-4">Feel free to contact our staff for any medical inquiry.</p>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fas fa-phone-alt"></i> <strong>Emergency Line:</strong> +94 762863425</li>
                <li class="mb-2"><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> City Care Hospital,Matara</li>
                <li><i class="fas fa-clock"></i> <strong>Hours:</strong> Mon - Fri: 8:00 am - 12:00 pm</li>
              </ul>
            </div>
            <div class="mt-4 z-index-1">
              <a href="#" class="btn btn-light btn-lg btn-block">Contact Us</a>
            </div>
          </div>
        </div>
      </div><!-- /.col-12 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</section><!-- /.Contact Layout 1 -->

<?php include 'Footer.php'; ?>

<!-- jQuery (for AJAX) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#contactForm').on('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting the default way

        $.ajax({
            url: '', // PHP file (current page) to process form
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                // Display success/error message
                var resultDiv = $('#contact-result');
                resultDiv.html('<div class="alert alert-' + (response.status === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
                resultDiv.fadeIn();

                // Fade out message after 5 seconds
                setTimeout(function() {
                    resultDiv.fadeOut();
                }, 5000);

                // Reset the form if the submission is successful
                if (response.status === 'success') {
                    $('#contactForm')[0].reset();
                }
            }
        });
    });
});
</script>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
