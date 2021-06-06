<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use stdClass;

class DesignController extends AbstractActionController
{
    public static function mainTitle(string $title)
    {
        $html = "<div class='main-title centered'>$title</div>";
        return $html;
    }
    public static function secondaryTitle(string $title)
    {
        $html = "<div class='secondary-title'>$title</div>";
        return $html;
    }
    public static function item(object $item)
    {
        $customerId = $_SESSION['user']->id;
        $price = ProductController::getFinalPrice($item->regularPrice, $item->salePrice);
        if ($price != "n/a") {
            $price .= " LBP";
        }
        $image = ($item->image != "" && $item->image != null) ? HelperController::getImageUrl($item->image) : PRODUCT_PLACEHOLDER_IMAGE_URL;
        $url = MAIN_URL . 'product/' . $item->slug;

        $imageSrc = "img/heart-off.png";
        if (isset($_SESSION['user'])) {
            $imageSrc = (in_array($item->id, $_SESSION['user']->wishlist)) ? "img/heart-on.png" : "img/heart-off.png";
        }

        $html = "<div class='item-wrapper'>
                    <div class='item-wrapper_img'>
                        <a href='$url'>
                            <img class='' src='$image' />
                        </a>
                    </div>
                    <div class='item-wrapper_title'>
                        <a href='$url'>
                        $item->title
                        </a>
                    </div>
                    <div class='item-wrapper_price'>
                        $price
                    </div>
                    <div class='item-wrapper_cart_heart'>
                        <a class='heart wishlist-add off' href='#' data-item-id='$item->id' data-customer-id='$customerId'>
                            <img src='$imageSrc' />
                        </a>
                        <a class='cart cart-add' href='javascript:void(0);' data-item-id='$item->id'>
                            <img src='img/cart.png' />
                        </a>
                    </div>
                </div>";
        return $html;
    }

    public static function orderItem($status, $label, $orderId)
    {
        $html =  "<div class='order-item'>
                    <div class='row'>
                        <div class='col-md-9'>
                            <div class='order-id'>ORDER #$orderId<span><a href='#'>VIEW ORDER</a></span></div>
                            <div class='items-wrap'>
                                <div class='item'>
                                    Taurus professional hair clipper, titanium blades,6W X 1
                                </div>
                            </div>
                            <div class='item-order-details line1'>
                                Customer: Samer Merhby | Date: Apr 6, 2021 | 7:05:27 PM
                            </div>
                            <div class='item-order-details line2'>
                                Product Price: LBP 280,008 | Total Amount: LBP 280,008 | Commission: LBP 70,002
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='final-amount-label'>Final Amount</div>
                            <div class='final-amount'>LBP 210,000</div>
                            <div class='order-status $status'>$label</div>
                        </div>
                    </div>
                </div>";
        return $html;
    }

    public static function getVendorSidebar($activePage = 'dashboard')
    {
        $dashboardActive = ($activePage == "dashboard") ? "active" : "";
        $productsActive = ($activePage == "products") ? "active" : "";
        $inventoryActive = ($activePage == "inventory") ? "active" : "";
        $ordersActive = ($activePage == "orders") ? "active" : "";
        $warehouseActive = ($activePage == "warehouse") ? "active" : "";
        $contactDetailsActive = ($activePage == "contact") ? "active" : "";
        $accountDetailsActive = ($activePage == "account") ? "active" : "";
        $dashboardUrl = MAIN_URL . 'vendor/my-dashboard';
        $productsUrl = MAIN_URL . 'vendor/my-products';
        $inventoryUrl = MAIN_URL . 'vendor/inventory';
        $ordersUrl = MAIN_URL . 'vendor/my-orders';
        $warehouseUrl = MAIN_URL . 'vendor/warehouse';
        $contacturl = MAIN_URL . 'vendor/contact';
        $accountUrl = MAIN_URL . 'vendor/account';
        return "<ul class='nav flex-column'>
                    <li class='nav-item'>
                        <a class='nav-link $dashboardActive' href='$dashboardUrl'>My Dashboard</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $productsActive' href='$productsUrl'>My Products</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $inventoryActive' href='$inventoryUrl'>Update Inventory</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $ordersActive' href='$ordersUrl'>My Orders</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $warehouseActive' href='$warehouseUrl'>Warehouse Details</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $contactDetailsActive' href='$contacturl'>Contact Details</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link $accountDetailsActive' href='$accountUrl'>Account Details</a>
                    </li>
                </ul>";
    }

    public static function cartItem($item)
    {
        $customerId = $_SESSION['user']->id;
        $price = ProductController::getFinalPrice($item->regularPrice, $item->salePrice);
        $rawPrice = ProductController::getFinalPrice($item->regularPrice, $item->salePrice, true);
        $subtotalRaw = $rawPrice * $item->cartQty;
        $subtotal = number_format($subtotalRaw) . " LBP";
        if ($price != "n/a") {
            $price .= " LBP";
        }
        $image = ($item->image != "" && $item->image != null) ? HelperController::getImageUrl($item->image) : PRODUCT_PLACEHOLDER_IMAGE_URL;
        //$url = MAIN_URL . 'product/' . $item->slug;
        $title = $item->title;
        //print_r($item);

        $html = "<tr id='cart-item-$item->id'>
                    <td>
                        <div class=\"img-wrap\"><img src=\"$image\" class=\"img-thumbnail img-sm\"></div>
                    </td>
                    <td> <h6 class=\"title text-truncate\">$title</h6></td>
                    <td><b>$price</b></td>
                    <td class='cart-qty'>
                        <span class='cart-qty-span'><input class='form-control' min='1' type='number' value=\"$item->cartQty\"/></span>
                        <span class='cart-update-wrap'>
                            <a href='javascript:void(0);' data-item-id='$item->id' class='cart-update btn btn-outline-success btn-round'>
                                <i class='far fa-save'></i>
                            </a>
                        </span>
                    </td>
                    <td>
                        <b class='item-subtotal'>$subtotal</b>
                    </td>
                    <td class=\"text-right\">
                        <a href=\"javasript:void(0);\" data-item-id='$item->id' class=\"cart-delete btn btn-outline-danger btn-round\"><i class='fas fa-trash-alt'></i></a>
                    </td>
                </tr>";

                $obj = new stdClass();
                $obj->html = $html;
                $obj->subtotal = $subtotalRaw;
                return $obj;
    }
}
