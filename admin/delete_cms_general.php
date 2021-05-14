<?php
include "class/Cms_general.php";
require "session_start.php";

include "connect.php";

extract($_POST);

foreach ($_POST as $key => $value) {
    $return = Cms_general::delete($value);
    if ($return) {
        $num ++;
    }
}

if ($num > 0) {
    $act = 5;
} else {
    $act = 6;
}

header("Location: display_cms_general.php?act=" . $act);
exit();
