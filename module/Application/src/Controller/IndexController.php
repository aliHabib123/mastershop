<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use ContentMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use WishlistMySqlExtDAO;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $langId = HelperController::langId(HelperController::filterInput($this->params('lang')));
        $bannerLocation = ($langId == 1) ? 1 : 2;
        $banners = ContentController::getBanners($bannerLocation);
        $ads = ContentController::getContent("type = 'ad' and lang = $langId ORDER BY display_order asc LIMIT 3");
        $featuredCategories = CategoryController::getCategories("is_featured = 1");

        //Daily DEALS, PICKED FOR YOU and BEST OFFERS
        $dailyDeals = ProductController::getItems(false, false, ProductController::$DAILY_DEALS, 10, 0);
        $pickedForYou = ProductController::getItems(false, false, ProductController::$PICKED_FOR_YOU, 10, 0);
        $bestOffers = ProductController::getItems(false, false, ProductController::$BEST_OFFERS, 10, 0);

        $this->layout()->withBanner = true;
        $this->layout()->banners = $banners;
        $data = [
            'ads' => $ads,
            'featuredCategories' => $featuredCategories,
            'dailyDeals' => $dailyDeals,
            'pickedForYou' => $pickedForYou,
            'bestOffers' => $bestOffers,
        ];
        return new ViewModel($data);
    }

    public function contentAction()
    {
        $slug = HelperController::filterInput($this->params('slug'));
        $contentMySqlExtDAO = new ContentMySqlExtDAO();
        $page = $contentMySqlExtDAO->queryBySlug($slug);
        $this->layout()->htmlClass = 'content';
        return new ViewModel([
            'page' => $page[0],
        ]);
    }
    public function testAction()
    {
        return new ViewModel();
    }
}
