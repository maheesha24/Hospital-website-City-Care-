<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for the FAQ form
$faqId = $question = $answer = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_faq'])) {
        // Add new FAQ
        if (!empty($_POST['question']) && !empty($_POST['answer'])) {
            $question = $conn->real_escape_string($_POST['question']);
            $answer = $conn->real_escape_string($_POST['answer']);
            $sql = "INSERT INTO faqs (question, answer) VALUES ('$question', '$answer')";
            
            if ($conn->query($sql)) {
                $_SESSION['message'] = "FAQ added successfully!";
                // Clear the form
                $question = '';
                $answer = '';
            } else {
                $_SESSION['message'] = "Error adding FAQ: " . $conn->error;
            }
        } else {
            $_SESSION['message'] = "Question and Answer fields cannot be empty.";
        }
    } elseif (isset($_POST['edit_faq'])) {
        // Edit existing FAQ
        $faqId = intval($_POST['id']);
        if (!empty($_POST['question']) && !empty($_POST['answer'])) {
            $question = $conn->real_escape_string($_POST['question']);
            $answer = $conn->real_escape_string($_POST['answer']);
            $sql = "UPDATE faqs SET question='$question', answer='$answer' WHERE id=$faqId";
            
            if ($conn->query($sql)) {
                $_SESSION['message'] = "FAQ updated successfully!";
                // Clear the form
                $faqId = '';
                $question = '';
                $answer = '';
            } else {
                $_SESSION['message'] = "Error updating FAQ: " . $conn->error;
            }
        }
    } elseif (isset($_POST['delete_faq'])) {
        // Delete FAQ
        $faqId = intval($_POST['id']);
        $sql = "DELETE FROM faqs WHERE id=$faqId";
        
        if ($conn->query($sql)) {
            $_SESSION['message'] = "FAQ deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting FAQ: " . $conn->error;
        }
    }
}

// Fetch all FAQs from the database
$sql = "SELECT id, question, answer FROM faqs ORDER BY created_at DESC";
$result = $conn->query($sql);

// Populate the form if an FAQ is being edited
if (isset($_POST['edit'])) {
    $faqId = intval($_POST['id']);
    $sql = "SELECT question, answer FROM faqs WHERE id=$faqId";
    $faqResult = $conn->query($sql);
    if ($faqResult->num_rows > 0) {
        $faq = $faqResult->fetch_assoc();
        $question = $faq['question'];
        $answer = $faq['answer'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQs - City Care Hospital</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fade-message {
            transition: opacity 1s ease;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Manage FAQs</h2>

    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div id="message" class="alert alert-info fade-message">
            <?= htmlspecialchars($_SESSION['message']); ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($faqId); ?>">
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" id="question" name="question" value="<?= htmlspecialchars($question); ?>" required>
        </div>
        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea class="form-control" id="answer" name="answer" rows="5" required><?= htmlspecialchars($answer); ?></textarea>
        </div>
        <button type="submit" name="<?= $faqId ? 'edit_faq' : 'add_faq'; ?>" class="btn btn-primary"><?= $faqId ? 'Update FAQ' : 'Add FAQ'; ?></button>
    </form>

    <h3 class="mt-4">Existing FAQs</h3>
    <div class="list-group">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($faq = $result->fetch_assoc()): ?>
                <div class="list-group-item">
                    <h5><?= htmlspecialchars($faq['question']); ?></h5>
                    <p><?= htmlspecialchars($faq['answer']); ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $faq['id']; ?>">
                        <button type="submit" name="edit" class="btn btn-warning btn-sm">Edit</button>
                        <button type="submit" name="delete_faq" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No FAQs available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fade out the message after 5 seconds
    window.onload = function() {
        var message = document.getElementById('message');
        if (message) {
            setTimeout(function() {
                message.style.opacity = '0';
                setTimeout(function() {
                    message.remove();
                }, 1000); // Remove the message after fade out
            }, 5000); // Wait for 5 seconds
        }
    };
</script>
</body>
</html>
