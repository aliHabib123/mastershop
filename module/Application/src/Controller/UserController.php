<?php

declare(strict_types=1);

namespace Application\Controller;

use Cart;
use CartMySqlExtDAO;
use CityMySqlExtDAO;
use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\View;
use SaleOrder;
use SaleOrderItem;
use SaleOrderItemMySqlExtDAO;
use SaleOrderMySqlExtDAO;
use stdClass;
use User;
use UserMySqlExtDAO;
use Wishlist;
use WishlistMySqlExtDAO;

class UserController extends AbstractActionController
{
    public static $ADMIN = 1;
    public static $SUPPLIER = 2;
    public static $CUSTOMER = 3;
    public static $WAREHOUSE_MANAGER = 4;

    public function registeOrLoginUser($userInfo)
    {
        $user = $this->getUserInfoByEmail($userInfo->email);
        if (!$user) {
            $user = $this->registerUser($userInfo);
        } else {
            $user = $user[0];
        }

        $this->setUserSession($user);
        return $user;
    }

    public function getUserInfoByEmail(string $email)
    {
        $userMySqlExtDAO = new UserMySqlExtDAO();
        return $userMySqlExtDAO->getUserByEmailAndType($email, UserController::$CUSTOMER);
    }

    public function setUserSession($user)
    {
        //Wishlist Items
        $wishListMySqlExtDAO = new WishlistMySqlExtDAO();
        $wishlistArr = $wishListMySqlExtDAO->queryByCustomerId($user->id);
        $itemIdsArray = array_map(function ($e) {
            return $e->itemId;
        }, $wishlistArr);
        //Wishlist Items
        $cartMySqlExtDAO = new CartMySqlExtDAO();
        $cartArr = $cartMySqlExtDAO->queryByUserId($user->id);
        $cartItemIdsArray = array_map(function ($e) {
            return $e->itemId;
        }, $cartArr);

        $obj = new stdClass();
        $obj->firstName = $user->firstName;
        $obj->lastName = $user->lastName;
        $obj->fullName = $user->firstName . ' ' . $user->lastName;
        if ($user->fullName) {
            $obj->fullName = $user->fullName;
        }
        if ($user->userType) {
            $obj->userType = $user->userType;
        }
        $obj->email = $user->email;
        $obj->id = $user->id;
        $obj->joinDate = $user->createdAt;
        $obj->wishlist = $itemIdsArray;
        $obj->cart = $cartItemIdsArray;

        $_SESSION['user'] = $obj;
    }

    public function logoutAction(string $redirectUrl = MAIN_URL)
    {
        session_destroy();
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function submitRegisterAction()
    {
        $result = false;
        $msg = "Error";
        $redirectUrl = MAIN_URL;

        $fullname = HelperController::filterInput($this->getRequest()->getPost('full-name'));
        $birthday = HelperController::filterInput($this->getRequest()->getPost('birthday'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $confirmPassword = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));
        $agree = HelperController::filterInput($this->getRequest()->getPost('agree'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));
        //print_r($agree);

        if ($fullname == "" || $birthday == "" || $email == "" || $password == "" || $confirmPassword == "") {
            $msg = "Please fill all inputs";
        } elseif ($password != $confirmPassword) {
            $msg = "Passwords do not match";
        } elseif (!$agree) {
            $msg = "please agree on our terms and conditions!";
        } else {
            $userExists = $this->getUserInfoByEmail($email);
            if ($userExists) {
                $result = false;
                $msg = "This email is already registered";
            } else {
                $firstName = explode(" ", $fullname)[0];
                $userObj = new stdClass();
                $userObj->firstName = $firstName;
                $userObj->lastName = "";
                $userObj->fullName = $fullname;
                $userObj->email = $email;
                $userObj->dob = $birthday;
                $userObj->userType = UserController::$CUSTOMER;
                $userObj->password = password_hash($password, PASSWORD_DEFAULT);

                $user = $this->registerUser($userObj);

                if ($user) {
                    $this->setUserSession($user);
                    $result = true;
                    $msg = "successfully registered";
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);
        //$response = HelperController::createJsonResponse($result, $msg);
        print_r($response);
        return $this->response;
    }

    public function submitloginAction()
    {
        $result = false;
        $msg = "Wrong email or password!";
        $redirectUrl = MAIN_URL;

        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));
        //print_r($agree);

        if ($email == "" || $password == "") {
            $msg = "Please fill all inputs";
        } else {
            $userExists = $this->getUserInfoByEmail($email);
            if ($userExists) {
                $user = $userExists[0];
                if ($user && password_verify($password, $user->password)) {
                    $this->setUserSession($user);
                    $result = true;
                    $msg = "successfully logged in!";
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);
        //$response = HelperController::createJsonResponse($result, $msg);
        print_r($response);
        return $this->response;
    }

    public function registerUser($userInfo)
    {
        $date = date('Y-m-d H:i:s');
        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userObj = new User();
        $userObj->firstName = $userInfo->firstName;
        $userObj->lastName = $userInfo->lastName;
        $userObj->fullName = $userInfo->fullName;
        $userObj->email = $userInfo->email;
        if ($userInfo->userType) {
            $userObj->userType = $userInfo->userType;
        }
        if ($userInfo->dob) {
            $userObj->dob = $userInfo->dob;
        }
        if ($userInfo->password) {
            $userObj->password = $userInfo->password;
        }
        if ($userInfo->mobile) {
            $userObj->mobile = $userInfo->mobile;
        }
        $userObj->createdAt = $date;
        $userObj->updatedAt = $date;
        $userId = $userMySqlExtDAO->insert($userObj);

        if ($userId) {
            $user = $userMySqlExtDAO->load($userId);
        }
        return $user;
    }

    public function myProfileAction()
    {
        self::checkCustomerLoggedIn();
        $cityMySqlExtDAO = new CityMySqlExtDAO();
        $cities = $cityMySqlExtDAO->queryAllOrderBy('city ASC');
        $userMysqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMysqlExtDAO->load($_SESSION['user']->id);
        return new ViewModel([
            'cities' => $cities,
            'userInfo' => $userInfo,
        ]);
    }
    public function myWishlistAction()
    {
        self::checkCustomerLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $wishlist = [];
        if (count($_SESSION['user']->wishlist)) {
            $list = implode(',', $_SESSION['user']->wishlist);
            $cond = "id IN ($list)";
            $wishlist = $itemMySqlExtDAO->select($cond);
        }
        return new ViewModel([
            'wishlist' => $wishlist,
        ]);
    }

    public function addToWishlistAction()
    {
        $result = false;
        $msg = "Error";
        $added = false;
        $deleted = false;

        $itemId = HelperController::filterInput($this->getRequest()->getPost('itemId'));
        $wishlistMySqlExtDAO = new WishlistMySqlExtDAO();
        $obj = new Wishlist();
        $obj->itemId = $itemId;
        $obj->customerId = $_SESSION['user']->id;

        if (in_array($itemId, $_SESSION['user']->wishlist)) {
            $del = $wishlistMySqlExtDAO->deleteFromWishlist($obj);
            if ($del) {
                $flipped = array_flip($_SESSION['user']->wishlist);
                unset($flipped[$itemId]);
                $_SESSION['user']->wishlist = array_flip($flipped);
                $result = true;
                $msg = "Deleted from wishlist";
                $deleted = true;
            }
        } else {
            $add = $wishlistMySqlExtDAO->insert($obj);
            if ($add) {
                array_push($_SESSION['user']->wishlist, $itemId);
                $result = true;
                $msg = "Added to wishlist";
                $added = true;
            }
        }

        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'added' => $added,
            'deleted' => $deleted,
        ]);
        print_r($response);
        return $this->response;
    }

    public function addToCartAction()
    {
        $result = false;
        $msg = "Error";

        $itemId = HelperController::filterInput($this->getRequest()->getPost('itemId'));
        $cartMySqlExtDAO = new CartMySqlExtDAO();
        $obj = new Cart();
        $obj->itemId = $itemId;
        $obj->userId = $_SESSION['user']->id;
        $obj->qty = 1;

        $exist = $cartMySqlExtDAO->getCartItems($itemId, $_SESSION['user']->id);
        if ($exist) {
            $qty = intval($exist->qty) + 1;
            $add = $cartMySqlExtDAO->incrementCartItems($itemId, $_SESSION['user']->id, $qty);
        } else {
            $add = $cartMySqlExtDAO->insert($obj);
            array_push($_SESSION['user']->cart, $itemId);
        }

        if ($add) {
            $result = true;
            $msg = "Added to cart";
        }

        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);
        print_r($response);
        return $this->response;
    }

    public function deleteFromCartAction()
    {
        $result = false;
        $msg = "Error";
        $haveItems = true;
        $total = 0;
        $itemId = HelperController::filterInput($this->getRequest()->getPost('itemId'));
        $cartMySqlExtDAO = new CartMySqlExtDAO();
        $delete = $cartMySqlExtDAO->deleteCartQty($itemId, $_SESSION['user']->id);
        //$delete = $cartMySqlExtDAO->delete($cartId);
        if ($delete) {
            $flipped = array_flip($_SESSION['user']->cart);
            unset($flipped[$itemId]);
            $_SESSION['user']->cart = array_flip($flipped);
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            $items = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
            if (!$items) {
                $haveItems = false;
            } else {
                foreach ($items as $item) {
                    $rawPrice = ProductController::getFinalPrice($item->regularPrice, $item->salePrice, true);
                    $subtotalRaw = $rawPrice * $item->cartQty;
                    $total += $subtotalRaw;
                }
            }
            $result = true;
            $msg = "Deleted from cart";
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'haveItems' => $haveItems,
            'total' => number_format($total) . " LBP",
        ]);
        print_r($response);
        return $this->response;
    }

    public function updateCartAction()
    {
        $result = false;
        $msg = "Error";
        $total = 0;
        $subtotal = 0;
        $itemId = HelperController::filterInput($this->getRequest()->getPost('itemId'));
        $cartQty = HelperController::filterInput($this->getRequest()->getPost('cartQty'));
        if ($cartQty <= 0 || !is_numeric($cartQty)) {
            $cartQty = 1;
        }
        $cartMySqlExtDAO = new CartMySqlExtDAO();
        $update = $cartMySqlExtDAO->updateCartQty($itemId, $_SESSION['user']->id, $cartQty);

        if ($update) {
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            $items = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
            foreach ($items as $item) {
                $rawPrice = ProductController::getFinalPrice($item->regularPrice, $item->salePrice, true);
                $subtotalRaw = $rawPrice * $item->cartQty;
                $total += $subtotalRaw;
                if ($item->id == $itemId) {
                    $subtotal = number_format($subtotalRaw) . " LBP";
                }
            }
            $result = true;
            $msg = "Qty Updated";
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'total' => number_format($total) . " LBP",
            'subtotal' => $subtotal,
            'qty' => $cartQty,
        ]);
        print_r($response);
        return $this->response;
    }
    public function deleteFromWishlistAction()
    {
        $result = false;
        $msg = "Error";

        $itemId = HelperController::filterInput($this->getRequest()->getPost('itemId'));

        $wishlistMySqlExtDAO = new WishlistMySqlExtDAO();
        $obj = new Wishlist();
        $obj->itemId = $itemId;
        $obj->customerId = $_SESSION['user']->id;
        $del = $wishlistMySqlExtDAO->deleteFromWishlist($obj);
        if ($del) {
            $flipped = array_flip($_SESSION['user']->wishlist);
            unset($flipped[$itemId]);
            $$_SESSION['user']->wishlist = array_flip($flipped);
            $result = true;
            $msg = "Deleted from wishlist";
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);
        print_r($response);
        return $this->response;
    }

    public function myCartAction()
    {
        self::checkCustomerLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
        return new ViewModel([
            'items' => $cartItems,
        ]);
    }

    public function checkoutAction()
    {
        self::checkCustomerLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
        if(count($cartItems)<=0){
            header('Location: '.MAIN_URL.'my-cart');
            exit();
        }

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMySqlExtDAO->load($_SESSION['user']->id);

        $cityMySqlExtDAO = new CityMySqlExtDAO();
        $cities = $cityMySqlExtDAO->queryAllOrderBy('city ASC');

        return new ViewModel([
            'items' => $cartItems,
            'userInfo' => $userInfo,
            'cities' => $cities,
        ]);
    }

    public function updateUserAction()
    {
        $result = false;
        $msg = "Nothing changed";

        $firstName = HelperController::filterInput($this->getRequest()->getPost('first-name'));
        $lastName = HelperController::filterInput($this->getRequest()->getPost('last-name'));
        //$email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $tel1 = HelperController::filterInput($this->getRequest()->getPost('tel1'));
        $tel2 = HelperController::filterInput($this->getRequest()->getPost('tel2'));
        $country = HelperController::filterInput($this->getRequest()->getPost('country'));
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $address = HelperController::filterInput($this->getRequest()->getPost('address'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $confirmPassword = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));

        $checkPassword = false;
        if($password != ""){
            $checkPassword = true;
        }
        $passwordStrength = HelperController::passwordStrength($password);

        if ($firstName == "" || $lastName == "" || $mobile == "" || $country == "" || $city == "" || $address == "") {
            $msg = "Please fill all inputs";
        } elseif ($password != "" && $password != $confirmPassword) {
            $msg = "Passwords do not match";
        } elseif ($checkPassword && $passwordStrength->status == false) {
            //echo 'here';
            $msg = $passwordStrength->msg;
        } else {
            //echo 'here1';
            $userMySqlExtDAO = new UserMySqlExtDAO();
            $userInfo = $userMySqlExtDAO->load($_SESSION['user']->id);

            $userInfo->firstName = $firstName;
            $userInfo->lastName = $lastName;
            $userInfo->fullName = $firstName . " " . $lastName;
            $userInfo->mobile = $mobile;
            $userInfo->tel1 = $tel1;
            $userInfo->tel2 = $tel2;
            $userInfo->country = $country;
            $userInfo->city = $city;
            $userInfo->address1 = $address;
            $userInfo->updatedAt = date('Y-m-d H:i:s');

            if ($passwordStrength->status) {
                $userInfo->password = password_hash($password, PASSWORD_DEFAULT);
            }
            $updateUser = $userMySqlExtDAO->update($userInfo);

            if ($updateUser) {
                $result = true;
                $msg = "successfully Updated User Info";
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);

        print_r($response);
        return $this->response;
    }

    public function orderCompleteAction(){
        self::checkCustomerLoggedIn();
        $result = false;
        $msg = "Error";
        $redirectUrl = MAIN_URL.'order-result?res=fail';
        $fullName = HelperController::filterInput($this->getRequest()->getPost('full-name'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $country = HelperController::filterInput($this->getRequest()->getPost('country'));
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $deliveryAddress = HelperController::filterInput($this->getRequest()->getPost('delivery-address'));
        $notes = HelperController::filterInput($this->getRequest()->getPost('notes'));

        if($fullName == "" || $email == "" || $mobile == "" || $country == "" || $city == "" || $deliveryAddress == ""){
            $msg = "Please fill all inputs!";
        } else {
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
            if(!$cartItems){
                $msg = "Nothing in cart!";
            } else {
                $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
                $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
                $saleOrderObj = new SaleOrder();
                $saleOrderObj->numItemsSold = count($cartItems);
                $saleOrderObj->status = 'pending';
                $saleOrderObj->customerId = $_SESSION['user']->id;
                $saleOrderObj->deliveryAddress = $deliveryAddress;

                $insertSaleOrder = $saleOrderMySqlExtDAO->insert($saleOrderObj);

                if($insertSaleOrder){
                    $c=0;
                    foreach($cartItems as $row){
                        $saleOrderItemObj = new SaleOrderItem();
                        $saleOrderItemObj->saleOrderId = $insertSaleOrder;
                        $saleOrderItemObj->itemId = $row->id;
                        $saleOrderItemObj->qty = $row->cartQty;
                        $saleOrderItemObj->price = ProductController::getFinalPrice($row->regularPrice, $row->salePrice, true);
                        $insertSaleOrderItem = $saleOrderItemMySqlExtDAO->insert($saleOrderItemObj);
                        if($insertSaleOrderItem){
                            $c++;
                        }
                        if(count($cartItems) == $c){
                            $cartMySqlExtDAO = new CartMySqlExtDAO();
                            $delete = $cartMySqlExtDAO->deleteByUserId($_SESSION['user']->id);
                            $_SESSION['user']->cart = [];
                            $msg = "Order Success";
                            $redirectUrl = MAIN_URL.'order-result?res=success';
                            $result = true;
                        }
                    }
                }
            }
        }        
        // if($cartItems){
        //     $userMySqlExtDAO = new UserMySqlExtDAO();
        //     $userInfo = $userMySqlExtDAO->load($_SESSION['user']->id);
        // }

        //$emailBody = MailController::getEmailHtmlTemplate("test");
        // $to = "";
        // $subject = "";
        // $send = MailController::sendMail($to, $subject, $emailBody);
        // $success = true;
        // if($result){
        //     header('Location: '.MAIN_URL.'order-result?res=success');
        //     exit();
        // } else{
        //     header('Location: '.MAIN_URL.'order-result?res=fail');
        //     exit();
        // }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);

        print_r($response);
        return $this->response;
    }

    public function orderResultAction(){
        self::checkCustomerLoggedIn();
        // $textArray = [
        //     'Hi There,',
        //     '',
        //     'Thank you for your order!',
        //     'We have received your order',
        // ];
        // $emailBody = MailController::getEmailHtmlTemplate('Order Complete', $textArray);
        // $emailBody = MailController::getOrderCompleteEmail();
        // echo $emailBody;die();
        return new ViewModel();
    }

    public function loginRequiredAction(){
        return new ViewModel();
    }

    public static function checkCustomerLoggedIn(){
        $redirectUrl = urlencode(HelperController::getCurrentUrl());
        $url = MAIN_URL.'login-required?redirectUrl='.$redirectUrl;
        if(!isset($_SESSION['user']) || $_SESSION['user']->userType != UserController::$CUSTOMER){
            header('Location: '.$url);
            exit();
        }
    }
    public static function checkVendorLoggedIn(){
        $redirectUrl = urlencode(HelperController::getCurrentUrl());
        $url = MAIN_URL.'login-required?redirectUrl='.$redirectUrl;
        if(!isset($_SESSION['user']) || $_SESSION['user']->userType != UserController::$SUPPLIER){
            header('Location: '.$url);
            exit();
        }
    }
}
