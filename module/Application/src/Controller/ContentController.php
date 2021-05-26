<?php

declare(strict_types=1);

namespace Application\Controller;

use BannerImageMySqlExtDAO;
use ContentMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;

class ContentController extends AbstractActionController
{
    public static function getBanners($location)
    {
        $bannerMySqlExtDAO = new BannerImageMySqlExtDAO();
        $banners =  $bannerMySqlExtDAO->getBannerImagesByLocation($location);
        return $banners;
    }

    public static function getAds($langId=1)
    {
        $contentMySqlExtDAO = new ContentMySqlExtDAO();
        $res = $contentMySqlExtDAO->select("type = ad and lang = $langId ORDER BY display_order asc LIMIT 3");
        return $res;
    }

    public static function getContent($cond = "1")
    {
        $contentMySqlExtDAO = new ContentMySqlExtDAO();
        return $contentMySqlExtDAO->select($cond);
    }
}
