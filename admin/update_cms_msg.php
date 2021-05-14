<?php
require "session_start.php";

include "connect.php";
include "config.php";
include "class/Cms_msg.php";


extract($_POST);




$query = "Msg_Description='".addslashes(stripslashes($msg_description))."' ";

$return=Cms_msg::updateCondition($msg_id, $query);
if ($return) {
    $num++;
}

if ($num>0) {
    $act=3;
} else {
    $act=4;
}

header("Location: display_cms_msg.php?act=".$act);
exit();
