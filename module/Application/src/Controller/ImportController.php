<?php

declare(strict_types=1);

namespace Application\Controller;

use ConnectionFactory;
use ItemBrandMappingMySqlExtDAO;
use ItemCategoryMappingMySqlExtDAO;
use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use PHPExcel_Reader_Excel2007;
use PHPExcel_Writer_Excel5;
use PHPExcel_WorksheetIterator;

use PHPExcel_Worksheet;

use PHPExcel;
use PHPExcel_IComparable;
use PHPExcel_Worksheet_BaseDrawing;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Worksheet_MemoryDrawing;

use PHPExcel_IOFactory;
use UserMySqlExtDAO;

class ImportController extends AbstractActionController
{
    public function submitImport1Action()
    {
        $result = true;
        $msg = "Initial";
        $missingSkusCount = 0;
        $missingTitlesCount = 0;
        if ($_FILES['excel']['tmp_name']) {
            $file = $_FILES['excel']['tmp_name'];
            $userfile_extn = explode(".", strtolower($_FILES['excel']['name']));
            $target_dir = BASE_PATH . upload_file_dir;
            $newName = HelperController::random(10) . '.' . $userfile_extn[1];
            define('fileName', $newName);
            $targetFile = BASE_PATH . upload_file_dir . fileName;
            $upload = move_uploaded_file($file, $targetFile);
            //var_dump($upload);

            $fileName = fileName;
            // Get our import file extension
            $r = explode('.', $fileName);
            ${'Extension'} = strtolower(array_pop($r));

            $allowedExtensions = ['xls', 'xlsx'];
            if (!in_array(${'Extension'}, $allowedExtensions)) {
                $result = false;
                $msg = "wrong extension";
            }

            // Store our content array
            ${'List'} = [];

            if ($result == true) {
                // Create a new Excel instance
                if (${'Extension'} == 'xlsx') {
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                } else {
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                }
                $objReader->setReadDataOnly(false);
                $objPHPExcel = $objReader->load(BASE_PATH . upload_file_dir . fileName);
                $objWorksheet = $objPHPExcel->getActiveSheet();

                // Check for the columns and column titles
                if (
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, 1)->getValue() != 'Image 1' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 1)->getValue() != 'Image 2' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, 1)->getValue() != 'Image 3' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, 1)->getValue() != 'Image 4' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, 1)->getValue() != 'Title' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, 1)->getValue() != 'Category' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, 1)->getValue() != 'sub category' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, 1)->getValue() != 'product category' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, 1)->getValue() != 'SKU' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, 1)->getValue() != 'Description' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, 1)->getValue() != 'Specification' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, 1)->getValue() != 'Color' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, 1)->getValue() != 'Size' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, 1)->getValue() != 'Weight' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, 1)->getValue() != 'Dimensions' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, 1)->getValue() != 'Brand Name' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, 1)->getValue() != 'Stock' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, 1)->getValue() != 'Price' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, 1)->getValue() != 'Special Price' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, 1)->getValue() != 'Warranty' ||
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, 1)->getValue() != 'Exchange'
                ) {
                    $result = false;
                    $msg = "Some coloumns missing, please use the correct excel sheet";
                }

                // Get the total number of rows in the spreadsheet
                $rows = $objWorksheet->getHighestRow();

                if ($result) {
                    // Loop through all the rows (line items)
                    $row = 1;
                    ${'Iterator'} = 0;
                    // skip the first row if it has our column names
                    for (((($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue()) == 'Image 1') ? $row = 2 :  $row = 1); $row <= $rows; ++$row) {
                        // Sanitize all our & add them to the accounts array
                        if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue() == "") {
                            $missingSkusCount++;
                            $missingSkusCount++;
                            $missingSkusCount++;
                        }
                        if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue() == "") {
                            $missingTitlesCount++;
                            $missingTitlesCount++;
                            $missingTitlesCount++;
                        }
                        ${'List'}[${'Iterator'}] = [
                            'Image 1' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getCalculatedValue(),
                            'Image 2' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getCalculatedValue(),
                            'Image 3' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getCalculatedValue(),
                            'Image 4' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getCalculatedValue(),
                            'Title' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getCalculatedValue(),
                            'Category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getCalculatedValue(),
                            'sub category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getCalculatedValue(),
                            'product category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getCalculatedValue(),
                            'SKU' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getCalculatedValue(),
                            'Description' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getCalculatedValue(),
                            'Specification' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getCalculatedValue(),
                            'Color' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getCalculatedValue(),
                            'Size' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getCalculatedValue(),
                            'Weight' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $row)->getCalculatedValue(),
                            'Dimensions' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->getCalculatedValue(),
                            'Brand Name' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $row)->getCalculatedValue(),
                            'Stock' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $row)->getCalculatedValue(),
                            'Price' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $row)->getCalculatedValue(),
                            'Special Price'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $row)->getCalculatedValue(),
                            'Warranty'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, $row)->getCalculatedValue(),
                            'Exchange'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, $row)->getCalculatedValue(),
                        ];
                        ${'Iterator'}++;
                        if ($missingSkusCount > 0) {
                            $result = false;
                            $msg = "Some products do not have SKUs";
                        }
                        if ($missingTitlesCount > 0) {
                            $result = false;
                            $msg = "Some products do not have Titles";
                        }
                    } //end for
                } //end if
            }
        } else {
            $result = false;
            $msg = "No file uploaded";
        }
        //print_r(${'List'});
        // insert rows into database
        if ($result) {
            $insert = ProductController::insertItems(${'List'}, $newName);
            $result = true;
            $msg = "Your file has been imported successfully";
            if ($insert->inserted == 0 && $insert->updated == 0 && $insert->deleted == 0) {
                $msg = "Nothing updated/deleted";
            }
        }

        $response = json_encode([
            'inserted' => $insert->inserted,
            'updated' => $insert->updated,
            'deleted' => $insert->deleted,
            'status' => $result,
            'msg' => $msg,
        ]);
        print_r($response);
        return $this->response;
    }

    public function submitImportAction()
    {
        if (USE_LOAD_DATA_INFILE) {
            $result = true;
            $msg = "Initial";
            $upload = false;
            $insertIntoTemp = false;
            // $missingSkusCount = 0;
            // $missingTitlesCount = 0;
            if ($_FILES['excel']['tmp_name']) {
                $userfile_extn = explode(".", strtolower($_FILES['excel']['name']));
                //print_r($userfile_extn[1]);
                if ($userfile_extn[1] == 'csv') {
                    $file = $_FILES['excel']['tmp_name'];
                    $target_dir = BASE_PATH . upload_file_dir;
                    $newName = HelperController::random(10) . '.' . $userfile_extn[1];
                    $target_file = $target_dir . $newName;
                    $upload = move_uploaded_file($file, $target_file);
                    if ($upload) {
                        $realPath = realpath($target_file);
                    }
                } else {
                    $result = false;
                    $msg = "please use .csv files only";
                }
            } else {
                $result = false;
                $msg = "No file uploaded";
            }
            // insert rows into temp table
            if ($result) {
                $realPath = str_replace("\\", "/", $realPath);
                $insertIntoTemp = ProductController::insertItemsIntoTempTable($realPath, $_SESSION['user']->id);
                $result = $insertIntoTemp->res;
                $msg = $insertIntoTemp->msg;
                if ($result) {
                    $userMysqlExtDAO = new UserMySqlExtDAO();
                    $userInfo = $userMysqlExtDAO->load($_SESSION['user']->id);
                    $userInfo->uploadedFile = $newName;
                    $update = $userMysqlExtDAO->update($userInfo);
                }
            }

            $response = json_encode([
                'status' => $result,
                'msg' => $msg,
                'imported' => $insertIntoTemp,
            ]);
            print_r($response);
            return $this->response;
        } else {
            $result = true;
            $msg = "Initial";
            $missingSkusCount = 0;
            $missingTitlesCount = 0;
            if ($_FILES['excel']['tmp_name']) {
                $file = $_FILES['excel']['tmp_name'];
                $userfile_extn = explode(".", strtolower($_FILES['excel']['name']));
                $target_dir = BASE_PATH . upload_file_dir;
                $newName = HelperController::random(10) . '.' . $userfile_extn[1];
                define('fileName', $newName);
                $targetFile = BASE_PATH . upload_file_dir . fileName;
                $upload = move_uploaded_file($file, $targetFile);
                //var_dump($upload);

                $fileName = fileName;
                // Get our import file extension
                $r = explode('.', $fileName);
                ${'Extension'} = strtolower(array_pop($r));

                $allowedExtensions = ['xls', 'xlsx'];
                if (!in_array(${'Extension'}, $allowedExtensions)) {
                    $result = false;
                    $msg = "wrong extension";
                }

                // Store our content array
                ${'List'} = [];

                if ($result == true) {
                    // Create a new Excel instance
                    if (${'Extension'} == 'xlsx') {
                        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                    } else {
                        $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    }
                    $objReader->setReadDataOnly(false);
                    $objPHPExcel = $objReader->load(BASE_PATH . upload_file_dir . fileName);
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    // Check for the columns and column titles
                    if (
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, 1)->getValue() != 'Image 1' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, 1)->getValue() != 'Image 2' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, 1)->getValue() != 'Image 3' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, 1)->getValue() != 'Image 4' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, 1)->getValue() != 'Title' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, 1)->getValue() != 'Category' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, 1)->getValue() != 'sub category' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, 1)->getValue() != 'product category' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, 1)->getValue() != 'SKU' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, 1)->getValue() != 'Description' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, 1)->getValue() != 'Specification' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, 1)->getValue() != 'Color' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, 1)->getValue() != 'Size' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, 1)->getValue() != 'Weight' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, 1)->getValue() != 'Dimensions' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, 1)->getValue() != 'Brand Name' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, 1)->getValue() != 'Stock' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, 1)->getValue() != 'Price' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, 1)->getValue() != 'Special Price' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, 1)->getValue() != 'Warranty' ||
                        $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, 1)->getValue() != 'Exchange'
                    ) {
                        $result = false;
                        $msg = "Some coloumns missing, please use the correct excel sheet";
                    }

                    // Get the total number of rows in the spreadsheet
                    $rows = $objWorksheet->getHighestRow();

                    if ($result) {
                        // Loop through all the rows (line items)
                        $row = 1;
                        ${'Iterator'} = 0;
                        // skip the first row if it has our column names
                        for (((($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue()) == 'Image 1') ? $row = 2 :  $row = 1); $row <= $rows; ++$row) {
                            // Sanitize all our & add them to the accounts array
                            if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue() == "") {
                                $missingSkusCount++;
                                $missingSkusCount++;
                                $missingSkusCount++;
                            }
                            if ($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue() == "") {
                                $missingTitlesCount++;
                                $missingTitlesCount++;
                                $missingTitlesCount++;
                            }
                            ${'List'}[${'Iterator'}] = [
                                'Image 1' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getCalculatedValue(),
                                'Image 2' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getCalculatedValue(),
                                'Image 3' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getCalculatedValue(),
                                'Image 4' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getCalculatedValue(),
                                'Title' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getCalculatedValue(),
                                'Category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getCalculatedValue(),
                                'sub category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getCalculatedValue(),
                                'product category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getCalculatedValue(),
                                'SKU' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getCalculatedValue(),
                                'Description' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getCalculatedValue(),
                                'Specification' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getCalculatedValue(),
                                'Color' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getCalculatedValue(),
                                'Size' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getCalculatedValue(),
                                'Weight' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $row)->getCalculatedValue(),
                                'Dimensions' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->getCalculatedValue(),
                                'Brand Name' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $row)->getCalculatedValue(),
                                'Stock' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $row)->getCalculatedValue(),
                                'Price' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $row)->getCalculatedValue(),
                                'Special Price'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $row)->getCalculatedValue(),
                                'Warranty'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(19, $row)->getCalculatedValue(),
                                'Exchange'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(20, $row)->getCalculatedValue(),
                            ];
                            ${'Iterator'}++;
                            if ($missingSkusCount > 0) {
                                $result = false;
                                $msg = "Some products do not have SKUs";
                            }
                            if ($missingTitlesCount > 0) {
                                $result = false;
                                $msg = "Some products do not have Titles";
                            }
                        } //end for
                    } //end if
                }
            } else {
                $result = false;
                $msg = "No file uploaded";
            }
            //print_r(${'List'});
            // insert rows into database
            if ($result) {
                $insert = ProductController::insertBulkItems(${'List'});
                $result = $insert->res;
                $msg = $insert->msg;
            }

            $response = json_encode([
                'status' => $result,
                'msg' => $msg,
                'imported' => $insert,
            ]);
            print_r($response);
            return $this->response;
        }
    }

    public function newImport()
    {
    }

    public function oldImport()
    {
    }

    public function insertBatchAction()
    {
        $processBatchRes = false;
        $conn = ConnectionFactory::getConnection();
        $supplierId = $_SESSION['user']->id;
        $sql = "SELECT * FROM items_temp WHERE supplier_id = $supplierId AND processed = 0 ORDER BY id ASC LIMIT 10 OFFSET 0";
        $result = $conn->query($sql);
        $res = true;
        $batch = [];
        if ($result->num_rows > 0) {
            // Initialize
            $brandIdsNames = [];
            // Get Brands
            $brands = BrandController::getBrands();
            foreach ($brands as $brand) {
                $brandIdsNames[$brand->name] = $brand->id;
            }

            // map items fields
            while ($row = $result->fetch_assoc()) {
                $item = [
                    'Image 1' => $row['image1'],
                    'Image 2' => $row['image2'],
                    'Image 3' => $row['image3'],
                    'Image 4' => $row['image4'],
                    'Title' => $row['title'],
                    'Category' => $row['category'],
                    'sub category' => $row['sub_category'],
                    'product category' => $row['product_category'],
                    'SKU' => $row['sku'],
                    'Description' => $row['description'],
                    'Specification' => $row['specs'],
                    'Color' => $row['color'],
                    'Size' => $row['size'],
                    'Weight' => $row['weight'],
                    'Dimensions' => $row['dimension'],
                    'Brand Name' => $row['brand_name'],
                    'Stock' => $row['stock'],
                    'Price' => $row['price'],
                    'Special Price'  => $row['special_price'],
                    'Warranty'  => $row['warranty'],
                    'Exchange'  => $row['exchange'],
                ];
                array_push($batch, $item);
            }
            // \ map items fields
            $processBatchRes = ProductController::processBatch($batch, $brandIdsNames);
            $msg = 'success';
        } else {
            $res = false;
            $msg = 'nothing to process';
        }

        $conn->close();
        $response = json_encode([
            'res' => $res,
            //'sql' => $sql,
            'msg' => $msg,
            'batchRes' => $processBatchRes,
        ]);
        print_r($response);
        return $this->response;
    }

    public function deleteDeletedItemsAction()
    {
        $itemMySqlExtDAO = new ItemMySqlExtDAO();

        $supplierId = $_SESSION['user']->id;
        $conn = ConnectionFactory::getConnection();
        // New Sku List
        $sql = "select sku from items_temp where supplier_id = $supplierId";
        $result = $conn->query($sql);
        $newItemsSKUList = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($newItemsSKUList, $row['sku']);
            }
        }

        // Old SKU List
        $oldItems = $itemMySqlExtDAO->queryBySupplierId($supplierId);
        $oldItemsSKUList = array_map(function ($e) {
            return $e->sku;
        }, $oldItems);
        $conn->close();
        $toBeDeleted = array_diff($oldItemsSKUList, $newItemsSKUList);

        $deletedItems = 0;
        if (count($toBeDeleted) > 0) {
            foreach ($toBeDeleted as $del) {
                $delete = ProductController::deleteItemBySku($del);
                if ($delete) {
                    $deletedItems++;
                }
            }
        }
        $response = json_encode([
            'deletedCount' => $deletedItems,
            'deletedItems' => $toBeDeleted,
        ]);
        print_r($response);
        return $this->response;
    }

    public function cleanTempTableAction()
    {

        $supplierId = $_SESSION['user']->id;
        $conn = ConnectionFactory::getConnection();

        $sql = "DELETE FROM items_temp where `processed` = 1 AND supplier_id = $supplierId";
        $result = $conn->query($sql);
        $msg = $result ? 'cleaned up' : 'not cleaned up';

        $conn->close();
        $response = json_encode([
            'res' => $result,
            'msg' => $msg,
        ]);
        print_r($response);
        return $this->response;
    }
}
