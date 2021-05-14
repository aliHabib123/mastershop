<?php
require "session_start.php";



include "connect.php";
include "config.php";
include "class/Cms_admin.php";



extract($_POST);


$condition = "admin_name='".addslashes(stripslashes($admin_name))."' ,user_name='".addslashes(stripslashes($user_name))."'  ,email='".addslashes(stripslashes($email))."' ";
if ($password != "") {
    $password = md5($password);
    $condition.=", password='".addslashes(stripslashes($password))."'";
}

$return=Cms_admin::updateCondition($admin_id, $condition);
if ($return) {
    $num++;
}

if ($num>0) {
    $act=3;
} else {
    $act=4;
}

header("Location: display_cms_admin.php?act=".$act);
exit();
