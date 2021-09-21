<?php

declare(strict_types=1);

namespace Application\Controller;

use ContentMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $langId =  LanguageController::setLanguage($this);
        $lang = LanguageController::getLanguage();
        $bannerId = ($langId == 1) ? 1 : 2;
        $banners = ContentController::getBanners($bannerId);
        $ads = ContentController::getContent("type = 'ad' and lang = $langId ORDER BY display_order asc LIMIT 3");
        $featuredCategories = CategoryController::getCategories("a.`is_featured` = 1 AND a.`lang_id` = 1");

        //Todays DEALS, PICKED FOR YOU and BEST OFFERS
        $todaysDeals = ProductController::getItems(false, false, "", "", "", ProductController::$TODAYS_DEALS, "", 10, 0);
        $pickedForYou = ProductController::getItems(false, false,  "", "", "", ProductController::$PICKED_FOR_YOU, "", 10, 0);
        $bestOffers = ProductController::getItems(false, false,  "", "", "", ProductController::$BEST_OFFERS, "", 10, 0);

        $this->layout()->withBanner = true;
        $this->layout()->banners = $banners;
        $data = [
            'ads' => $ads,
            'featuredCategories' => $featuredCategories,
            'todaysDeals' => $todaysDeals,
            'pickedForYou' => $pickedForYou,
            'bestOffers' => $bestOffers,
            'lang' => $lang,
        ];
        return new ViewModel($data);
    }

    public function contentAction()
    {
        $langId =  LanguageController::setLanguage($this);
        $slug = HelperController::filterInput($this->params('slug'));
        $contentMySqlExtDAO = new ContentMySqlExtDAO();
        $page = $contentMySqlExtDAO->queryBySlugAndLang($slug, $langId);
        $this->layout()->htmlClass = 'content';
        return new ViewModel([
            'page' => $page[0],
        ]);
    }
    public function testAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
}
