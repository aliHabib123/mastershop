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

$translate = (isset($translation_id) && $translation_id != 0) ? true : false;
//var_dump($translate);die();
$active=radio_button($active);
$image=upload_image("image", "$imagesPath");
if (is_file($imagesPath.$image)) {
    $simpleImage->load($imagesPath.$image);
    $simpleImage->resizeToWidth($medImageW);
    $simpleImage->save($imagesPath."med_".$image);
    $simpleImage->resizeToWidth($smallImageW);
    $simpleImage->save($imagesPath."small_".$image);
} else {
    $image="";
}

$obj =  new ContentMySqlDAO();
$obj->title = $title;
$obj->image = $image;
$obj->details = $details;
$obj->lang = $lang;
$obj->displayOrder = $display_order;
$obj->type = 'page';
$obj->slug = $slug;
$obj->canDelete = 1;

if($translate){
    $obj->translationId = $translation_id;
 }

$insert = $contentMysqlExtDAO->insert($obj);
if ($insert) {
    if($translate){
        $contentMysqlExtDAO->updateTranslation($translation_id, $insert);
    }
    $act=1;
} else {
    $act=2;
}

header("Location: display_page.php?act=".$act);
exit;
