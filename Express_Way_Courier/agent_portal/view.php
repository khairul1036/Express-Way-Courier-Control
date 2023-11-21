<?php
include('dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin-top: 50px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }

        .thank-you-message {
            color: #0a8c52;
            font-size: 24px;
        }
        .back-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #0074d9;
        color: #fff;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        }

        .back-button:hover {
            background-color: #0056a9;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You for Your Submission</h1>
        <p class="thank-you-message">Your request has been received and is being processed. We appreciate your business!</p>
        <a href="index.php" class="back-button">Go Back</a>
    </div>
</body>
</html>