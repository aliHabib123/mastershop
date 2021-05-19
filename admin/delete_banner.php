<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$bannerMySqlExtDAO = new BannerMySqlExtDAO();

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$banner = $bannerMySqlExtDAO->load($id);
	print_r(is_file(IMAGES_PATH . $banner->image));
	if (is_file(IMAGES_PATH . $banner->image)) {
		unlink(IMAGES_PATH . $banner->image);
		unlink(IMAGES_PATH . "med_" . $banner->image);
		unlink(IMAGES_PATH . "small_" . $banner->image);
	}
	$delete = $bannerMySqlExtDAO->delete($id);
	exit($delete);
}
