<?php
include "class/Cms_msg.php";
require "session_start.php";

include "connect.php";

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    $return=Cms_msg::delete($id);

    exit($return);
}

extract($_POST);

foreach ($_POST as $key => $value) {
    $return=Cms_msg::delete($value);
    if ($return) {
        $num++;
    }
}



if ($num>0) {
    $act=5;
} else {
    $act=6;
}

header("Location: display_cms_msg.php?act=".$act);
exit;
