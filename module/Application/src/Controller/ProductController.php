<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use stdClass;
use Album;
use AlbumMySqlExtDAO;
use ConnectionFactory;
use Image;
use ImageMySqlExtDAO;
use Item;
use ItemBrandMappingMySqlExtDAO;
use ItemBrandMySqlExtDAO;
use ItemCategoryMappingMySqlExtDAO;
use ItemCategoryMySqlExtDAO;
use ItemMySqlExtDAO;
use ItemTagMySqlExtDAO;
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
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : false;
        $brandId = (isset($_GET['brand']) && $_GET['brand'] != "") ? $_GET['brand'] : "";
        $minPrice = (isset($_GET['min-price']) && $_GET['min-price'] != "") ? $_GET['min-price'] : "";
        $maxPrice = (isset($_GET['max-price']) && $_GET['max-price'] != "") ? $_GET['max-price'] : "";

        $cat1 = $this->params('cat1') ? HelperController::filterInput($this->params('cat1')) : false;
        $cat2 = $this->params('cat2') ? HelperController::filterInput($this->params('cat2')) : false;
        $cat3 = $this->params('cat3') ? HelperController::filterInput($this->params('cat3')) : false;

        // var_dump($cat1);
        // var_dump($cat2);
        // var_dump($cat3);
        // var_dump($brandId);
        // var_dump($minPrice);
        // var_dump($maxPrice);

        // Get Category Slug
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
            $completeSlug .= "/" . $cat1;
        }
        if ($cat2) {
            $completeSlug .= "/" . $cat2;
        }
        if ($cat3) {
            $completeSlug .= "/" . $cat3;
        }

        if ($categorySlug != "") {
            $categoryInfo = $itemCategoryMySqlExtDAO->queryBySlug($categorySlug);
            if ($categoryInfo) {
                $categoryId = $categoryInfo[0]->id;
            }
        }
        // End of get Category Slug

        $categoryArray = [];
        if ($categoryId) {
            array_push($categoryArray, $categoryId);
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
                $categoryList = $itemCategoryMySqlExtDAO->select("parent_id = $cat2Id ORDER BY name ASC");
                $prefixUrl = MAIN_URL . 'products/' . $cat1 . "/" . $cat2 . "/";
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
                $categoryList = $itemCategoryMySqlExtDAO->select("parent_id = $cat1Id ORDER BY name ASC");
                $prefixUrl = MAIN_URL . 'products/' . $cat1 . "/";
            }
        } else {
            $categoryList = $itemCategoryMySqlExtDAO->select('parent_id = 0 ORDER BY name ASC');
            $prefixUrl = MAIN_URL . 'products/';
        }

        $itemBrandMySqlExtDAO = new ItemBrandMySqlExtDAO();

        $brandsList = $itemBrandMySqlExtDAO->queryAll();

        $items = self::getItems($categoryArray, $search, $brandId, $minPrice, $maxPrice, false, "", $limit, $offset);
        //print_r($items);
        $itemsCount = count(self::getItems($categoryArray, $search, $brandId, $minPrice, $maxPrice, false));
        $totalPages = ceil($itemsCount / $limit);

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
            'categoryList' => $categoryList,
            'prefixUrl' => $prefixUrl,
            'brandsList' => $brandsList,
            'brandId' => $brandId,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ];
        return new ViewModel($data);
    }
    public function detailsAction()
    {
        $slug = HelperController::filterInput($this->params('slug'));
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $item = $itemMySqlExtDAO->queryBySlug($slug);
        $item = $item[0];

        //Get Categories
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $itemCategory = $itemCategoryMappingMySqlExtDAO->getItemCategory($item->id);
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        $parentCategory = $itemCategoryMySqlExtDAO->load($itemCategory->parentId);
        $mainCategory = $itemCategoryMySqlExtDAO->load($parentCategory->parentId);

        //Get Brand
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();
        $itemBrand = $itemBrandMappingMySqlExtDAO->getItemBrand($item->id);

        //Album Images
        $imageMySqlExtDAO = new ImageMySqlExtDAO();
        $images = $imageMySqlExtDAO->queryByAlbumId($item->albumId);

        // Related Products
        $related = self::getRelatedProducts($itemCategory->categoryId, $item->id);
        $relatedIds = array_map(function ($e) {
            return $e->itemId;
        }, $related);
        $relatedIds = implode(',', $relatedIds);
        $relatedProducts = [];
        if ($relatedIds) {
            $relatedProducts = $itemMySqlExtDAO->select("a.id IN($relatedIds)");
        }

        return new ViewModel([
            'item' => $item,
            'itemCategory' => $itemCategory,
            'parentCategory' => $parentCategory,
            'mainCategory' => $mainCategory,
            'itemBrand' => $itemBrand,
            'images' => $images,
            'relatedProducts' => $relatedProducts,
        ]);
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
        $items = self::getItems(false, false, "", "", "", $tagId, "", $limit, $offset);
        $spotLight = self::getItems(false, false, "", "", "", self::$SPOTLIGHT, "RAND(),", 1, $offset);
        $itemsCount = count(self::getItems(false, false, "", "", "", $tagId));
        $totalPages = ceil($itemsCount / $limit);
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'spotlight' => false,
        ];
        if ($spotLight) {
            $data['spotlight'] = $spotLight[0];
        }
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
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
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
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
        return new ViewModel($data);
    }

    public static function insertItems($items, $fileName)
    {
        $supplierId = $_SESSION['user']->id;
        // Initialize
        $brandIdsNames = [];
        $insertedItems = 0;
        $updatedItems = 0;
        $deletedItems = 0;
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();

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

            $itemExists = $itemMySqlExtDAO->queryBySkuAndSupplierId($row['SKU'], $supplierId);
            //echo 'SKU: ' . $row['SKU'] . ' title: ' . $row['Title'].'<br>';
            $date = date('Y-m-d H:i:s');
            $categoryId = ProductController::getCategory($row['Category'], $row['sub category'], $row['product category']);
            if ($itemExists) {
                // print_r($itemExists[0]);
                // echo '<br>';
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
                //print_r($itemObj);echo '<br>';
                $update = $itemMySqlExtDAO->update($itemObj);
                if ($update) {
                    //echo $itemObj->id.'<br>';
                    if ($categoryId) {
                        CategoryController::updateOrInsertItemCategory($itemObj->id, $categoryId);
                    }
                    if (array_key_exists($row['Brand Name'], $brandIdsNames)) {
                        BrandController::updateOrInsertItemBrand($itemObj->id, $brandIdsNames[$row['Brand Name']]);
                    }
                    $updatedItems++;
                }
            } else {
                //echo 'does not exists<br>';
                $itemObj->updatedAt = $date;
                $itemObj->createdAt = $date;
                $insert = $itemMySqlExtDAO->insert($itemObj);
                if ($insert) {
                    if ($categoryId) {
                        $itemCategoryMappingMySqlExtDAO->insertItemCategory($insert, $categoryId);
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
        $itemObj->regularPrice = (isset($row['Price']) && !empty($row['Price'])) ? $row['Price'] : 0;
        $itemObj->salePrice = (isset($row['Special Price']) && !empty($row['Special Price'])) ? $row['Special Price'] : 0;
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
        $itemObj->slug = self::slugify($row['Title'], $row['SKU']);
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

    public static function getFinalPrice($regularPrice, $salePrice, $raw = false)
    {
        if ($salePrice != 0) {
            if (!$raw) {
                return number_format(floatval($salePrice));
            }
            return floatval($salePrice);
        } elseif ($regularPrice != 0) {
            if (!$raw) {
                return number_format(floatval($regularPrice));
            }
            return floatval($regularPrice);
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

    public static function getItems($categoryId = false, $search = false, $brandId = "", $minPrice = "", $maxPrice = "", $tagId = false, $orderBy = "", $limit = 0, $offset = 0)
    {
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $items = $itemMySqlExtDAO->getItems($categoryId, $search, $brandId, $minPrice, $maxPrice, $tagId, $orderBy, $limit, $offset);
        return $items;
    }

    public static function getRelatedProducts($categoryId, $excludeId)
    {
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $list = $itemCategoryMappingMySqlExtDAO->getListOfItemsInCategory($categoryId, $excludeId);
        return $list;
    }

    public static function getCategoryBanner($cat1 = false, $cat2 = false, $cat3, $cat1Info = false, $cat2info = false, $cat3Info = false)
    {
        $bannerImage = PRODUCT_BANNER_PLACEHOLDER_URL;
        if ($cat1) {
            if (@getimagesize(BASE_PATH . upload_image_dir . $cat1Info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat1Info[0]->bannerImage);
            }
        }
        if ($cat2) {
            if (@getimagesize(BASE_PATH . upload_image_dir . $cat2info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat2info[0]->bannerImage);
            } elseif (@getimagesize(BASE_PATH . upload_image_dir . $cat1Info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat1Info[0]->bannerImage);
            }
        }
        if ($cat3) {
            if (@getimagesize(BASE_PATH . upload_image_dir . $cat3Info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat3Info[0]->bannerImage);
            } elseif (@getimagesize(BASE_PATH . upload_image_dir . $cat2info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat2info[0]->bannerImage);
            } elseif (@getimagesize(BASE_PATH . upload_image_dir . $cat1Info[0]->bannerImage)) {
                $bannerImage = HelperController::getImageUrl($cat1Info[0]->bannerImage);
            }
        }
        //echo 'banner-image1-<br>'.$bannerImage .'<br>-banner';
        return $bannerImage;
    }

    public static function getCategory($cat1 = "", $cat2 = "", $cat3 = "")
    {
        $conn = ConnectionFactory::getConnection();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT
            c.`id`
            FROM
            item_category a
            LEFT OUTER JOIN item_category b
            ON a.`id` = b.`parent_id`
            LEFT OUTER JOIN item_category c
            ON b.`id` = c.`parent_id`
            WHERE c.`name` IS NOT NULL
            AND c.`name` = '$cat3' AND b.`name` = '$cat2' AND a.`name` = '$cat1'
            ORDER BY c.`name` ASC LIMIT 1 OFFSET 0";
        $rows = $conn->query($sql);
        $conn->close();
        if ($rows->num_rows > 0) {
            // output data of each row
            $row  =  $rows->fetch_object();
            return $row->id;
        } else {
            return 0;
        }
    }

    public static function slugify($title, $sku = "")
    {
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $slug = HelperController::slugify($title);
        $item = $itemMySqlExtDAO->queryBySlugAndSupplierId($slug, $_SESSION['user']->id)[0];
        if ($item->sku == $sku && $item->slug == $slug) {
            return $item->slug;
        } else {
            $c = 1;
            while ($itemMySqlExtDAO->queryBySlugAndSupplierId($slug, $_SESSION['user']->id)) {
                $slug =  HelperController::slugify($title);
                $slug = $slug . '-' . $c;
                $c++;
            }
            return $slug;
        }
    }
}
