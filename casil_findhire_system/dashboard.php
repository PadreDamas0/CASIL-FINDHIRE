<?php
require 'core/dbConfig.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['user_role'];






if ($user_role === 'HR') {
    header("Location: hr/dashboard.php");
} elseif ($user_role === 'Applicant') {
    header("Location: applicant/dashboard.php");
}
exit();
?>
