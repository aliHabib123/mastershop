<?php
// $file_type_arr = array(".xls",".xlsx",".doc",".docx",".pdf",".txt",".rtf","tiff",".jpg",".jpeg",".gif");
// file_uploader("pdf_file",$file_type_arr,"../uploads/");


function file_uploader($control, $file_type_arr, $file_dir)
{
    if (! empty($_FILES [$control] ['name'])) {
        if ($_FILES [$control] ['error'] == 0) {
            $ext = strtolower(strrchr($_FILES [$control] ['name'], '.'));
            
            if (in_array($ext, $file_type_arr)) {
                if ($_FILES [$control] ['size'] > 0) {
                    $new_document= $rand_name=rand(1000, 9999)."_".$_FILES [$control] ['name'];
                    //$new_document = $_FILES [$control] ['name'];
                    while (is_file($file_dir . $new_document)) {
                        $new_document = $rand_name = rand(1000, 9999) . "_" . rand(1000, 9999) . "_" . rand(1000, 9999) . $ext;
                    }
                    
                    if ((move_uploaded_file($_FILES [$control] ['tmp_name'], $file_dir . $new_document))) {
                        return $new_document;
                    }
                }
            }
        }
    }
}
