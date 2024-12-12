<?php

session_start();


include('core/db_connection.php');


$username = $_POST['username'];
$password = $_POST['password'];


$query = "SELECT * FROM users WHERE username = :username LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($_SESSION['role'] == 'HR') {
        header('Location: hr/dashboard.php');
    } else {
        header('Location: applicant/dashboard.php');
    }
} else {

    $_SESSION['error'] = 'Invalid username or password';
    header('Location: login.php');
}
exit;
?>
