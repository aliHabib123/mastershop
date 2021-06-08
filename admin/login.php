<?php
session_save_path("sessions");
session_start();
include 'connect.php';
require_once '../module/Application/src/Model/include_dao.php';

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

$userMySqlExtDAO =  new UserMySqlExtDAO();
$admin = $userMySqlExtDAO->checkLoginCredentials($email, 1);
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
