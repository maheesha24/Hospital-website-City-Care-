<?php 
session_start();
include 'db_connect.php'; // Ensure this file connects to your database

// Initialize variables
$reviews = [];
$message = ''; // Variable to store success or error messages

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header('Location: login.php');
        exit(); // Ensure no further code is executed
    }

    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Insert review into the database
    $sql = "INSERT INTO reviews (user_id, review, rating) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isi", $user_id, $review, $rating);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "Review submitted successfully!";
        $_POST = []; // Clear the form fields
    } else {
        $message = "Error submitting review. Please try again.";
    }
    
    mysqli_stmt_close($stmt);
}

// Fetch accepted reviews from the database
$sql = "SELECT reviews.id, reviews.review, reviews.created_at, reviews.rating, users.name 
        FROM reviews 
        JOIN users ON reviews.user_id = users.id 
        WHERE reviews.status = 'accepted' 
        ORDER BY reviews.created_at DESC";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/review.css"> <!-- Link to the separate CSS file -->
    <title>Customer Reviews</title>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">Share Your Experience</h1>

    <?php if ($message): ?>
        <div class="alert alert-info" id="message" role="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Review Submission Form -->
    <form method="POST" class="mb-5">
        <div class="form-group">
            <label for="review">Your Review</label>
            <textarea id="review" name="review" class="form-control" rows="3" required><?php echo isset($_POST['review']) ? htmlspecialchars($_POST['review']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label>Rating</label>
            <div class="star-rating">
                <input type="radio" id="star1" name="rating" value="1" required>
                <label for="star1" class="fa fa-star"></label>
                <input type="radio" id="star2" name="rating" value="2" <?php echo isset($_POST['rating']) && $_POST['rating'] == 2 ? 'checked' : ''; ?>>
                <label for="star2" class="fa fa-star"></label>
                <input type="radio" id="star3" name="rating" value="3" <?php echo isset($_POST['rating']) && $_POST['rating'] == 3 ? 'checked' : ''; ?>>
                <label for="star3" class="fa fa-star"></label>
                <input type="radio" id="star4" name="rating" value="4" <?php echo isset($_POST['rating']) && $_POST['rating'] == 4 ? 'checked' : ''; ?>>
                <label for="star4" class="fa fa-star"></label>
                <input type="radio" id="star5" name="rating" value="5" <?php echo isset($_POST['rating']) && $_POST['rating'] == 5 ? 'checked' : ''; ?>>
                <label for="star5" class="fa fa-star"></label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>

    <h2>Customer Reviews:</h2>
    <div class="row">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="col-md-4 mb-4">
                    <div class="review-card">
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if ($i <= $review['rating']): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="review-name"><?php echo htmlspecialchars($review['name']); ?></div>
                        <p class="review-text"><?php echo htmlspecialchars($review['review']); ?></p>
                        <div class="date-posted">Posted on <?php echo htmlspecialchars($review['created_at']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info col-12">No reviews yet.</div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Check if message exists and fade out after 5 seconds
        var message = $('#message');
        if (message.length) {
            message.show(); // Ensure the message is shown
            setTimeout(function() {
                message.fadeOut(); // Fade out after 5 seconds
            }, 5000); 
        }
    });
</script>
</body>
</html>
