<?php

use Application\Controller\MailController;

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';
require_once './includes/MailController.php';

$userMysqlExtDAO = new UserMySqlExtDAO();

$result = false;
$msg = "Error";
extract($_POST);
$active = isset($active) ? $active : "";
$status = (radio_button($active) == 1) ? 'active' : 'inactive';

$user = ($action == 'edit') ? $userMysqlExtDAO->load($id) : new User();
$oldEmail = $user->email;
$user->companyName = $company_name;
$user->firstName = $first_name;
$user->lastName = $last_name;
$user->middleName = $middle_name;
$user->fullName = $first_name . " " . $middle_name . " " . $last_name;
$user->email = $email;
$user->mobile = $mobile;
$user->tel1 = $tel1;
$user->tel2 = $tel2;
$user->companyCommission = $commission;
$user->status = $status;
$user->usdExchangeRate = $usd_exchange_rate;

if ($company_name == "" || $commission == "" || $first_name == "" || $last_name == "" || $email == ""|| $usd_exchange_rate == "") {
    $msg = "Please fill all required fields marked with *";
} elseif (
    ($action == 'new' && $userMysqlExtDAO->queryByEmail($email)) ||
    ($action == 'edit' && $oldEmail != $email && $userMysqlExtDAO->queryByEmail($email))
) {
    $msg = "This email is already registered.";
} else {
    if ($action == 'edit') {
        $res = $userMysqlExtDAO->update($user);
        if ($res) {
            $result = true;
            $msg = "User Updated successfully";
        }
    } elseif ($action == 'new') {
        ///
        $rand = random(150);
        $to = $email;
        $subject = "Mastershop: Set Password";
        $resetLink = SITE_LINK . 'reset-password/2?activationCode=' . $rand;
        $emailBody = MailController::getPasswordResetEmailBody($user->fullName, $resetLink);
        $sendEmail = MailController::sendMail($to, $subject, $emailBody);
        ///
        $user->activationCode = $rand;
        $user->userType = 2;
        $res = $userMysqlExtDAO->insert($user);
        if ($res) {
            $result = true;
            $msg = "User inserted successfully";
        }
    }
}

echo json_encode([
    'status' => $result,
    'msg' => $msg,
]);
