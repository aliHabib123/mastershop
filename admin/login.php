<?php
session_save_path("sessions");
session_start();
include 'connect.php';
require_once '../module/Application/src/Model/include_dao.php';

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

if (isset($_SESSION['adminId'])) {
    unset($_SESSION['Msg']);
    unset($_SESSION['adminId']);
    unset($_SESSION['adminName']);
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    $userMySqlExtDAO =  new UserMySqlExtDAO();
    $admin = $userMySqlExtDAO->checkLoginCredentials($email);
    
    if ($admin && password_verify($password, $admin->password)) {
        $_SESSION['adminId'] = $admin->id;
        $_SESSION['adminName'] = $admin->firstName;
        unset($_SESSION['Msg']);
        header("Location: main.php");
        exit;
    } else {
        $_SESSION['Msg'] = 'Invalid email and/or Password';
        header("Location: index.php");
        exit;
    }
}
