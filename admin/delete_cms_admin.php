<?php
include "class/Cms_admin.php";
require "session_start.php";

include "connect.php";

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    $return=Cms_admin::delete($id);

    exit($return);
}

extract($_POST);

foreach ($_POST as $key => $value) {
    $return=Cms_admin::delete($value);
    if ($return) {
        $num++;
    }
}



if ($num>0) {
    $act=5;
} else {
    $act=6;
}

header("Location: display_cms_admin.php?act=".$act);
exit;
