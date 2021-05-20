<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';
$response = [
    'status' => false,
    'msg' => 'Error',
];

$itemCateoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];    
    $hasChildren = $itemCateoryMySqlExtDAO->queryByParentId($id);
    if (count($hasChildren) > 0) {
        $response['msg'] = "This item has subcategories, delete them first";
    } else {
		$res = $itemCateoryMySqlExtDAO->load($id);
        $delete = $itemCateoryMySqlExtDAO->delete($id);
        if ($delete) {
            if (is_file(IMAGES_PATH . $res->image)) {
                unlink(IMAGES_PATH . $res->image);
                unlink(IMAGES_PATH . "med_" . $res->image);
                unlink(IMAGES_PATH . "small_" . $res->image);
            }
            $response = [
                'status' => true,
                'msg' => 'Deleted',
            ];
        }
    }
}
echo json_encode($response);
