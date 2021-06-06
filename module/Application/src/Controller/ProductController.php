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
use ItemTagMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use stdClass;
use User;
use UserMySqlExtDAO;

class ProductController extends AbstractActionController
{
    public static $TODAYS_DEALS = 1;
    public static $LATEST_ARRIVALS = 2;
    public static $PICKED_FOR_YOU = 3;
    public static $DAILY_DEALS = 4;
    public static $BEST_OFFERS = 5;
    public static $SPOTLIGHT = 6;
    public static $PROMOTIONS = 7;
    public function indexAction()
    {
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : false;
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $cat1 = $this->params('cat1') ? HelperController::filterInput($this->params('cat1')) : false;
        $cat2 = $this->params('cat2') ? HelperController::filterInput($this->params('cat2')) : false;
        $cat3 = $this->params('cat3') ? HelperController::filterInput($this->params('cat3')) : false;

        $categorySlug = "";
        $categoryId = false;
        $completeSlug = "";
        if ($cat3) {
            $categorySlug = $cat3;
        } elseif ($cat2) {
            $categorySlug = $cat2;
        } elseif ($cat1) {
            $categorySlug = $cat1;
        }
        if ($cat1) {
            $completeSlug .= "/".$cat1;
        }
        if ($cat2) {
            $completeSlug .= "/".$cat2;
        }
        if ($cat3) {
            $completeSlug .= "/".$cat3;
        }
        if ($categorySlug != "") {
            $categoryInfo = $itemCategoryMySqlExtDAO->queryBySlug($categorySlug);
            if ($categoryInfo) {
                $categoryId = $categoryInfo[0]->id;
            }
        }
        $categoryArray = [];
        if ($categoryId) {
            if ($cat3) {
                $cat3Info = $itemCategoryMySqlExtDAO->queryBySlug($cat3);
                array_push($categoryArray, $cat3Info[0]->id);
            } elseif ($cat2 && !$cat3) {
                $cat2Info = $itemCategoryMySqlExtDAO->queryBySlug($cat2);
                $cat2Id = $cat2Info[0]->id;
                $categoriesLevel2 = CategoryController::getCategories("parent_id = $cat2Id");
                foreach ($categoriesLevel2 as $row) {
                    array_push($categoryArray, $row->id);
                }
                //array_push($categoryArray, $cat2Info[0]->id);
            } elseif ($cat1 && !$cat2 && !$cat3) {
                $cat1Info = $itemCategoryMySqlExtDAO->queryBySlug($cat1);
                $cat1Id = $cat1Info[0]->id;
                $categoriesLevel1 = CategoryController::getCategories("parent_id = $cat1Id");
                foreach ($categoriesLevel1 as $row) {
                    array_push($categoryArray, $row->id);
                    $cat2Info = $itemCategoryMySqlExtDAO->queryBySlug($row->slug);
                    $cat2Id = $cat2Info[0]->id;
                    $categoriesLevel2 = CategoryController::getCategories("parent_id = $cat2Id");
                    foreach ($categoriesLevel2 as $row) {
                        array_push($categoryArray, $row->id);
                    }
                }
            }
        }
        //echo $completeSlug.'<br>';
        $items = self::getItems($categoryArray, $search, false, "", $limit, $offset);
        $itemsCount = count(self::getItems($categoryArray, $search, false));
        $totalPages = ceil($itemsCount / $limit);
        // var_dump($cat1);
        // var_dump($cat2);
        // var_dump($cat3);
        $isSearchPage = false;
        if ($search != false) {
            $isSearchPage = true;
        }
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'completeSlug' => $completeSlug,
            'isSearch' => $isSearchPage,
            'cat1' => $cat1,
            'cat2' => $cat2,
            'cat3' => $cat3,
        ];
        //print_r($items);
        return new ViewModel($data);
    }
    public function detailsAction()
    {
        return new ViewModel();
    }
    public function todaysDealsAction()
    {
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : false;
        $itemTagMySqlExtDAO = new ItemTagMySqlExtDAO();
        $tagInfo = $itemTagMySqlExtDAO->queryBySlug('todays-deals');
        $tagId = $tagInfo[0]->id;
        $items = self::getItems(false, false, $tagId, "", $limit, $offset);
        $spotLight = self::getItems(false, false, self::$SPOTLIGHT, "RAND(),", 1, $offset);
        $itemsCount = count(self::getItems(false, false, $tagId));
        $totalPages = ceil($itemsCount / $limit);
        //print_r($spotLight);
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'spotlight' => $spotLight[0],
        ];
        //print_r($items);
        return new ViewModel($data);
    }
    public function latestArrivalsAction()
    {
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : false;
        $itemTagMySqlExtDAO = new ItemTagMySqlExtDAO();
        $tagInfo = $itemTagMySqlExtDAO->queryBySlug('latest-arrivals');
        $tagId = $tagInfo[0]->id;
        $items = self::getItems(false, false, $tagId, "", $limit, $offset);
        $itemsCount = count(self::getItems(false, false, $tagId));
        $totalPages = ceil($itemsCount / $limit);
        //print_r($spotLight);
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
        //print_r($items);
        return new ViewModel($data);
    }

    public function promotionsAction()
    {
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : false;
        $itemTagMySqlExtDAO = new ItemTagMySqlExtDAO();
        $tagInfo = $itemTagMySqlExtDAO->queryBySlug('promotions');
        $tagId = $tagInfo[0]->id;
        $items = self::getItems(false, false, $tagId, "", $limit, $offset);
        $itemsCount = count(self::getItems(false, false, $tagId));
        $totalPages = ceil($itemsCount / $limit);
        //print_r($spotLight);
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
        //print_r($items);
        return new ViewModel($data);
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
        $categories = CategoryController::getCategories('1 ORDER BY display_order ASC, name ASC, id DESC');
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
            if ($row['Image 2'] != "") {
                $image1 = HelperController::downloadFile($row['Image 2'], $prefix);
                if ($image1) {
                    array_push($imagesArray, $image1);
                }
            }
            if ($row['Image 3'] != "") {
                $image2 = HelperController::downloadFile($row['Image 3'], $prefix);
                if ($image2) {
                    array_push($imagesArray, $image2);
                }
            }
            if ($row['Image 4'] != "") {
                $image3 = HelperController::downloadFile($row['Image 4'], $prefix);
                if ($image3) {
                    array_push($imagesArray, $image3);
                }
            }

            if ($imagesArray) {
                $albumMySqlExtDAO = new AlbumMySqlExtDAO();
                $albumImageMySqlExtDAO = new ImageMySqlExtDAO();
                $albumObj = new Album();
                $albumObj->displayOrder = 0;
                $albumObj->active = 1;
                $albumId = $albumMySqlExtDAO->insert($albumObj);

                foreach ($imagesArray as $albumImageItem) {
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
                if ($itemExists[0]->albumId != 0) {
                    $oldImages = $albumImageMySqlExtDAO->queryByAlbumId($itemExists[0]->albumId);
                    foreach ($oldImages as $oldImage) {
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

    public static function getFinalPrice($regularPrice, $salePrice, $raw=false)
    {
        if ($salePrice != "" && $salePrice != null && $salePrice != 0) {
            if(!$raw){
                return number_format(floatval($salePrice));
            }
            return floatval($salePrice);
        } elseif ($regularPrice != "" && $regularPrice != null && $regularPrice != 0) {
            if(!$raw){
                return number_format(floatval($regularPrice));
            }
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

    public static function productImages(string $itemId, array $images)
    {
    }

    public static function getItems($categoryId = false, $search = false, $tagId = false, $orderBy = "", $limit = 0, $offset = 0)
    {
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $items = $itemMySqlExtDAO->getItems($categoryId, $search, $tagId, $orderBy, $limit, $offset);
        return $items;
    }
}
