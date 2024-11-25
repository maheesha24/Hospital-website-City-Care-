<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Bot</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-box">
            <div class="chat-header">
                <h5>Chat with Us</h5>
                <button class="btn btn-close" aria-label="Close"></button>
            </div>
            <div class="chat-body" id="chat-body">
                <!-- Messages will appear here -->
            </div>
            <div class="chat-footer">
                <input type="text" id="user-input" class="form-control" placeholder="Type your message here...">
                <button class="btn btn-primary" id="send-btn">Send</button>
            </div>
        </div>
        <button class="btn btn-primary chat-toggle" id="chat-toggle">
            <i class="fas fa-comments"></i>
        </button>
    </div>

    <!-- Font Awesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="javascript/chat.js"></script>
</body>
</html>
