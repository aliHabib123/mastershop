<?php
session_save_path("sessions");
session_start();
if (isset($_SESSION['adminId'])) {
    unset($_SESSION['Msg']);
    unset($_SESSION['adminId']);
    unset($_SESSION['adminName']);
    session_destroy();
    header("Location: index.php");
    exit;
}
