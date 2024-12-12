<?php
session_start();
require '../core/dbConfig.php';


if ($_SESSION['role'] !== 'HR') {
    header('Location: ../login.php');
    exit();
}

if (isset($_POST['accept']) && isset($_POST['application_id'])) {
    $application_id = $_POST['application_id'];

    try {

        $stmt = $pdo->prepare("UPDATE applications SET status = 'hired', hired_applicant_id = ? WHERE application_id = ?");
        $stmt->execute([$_SESSION['user_id'], $application_id]);

        header('Location: messages.php');
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
