<?php 
session_start();
include 'db_connect.php'; // Ensure this file connects to your database

// Initialize messages
$message = '';
$message_type = '';

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_review_id'])) {
        // Delete review
        $review_id = intval($_POST['delete_review_id']);
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $review_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Set success message
        $message = 'Review deleted successfully.';
        $message_type = 'success';
    } else {
        // Accept or reject review
        $review_id = intval($_POST['review_id']);
        $action = $_POST['action']; // 'accept' or 'reject'

        if ($action == 'accept') {
            $sql = "UPDATE reviews SET status = 'accepted' WHERE id = ?";
            $message = 'Review accepted successfully.';
            $message_type = 'success';
        } else {
            $sql = "UPDATE reviews SET status = 'rejected' WHERE id = ?";
            $message = 'Review rejected successfully.';
            $message_type = 'danger';
        }

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $review_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Fetch pending reviews
$sql_pending = "SELECT reviews.id, reviews.review, reviews.created_at, reviews.rating, users.name 
                FROM reviews JOIN users ON reviews.user_id = users.id 
                WHERE reviews.status = 'pending' 
                ORDER BY reviews.created_at DESC";
$result_pending = mysqli_query($conn, $sql_pending);

$pending_reviews = [];
if ($result_pending) {
    while ($row = mysqli_fetch_assoc($result_pending)) {
        $pending_reviews[] = $row;
    }
}

// Fetch accepted reviews
$sql_accepted = "SELECT reviews.id, reviews.review, reviews.created_at, reviews.rating, users.name 
                 FROM reviews JOIN users ON reviews.user_id = users.id 
                 WHERE reviews.status = 'accepted' 
                 ORDER BY reviews.created_at DESC";
$result_accepted = mysqli_query($conn, $sql_accepted);

$accepted_reviews = [];
if ($result_accepted) {
    while ($row = mysqli_fetch_assoc($result_accepted)) {
        $accepted_reviews[] = $row;
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
    <title>Admin Review Management</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .review-card {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .review-card:hover {
            transform: scale(1.05);
        }
        .star-rating i {
            color: #ffcc00;
        }
        .review-name {
            font-weight: bold;
        }
        .date-posted {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Manage Reviews</h1>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert" id="message">
            <?php echo $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <h2>Pending Reviews</h2>
    <?php if (!empty($pending_reviews)): ?>
        <div class="d-flex flex-wrap">
            <?php foreach ($pending_reviews as $review): ?>
                <div class="review-card col-md-4">
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?php echo ($i <= $review['rating']) ? 'fas fa-star' : 'far fa-star'; ?>"></span>
                        <?php endfor; ?>
                    </div>
                    <div class="review-name"><?php echo htmlspecialchars($review['name']); ?></div>
                    <p class="review-text"><?php echo htmlspecialchars($review['review']); ?></p>
                    <div class="date-posted">Posted on <?php echo htmlspecialchars($review['created_at']); ?></div>
                    <form method="POST" class="mt-2">
                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No pending reviews.</div>
    <?php endif; ?>

    <h2 class="mt-5">Accepted Reviews</h2>
    <?php if (!empty($accepted_reviews)): ?>
        <div class="d-flex flex-wrap">
            <?php foreach ($accepted_reviews as $review): ?>
                <div class="review-card col-md-4">
                    <div class="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?php echo ($i <= $review['rating']) ? 'fas fa-star' : 'far fa-star'; ?>"></span>
                        <?php endfor; ?>
                    </div>
                    <div class="review-name"><?php echo htmlspecialchars($review['name']); ?></div>
                    <p class="review-text"><?php echo htmlspecialchars($review['review']); ?></p>
                    <div class="date-posted">Posted on <?php echo htmlspecialchars($review['created_at']); ?></div>
                    <form method="POST" class="mt-2">
                        <input type="hidden" name="delete_review_id" value="<?php echo $review['id']; ?>">
                        <button type="submit" class="btn btn-warning">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No accepted reviews.</div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Wait for the document to be fully loaded
    $(document).ready(function() {
        // Fade out messages after 5 seconds if they exist
        if ($('#message').length) {
            setTimeout(function() {
                $('#message').fadeOut();
            }, 5000);
        }
    });
</script>
</body>
</html>
