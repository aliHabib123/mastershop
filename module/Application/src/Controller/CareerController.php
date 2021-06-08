<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class CareerController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function detailsAction(){
        return new ViewModel();
    }

}
