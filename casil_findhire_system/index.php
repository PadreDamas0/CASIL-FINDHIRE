<?php
require 'core/dbConfig.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_role = $_SESSION['user_role'];


    if ($user_role === 'HR') {
        header("Location: hr/dashboard.php");
        exit();
    } elseif ($user_role === 'Applicant') {
        header("Location: applicant/dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindHire - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 900px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to CSLFindHire</h1>
        <p>Find your dream job or post your job opening here.</p>
        <a href="login.php">Login</a> | <a href="register.php">Register</a>
    </div>
</body>
</html>

