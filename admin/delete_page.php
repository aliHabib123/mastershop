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
	$content = $contentMySqlExtDAO->load($id);
	if ($content->canDelete) {
		if ($content->translationId != 0) {
			$contentMySqlExtDAO->delete($content->translationId);
		}
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
	} else {
		$response['msg'] = "Protected";
	}
}
echo json_encode($response);
