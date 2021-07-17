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
    //public static $DAILY_DEALS = 4;
    public static $BEST_OFFERS = 5;
    public static $SPOTLIGHT = 6;
    public static $PROMOTIONS = 7;

    public function indexAction()
    {
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        $prefixUrl = MAIN_URL . 'products/';
        $categoryList = [];
        $page = 1;
        $limit = 12;
        $offset = 0;
        if (isset($_GET['page']) && $_GET['page'] != "") {
            $page = $_GET['page'];
            $offset = ($page - 1) * $limit;
        }
        $search = (isset($_GET['search']) && $_GET['search'] != "") ? $_GET['search'] : "";
        $brandId = (isset($_GET['brand']) && $_GET['brand'] != "") ? $_GET['brand'] : "";
        $minPrice = (isset($_GET['min-price']) && $_GET['min-price'] != "") ? $_GET['min-price'] : "";
        $maxPrice = (isset($_GET['max-price']) && $_GET['max-price'] != "") ? $_GET['max-price'] : "";
        $categoriesFiltered = (isset($_GET['categories']) && $_GET['categories'] != "") ? $_GET['categories'] : [];

        $cat1 = $this->params('cat1') ? HelperController::filterInput($this->params('cat1')) : false;
        $cat2 = $this->params('cat2') ? HelperController::filterInput($this->params('cat2')) : false;
        $cat3 = $this->params('cat3') ? HelperController::filterInput($this->params('cat3')) : false;

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
            if ($cat3) {
                $cat3Info = $itemCategoryMySqlExtDAO->queryBySlug($cat3);
                array_push($categoryArray, $cat3Info[0]->id);
            } elseif ($cat2 && !$cat3) {
                $cat2Info = $itemCategoryMySqlExtDAO->queryBySlug($cat2);
                $cat2Id = $cat2Info[0]->id;
                $categoriesLevel2 = CategoryController::getCategories("parent_id = $cat2Id");
                foreach ($categoriesLevel2 as $row) {
                    if (count($categoriesFiltered) > 0) {
                        if (in_array($row->id, $categoriesFiltered)) {
                            array_push($categoryArray, $row->id);
                        }
                    } else {
                        array_push($categoryArray, $row->id);
                    }
                }
                $categoryList = $itemCategoryMySqlExtDAO->select("parent_id = $cat2Id ORDER BY name ASC");
                $prefixUrl = MAIN_URL . 'products/' . $cat1 . "/" . $cat2 . "/";
            } elseif ($cat1 && !$cat2 && !$cat3) {
                $cat1Info = $itemCategoryMySqlExtDAO->queryBySlug($cat1);
                $cat1Id = $cat1Info[0]->id;
                $categoriesLevel1 = CategoryController::getCategories("parent_id = $cat1Id");
                foreach ($categoriesLevel1 as $row) {
                    if (count($categoriesFiltered) > 0) {
                        $categoriesFilteredList = implode(',', $categoriesFiltered);
                        $categoriesLevel2 = CategoryController::getCategories("parent_id IN ($categoriesFilteredList)");
                        foreach ($categoriesLevel2 as $row) {
                            array_push($categoryArray, $row->id);
                        }
                    } else {
                        $cat2Info = $itemCategoryMySqlExtDAO->queryBySlug($row->slug);
                        $cat2Id = $cat2Info[0]->id;
                        $categoriesLevel2 = CategoryController::getCategories("parent_id = $cat2Id");
                        foreach ($categoriesLevel2 as $row) {
                            array_push($categoryArray, $row->id);
                        }
                    }
                }
                $categoryList = $itemCategoryMySqlExtDAO->select("parent_id = $cat1Id ORDER BY name ASC");
                $prefixUrl = MAIN_URL . 'products/' . $cat1 . "/";
            }
        } else {
            if (count($categoriesFiltered) > 0) {
                $categoriesFilteredList = implode(',', $categoriesFiltered);
                $categoriesLevel1 = CategoryController::getCategories("parent_id IN ($categoriesFilteredList)");
                foreach ($categoriesLevel1 as $row) {
                    $cat2Info = $itemCategoryMySqlExtDAO->queryBySlug($row->slug);
                    $cat2Id = $cat2Info[0]->id;
                    $categoriesLevel2 = CategoryController::getCategories("parent_id = $cat2Id");
                    foreach ($categoriesLevel2 as $row) {
                        array_push($categoryArray, $row->id);
                    }
                }
            } else {
                $categoryList = $itemCategoryMySqlExtDAO->select('parent_id = 0 ORDER BY name ASC');
            }
        }

        $itemBrandMySqlExtDAO = new ItemBrandMySqlExtDAO();

        if ($cat1) {
            $cat1Info = $itemCategoryMySqlExtDAO->queryBySlug($cat1)[0];
            $brandsList = $itemBrandMySqlExtDAO->getBrandsByCategoryId($cat1Info->id);
        } else {
            $brandsList = $itemBrandMySqlExtDAO->queryAll();
        }

        sort($categoryArray);
        $categoryArray = array_unique($categoryArray);
        $items = self::getItems($categoryArray, $search, $brandId, $minPrice, $maxPrice, false, "", $limit, $offset);
        $itemsCount = count(self::getItems($categoryArray, $search, $brandId, $minPrice, $maxPrice, false));
        $totalPages = ceil($itemsCount / $limit);

        $isSearchPage = $search != "" ? true : false;

        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'completeSlug' => $completeSlug,
            'isSearch' => $isSearchPage,
            'search' => $search,
            'cat1' => $cat1,
            'cat2' => $cat2,
            'cat3' => $cat3,
            'categoryList' => $categoryList,
            'prefixUrl' => $prefixUrl,
            'brandsList' => $brandsList,
            'brandId' => $brandId,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'categoriesFiltered' => $categoriesFiltered,
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
        $langId = HelperController::langId(HelperController::filterInput($this->params('lang')));
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

        $ads = ContentController::getContent("type = 'ad1' and lang = $langId ORDER BY display_order asc LIMIT 3");
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'ads' => $ads,
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
        $catetgories = CategoryController::getCategories('parent_id = 0 ORDER BY display_order ASC, name ASC, id DESC');
        $category = (isset($_GET['category']) && $_GET['category'] != "") ? $_GET['category'] : false;
        $categoryArray = [];
        if ($category) {
            $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
            $cat1Info = $itemCategoryMySqlExtDAO->queryBySlug($category);
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
        $itemTagMySqlExtDAO = new ItemTagMySqlExtDAO();
        $tagInfo = $itemTagMySqlExtDAO->queryBySlug('promotions');
        $tagId = $tagInfo[0]->id;
        $items = self::getItems($categoryArray, "", "", "", "", $tagId, "", $limit, $offset);
        $itemsCount = count(self::getItems($categoryArray, "", "", "", "", $tagId));
        $totalPages = ceil($itemsCount / $limit);
        $data = [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'categories' =>  $catetgories,
            'category' => $category,
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
            $image = HelperController::getOrDownloadImage($row['Image 1'], $prefix);
            $imagesArray = [];
            if ($row['Image 2'] != "") {
                $image1 = HelperController::getOrDownloadImage($row['Image 2'], $prefix);
                if ($image1) {
                    array_push($imagesArray, $image1);
                }
            }
            if ($row['Image 3'] != "") {
                $image2 = HelperController::getOrDownloadImage($row['Image 3'], $prefix);
                if ($image2) {
                    array_push($imagesArray, $image2);
                }
            }
            if ($row['Image 4'] != "") {
                $image3 = HelperController::getOrDownloadImage($row['Image 4'], $prefix);
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
            $date = date('Y-m-d H:i:s');
            $categoryId = ProductController::getCategory($row['Category'], $row['sub category'], $row['product category']);
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

    public static function insertBulkItems($items)
    {
        $conn = ConnectionFactory::getConnection();
        $supplierId = $_SESSION['user']->id;
        $data = [];
        foreach ($items as $row) {
            $image1 = isset($row['Image 1']) ? mysqli_real_escape_string($conn, strval($row['Image 1'])) : '';
            $image2 = isset($row['Image 2']) ? mysqli_real_escape_string($conn, strval($row['Image 2'])) : '';
            $image3 = isset($row['Image 3']) ? mysqli_real_escape_string($conn, strval($row['Image 3'])) : '';
            $image4 = isset($row['Image 4']) ? mysqli_real_escape_string($conn, strval($row['Image 4'])) : '';
            $title = isset($row['Title']) ? mysqli_real_escape_string($conn, $row['Title']) : '';
            $category = isset($row['Category']) ? $row['Category'] : '';
            $subCategory = isset($row['sub category']) ? $row['sub category'] : '';
            $productCategory = isset($row['product category']) ? $row['product category'] : '';
            $sku = isset($row['SKU']) ? mysqli_real_escape_string($conn, strval($row['SKU'])) : '';
            $description = isset($row['Description']) ?  mysqli_real_escape_string($conn, $row['Description']) : '';
            $specs = isset($row['Specification']) ?  mysqli_real_escape_string($conn, $row['Specification']) : '';
            $color = isset($row['Color']) ? $row['Color'] : '';
            $size = isset($row['Size']) ? $row['Size'] : '';
            $weight = isset($row['Weight']) ? $row['Weight'] : '';
            $dimensions = isset($row['Dimensions']) ? $row['Dimensions'] : '';
            $brandName = isset($row['Brand Name']) ? $row['Brand Name'] : '';
            $stock = isset($row['Stock']) ? $row['Stock'] : '';
            $price = isset($row['Price']) ? $row['Price'] : '';
            $specialPrice = isset($row['Special Price']) ? $row['Special Price'] : '';
            $warranty = isset($row['Warranty']) ? $row['Warranty'] : '';
            $exchange = isset($row['Exchange']) ? $row['Exchange'] : '';
            $title_ar = isset($row['title_ar']) ? $row['title_ar'] : '';
            $description_ar = isset($row['description_ar']) ? $row['description_ar'] : '';
            $specs_ar = isset($row['specs_ar']) ? $row['specs_ar'] : '';
            $color_ar = isset($row['color_ar']) ? $row['color_ar'] : '';
            $size_ar = isset($row['size_ar']) ? $row['size_ar'] : '';
            $dimensions_ar = isset($row['dimensions_ar']) ? $row['dimensions_ar'] : '';
            $warranty_ar = isset($row['warranty_ar']) ? $row['warranty_ar'] : '';
            $exchange_ar = isset($row['exchange_ar']) ? $row['exchange_ar'] : '';
            $processed = 0;

            $data[] = "('$image1', '$image2', '$image3', '$image4', '$title', '$category',
                        '$subCategory', '$productCategory', '$sku',
                        '$description', '$specs', '$color', '$size', '$weight', '$dimensions', '$brandName',
                        '$stock', '$price', '$specialPrice', '$warranty', '$exchange',
                        '$title_ar', '$description_ar', '$specs_ar',
                        '$color_ar', '$size_ar', '$dimensions_ar', '$warranty_ar', '$exchange_ar', $supplierId, $processed)";
        }
        $sql  = "INSERT INTO items_temp (`image1`, `image2`, `image3`, `image4`, `title`, `category`,
        `sub_category`, `product_category`, `sku`,
        `description`, `specs`, `color`, `size`, `weight`, `dimension`, `brand_name`,
        `stock`, `price`, `special_price`, `warranty`, `exchange`,
        `title_ar`, `description_ar`, `specs_ar`,
        `color_ar`, `size_ar`, `dimensions_ar`, `warranty_ar`, `exchange_ar`, `supplier_id`, `processed`) VALUES " . implode(',', $data);
        
        if (!$conn->query($sql)) {
            $res = false;
            $msg = $conn->error;
            error_log($msg);
            error_log($sql);
        } else {
            $res = true;
            $msg = 'imported';
        }

        $conn->close();
        $cls = new stdClass();
        $cls->res = $res;
        $cls->msg = $msg;
        return $cls;
    }

    public static function processBatch($items, $brandIdsNames = [])
    {
        $supplierId = $_SESSION['user']->id;
        $insertedItems = 0;
        $updatedItems = 0;
        // Initialize
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO();
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();


        foreach ($items as $row) {
            $update = $insert = false;
            $albumId = 0;
            $prefix = $supplierId . '-' . HelperController::slugify($row['SKU']);
            $image = HelperController::getOrDownloadImage($row['Image 1'], $prefix);
            $imagesArray = [];
            if ($row['Image 2'] != "") {
                $image1 = HelperController::getOrDownloadImage($row['Image 2'], $prefix);
                if ($image1) {
                    array_push($imagesArray, $image1);
                }
            }
            if ($row['Image 3'] != "") {
                $image2 = HelperController::getOrDownloadImage($row['Image 3'], $prefix);
                if ($image2) {
                    array_push($imagesArray, $image2);
                }
            }
            if ($row['Image 4'] != "") {
                $image3 = HelperController::getOrDownloadImage($row['Image 4'], $prefix);
                if ($image3) {
                    array_push($imagesArray, $image3);
                }
            }

            $albumMySqlExtDAO = new AlbumMySqlExtDAO();
            $albumImageMySqlExtDAO = new ImageMySqlExtDAO();
            // if ($imagesArray) {
            //     $albumObj = new Album();
            //     $albumObj->displayOrder = 0;
            //     $albumObj->active = 1;
            //     $albumId = $albumMySqlExtDAO->insert($albumObj);

            //     foreach ($imagesArray as $albumImageItem) {
            //         $albumImageObj = new Image();
            //         $albumImageObj->albumId = $albumId;
            //         $albumImageObj->imageName = $albumImageItem;
            //         $albumImageMySqlExtDAO->insert($albumImageObj);
            //     }
            // }

            $itemObj = new Item();
            self::populateItem($itemObj, $row, $supplierId);
            if ($image) {
                $itemObj->image = $image;
            }

            $itemExists = $itemMySqlExtDAO->queryBySkuAndSupplierId($row['SKU'], $supplierId);
            $date = date('Y-m-d H:i:s');
            $categoryId = ProductController::getCategory($row['Category'], $row['sub category'], $row['product category']);
            if ($itemExists) {

                // if ($imagesArray) {
                //     $albumObj = new Album();
                //     $albumObj->displayOrder = 0;
                //     $albumObj->active = 1;
                //     $albumId = $albumMySqlExtDAO->insert($albumObj);

                //     foreach ($imagesArray as $albumImageItem) {
                //         $albumImageObj = new Image();
                //         $albumImageObj->albumId = $albumId;
                //         $albumImageObj->imageName = $albumImageItem;
                //         $albumImageMySqlExtDAO->insert($albumImageObj);
                //     }
                // }

                // delete image if changed or removed
                if (!$image || ($image != $itemExists[0]->image)) {
                    HelperController::deleteImage($itemExists[0]->image);
                }

                // delete album and images
                if ($itemExists[0]->albumId && $itemExists[0]->albumId != 0) {
                    if (count($imagesArray) == 0) {
                        $oldImages = $albumImageMySqlExtDAO->queryByAlbumId($itemExists[0]->albumId);
                        foreach ($oldImages as $oldImage) {
                            HelperController::deleteImage($oldImage->imageName);
                            $albumImageMySqlExtDAO->deleteByAlbumId($itemExists[0]->albumId);
                        }
                        $albumMySqlExtDAO->delete($itemExists[0]->albumId);
                    } else {
                        $albumObj = $albumMySqlExtDAO->load($itemExists[0]->albumId);
                        if ($albumObj) {
                            $albumId = $albumObj->id;
                            if($albumId != 0){
                                $albumImages = $albumImageMySqlExtDAO->queryByAlbumId($albumId);

                                //Delete deleted images
                                foreach ($albumImages as $row1) {
                                    if (!in_array($row1->imageName, $imagesArray)) {
                                        HelperController::deleteImage($row1->imageName);
                                    }
                                }
    
                                $oldImagesNames = array_map(function ($e) {
                                    return $e->imageName;
                                }, $albumImages);
    
                                //error_log(json_encode($oldImagesNames));
                                
                                //update album 
                                foreach ($imagesArray as $albumImageItem) {
                                    if (!in_array($albumImageItem, $oldImagesNames)) {
                                        $albumImageObj = new Image();
                                        $albumImageObj->albumId = $albumId;
                                        $albumImageObj->imageName = $albumImageItem;
                                        $albumImageMySqlExtDAO->insert($albumImageObj);
                                    }
                                }
                            }
                        } else {
                            if ($imagesArray) {
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
                                $itemObj->albumId = $albumId;
                            }
                        }
                    }
                    //print_r($itemExists);
                } else {
                    if ($imagesArray) {
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
                        $itemObj->albumId = $albumId;
                    }
                }

                $itemObj->id = $itemExists[0]->id;
                $itemObj->createdAt = $itemExists[0]->createdAt;
                $itemObj->updatedAt = $date;
                //print_r($itemObj);echo '<br>';
                $update = $itemMySqlExtDAO->update($itemObj);
                if ($update) {
                    $updatedItems++;
                    //echo $itemObj->id.'<br>';
                    if ($categoryId) {
                        CategoryController::updateOrInsertItemCategory($itemObj->id, $categoryId);
                    }
                    if (array_key_exists($row['Brand Name'], $brandIdsNames)) {
                        BrandController::updateOrInsertItemBrand($itemObj->id, $brandIdsNames[$row['Brand Name']]);
                    }
                }
            } else {

                if ($imagesArray) {
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
                    $itemObj->albumId = $albumId;
                }

                //echo 'does not exists<br>';
                $itemObj->updatedAt = $date;
                $itemObj->createdAt = $date;
                $insert = $itemMySqlExtDAO->insert($itemObj);
                if ($insert) {
                    $insertedItems++;
                    if ($categoryId) {
                        $itemCategoryMappingMySqlExtDAO->insertItemCategory($insert, $categoryId);
                    }
                    if (array_key_exists($row['Brand Name'], $brandIdsNames)) {
                        $itemBrandMappingMySqlExtDAO->insertItemBrand($insert, $brandIdsNames[$row['Brand Name']]);
                    }
                }
            }
            if ($update || $insert) {
                //echo 'update or insert<br>';
                $conn =  ConnectionFactory::getConnection();
                $sql = "UPDATE items_temp set processed = 1 where supplier_id = $supplierId AND sku = '" . $row['SKU'] . "'";
                if (!$conn->query($sql)) {
                    $msg = $conn->error;
                    //echo $msg;
                }
            }
        }

        $response = new stdClass();
        $response->inserted = $insertedItems;
        $response->updated = $updatedItems;
        return $response;
    }

    public static function populateItem(&$itemObj, $row, $supplierId)
    {
        $itemObj->title = $row['Title'];
        $itemObj->description = (isset($row['Description']) && !empty($row['Description'])) ? $row['Description'] : "";
        $itemObj->regularPrice = (isset($row['Price']) && !empty($row['Price'])) ? $row['Price'] : 0;
        $itemObj->salePrice = (isset($row['Special Price']) && !empty($row['Special Price'])) ? $row['Special Price'] : 0;
        $itemObj->weight = (isset($row['Weight']) && !empty($row['Weight'])) ? $row['Weight'] : "";
        $itemObj->sku = $row['SKU'];
        $itemObj->qty = (isset($row['Stock']) && !empty($row['Stock'])) ? $row['Stock'] : 0;
        $itemObj->specification = (isset($row['Specification']) && !empty($row['Specification'])) ? $row['Specification'] : "";
        $itemObj->color = (isset($row['Color']) && !empty($row['Color'])) ? $row['Color'] : "";
        $itemObj->size = (isset($row['Size']) && !empty($row['Size'])) ? $row['Size'] : "";
        $itemObj->dimensions = (isset($row['Dimensions']) && !empty($row['Dimensions'])) ? $row['Dimensions'] : "";
        $itemObj->supplierId = $supplierId;
        $itemObj->displayOrder = 0;
        $itemObj->slug = self::slugify($row['Title'], $row['SKU']);
        $itemObj->warranty = (isset($row['Warranty']) && !empty($row['Warranty'])) ? $row['Warranty'] : "";
        $itemObj->exchange = (isset($row['Exchange']) && !empty($row['Exchange'])) ? $row['Exchange'] : "";
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

    public static function getItems($categoryId = false, $search = "", $brandId = "", $minPrice = "", $maxPrice = "", $tagId = false, $orderBy = "", $limit = 0, $offset = 0)
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
        $item = $itemMySqlExtDAO->queryBySlug($slug);
        if ($item) {
            $item = $item[0];
            if ($item->sku == $sku && $item->supplierId == $_SESSION['user']->id && $item->slug == $slug) {
                return $item->slug;
            } else {
                $c = 1;
                while ($itemMySqlExtDAO->queryBySlug($slug)) {
                    $slug =  HelperController::slugify($title);
                    $slug = $slug . '-' . $c;
                    $c++;
                }
                return $slug;
            }
        } else {
            $c = 1;
            while ($itemMySqlExtDAO->queryBySlug($slug)) {
                $slug =  HelperController::slugify($title);
                $slug = $slug . '-' . $c;
                $c++;
            }
            return $slug;
        }
    }

    public static function insertItemsIntoTempTable($targetFile, $supplierId)
    {
        $conn = ConnectionFactory::getConnection();

        $sql  = "LOAD DATA LOCAL INFILE '$targetFile' INTO TABLE `items_temp` CHARACTER SET 'utf8' FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES SET supplier_id = $supplierId, processed=0, id=NULL";
        if (!$conn->query($sql)) {
            echo ("Error description: " . $conn->error);
            $res = false;
            $msg = $conn->error;
        } else {
            $res = true;
            $msg = 'imported';
        }

        $conn->close();
        $cls = new stdClass();
        $cls->res = $res;
        $cls->msg = $msg;
        return $cls;
    }
}
