<?php
require "session_start.php";



include "connect.php";
include "config.php";
include "class/Cms_general.php";



extract($_POST);



$return=Cms_general::updateCondition($general_id, "site_title='".addslashes(stripslashes($site_title))."'  ,email='".addslashes(stripslashes($email))."' ");
if ($return) {
    $num++;
}

if ($num>0) {
    $act=3;
} else {
    $act=4;
}

header("Location: display_cms_general.php?act=".$act);
exit();
