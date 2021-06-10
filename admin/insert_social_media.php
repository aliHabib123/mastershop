<?php 

require "session_start.php";
include "config.php";
include 'change_format.php';
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$contentMysqlExtDAO = new ContentMySqlExtDAO();
extract($_POST);

$slug = slugify($title);
$c=1;
while($contentMysqlExtDAO->queryBySlug($slug)){
    $slug = slugify($title);
    $slug = $slug.'-'.$c;
    $c++;
}

$obj =  new ContentMySqlDAO();
$obj->title = $title;
$obj->customUrl = $custom_url;
$obj->displayOrder = $display_order;
$obj->type = 'social-media';
$obj->slug = $slug;
$obj->canDelete = 0;
$obj->createdAt = date('Y-m-d H:i:s');
$obj->updatedAt = date('Y-m-d H:i:s');

$insert = $contentMysqlExtDAO->insert($obj);
if ($insert) {
    $act=1;
} else {
    $act=2;
}

header("Location: display_social_media.php?act=".$act);
exit;
