<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/

class SimpleImage
{
    public $image;
    public $image_type;
    
    public function SimpleImage()
    {
        //reset the class values
        $this->image = "";
        $this->image_type = "";
    }
    
    public function load($filename)
    {
        if (is_file($filename) == false) {
            return;
        }
        $image_info = getimagesize($filename);
        $this->image_type = $image_info [2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {
        if ($filename  == "") {
            return;
        }
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }
    public function output($image_type = IMAGETYPE_JPEG)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            return imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            return imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            return imagepng($this->image);
        }
        return;
    }
    public function getWidth()
    {
        return imagesx($this->image);
    }
    public function getHeight()
    {
        if ($this->image == "") {
            return;
        }
        return imagesy($this->image);
    }
    public function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }
    public function resizeToWidth($width)
    {
        if ($this->image == "") {
            return;
        }
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }
    public function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }
    public function resize($width, $height)
    {
        if ($this->image == "") {
            return;
        }
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
    
    public function uploadImage($control_name, $filedir)
    {
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
        
        if ($_FILES [$control_name] ['size'] < 0) {
            return 4;
        }
        
        $new_file_name = rand(100000, 999999) . $ext;
        
        while (is_file($filedir . $new_file_name)) {
            $new_file_name = rand(100000, 999999) . $ext;
        }
        
        if (! (move_uploaded_file($_FILES [$control_name] ['tmp_name'], $filedir . $new_file_name))) {
            return 5;
        }
        if ($new_file_name == 1) {
            $new_file_name = "";
        }
        return ($new_file_name);
    }
}
