<?php require "session_start.php";

include "config.php";include "class/Cms_admin.php";

include "connect.php";

extract($_POST);

if ($password != "") {
    $password=md5(trim($password));
}


$return = Cms_admin::save(addslashes($admin_id), addslashes($admin_name), addslashes($user_name), addslashes($password), addslashes($email));
    if ($return == true) {
        $act=1;
    } else {
        $act=2;
    }

header("Location: display_cms_admin.php?act=".$act);
exit;
