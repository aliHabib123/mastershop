<?php

require 'config.php';
include '../module/Application/src/Model/include_dao.php';

$response = [
    'status' => false,
    'msg' => 'Error',
];

$itemBrandMySqlExtDAO = new ItemBrandMySqlExtDAO();

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $banner = $itemBrandMySqlExtDAO->load($id);
    $delete = $itemBrandMySqlExtDAO->delete($id);
    
    if ($delete) {
        if (is_file(IMAGES_PATH . $banner->image)) {
            unlink(IMAGES_PATH . $banner->image);
            unlink(IMAGES_PATH . "med_" . $banner->image);
            unlink(IMAGES_PATH . "small_" . $banner->image);
        }
        $brandCategoryMapping = DAOFactory::getBrandCategoryMappingDAO();
        $deleteMapping = $brandCategoryMapping->deleteByBrandId($id);
        $response = [
            'status' => true,
            'msg' => 'Deleted',
        ];
    }
}
echo json_encode($response);
