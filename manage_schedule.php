<?php 
include 'db_connect.php'; // Your DB connection file

$statusMessage = ''; // Initialize status message
$doctor_id = $day = $start_time = $end_time = $availability = '';
$id = null; // Initialize the ID for editing

// Check if there's an ID in the URL for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing schedule data to populate the form
    $query = "SELECT * FROM doctor_schedule WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $schedule = $result->fetch_assoc();
        $doctor_id = $schedule['doctor_id'];
        $day = $schedule['day'];
        $start_time = $schedule['start_time'];
        $end_time = $schedule['end_time'];
        $availability = $schedule['availability'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $availability = $_POST['availability'];

    // Check if the schedule for the doctor and day already exists to avoid duplicates (only for new schedules)
    if (!$id) {
        $check_query = "SELECT * FROM doctor_schedule WHERE doctor_id = ? AND day = ? AND start_time = ? AND end_time = ?";
        $stmt_check = $conn->prepare($check_query);
        $stmt_check->bind_param("isss", $doctor_id, $day, $start_time, $end_time);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Schedule already exists, don't insert
            $statusMessage = 'This schedule already exists!';
        } else {
            // Insert new schedule
            $query = "INSERT INTO doctor_schedule (doctor_id, day, start_time, end_time, availability) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssi", $doctor_id, $day, $start_time, $end_time, $availability);
            if ($stmt->execute()) {
                $statusMessage = 'Schedule saved successfully!';
                // Redirect to avoid resubmission upon page refresh
                header("Location: manage_schedule.php");
                exit();
            } else {
                $statusMessage = 'Error: ' . $conn->error;
            }
        }
    } else {
        // Update existing schedule
        $query = "UPDATE doctor_schedule SET doctor_id=?, day=?, start_time=?, end_time=?, availability=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssii", $doctor_id, $day, $start_time, $end_time, $availability, $id);
        if ($stmt->execute()) {
            $statusMessage = 'Schedule updated successfully!';
            // Redirect to avoid resubmission upon page refresh
            header("Location: manage_schedule.php");
            exit();
        } else {
            $statusMessage = 'Error: ' . $conn->error;
        }
    }
}

// Handle availability toggling via GET
if (isset($_GET['toggle_availability'])) {
    $id = $_GET['toggle_availability'];
    $query = "UPDATE doctor_schedule SET availability = CASE WHEN availability = 1 THEN 0 ELSE 1 END WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_schedule.php"); // Redirect after toggling
    exit();
}

// Handle deletion of schedule
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM doctor_schedule WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $statusMessage = 'Schedule deleted successfully!';
    } else {
        $statusMessage = 'Error: ' . $conn->error;
    }
    header("Location: manage_schedule.php"); // Redirect after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctor's Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section>
  <div class="container my-5">
    <h2 class="text-center mb-5 text-primary">Manage Doctor's Timetable</h2>

    <!-- Success/Error Message -->
    <?php if ($statusMessage): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $statusMessage; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- Form to Add/Edit Schedule -->
    <form id="schedule-form" method="POST" action="manage_schedule.php" class="shadow-lg p-4 rounded bg-light">
      <div class="row g-3">
        <div class="col-md-4">
          <label for="doctor" class="form-label">Doctor</label>
          <select name="doctor_id" id="doctor" class="form-select shadow-sm" onchange="fetchSpecialization()">
            <option value="">Select Doctor</option>
            <?php
              // Example PHP code to fetch doctors
              $result = $conn->query("SELECT id, name FROM doctors");
              while ($row = $result->fetch_assoc()) {
                  $selected = $row['id'] == $doctor_id ? 'selected' : '';
                  echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
              }
            ?>
          </select>
        </div>

        <div class="col-md-4">
          <label for="specialization" class="form-label">Specialization</label>
          <input type="text" name="specialization" id="specialization" class="form-control shadow-sm" readonly>
        </div>

        <div class="col-md-2">
          <label for="day" class="form-label">Day</label>
          <select name="day" id="day" class="form-select shadow-sm">
            <option value="Sunday" <?php echo $day == 'Sunday' ? 'selected' : ''; ?>>Sunday</option>
            <option value="Monday" <?php echo $day == 'Monday' ? 'selected' : ''; ?>>Monday</option>
            <option value="Tuesday" <?php echo $day == 'Tuesday' ? 'selected' : ''; ?>>Tuesday</option>
            <option value="Wednesday" <?php echo $day == 'Wednesday' ? 'selected' : ''; ?>>Wednesday</option>
            <option value="Thursday" <?php echo $day == 'Thursday' ? 'selected' : ''; ?>>Thursday</option>
            <option value="Friday" <?php echo $day == 'Friday' ? 'selected' : ''; ?>>Friday</option>
            <option value="Saturday" <?php echo $day == 'Saturday' ? 'selected' : ''; ?>>Saturday</option>
          </select>
        </div>

        <div class="col-md-2">
          <label for="start_time" class="form-label">Start Time</label>
          <input type="time" name="start_time" id="start_time" class="form-control shadow-sm" value="<?php echo $start_time; ?>" required>
        </div>

        <div class="col-md-2">
          <label for="end_time" class="form-label">End Time</label>
          <input type="time" name="end_time" id="end_time" class="form-control shadow-sm" value="<?php echo $end_time; ?>" required>
        </div>

        <div class="col-md-2">
          <label for="availability" class="form-label">Available</label>
          <select name="availability" id="availability" class="form-select shadow-sm">
            <option value="1" <?php echo $availability == 1 ? 'selected' : ''; ?>>Available</option>
            <option value="0" <?php echo $availability == 0 ? 'selected' : ''; ?>>Unavailable</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-4 px-4 py-2 rounded-3 shadow-sm">Save</button>
    </form>

    <!-- Schedule Management -->
    <h3 class="text-center my-4">Current Doctor Schedules</h3>
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>

          <th>Doctor</th>
          <th>Day</th>
          <th>Time</th>
          <th>Availability</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch schedules and display
        $result = $conn->query("SELECT * FROM doctor_schedule");
        while ($row = $result->fetch_assoc()) {
            $doctor_result = $conn->query("SELECT name FROM doctors WHERE id = " . $row['doctor_id']);
            $doctor = $doctor_result->fetch_assoc();
            $availability = $row['availability'] == 1 ? 'Available' : 'Unavailable';
            echo "
            <tr>
   
              <td>{$doctor['name']}</td>
              <td>{$row['day']}</td>
              <td>{$row['start_time']} - {$row['end_time']}</td>
              <td>{$availability}</td>
              <td>
                <a href='manage_schedule.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='manage_schedule.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this schedule?\")'>Delete</a>
                <a href='manage_schedule.php?toggle_availability={$row['id']}' class='btn btn-secondary btn-sm'>{$availability}</a>
              </td>
            </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</section>

<!-- Bootstrap JS (required for alert dismiss) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function fetchSpecialization() {
  var doctor_id = document.getElementById('doctor').value;

  if (doctor_id) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'fetch_specialization.php?doctor_id=' + doctor_id, true);
    xhr.onload = function () {
      if (xhr.status == 200) {
        document.getElementById('specialization').value = xhr.responseText;
      }
    };
    xhr.send();
  }
}
</script>

</body>
</html>

