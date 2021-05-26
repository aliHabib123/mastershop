<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $langId = HelperController::langId(HelperController::filterInput($this->params('lang')));
        $bannerLocation = ($langId==1) ? 1 : 2;
        $banners = ContentController::getBanners($bannerLocation);
        $ads = ContentController::getContent("type = 'ad' and lang = $langId ORDER BY display_order asc LIMIT 3");
        $featuredCategories = CategoryController::getCategories("is_featured = 1");
        
        $this->layout()->withBanner = true;
        $this->layout()->banners = $banners;
        $data = [
            'ads' => $ads,
            'featuredCategories' => $featuredCategories,
        ];
        return new ViewModel($data);
    }
    public function testAction()
    {
        return new ViewModel();
    }
}
