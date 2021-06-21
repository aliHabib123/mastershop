<?php

declare(strict_types=1);

namespace Application\Controller;

use CityMySqlExtDAO;
use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use SaleOrderItemMySqlExtDAO;
use SaleOrderMySqlExtDAO;
use stdClass;
use User;
use UserMySqlExtDAO;
use Warehouse;
use WarehouseMySqlExtDAO;

class VendorController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function contactDetailsAction()
    {
        $cityMySqlExtDAO = new CityMySqlExtDAO();
        $cities = $cityMySqlExtDAO->queryAllOrderBy('city ASC');
        $userMysqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMysqlExtDAO->load($_SESSION['user']->id);
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel([
            'cities' => $cities,
            'userInfo' => $userInfo,
        ]);
    }
    public function accountDetailsAction()
    {
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel();
    }
    public function warehouseDetailsAction()
    {
        UserController::checkVendorLoggedIn();
        $warehouseMySqlExtDAO = new WarehouseMySqlExtDAO();
        $warehouses = $warehouseMySqlExtDAO->getWarehouseBySupplierId($_SESSION['user']->id);

        $data = [
            'warehouses' => $warehouses,
        ];
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel($data);
    }
    public function inventoryAction()
    {
        UserController::checkVendorLoggedIn();
        $this->layout()->htmlClass = 'mb0';

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMySqlExtDAO->load($_SESSION['user']->id);
        $data = [
            'user' => $userInfo
        ];
        return new ViewModel($data);
    }
    public function myProductsAction()
    {
        UserController::checkVendorLoggedIn();
        $cond = "";
        $limit = 10;
        $offset = 0;
        $page = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        if (isset($_GET['with-image'])) {
            if ($_GET['with-image'] == 'yes') {
                $cond  .= "(image != '' AND image IS NOT NULL) AND";
            } elseif ($_GET['with-image'] == 'no') {
                $cond  .= "(image = '' OR image IS NULL) AND";
            }
        }
        if (isset($_GET['with-price'])) {
            if ($_GET['with-price'] == 'yes') {
                $cond  .= "(regular_price != '' AND regular_price != 0 AND regular_price IS NOT NULL) AND";
            } elseif ($_GET['with-price'] == 'no') {
                $cond  .= "(regular_price = '' OR regular_price = 0 OR regular_price IS NULL) AND";
            }
        }
        $cond  .= ' supplier_id = ' . $_SESSION['user']->id;
        //echo $cond;
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
        UserController::checkVendorLoggedIn();
        $limit = 4;
        $offset = 0;
        $page = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
        $orderId  = isset($_GET['order_id']) ? $_GET['order_id'] : false;
        $status  = isset($_GET['status']) ? $_GET['status'] : false;
        $saleOrders = $saleOrderItemMySqlExtDAO->getSalOrderItemsIdsBySupplier($_SESSION['user']->id, $orderId, $status, $limit, $offset);
        $saleOrdersCount = count($saleOrderItemMySqlExtDAO->getSalOrderItemsIdsBySupplier($_SESSION['user']->id, $orderId, $status));
        $totalPages = ceil($saleOrdersCount / $limit);
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel([
            'saleOrders' => $saleOrders,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ]);
    }
    public function myDashboardAction()
    {
        UserController::checkVendorLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $itemsCount = count($itemMySqlExtDAO->queryBySupplierId($_SESSION['user']->id));

        // Last 3 Sale Orders
        $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
        $saleOrders = $saleOrderItemMySqlExtDAO->getSalOrderItemsIdsBySupplier($_SESSION['user']->id, false, false, 3);
        $this->layout()->htmlClass = 'mb0';
        return new ViewModel([
            'itemsCount' => $itemsCount,
            'saleOrders' => $saleOrders,
        ]);
    }

    public function addWarehouseAction()
    {
        $result = false;
        $msg = "Error";

        $firstName = HelperController::filterInput($this->getRequest()->getPost('first-name'));
        $lastName = HelperController::filterInput($this->getRequest()->getPost('last-name'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $warehouseName = HelperController::filterInput($this->getRequest()->getPost('warehouse-name'));

        if ($firstName == "" || $lastName == "" || $email == "" || $mobile == "" || $warehouseName == "") {
            $msg = "Please fill all inputs";
        } else {
            // createContact
            $userObj = new stdClass();
            $userObj->firstName = $firstName;
            $userObj->lastName = $lastName;
            $userObj->fullName = $firstName . " " . $lastName;
            $userObj->email = $email;
            $userObj->mobile = $mobile;
            $userObj->userType = UserController::$WAREHOUSE_MANAGER;

            $userController = new UserController();
            $user = $userController->registerUser($userObj);

            $contactId = $user->id;

            // Create Warehouse
            if ($contactId) {
                $date = date('Y-m-d H:i:s');
                $warehouseMySqlExtDAO = new WarehouseMySqlExtDAO();
                $warehouseObj = new Warehouse();
                $warehouseObj->title = $warehouseName;
                $warehouseObj->contactId = $contactId;
                $warehouseObj->active = 1;
                $warehouseObj->companyId = $_SESSION['user']->id;
                $warehouseObj->createdAt = $date;
                $warehouseObj->updatedAt = $date;
                $warehouse = $warehouseMySqlExtDAO->insert($warehouseObj);
            }
            if ($warehouse) {
                $warehouseObj->id = $warehouse;
                $result = true;
                $msg = "successfully Added Warehouse";
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'contact' => $userObj,
            'warehouse' => $warehouseObj,
        ]);

        print_r($response);
        return $this->response;
    }

    public function deleteWarehouseAction()
    {
        $result = false;
        $msg = "Error";

        $warehouseId = HelperController::filterInput($this->getRequest()->getPost('warehouseId'));
        $contactId = HelperController::filterInput($this->getRequest()->getPost('contactId'));

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $deleteContact = $userMySqlExtDAO->delete($contactId);

        if ($deleteContact) {
            $warehouseMySqlExtDAO = new WarehouseMySqlExtDAO();
            $deleteWarehouse = $warehouseMySqlExtDAO->delete($warehouseId);
            if ($deleteWarehouse) {
                $result = true;
                $msg = "successfully Deleted Warehouse";
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);

        print_r($response);
        return $this->response;
    }

    public function editWarehouseAction()
    {
        $result = false;
        $msg = "Error";

        $firstName = HelperController::filterInput($this->getRequest()->getPost('first-name'));
        $lastName = HelperController::filterInput($this->getRequest()->getPost('last-name'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $warehouseName = HelperController::filterInput($this->getRequest()->getPost('warehouse-name'));
        $contactId = HelperController::filterInput($this->getRequest()->getPost('contact-id'));
        $warehouseId = HelperController::filterInput($this->getRequest()->getPost('warehouse-id'));

        if ($firstName == "" || $lastName == "" || $email == "" || $mobile == "" || $warehouseName == "") {
            $msg = "Please fill all inputs";
        } else {
            $userMySqlExtDAO = new UserMySqlExtDAO();
            $userObj = new User();
            // createContact
            $userObj->id = $contactId;
            $userObj->firstName = $firstName;
            $userObj->lastName = $lastName;
            $userObj->fullName = $firstName . " " . $lastName;
            $userObj->email = $email;
            $userObj->mobile = $mobile;
            $userObj->userType = UserController::$WAREHOUSE_MANAGER;

            $updateUser = $userMySqlExtDAO->update($userObj);

            // print_r($updateUser);
            // echo '<br>';

            // update Warehouse
            if ($updateUser) {
                $date = date('Y-m-d H:i:s');
                $warehouseMySqlExtDAO = new WarehouseMySqlExtDAO();
                $warehouseObj = new Warehouse();
                $warehouseObj->warehouseId = $warehouseId;
                
                $warehouseObj->title = $warehouseName;
                $warehouseObj->contactId = $contactId;
                $warehouseObj->active = 1;
                $warehouseObj->companyId = $_SESSION['user']->id;
                $warehouseObj->createdAt = $date;
                $warehouseObj->updatedAt = $date;
                $warehouse = $warehouseMySqlExtDAO->update($warehouseObj);
            }
            if ($warehouse) {
                // for javascript
                $warehouseObj->id = $warehouseId;
                $result = true;
                $msg = "successfully Updated Warehouse";
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'contact' => $userObj,
            'warehouse' => $warehouseObj,
        ]);

        print_r($response);
        return $this->response;
    }

    public function vendorOrderDetailsAction(){
        UserController::checkVendorLoggedIn();
        $id = HelperController::filterInput($this->params('id'));
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
        $saleOrder = $saleOrderMySqlExtDAO->load($id);
        $saleOrderItems  = $saleOrderItemMySqlExtDAO->itemsBySupplierIdAndSaleOrderId($id, $_SESSION['user']->id);
        $data = [
            'saleOrder' => $saleOrder,
            'items' => $saleOrderItems,
        ];
        return new ViewModel($data);
    }
}
