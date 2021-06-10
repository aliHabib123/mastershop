<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$contentMysqlExtDAO = new ContentMySqlExtDAO();

extract($_POST);
$page = $contentMysqlExtDAO->load($id);

$page->customUrl = $custom_url;
$page->displayOrder = $display_order;

$update = $contentMysqlExtDAO->update($page);

if ($update) {
    $num++;
}

if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

header("Location: display_social_media.php?act=" . $act);
exit();
