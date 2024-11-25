<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Timetable | City Care Hospital</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Quicksand and Roboto Fonts from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Fancybox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/timetable.css">
    
    <!-- Inline CSS for gap between schedules -->
    <style>
    /* Add space between events */
    .event {
        margin-bottom: 10px; /* Adjust this value to control the gap between schedules */
    }
    
    /* Optionally, you can also add some padding for better spacing */
    .event__header {
        padding-bottom: 5px;
    }

    .event__time {
        padding-bottom: 5px;
    }

    /* Style for available schedules with transparent background */
    .available {
        background-color: rgba(40, 167, 69, 0.3); /* Green with transparency */
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    /* Style for unavailable schedules with transparent background */
    .unavailable {
        background-color: rgba(220, 53, 69, 0.3); /* Red with transparency */
        color: white;
        padding: 5px;
        border-radius: 5px;
        margin-bottom: 5px;
    }
</style>

</head>
<body>

<?php include 'Header.php'; ?>

<!-- ========================
   Page Title 
=========================== -->
<section class="page-title page-title-layout5">
  <div class="bg-img">
    <img src="images/background/5.png" alt="background" class="img-fluid">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 d-flex justify-content-between flex-wrap align-items-center">
        <h1 class="pagetitle__heading my-3 text-light">Doctor’s Timetable</h1>
        <nav>
          <ol class="breadcrumb my-3">
            <li class="breadcrumb-item"><a href="index.html" class="text-light">Home</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">Doctor's Timetable</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>

<!-- ========================
   Doctors Timetable
=========================== -->
<section>
  <div class="container">
    <div class="row">
      <div class="col-12 mb-4">
        <!-- Legend Section -->
        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center mr-3">
            <div class="available" style="width: 20px; height: 20px; margin-right: 5px;"></div>
            <span>Available</span>
          </div>
          <div class="d-flex align-items-center">
            <div class="unavailable" style="width: 20px; height: 20px; margin-right: 5px;"></div>
            <span>Unavailable</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="table-responsive">
          <table class="doctors-timetable w-100">
            <!-- Table structure remains the same -->
            <thead>
              <tr>
                <th>Sunday</th>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Database connection
              $conn = new mysqli("localhost", "root", "", "hospital_db");

              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }

              // Fetch data using JOIN
              $sql = "
                  SELECT 
                      d.name AS doctor_name, 
                      d.specialization, 
                      s.day, 
                      TIME_FORMAT(s.start_time, '%h:%i %p') AS start_time, 
                      TIME_FORMAT(s.end_time, '%h:%i %p') AS end_time, 
                      s.availability
                  FROM 
                      doctors d
                  INNER JOIN 
                      doctor_schedule s ON d.id = s.doctor_id
                  WHERE 
                      d.status = 'active'
                  ORDER BY 
                      d.name, FIELD(s.day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), s.start_time
              ";

              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                  $events = [];

                  // Loop through each row and categorize events by day
                  while ($row = $result->fetch_assoc()) {
                      // Get the availability value (0 or 1)
                      $availability = $row['availability'];

                      // Set the class based on availability
                      $availability_class = ($availability == 1) ? 'available' : 'unavailable';

                      $day_index = array_search($row['day'], $days);
                      $events[$day_index][] = [
                          'start_time' => $row['start_time'],
                          'end_time' => $row['end_time'],
                          'doctor_name' => $row['doctor_name'],
                          'specialization' => $row['specialization'],
                          'availability' => $availability_class // Store class name, not value
                      ];
                  }

                  // Output the timetable
                  echo "<tr>";

                  // Loop through the days of the week
                  foreach ($days as $day_index => $day) {
                      echo "<td>";

                      // Output each day's events
                      if (isset($events[$day_index])) {
                          foreach ($events[$day_index] as $event) {
                              echo "<div class='event " . htmlspecialchars($event['availability']) . "'>";
                              echo "<a class='event__header' href='#'>" . htmlspecialchars($event['doctor_name']) . "</a>";
                              echo "<div class='event__time'><span>" . htmlspecialchars($event['start_time']) . "</span> - <span>" . $event['end_time'] . "</span></div>";
                              echo "<div class='doctor__name'>" . htmlspecialchars($event['specialization']) . "</div>";
                              echo "</div>";
                          }
                      } else {
                          echo "<p>No schedule available</p>";
                      }

                      echo "</td>";
                  }

                  echo "</tr>";
              } else {
                  echo "<tr><td colspan='7' class='text-center'>No data available</td></tr>";
              }

              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
        <!-- "Book an Appointment" Button -->
        <div class="text-center mt-4">
          <a href="appoiment.php" class="btn btn-primary btn-lg">Book an Appointment</a>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
