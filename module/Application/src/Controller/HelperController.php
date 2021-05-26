<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Filter\HtmlEntities;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Validator\Digits;
use Laminas\Validator\NotEmpty;

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
}
