<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Album;
use AlbumMySqlExtDAO;
use Image;
use ImageMySqlDAO;
use ImageMySqlExtDAO;
use Item;
use ItemBrandMappingMySqlExtDAO;
use ItemCategoryMappingMySqlExtDAO;
use ItemCategoryMySqlExtDAO;
use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use stdClass;
use User;
use UserMySqlExtDAO;

class ProductController extends AbstractActionController
{
    public function indexAction()
    {
        var_dump($_SESSION);
        return new ViewModel();
    }
    public function detailsAction()
    {
        return new ViewModel();
    }
    public function todaysDealsAction()
    {
        return new ViewModel();
    }
    public function latestArrivalsAction()
    {
        return new ViewModel();
    }

    public static function insertItems($items, $supplierId, $fileName)
    {
        // Initialize
        $categoriesIdsNames = [];
        $brandIdsNames = [];
        $insertedItems = 0;
        $updatedItems = 0;
        $deletedItems = 0;
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();

        // Get Categories
        $categories = CategoryController::getCategories('parent_id = 0 ORDER BY display_order ASC, name ASC, id DESC');
        foreach ($categories as $cat) {
            $categoriesIdsNames[$cat->name] = $cat->id;
        }

        // Get Brands
        $brands = BrandController::getBrands();
        foreach ($brands as $brand) {
            $brandIdsNames[$brand->name] = $brand->id;
        }

        // New Sku List
        $newItemsSKUList = array_column($items, 'SKU');

        // Old SKU List
        $oldItems = $itemMySqlExtDAO->queryBySupplierId($supplierId);
        $oldItemsSKUList = array_map(function ($e) {
            return $e->sku;
        }, $oldItems);

        $toBeDeleted = array_diff($oldItemsSKUList, $newItemsSKUList);

        foreach ($items as $row) {
            $albumId = 0;
            $prefix = $supplierId . '-' . HelperController::slugify($row['SKU']);
            $image = HelperController::downloadFile($row['Image 1'], $prefix);
            $imagesArray = [];
            if($row['Image 2'] != ""){
                $image1 = HelperController::downloadFile($row['Image 2'], $prefix);
                if($image1){
                    array_push($imagesArray, $image1);
                }
            }
            if($row['Image 3'] != ""){
                $image2 = HelperController::downloadFile($row['Image 3'], $prefix);
                if($image2){
                    array_push($imagesArray, $image2);
                }
            }
            if($row['Image 4'] != ""){
                $image3 = HelperController::downloadFile($row['Image 4'], $prefix);
                if($image3){
                    array_push($imagesArray, $image3);
                }
            }

            if($imagesArray){
                $albumMySqlExtDAO = new AlbumMySqlExtDAO();
                $albumImageMySqlExtDAO = new ImageMySqlExtDAO();
                $albumObj = new Album();
                $albumObj->displayOrder = 0;
                $albumObj->active = 1;
                $albumId = $albumMySqlExtDAO->insert($albumObj);

                foreach($imagesArray as $albumImageItem){
                    $albumImageObj = new Image();
                    $albumImageObj->albumId = $albumId;
                    $albumImageObj->imageName = $albumImageItem;
                    $albumImageMySqlExtDAO->insert($albumImageObj);
                }
            }

            $itemObj = new Item();
            self::populateItem($itemObj, $row, $supplierId, $albumId);
            if ($image) {
                $itemObj->image = $image;
            }

            $itemExists = $itemMySqlExtDAO->queryBySku($row['SKU']);
            $date = date('Y-m-d H:i:s');
            if ($itemExists) {

                // delete image
                HelperController::deleteImage($itemExists[0]->image);
                // delete album and images
                if($itemExists[0]->albumId != 0){
                    $oldImages = $albumImageMySqlExtDAO->queryByAlbumId($itemExists[0]->albumId);
                    foreach($oldImages as $oldImage){
                        HelperController::deleteImage($oldImage->imageName);
                        $albumImageMySqlExtDAO->deleteByAlbumId($itemExists[0]->albumId);
                    }
                    $albumMySqlExtDAO->delete($itemExists[0]->albumId);
                }
                
                $itemObj->id = $itemExists[0]->id;
                $itemObj->createdAt = $itemExists[0]->createdAt;
                $itemObj->updatedAt = $date;
                $update = $itemMySqlExtDAO->update($itemObj);
                if ($update) {
                    if (array_key_exists($row['Category'], $categoriesIdsNames)) {
                        CategoryController::updateOrInsertItemCategory($itemObj->id, $categoriesIdsNames[$row['Category']]);
                    }
                    if (array_key_exists($row['Brand Name'], $brandIdsNames)) {
                        BrandController::updateOrInsertItemBrand($itemObj->id, $brandIdsNames[$row['Brand Name']]);
                    }
                    $updatedItems++;
                }
            } else {
                $itemObj->updatedAt = $date;
                $itemObj->createdAt = $date;
                $insert = $itemMySqlExtDAO->insert($itemObj);
                if ($insert) {
                    if (array_key_exists($row['Category'], $categoriesIdsNames)) {
                        $itemCategoryMappingMySqlExtDAO->insertItemCategory($insert, $categoriesIdsNames[$row['Category']]);
                    }
                    if (array_key_exists($row['Brand Name'], $brandIdsNames)) {
                        $itemBrandMappingMySqlExtDAO->insertItemBrand($insert, $brandIdsNames[$row['Brand Name']]);
                    }
                    $insertedItems++;
                }
            }
        }

        // delete Items
        foreach ($toBeDeleted as $del) {
            $delete = self::deleteItemBySku($del);
            if ($delete) {
                $deletedItems++;
            }
        }

        // Update File
        if ($insertedItems != 0 || $updatedItems != 0 || $deletedItems != 0) {
            $userMySqlExtDAO = new UserMySqlExtDAO();
            $userObj = new User();
            $userObj->id = $supplierId;
            $userObj->uploadedFile = $fileName;
            $userMySqlExtDAO->updateFile($supplierId, $fileName);
        }

        $response = new stdClass();
        $response->inserted = $insertedItems;
        $response->updated = $updatedItems;
        $response->deleted = $deletedItems;
        return $response;
    }

    public static function populateItem(&$itemObj, $row, $supplierId, $albumId)
    {
        $itemObj->title = $row['Title'];
        $itemObj->description = (isset($row['Description']) && !empty($row['Description'])) ? $row['Description'] : "";
        $itemObj->regularPrice = $row['Price'];
        $itemObj->salePrice = (isset($row['Special Price']) && !empty($row['Special Price'])) ? $row['Special Price'] : "";
        $itemObj->weight = (isset($row['Weight']) && !empty($row['Weight'])) ? $row['Weight'] : "";
        $itemObj->sku = $row['SKU'];
        $itemObj->qty = (isset($row['Stock']) && !empty($row['Stock'])) ? $row['Stock'] : 0;
        $itemObj->supplierId = $supplierId;
        $itemObj->displayOrder = 0;
        $itemObj->specification = (isset($row['Specification']) && !empty($row['Specification'])) ? $row['Specification'] : "";
        $itemObj->color = (isset($row['Color']) && !empty($row['Color'])) ? $row['Color'] : "";
        $itemObj->size = (isset($row['Size']) && !empty($row['Size'])) ? $row['Size'] : "";
        $itemObj->dimensions = (isset($row['Dimensions']) && !empty($row['Dimensions'])) ? $row['Dimensions'] : "";
        $itemObj->albumId = $albumId;
        $itemObj->slug = HelperController::slugify($row['Title']);
    }

    public static function deleteItemBySku($sku)
    {
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();
        $item = $itemMySqlExtDAO->queryBySku($sku);
        $itemId = $item[0]->id;
        $itemCategoryMappingMySqlExtDAO->deleteByItemId($itemId);
        $itemBrandMappingMySqlExtDAO->deleteByItemId($itemId);
        $delete = $itemMySqlExtDAO->delete($itemId);
        return $delete;
    }

    public static function getFinalPrice($regularPrice, $salePrice)
    {
        if ($salePrice != "" && $salePrice != null && $salePrice != 0) {
            return $salePrice;
        } elseif ($regularPrice != "" && $regularPrice != null && $regularPrice != 0) {
            return $regularPrice;
        } else {
            return 'n/a';
        }
    }

    public static function getProductImage($imageName)
    {
        if ($imageName != "" && $imageName != null) {
            if (file_exists(BASE_PATH . upload_image_dir . $imageName)) {
                return BASE_URL . upload_image_dir . $imageName;
            }
        }
        return PRODUCT_PLACEHOLDER_IMAGE_URL;
    }

    public static function productImages(string $itemId, array $images){

    }
}
