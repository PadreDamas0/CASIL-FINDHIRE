<?php
require '../core/dbConfig.php';
require '../core/functions.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


checkLogin('HR');


$hr_id = $_SESSION['user_id'];


$query = "SELECT * FROM messages WHERE receiver_id = ? ORDER BY sent_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$hr_id]);
$messages = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_message'])) {
    $message_content = $_POST['reply_message'];
    $message_id = $_POST['message_id'];


    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content, sent_at, parent_message_id) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->execute([$hr_id, $_POST['sender_id'], $message_content, $message_id]);

    echo "<p>Reply sent successfully!</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Messages</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .message {
            background-color: #f9f9f9;
            border-left: 5px solid #4CAF50;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .message h3 {
            margin: 0;
            color: #4CAF50;
            font-size: 16px;
        }

        .message p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .message small {
            color: #888;
            font-size: 12px;
        }

        .reply-form {
            margin-top: 10px;
            display: none;
        }

        .reply-form textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .reply-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .reply-form button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>HR Messages</h1>

        <?php if (count($messages) > 0): ?>
            <div class="message-container">
                <?php foreach ($messages as $message): ?>
                    <div class="message">
                        <h3>From: Applicant <?php echo htmlspecialchars($message['sender_id']); ?></h3>
                        <p><?php echo htmlspecialchars($message['content']); ?></p>
                        <p><small>Sent at: <?php echo htmlspecialchars($message['sent_at']); ?></small></p>
                        
                        <!-- Reply button -->
                        <button onclick="toggleReplyForm(<?php echo $message['message_id']; ?>, <?php echo $message['sender_id']; ?>)">Reply</button>

                        <!-- Reply form -->
                        <div class="reply-form" id="reply-form-<?php echo $message['message_id']; ?>">
                            <form method="POST">
                                <textarea name="reply_message" placeholder="Type your reply here..."></textarea>
                                <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>">
                                <input type="hidden" name="sender_id" value="<?php echo $message['sender_id']; ?>">
                                <button type="submit">Send Reply</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No messages available.</p>
        <?php endif; ?>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

    <script>

        function toggleReplyForm(messageId, senderId) {
            var form = document.getElementById('reply-form-' + messageId);
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

</body>
</html>
