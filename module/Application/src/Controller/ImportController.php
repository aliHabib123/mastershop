<?php

declare(strict_types=1);

namespace Application\Controller;

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

class ImportController extends AbstractActionController
{
    public function submitImportAction()
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

            // Get our import file extension
            ${'Extension'} = strtolower(array_pop(explode('.', fileName)));

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
                    $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, 1)->getValue() != 'Special Price'
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
                            'Image 1' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue(),
                            'Image 2' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue(),
                            'Image 3' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue(),
                            'Image 4' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue(),
                            'Title' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row)->getValue(),
                            'Category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $row)->getValue(),
                            'sub category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $row)->getValue(),
                            'product category' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $row)->getValue(),
                            'SKU' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row)->getValue(),
                            'Description' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(9, $row)->getValue(),
                            'Specification' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(10, $row)->getValue(),
                            'Color' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(11, $row)->getValue(),
                            'Size' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(12, $row)->getValue(),
                            'Weight' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $row)->getValue(),
                            'Dimensions' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(14, $row)->getValue(),
                            'Brand Name' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(15, $row)->getValue(),
                            'Stock' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(16, $row)->getValue(),
                            'Price' => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(17, $row)->getValue(),
                            'Special Price'  => $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(18, $row)->getValue(),
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
}
