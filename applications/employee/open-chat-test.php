<?php
// Handle sending message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the message from the request
    $message = $_POST['message'];

    // Save the message to the database or any other storage mechanism

    // Return a response (optional)
    echo 'Message sent successfully';
    exit;
}

// Handle retrieving messages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve messages from the database or any other storage mechanism

    // Return the messages as JSON
    $messages = [
        ['sender' => 'John', 'message' => 'Hello'],
        ['sender' => 'Alice', 'message' => 'Hi'],
        // Add more messages as needed
    ];

    echo json_encode($messages);
    exit;
}
?>
