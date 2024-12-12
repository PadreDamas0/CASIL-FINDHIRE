<?php
session_start();

function checkRole($role) {
    if ($_SESSION['role'] !== $role) {
        header("Location: ../index.php");
        exit();
    }
}

function isLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

function checkLogin() {

    if (!isset($_SESSION['user_id'])) {

        header("Location: login.php");
        exit();
    }
}

?>
