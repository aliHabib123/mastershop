<?php require "session_start.php";

include "config.php";
include "class/Cms_msg.php";

include "connect.php";

extract($_POST);


$return = Cms_msg::save(addslashes($Msg_ID), addslashes($Msg_Description));
if ($return == true) {
    $act = 1;
} else {
    $act = 2;
}

header("Location: display_cms_msg.php?act=" . $act);
exit;
