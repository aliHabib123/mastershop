<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$response = [
	'status' => false,
	'msg' => 'Error',
];

$bannerMySqlExtDAO = new BannerMySqlExtDAO();
$bannerImageMySqlExtDAO = new BannerImageMySqlExtDAO();

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$hasChildren = $bannerImageMySqlExtDAO->queryByBannerId($id);
	if ($hasChildren) {
		$response['msg'] = "This banner has images, delete them first";
	} else {
		$banner = $bannerMySqlExtDAO->load($id);
		if (is_file(IMAGES_PATH . $banner->image)) {
			unlink(IMAGES_PATH . $banner->image);
			unlink(IMAGES_PATH . "med_" . $banner->image);
			unlink(IMAGES_PATH . "small_" . $banner->image);
		}
		$delete = $bannerMySqlExtDAO->delete($id);
		if ($delete) {
			$response = [
				'status' => true,
				'msg' => 'Deleted',
			];
		}
	}
}
echo json_encode($response);
