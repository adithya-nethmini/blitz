<!DOCTYPE html>
<html>
<head>
    <title>Chat Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="chatMessages"></div>
    <input type="text" id="inputField" />
    <button id="sendButton">Send</button>

    <script>
        // Function to retrieve messages from the server
        function retrieveMessages() {
            $.ajax({
                url: 'chat.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    // Clear existing messages
                    $('#chatMessages').empty();

                    // Add each message to the chatMessages div
                    for (var i = 0; i < response.length; i++) {
                        var message = response[i];
                        var messageText = '<p><strong>' + message.sender + ': </strong>' + message.message + '</p>';
                        $('#chatMessages').append(messageText);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }

        // Function to send a message to the server
        function sendMessage(message) {
            $.ajax({
                url: 'open-chat-test.php',
                type: 'POST',
                data: { message: message },
                success: function (response) {
                    console.log('Message sent successfully');
                },
                error: function (xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }

        // Function to handle sending a message when the send button is clicked
        $('#sendButton').click(function () {
            var message = $('#inputField').val();
            if (message.trim() !== '') {
                sendMessage(message);
                $('#inputField').val(''); // Clear the input field
            }
        });

        // Retrieve messages initially and set an interval to update them periodically
        retrieveMessages();
        setInterval(retrieveMessages, 5000); // Refresh every 5 seconds (adjust as needed)
    </script>
</body>
</html>
