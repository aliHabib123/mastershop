<?php

declare(strict_types=1);

namespace Application\Controller;

use Attachment;
use AttachmentMySqlExtDAO;
use Laminas\Filter\HtmlEntities;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Validator\Digits;
use Laminas\Validator\NotEmpty;
use stdClass;

class HelperController extends AbstractActionController
{
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function filterInput($input)
    {
        // Check if empty, if true then return it
        $checkEmpty = new NotEmpty();
        if ($checkEmpty->isValid($input) == false) {
            return $input;
        }

        // Check if the value is integer then return it directly
        $checkInteger = new Digits();
        if ($checkInteger->isValid($input)) {
            return $input;
        }

        $stripTags = new StripTags();
        $stringTrim = new StringTrim();
        $htmlEntities = new HtmlEntities();

        $input = $stripTags->filter($input);
        $input = $stringTrim->filter($input);
        $input = $htmlEntities->filter($input);
        $input = str_replace("\\", "", $input); // kill remained backslash
        $input = preg_replace("/&apos;/", "'", $input); // replace '&apos;' with " ' "

        return $input;
    }

    public static function langId($langId)
    {
        switch ($langId) {
            case 'en':
                return 1;
                break;
            case 'ar':
                return 2;
                break;
            default:
                return 1;
        }
    }

    public static function getImageUrl($imageName)
    {
        return BASE_URL . upload_image_dir . $imageName;
    }

    public static function getFileUrl($fileName)
    {
        return BASE_URL . upload_file_dir . $fileName;
    }

    public static function getCurrentUrl()
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public static function createJsonResponse($status, $message)
    {
        $array = [
            "status" => $status,
            "msg" => $message
        ];
        return Json::encode($array);
    }

    public static function random($length = 10)
    {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $size = strlen($chars);
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    public static function randomNumber($length = 10)
    {
        $chars = "0123456789";
        $size = strlen($chars);
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    public static function downloadFile($url = "", $prefix = "")
    {
        $res = false;
        if ($url && $url != "" && @getimagesize($url)) {
            $ext = pathinfo($url, PATHINFO_EXTENSION);
            // Initialize the cURL session
            $ch = curl_init($url);

            $file_name = $prefix . '_' . HelperController::random(10) . '.' . $ext;
            while (is_file(BASE_PATH . upload_image_dir . $file_name)) {
                $file_name = $prefix . '_' . HelperController::random(10) . '.' . $ext;
            }

            // Save file into file location
            $save_file_loc = BASE_PATH . upload_image_dir . $file_name;
            // Open file
            $fp = @fopen($save_file_loc, 'wb');
            // It set an option for a cURL transfer
            if (file_exists($save_file_loc)) {
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                // Perform a cURL session
                $res = curl_exec($ch);
                // Closes a cURL session and frees all resources
                curl_close($ch);
                // Close file
                fclose($fp);
                if ($res) {
                    $res = $file_name;
                }
            }
        }
        return $res;
    }

    public static function getOrDownloadImage($url, $prefix = "")
    {
        $attachmentMySqlExtDAO = new AttachmentMySqlExtDAO();
        $attachemntExists = $attachmentMySqlExtDAO->queryByUrl($url);
        //error_log('result for: '. $url . ' ' . json_encode($attachemntExists[0]));
        if ($attachemntExists && file_exists(BASE_PATH . upload_image_dir . $attachemntExists[0]->imageName)) {
            //error_log($url . ' already exists. image name: '. $attachemntExists[0]->imageName);
            return $attachemntExists[0]->imageName;
        } else {
            //error_log('downloading: ' . $url);
            $imageName = self::downloadFile($url, $prefix);
            if ($imageName) {
                $attachmentObj = new Attachment();
                $attachmentObj->url = $url;
                $attachmentObj->imageName = $imageName;
                $attachmentMySqlExtDAO->insert($attachmentObj);
            }
            return $imageName;
        }
    }

    public static function deleteImage($imageName)
    {
        $filePath = BASE_PATH . upload_image_dir . $imageName;
        if (is_file($filePath)) {
            unlink($filePath);
            return true;
        }
        return false;
    }

    public static function passwordStrength($password = "")
    {
        $msg = "Invalid pass";
        $result = false;
        if ($password != "" && $password != null) {
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $msg = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                $result = false;
            } else {
                $msg = 'Strong password.';
                $result = true;
            }
        }

        $ret = new stdClass();
        $ret->msg = $msg;
        $ret->status = $result;
        return $ret;
    }
}
