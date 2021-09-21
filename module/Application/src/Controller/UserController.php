<?php

declare(strict_types=1);

namespace Application\Controller;

use Cart;
use CartMySqlExtDAO;
use CityMySqlExtDAO;
use DateTime;
use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
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
        }

        $this->setUserSession($user);
        return $user;
    }

    public function getUserInfoByEmail(string $email)
    {
        $userMySqlExtDAO = new UserMySqlExtDAO();
        return $userMySqlExtDAO->getUserByEmailAndType($email, UserController::$CUSTOMER);
    }

    public function getVendorInfoByEmail(string $email)
    {
        $userMySqlExtDAO = new UserMySqlExtDAO();
        return $userMySqlExtDAO->getUserByEmailAndType($email, UserController::$SUPPLIER);
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
        $obj->country = $user->country;

        $_SESSION['user'] = $obj;
    }

    public function logoutAction()
    {
        session_destroy();
        header('Location: ' . MAIN_URL);
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
        print_r($response);
        return $this->response;
    }

    public function submitLoginAction()
    {
        $result = false;
        $msg = "Wrong email or password!";
        $redirectUrl = MAIN_URL;

        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));

        if ($email == "" || $password == "") {
            $msg = "Please fill all inputs";
        } else {
            $userExists = $this->getUserInfoByEmail($email);
            if ($userExists) {
                $user = $userExists;
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
        print_r($response);
        return $this->response;
    }

    public function submitVendorLoginAction()
    {
        $result = false;
        $msg = "Wrong email or password!";
        $redirectUrl = MAIN_URL;

        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $redirectUrl = HelperController::filterInput($this->getRequest()->getPost('redirectUrl'));

        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']->userType == UserController::$CUSTOMER) {
                $msg = "You are logged in as a customer, please sign out first";
            }
        } elseif ($email == "" || $password == "") {
            $msg = "Please fill all inputs";
        } else {
            $userExists = $this->getVendorInfoByEmail($email);
            if ($userExists) {
                $user = $userExists;
                if ($user && password_verify($password, $user->password)) {
                    $this->setUserSession($user);
                    $result = true;
                    $msg = "successfully logged in...";
                    $redirectUrl = MAIN_URL . 'vendor/my-dashboard';
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);
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
        if (isset($userInfo->userType)) {
            $userObj->userType = $userInfo->userType;
        }
        if (isset($userInfo->dob)) {
            $userObj->dob = $userInfo->dob;
        }
        if (isset($userInfo->password)) {
            $userObj->password = $userInfo->password;
        }
        if (isset($userInfo->mobile)) {
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
        $langId =  LanguageController::setLanguage($this);
        $saleOrders = self::getOrders();
        $cityMySqlExtDAO = new CityMySqlExtDAO();
        $cities = $cityMySqlExtDAO->queryAllOrderBy('city ASC');
        $userMysqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMysqlExtDAO->load($_SESSION['user']->id);
        return new ViewModel([
            'cities' => $cities,
            'userInfo' => $userInfo,
            'saleOrdersCount' => count($saleOrders),
        ]);
    }
    public function myWishlistAction()
    {
        self::checkCustomerLoggedIn();
        $langId =  LanguageController::setLanguage($this);
        $saleOrders = self::getOrders();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $wishlist = [];
        if (count($_SESSION['user']->wishlist)) {
            $list = implode(',', $_SESSION['user']->wishlist);
            $cond = "b.`id` IN ($list)";
            $wishlist = $itemMySqlExtDAO->select($cond);
        }
        return new ViewModel([
            'wishlist' => $wishlist,
            'saleOrdersCount' => count($saleOrders),
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
            'count' => count($_SESSION['user']->wishlist),
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
            $cartCount = count($_SESSION['user']->cart);
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
            $result = true;
            $msg = "Added to cart";
        }

        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'count' => $cartCount,
            'items' => DesignController::compactCartItems($cartItems),
        ]);
        print_r($response);
        return $this->response;
    }

    //getShippingPrice
    public function getShippingPriceAction()
    {
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $productsTotal = HelperController::filterInput($this->getRequest()->getPost('productsTotal'));
        $shipping = 0;
        if ($city == "Beirut") {
            $shipping = OptionsController::getOption(OptionsController::$SHIPPING_INSIDE_BEIRUT);
        } else {
            $shipping = OptionsController::getOption(OptionsController::$SHIPPING_OUTSIDE_BEIRUT);
        }
        $shippingLabel = number_format(floatval($shipping)) . " " . _t('lbp');
        $total = number_format(floatval($productsTotal) + floatval($shipping)) . " " . _t('lbp');
        $response = json_encode([
            'shipping' => $shipping,
            'label' => $shippingLabel,
            'total' => $total,
        ]);
        print_r($response);
        return $this->response;
    }

    public function getCheckoutItemsAction()
    {
        self::checkCustomerLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
        $html = "<table class=\"table shopping-cart-wrap checkout-wrap\">
                    <thead class=\"text-muted\">
                        <tr>
                            <th scope=\"col\">Name</th>
                            <th scope=\"col\" class=\"text-right\">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>";
        $total = 0;
        foreach ($cartItems as $item) {
            $item = DesignController::checkOutItem($item);
            $total += $item->subtotal;
            $html .= $item->html;
        }
        $html .= "</tbody>
                    <tfoot>
                    <tr>
                        <td class=\"text-right cart-total\">Delivery</td>
                        <td class=\"text-right\" id=\"shipping-total\">Select City</td>
                    </tr>
                    <tr>
                        <td class=\"text-right cart-total\">Total</td>
                        <td class=\"text-right\" id=\"cart-total\">";
        $html .= number_format($total) . " " . _t('lbp');
        $html .= "</td>
                </tr>
            </tfoot>
        </table>";
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
            'total' => number_format($total) . " ". _t('lbp'),
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
                $rawPrice = ProductController::getFinalPrice($item->regularPrice * $item->usdExchangeRate, $item->salePrice * $item->usdExchangeRate, true);
                $subtotalRaw = $rawPrice * $item->cartQty;
                $total += $subtotalRaw;
                if ($item->id == $itemId) {
                    $subtotal = number_format($subtotalRaw) . " ". _t('lbp');
                }
            }
            $result = true;
            $msg = "Qty Updated";
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'total' => number_format($total) . " ". _t('lbp'),
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

    public function myOrdersAction()
    {
        self::checkCustomerLoggedIn();
        $langId =  LanguageController::setLanguage($this);
        $fromDate = $toDate = false;
        $status = (isset($_GET['status']) && !empty($_GET['status'])) ? HelperController::filterInput($_GET['status']) : false;
        $date = (isset($_GET['date']) && !empty($_GET['date'])) ? HelperController::filterInput($_GET['date']) : false;

        if ($date) {
            $dateArr = explode(' - ', $date);
            $fromDate = DateTime::createFromFormat('d-m-Y', $dateArr[0]);
            $fromDate = $fromDate->format('Y-m-d 00:00:01');
            $toDate = DateTime::createFromFormat('d-m-Y', $dateArr[1]);
            $toDate = $toDate->format('Y-m-d 23:59:59');
        }

        $saleOrders = self::getOrders($fromDate, $toDate, $status);
        return new ViewModel([
            'saleOrders' => $saleOrders,
            'status' => $status,
        ]);
    }

    public function checkoutAction()
    {
        self::checkCustomerLoggedIn();
        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $singleItemId = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : false;
        if ($singleItemId) {
            $cartItems = $itemMySqlExtDAO->getSinglesCheckoutItem($singleItemId);
        } else {
            $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
        }
        if (count($cartItems) <= 0) {
            header('Location: ' . MAIN_URL . 'my-cart');
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
            'singleItemId' => $singleItemId,
        ]);
    }

    public function updateUserAction()
    {
        $result = false;
        $msg = "Nothing changed";

        $firstName = HelperController::filterInput($this->getRequest()->getPost('first-name'));
        $lastName = HelperController::filterInput($this->getRequest()->getPost('last-name'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $tel1 = HelperController::filterInput($this->getRequest()->getPost('tel1'));
        $tel2 = HelperController::filterInput($this->getRequest()->getPost('tel2'));
        $country = HelperController::filterInput($this->getRequest()->getPost('country'));
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $address = HelperController::filterInput($this->getRequest()->getPost('address'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $confirmPassword = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));

        $checkPassword = false;
        if ($password != "") {
            $checkPassword = true;
        }
        $passwordStrength = HelperController::passwordStrength($password);

        if ($firstName == "" || $lastName == "" || $mobile == "" || $country == "" || $city == "" || $address == "") {
            $msg = "Please fill all inputs";
        } elseif ($password != "" && $password != $confirmPassword) {
            $msg = "Passwords do not match";
        } elseif ($checkPassword && $passwordStrength->status == false) {
            $msg = $passwordStrength->msg;
        } else {
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

    public function vendorContactUpdateAction()
    {
        $result = false;
        $msg = "Nothing changed";

        $firstName = HelperController::filterInput($this->getRequest()->getPost('first-name'));
        $lastName = HelperController::filterInput($this->getRequest()->getPost('last-name'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $tel1 = HelperController::filterInput($this->getRequest()->getPost('tel1'));
        $country = HelperController::filterInput($this->getRequest()->getPost('country'));
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $address1 = HelperController::filterInput($this->getRequest()->getPost('address-1'));
        $address2 = HelperController::filterInput($this->getRequest()->getPost('address-2'));
        $password = HelperController::filterInput($this->getRequest()->getPost('password'));
        $confirmPassword = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));
        $companyName = HelperController::filterInput($this->getRequest()->getPost('company-name'));
        $usdExchangeRate = HelperController::filterInput($this->getRequest()->getPost('usd-exchange-rate'));

        $checkPassword = false;
        if ($password != "") {
            $checkPassword = true;
        }
        $passwordStrength = HelperController::passwordStrength($password);

        if (
            $firstName == "" ||
            $lastName == "" ||
            $mobile == "" ||
            $country == "" ||
            $city == "" ||
            $address1 == "" ||
            $companyName == "" ||
            $usdExchangeRate == 0 ||
            $usdExchangeRate == ""
        ) {
            $msg = "Please fill all inputs";
        } elseif ($password != "" && $password != $confirmPassword) {
            $msg = "Passwords do not match";
        } elseif ($checkPassword && $passwordStrength->status == false) {
            $msg = $passwordStrength->msg;
        } else {
            $userMySqlExtDAO = new UserMySqlExtDAO();
            $userInfo = $userMySqlExtDAO->load($_SESSION['user']->id);

            $userInfo->companyName = $companyName;
            $userInfo->firstName = $firstName;
            $userInfo->lastName = $lastName;
            $userInfo->fullName = $firstName . " " . $lastName;
            $userInfo->mobile = $mobile;
            $userInfo->tel1 = $tel1;
            $userInfo->country = $country;
            $userInfo->city = $city;
            $userInfo->address1 = $address1;
            $userInfo->address2 = $address2;
            $userInfo->usdExchangeRate = $usdExchangeRate;
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

    public function orderCompleteAction()
    {
        self::checkCustomerLoggedIn();
        $result = false;
        $msg = "Error";
        $redirectUrl = MAIN_URL . 'order-result?res=fail';
        $availablePayments = [
            PaymentController::$PAYMENT_CASH_ON_DELIVERY,
            PaymentController::$PAYMENT_ONLINE,
        ];

        $fullName = HelperController::filterInput($this->getRequest()->getPost('full-name'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));
        $mobile = HelperController::filterInput($this->getRequest()->getPost('mobile'));
        $country = HelperController::filterInput($this->getRequest()->getPost('country'));
        $city = HelperController::filterInput($this->getRequest()->getPost('city'));
        $deliveryAddress = HelperController::filterInput($this->getRequest()->getPost('delivery-address'));
        $notes = HelperController::filterInput($this->getRequest()->getPost('notes'));
        $paymentMethod = HelperController::filterInput($this->getRequest()->getPost('payment-method'));
        $isSingleItemCheckout = HelperController::filterInput($this->getRequest()->getPost('is_single_item_checkout'));
        $singleItemId = HelperController::filterInput($this->getRequest()->getPost('single_item_id'));

        if ($fullName == "" || $email == "" || $mobile == "" || $country == "" || $city == "" || $deliveryAddress == "") {
            $msg = "Please fill all inputs!";
        } elseif (!in_array($paymentMethod, $availablePayments)) {
            $msg = "Invalid payment method!";
        } else {
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            if ($isSingleItemCheckout) {
                $cartItems = $itemMySqlExtDAO->getSinglesCheckoutItem($singleItemId);
            } else {
                $cartItems = $itemMySqlExtDAO->getCartItemsByUserId($_SESSION['user']->id);
            }
            if (!$cartItems && !$isSingleItemCheckout) {
                $msg = "Nothing in cart!";
            } else {
                $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
                $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
                $saleOrderObj = new SaleOrder();
                $saleOrderObj->numItemsSold = count($cartItems);
                $saleOrderObj->status = PaymentController::$PENDING;
                $saleOrderObj->customerId = $_SESSION['user']->id;
                $saleOrderObj->note = $notes;
                $saleOrderObj->deliveryAddress = $deliveryAddress;
                $saleOrderObj->paymentType = $paymentMethod;
                $saleOrderObj->createdAt = date('Y-m-d H:i:s');
                $saleOrderObj->updatedAt = date('Y-m-d H:i:s');
                $saleOrderObj->createdAtGmt = gmdate('Y-m-d H:i:s');

                $insertSaleOrder = $saleOrderMySqlExtDAO->insert($saleOrderObj);

                if ($insertSaleOrder) {
                    $saleOrder = $saleOrderMySqlExtDAO->load($insertSaleOrder);
                    $saleOrder->reference = $insertSaleOrder . "-" . HelperController::randomNumber(15);
                    $saleOrderMySqlExtDAO->update($saleOrder);
                    $c = 0;
                    $total = 0;
                    foreach ($cartItems as $row) {
                        $itemInfo = $itemMySqlExtDAO->loadItem($row->id);
                        $total += $row->cartQty * ProductController::getFinalPrice($row->regularPrice * $row->usdExchangeRate, $row->salePrice * $row->usdExchangeRate, true);
                        $saleOrderItemObj = new SaleOrderItem();
                        $saleOrderItemObj->saleOrderId = $insertSaleOrder;
                        $saleOrderItemObj->itemId = $row->id;
                        $saleOrderItemObj->qty = $row->cartQty;
                        $saleOrderItemObj->price = ProductController::getFinalPrice($row->regularPrice * $row->usdExchangeRate, $row->salePrice * $row->usdExchangeRate, true);
                        $saleOrderItemObj->commission = $row->cartQty * $saleOrderItemObj->price * ($itemInfo->companyCommission / 100);
                        $insertSaleOrderItem = $saleOrderItemMySqlExtDAO->insert($saleOrderItemObj);
                        if ($insertSaleOrderItem) {
                            $c++;
                        }
                    }

                    if (count($cartItems) == $c) {
                        $saleOrder = $saleOrderMySqlExtDAO->load($insertSaleOrder);
                        $shipping = 0;
                        if ($city == "Beirut") {
                            $shipping = OptionsController::getOption(OptionsController::$SHIPPING_INSIDE_BEIRUT);
                        } else {
                            $shipping = OptionsController::getOption(OptionsController::$SHIPPING_OUTSIDE_BEIRUT);
                        }
                        $netTotal = floatval($total) + floatval($shipping);
                        $saleOrder->netTotal = $netTotal;
                        $saleOrder->shippingTotal = floatval($shipping);
                        $saleOrder->totalSales = floatval($total);
                        $saleOrderMySqlExtDAO->update($saleOrder);
                        $msg = "Order Success";
                        if ($paymentMethod == PaymentController::$PAYMENT_CASH_ON_DELIVERY) {
                            $redirectUrl = MAIN_URL . 'order-result?orderId=' . $insertSaleOrder . "&payment=" . PaymentController::$PAYMENT_CASH_ON_DELIVERY . "&single_item_checkout=" . $isSingleItemCheckout;
                        } elseif ($paymentMethod == PaymentController::$PAYMENT_ONLINE) {
                            $redirectUrl = MAIN_URL . 'pay?orderId=' . $insertSaleOrder . "&amount=" . $netTotal . "&single_item_checkout=" . $isSingleItemCheckout;
                        }

                        $result = true;
                    }
                }
            }
        }
        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
            'redirectUrl' => $redirectUrl,
        ]);

        print_r($response);
        return $this->response;
    }

    public function orderResultAction()
    {
        self::checkCustomerLoggedIn();
        $success = false;
        $isCashOnDelivery = false;
        $orderId = isset($_GET['orderId']) ? $_GET['orderId'] : "";
        $successIndicator = isset($_GET['resultIndicator']) ? $_GET['resultIndicator'] : "";
        //single_item_checkout
        $isSingleItemCheckout = isset($_GET['single_item_checkout']) ? $_GET['single_item_checkout'] : false;
        if (isset($_GET['payment'])) {
            if ($_GET['payment'] == PaymentController::$PAYMENT_CASH_ON_DELIVERY) {
                $isCashOnDelivery = true;
            }
        }
        $saleOrdermySqlExtDAO = new SaleOrderMySqlExtDAO();
        $orderInfo = $saleOrdermySqlExtDAO->load($orderId);
        $success = true;

        if (!$isSingleItemCheckout) {
            $cartMySqlExtDAO = new CartMySqlExtDAO();
            $cartMySqlExtDAO->deleteByUserId($_SESSION['user']->id);
            $_SESSION['user']->cart = [];
        }

        if ($isCashOnDelivery) {
        } else {
            $paymentStatus = $orderInfo->successIndicator == $successIndicator ? PaymentController::$PAID : PaymentController::$FAILED;
            UserController::UpdateOrderStatus($orderId, $paymentStatus);
        }
        $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
        $saleOrderItems  = $saleOrderItemMySqlExtDAO->getSaleOrderItems($orderId);

        // Semd client Email
        $linesArr1 = [
            'Hi ' . $_SESSION['user']->fullName . ',',
            'Your order has been received and is now being processed. Your order details are shown below for your reference.',
            '&nbsp;',
            '<b>Order Id: </b> #' . $orderInfo->id,
            '<b>Payment Type: </b> ' . ucfirst(str_replace('-', " ", $orderInfo->paymentType)),
        ];
        $linesArr2 = [
            'Happy Shopping,',
            'Mastershop'
        ];
        $emailBody = EcommerceMailController::getClientEmailBody($linesArr1, $linesArr2, $saleOrderItems, $orderInfo);
        $toClient = $_SESSION['user']->email;
        $subject = "Mastershop: Order Info";
        MailController::sendMail($toClient, $subject, $emailBody);

        //Semd Admin Email
        $adminEmailBody = EcommerceMailController::getAdminEmailBody($saleOrderItems, $orderInfo);
        $toAdmin = OptionsController::getOption(OptionsController::$ECOMMERCE_MANAGER_EMAIL_ADDRESS);
        MailController::sendMail($toAdmin, 'Mastershop: New Order', $adminEmailBody);

        // Send Suppliers Emails
        $orderSuppliers = array_map(function ($o) {
            return $o->supplierId;
        }, $saleOrderItems);
        $userMySqlExtDAO = new UserMySqlExtDAO();
        foreach ($orderSuppliers as $row) {
            $supplierSaleOrderItems  = $saleOrderItemMySqlExtDAO->getSupplierSaleOrderItems($orderId, $row);
            $supplierEmailBody = EcommerceMailController::getSupplierEmailBody($supplierSaleOrderItems, $orderInfo);
            $supplierInfo = $userMySqlExtDAO->load($row);
            $toSupplier = $supplierInfo->email;
            MailController::sendMail($toSupplier, 'Mastershop: New Order', $supplierEmailBody);
        }

        return new ViewModel([
            'success' => $success,
        ]);
    }

    public function loginRequiredAction()
    {
        return new ViewModel();
    }

    public static function checkCustomerLoggedIn()
    {
        $redirectUrl = urlencode(HelperController::getCurrentUrl());
        $url = MAIN_URL . 'login-required?redirectUrl=' . $redirectUrl;
        if (!isset($_SESSION['user']) || $_SESSION['user']->userType != UserController::$CUSTOMER) {
            header('Location: ' . $url);
            exit();
        }
    }
    public static function checkVendorLoggedIn()
    {
        $redirectUrl = urlencode(HelperController::getCurrentUrl());
        $url = MAIN_URL . 'login-required?redirectUrl=' . $redirectUrl;
        if (!isset($_SESSION['user']) || $_SESSION['user']->userType != UserController::$SUPPLIER) {
            header('Location: ' . $url);
            exit();
        }
    }

    public function vendorLoginAction()
    {
        $langId =  LanguageController::setLanguage($this);
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']->userType == UserController::$SUPPLIER) {
                header('Location: ' . MAIN_URL . 'vendor/my-dashboard');
                exit();
            }
        }
        return new ViewModel();
    }
    public function forgotPasswordAction()
    {
        $userType = HelperController::filterInput($this->params('userType'));
        return new ViewModel([
            'userType' => $userType,
        ]);
    }

    public function forgotPasswordSubmitAction()
    {
        $result = false;
        $msg = "Error";

        $userType = HelperController::filterInput($this->params('userType'));
        $email = HelperController::filterInput($this->getRequest()->getPost('email'));

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $userInfo = $userMySqlExtDAO->getUserByEmailAndType($email, $userType);

        if ($userInfo) {
            $rand = HelperController::random(150);
            $userInfo->activationCode = $rand;

            $update = $userMySqlExtDAO->update($userInfo);
            if ($update) {
                $to = $userInfo->email;
                $subject = "Mastershop: Reset Password";

                $resetLink = MAIN_URL . 'reset-password/' . $userType . '?activationCode=' . $rand;
                $emailBody = MailController::getPasswordResetEmailBody($userInfo->fullName, $resetLink);
                $sendEmail = MailController::sendMail($to, $subject, $emailBody);
                $sendEmail = true;
                if ($sendEmail) {
                    $result = true;
                    $msg = "Please check your email for reset link";
                    error_log($resetLink, 0);
                }
            }
        } else {
            $result = false;
            $msg = "This user does not exist";
        }

        $response = json_encode([
            'status' => $result,
            'msg' => $msg,
        ]);

        print_r($response);
        return $this->response;
    }
    public function resetPasswordAction()
    {
        $userType = HelperController::filterInput($this->params('userType'));
        if (isset($_POST) && !empty($_POST)) {
            $result = false;
            $msg = "Error";

            $activationCode = HelperController::filterInput($this->getRequest()->getPost('activationCode'));
            $pass = HelperController::filterInput($this->getRequest()->getPost('password'));
            $confirmPass = HelperController::filterInput($this->getRequest()->getPost('confirm-password'));

            $userMySqlExtDAO = new UserMySqlExtDAO();
            $userInfo = $userMySqlExtDAO->getUserByActivationCodeAndType($activationCode, $userType);

            $checkPassword = false;
            if ($pass != "") {
                $checkPassword = true;
            }
            $passwordStrength = HelperController::passwordStrength($pass);

            if ($pass == "" || $confirmPass == "") {
                $msg = "Please fill all inputs";
            } elseif ($pass != "" && $pass != $confirmPass) {
                $msg = "Passwords do not match";
            } elseif ($checkPassword && $passwordStrength->status == false) {
                $msg = $passwordStrength->msg;
            } else {
                $userInfo->password = password_hash($pass, PASSWORD_DEFAULT);
                $userInfo->activationCode = "";
                $userInfo->updatedAt = date('Y-m-d H:i:s');
                $update = $userMySqlExtDAO->update($userInfo);
                if ($update) {
                    $this->setUserSession($userInfo);
                    $result = true;
                    $msg = "Password updated";
                }
            }

            $response = json_encode([
                'status' => $result,
                'msg' => $msg,
            ]);

            print_r($response);
            return $this->response;
        } else {
            return new ViewModel([
                'userType' => $userType,
            ]);
        }
    }
    public function orderDetailsAction()
    {
        $id = HelperController::filterInput($this->params('id'));
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
        $saleOrder = $saleOrderMySqlExtDAO->load($id);
        $saleOrderItems  = $saleOrderItemMySqlExtDAO->getSaleOrderItems($id);
        $data = [
            'saleOrder' => $saleOrder,
            'items' => $saleOrderItems,
        ];
        return new ViewModel($data);
    }

    public static function getOrders($fromDate = false, $toDate = false, $status = false)
    {
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        return $saleOrderMySqlExtDAO->getOrders($_SESSION['user']->id, $fromDate, $toDate, $status);
    }

    public function payAction()
    {
        $orderId = HelperController::filterInput($_GET['orderId']);
        $amount = HelperController::filterInput($_GET['amount']);
        $isSingleItemCheckout = HelperController::filterInput($_GET['single_item_checkout']);

        $mpgs = new MPGSController(MPGS_CONFIG);
        $mpgs->SetOrderId(HelperController::random(10));
        $mpgs->SetOrderAmount($amount);
        $mpgs->SetReturnUrl(MAIN_URL . 'order-result?orderId=' . $orderId . '&single_item_checkout=' . $isSingleItemCheckout);
        $response = $mpgs->createCheckoutSession();

        if ($response['result'] != 'SUCCESS') {
            header('Location: ' . MAIN_URL . 'payment-error');
            exit();
        }

        UserController::addOrderSuccessIndicator($orderId, $response['successIndicator']);

        return new ViewModel([
            'sessionId' => $response['session_id'],
            'merchant' => $response['merchant'],
            'orderId' => $orderId,
            'amount' => $amount,
        ]);
    }

    public function payErrorAction()
    {
        return new ViewModel();
    }

    public static function UpdateOrderStatus($id, $status)
    {
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $order = $saleOrderMySqlExtDAO->load($id);
        $order->status = $status;
        $order->updatedAt = date('Y-m-d H:i:s');
        return $saleOrderMySqlExtDAO->update($order);
    }
    public static function addOrderSuccessIndicator($id, $successIndicator)
    {
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $order = $saleOrderMySqlExtDAO->load($id);
        $order->successIndicator = $successIndicator;
        $order->updatedAt = date('Y-m-d H:i:s');
        return $saleOrderMySqlExtDAO->update($order);
    }

    public function orderCancelAction()
    {
        self::checkCustomerLoggedIn();
        $orderId = (isset($_GET['order_id']) && !empty($_GET['order_id'])) ? HelperController::filterInput($_GET['order_id']) : false;
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $saleOrder = $saleOrderMySqlExtDAO->load($orderId);
        $saleOrder->status = PaymentController::$CANCELED;
        $update = $saleOrderMySqlExtDAO->update($saleOrder);
        if ($update) {
            header('Location: ' . MAIN_URL);
            exit();
        }
        return new ViewModel();
    }
    public function orderErrorAction()
    {
        self::checkCustomerLoggedIn();
        $orderId = (isset($_GET['order_id']) && !empty($_GET['order_id'])) ? HelperController::filterInput($_GET['order_id']) : false;
        $saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
        $saleOrder = $saleOrderMySqlExtDAO->load($orderId);
        $saleOrder->status = PaymentController::$FAILED;
        $update = $saleOrderMySqlExtDAO->update($saleOrder);
        if ($update) {
            header('Location: ' . MAIN_URL);
            exit();
        }
        return new ViewModel();
    }
}
