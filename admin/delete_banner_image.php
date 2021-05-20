<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$response = [
	'status' => false,
	'msg' => 'Error',
];

$bannerImageMySqlExtDAO = new BannerImageMySqlExtDAO();

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$banner = $bannerImageMySqlExtDAO->load($id);
	if (is_file(IMAGES_PATH . $banner->imageName)) {
		unlink(IMAGES_PATH . $banner->imageName);
		unlink(IMAGES_PATH . "med_" . $banner->imageName);
		unlink(IMAGES_PATH . "small_" . $banner->imageName);
	}
	$delete = $bannerImageMySqlExtDAO->delete($id);
	if ($delete) {
		$response = [
			'status' => true,
			'msg' => 'Deleted',
		];
	}
}
echo json_encode($response);
