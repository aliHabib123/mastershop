<?php

require "session_start.php";
include "config.php";
require_once '../module/Application/src/Model/include_dao.php';

extract($_POST);

$userMySqlExtDAO = new UserMySqlExtDAO();

$password = password_hash($password, PASSWORD_DEFAULT);

$update = $userMySqlExtDAO->updatePassword($password, $_SESSION['adminId']);
if ($update) {
    $num++;
}

if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

header("Location: display_cms_admin.php?act=" . $act);
exit();
