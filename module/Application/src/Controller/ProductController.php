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

class ProductController extends AbstractActionController
{
    public function indexAction()
    {
        var_dump($_SESSION);
        return new ViewModel();
    }
    public function detailsAction()
    {
        return new ViewModel();
    }
    public function todaysDealsAction()
    {
        return new ViewModel();
    }
    public function latestArrivalsAction()
    {
        return new ViewModel();
    }
}
