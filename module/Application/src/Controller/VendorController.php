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

class VendorController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function contactDetailsAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function accountDetailsAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function warehouseDetailsAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function inventoryAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
}
