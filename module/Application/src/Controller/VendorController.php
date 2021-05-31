<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use UserMySqlExtDAO;

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

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMySqlExtDAO->load(9);
        $data = [
            'user' => $userInfo
        ];
        return new ViewModel($data);
    }
    public function myProductsAction()
    {
        $limit = 10;
        $offset = 0;
        $page = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $cond  = 'supplier_id = ' . $_SESSION['user']->id;
        $itemsMySqlExtDAO = new ItemMySqlExtDAO();
        $items = $itemsMySqlExtDAO->select($cond, $limit, $offset);
        $itemsCount = count($itemsMySqlExtDAO->select($cond));
        // print_r($items);
        // print_r($itemsCount);
        // print_r($page);
        // die();
        $data = [
            'items' => $items,
            'count' => $itemsCount,
            'currentPage' => $page,
            'totalPages' => ceil($itemsCount / $limit),
        ];
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel($data);
    }
    public function myOrdersAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function myDashboardAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
}
