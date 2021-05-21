<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$response = [
	'status' => false,
	'msg' => 'Error',
];

$contentMySqlExtDAO = new ContentMySqlExtDAO();

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	if (false) {
		$response['msg'] = "This banner has images, delete them first";
	} else {
		$content = $contentMySqlExtDAO->load($id);
		$delete = $contentMySqlExtDAO->delete($id);
		if ($delete) {
			if (is_file(IMAGES_PATH . $content->image)) {
				unlink(IMAGES_PATH . $content->image);
				unlink(IMAGES_PATH . "med_" . $content->image);
				unlink(IMAGES_PATH . "small_" . $content->image);
			}
			$response = [
				'status' => true,
				'msg' => 'Deleted',
			];
		}
	}
}
echo json_encode($response);
