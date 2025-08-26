<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: modules/dashboard/index.php");
    exit();
} else {
    header("Location: modules/auth/login.php");
    exit();
}
?>