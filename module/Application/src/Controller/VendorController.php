<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
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
               // echo 'ok 1';
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
}
