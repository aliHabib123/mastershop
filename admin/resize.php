<?php
function upload_image($control_name, $filedir)
{
    $simpleImage = new SimpleImage();
    if (empty($_FILES [$control_name] ['name'])) {
        return 1;
    }
    
    if ($_FILES [$control_name] ['error'] != 0) {
        return 2;
    }
    
    $limited_ext = array(".jpg", ".jpeg", ".png", ".gif" );
    
    $ext = strtolower(strrchr($_FILES [$control_name] ['name'], '.'));
    
    if (! in_array($ext, $limited_ext)) {
        return 3;
    }
    //$kbSize = $_FILES [$control_name] ['size'] * 1024;
    if ($_FILES [$control_name] ['size'] < 0) {
        return 4;
    }
    
    $new_file_name = rand(100000000000000, 999999999999999) . $ext;
    
    while (is_file($filedir . $new_file_name)) {
        $new_file_name = rand(100000000000000, 999999999999999) . $ext;
    }
    
    if (! (move_uploaded_file($_FILES [$control_name] ['tmp_name'], $filedir . $new_file_name))) {
        return 5;
    }
    
    return ($new_file_name);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////


function resize_image($widthreq, $heightreq, $prefix, $ext, $filedir, $new_file_name)
{
    $source_img = $filedir . $new_file_name;
    $thumb_img = $filedir . $prefix . $new_file_name;
    
    $sizes = getimagesize($filedir . $new_file_name);
    
    $ow = $sizes [0];
    $oh = $sizes [1];
    
    if ($ow >= $widthreq) {
        $new_width = $widthreq;
        $new_height = ($oh * $new_width) / $ow;
    }
    
    if ($oh >= $heightreq) {
        $new_height = $heightreq;
        $new_width = ($ow * $new_height) / $oh;
    }
    
    if ($ow <= $widthreq) {
        $new_width = $ow;
        $new_height = $oh;
    }
    
    if ($oh <= $heightreq) {
        $new_height = $oh;
        $new_width = $ow;
    }
    
    if ($new_width > $widthreq) {
        $new_width = $widthreq;
        $new_height = ($oh * $new_width) / $ow;
    }
    
    if ($new_height > $heightreq) {
        $new_height = $heightreq;
        $new_width = ($ow * $new_height) / $oh;
    }
    
    $dest_img = imagecreatetruecolor($new_width, $new_height) or die('Problem In Creating image');
    
    ///////////////////////////////////////////////
    //$image_info = getimagesize($source_img);
    // /echo "<br>".$image_info['mime'];
    

    switch ($ext) {
        case '.gif':
            $src_img = imagecreatefromgif($source_img);
            break;
        case '.jpg':
            $src_img = imagecreatefromjpeg($source_img);
            break;
        case '.jpeg':
            $src_img = imagecreatefromjpeg($source_img);
            break;
        case '.png':
            $src_img = imagecreatefrompng($source_img);
            break;
    }
    
    ///////////////////////////////////////////////
    

    if (function_exists('imagecopyresampled')) {
        imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, ImageSX($src_img), ImageSY($src_img)) or die('Problem In resizing1');
    } else {
        imagecopyresized($dest_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, ImageSX($src_img), ImageSY($src_img)) or die('Problem In resizing2');
    }
    
    imagejpeg($dest_img, $thumb_img, 90) or die('Problem In saving');
    imagedestroy($dest_img);
}

function getSlug($title)
{
    $slug = strtolower(trim($title));
    $slug= str_replace('â€™', '', $slug);
    $slug= str_replace('â€œ', '', $slug);
    $slug= str_replace('â€“', '', $slug);
    $slug= str_replace('â€', '', $slug);
    $slug= str_replace('â€', '', $slug);
    $slug= str_replace('(', '', $slug);
    $slug= str_replace(')', '', $slug);
    $slug= str_replace(' - ', '', $slug);
    $slug= str_replace('Â½', 'half', $slug);
    $slug= str_replace('&', 'and', $slug);
    $slug= str_replace('â€“', '', $slug);
    $slug= str_replace(',', '', $slug);
    $slug= str_replace(':', '', $slug);
    $slug= str_replace(';', '', $slug);
    $slug= str_replace('!', '', $slug);
    $slug= str_replace(' ', '-', $slug);
    $slug= str_replace('?', '', $slug);
    $slug= str_replace('---', '-', $slug);
    $slug= str_replace('--', '-', $slug);
    $slug = trim($slug, "-");
    
    return $slug;
}
