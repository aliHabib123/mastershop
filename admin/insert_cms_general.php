<?php require "session_start.php";

include "config.php";include "class/Cms_general.php";

include "connect.php";

extract($_POST);


$return = Cms_general::save(addslashes($general_id), addslashes($site_title), addslashes($email));
    if ($return == true) {
        $act=1;
    } else {
        $act=2;
    }

header("Location: display_cms_general.php?act=".$act);
exit;
