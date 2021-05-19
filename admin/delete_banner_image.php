<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$bannerImageMySqlExtDAO = new BannerImageMySqlExtDAO();

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$banner = $bannerImageMySqlExtDAO->load($id);
	//print_r($banner);
	if (is_file(IMAGES_PATH . $banner->imageName)) {
		unlink(IMAGES_PATH . $banner->imageName);
		unlink(IMAGES_PATH . "med_" . $banner->imageName);
		unlink(IMAGES_PATH . "small_" . $banner->imageName);
	}
	$delete = $bannerImageMySqlExtDAO->delete($id);
	exit($delete);
}
