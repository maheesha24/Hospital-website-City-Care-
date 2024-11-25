<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Care Hospital Blog</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        /* Page Title Section */
        .page-title {
            position: relative;
            overflow: hidden;
            background-color: #333;
            padding: 40px 0;
        }

        .page-title .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .page-title .container {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        .page-title h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Blog Card Styling */
        .post-item {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .post-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .post-img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-body {
            flex-grow: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .post-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .post-desc {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .post-meta {
            font-size: 0.8rem;
            color: #aaa;
        }

        .btn-read-more {
            background-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-read-more:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include 'Header.php'; ?>

<!-- Page Title Section -->
<section class="page-title page-title-layout5" data-aos="fade-up">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between flex-wrap align-items-center">
                <h1 class="pagetitle__heading my-3 text-light">Health Essentials</h1>
                <nav>
                    <ol class="breadcrumb my-3">
                        <li class="breadcrumb-item"><a href="index.php" class="text-light">Home</a></li>
                        <li class="breadcrumb-item active text-light">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Blog Grid Section -->
<section class="blog-grid py-5">
    <div class="container">
        <div class="row g-4">
            <?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "hospital_db");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch blogs from the database
            $sql = "SELECT title, content, image_path, author, date_created FROM blogs ORDER BY date_created DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Loop through each blog post
                while ($row = $result->fetch_assoc()) {
                    $title = htmlspecialchars($row['title']);
                    $shortContent = htmlspecialchars(substr($row['content'], 0, 100)) . '...'; // Shortened content
                    $fullContent = $row['content']; // Full content without escaping HTML
                    $image = htmlspecialchars($row['image_path']);
                    $author = htmlspecialchars($row['author']);
                    $date = htmlspecialchars(date('F d, Y', strtotime($row['date_created'])));
                    ?>
                    <div class="col-md-4">
                        <div class="post-item">
                            <div class="post-img">
                                <img src="<?php echo $image; ?>" alt="Post Image">
                            </div>
                            <div class="post-body">
                                <h4 class="post-title"><?php echo $title; ?></h4>
                                <p class="post-desc"><?php echo $shortContent; ?></p>
                                <div class="post-meta">
                                    <span><?php echo $date; ?> • By <?php echo $author; ?></span>
                                </div>
                                <button 
                                    class="btn btn-read-more mt-3" 
                                    data-toggle="modal" 
                                    data-target="#blogModal" 
                                    data-title="<?php echo addslashes($title); ?>" 
                                    data-content="<?php echo addslashes($fullContent); ?>">
                                    Read More
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>No blogs available at the moment.</p>";
            }

            // Close the connection
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" aria-labelledby="blogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blogModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="blogModalContent"></div> <!-- Content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include 'Footer.php'; ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Update modal with dynamic content when button is clicked
    $('#blogModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var title = button.data('title'); // Extract title from data-* attributes
        var content = button.data('content'); // Extract content from data-* attributes

        // Update the modal's content using html() to preserve formatting
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('#blogModalContent').html(content); // Using html() to allow HTML tags
    });
</script>

</body>
</html>
