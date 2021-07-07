<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Application\Controller\HelperController;

class LanguageController extends AbstractActionController
{
    public static $ENGLISH = 'en';
    public static $ENGLISH_ID = '1';
    public static $ARABIC = 'ar';
    public static $ARABIC_ID = '2';

    public static function setLanguage($e)
    {
        $lang = HelperController::filterInput($e->params('lang'));
        $langId = self::langId($lang);
        $_SESSION['lang'] = $lang;
        return $langId;
    }
    public static function getLanguage()
    {
        return isset($_SESSION['lang']) ? $_SESSION['lang'] : self::$ENGLISH;
    }

    public static function langId($langId)
    {
        switch ($langId) {
            case self::$ENGLISH:
                return 1;
                break;
            case self::$ARABIC:
                return 2;
                break;
            default:
                return 1;
        }
    }
}
