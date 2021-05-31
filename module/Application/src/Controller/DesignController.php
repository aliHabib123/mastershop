<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

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
    public static function item()
    {
        $html = "<div class='item-wrapper'>
                    <div class='item-wrapper_img'>
                        <a href='#'>
                            <img src='img/product.png' />
                        </a>
                    </div>
                    <div class='item-wrapper_title'>
                        <a href='#'>
                        Tefal Fondue Inox & Design
                        </a>
                    </div>
                    <div class='item-wrapper_price'>
                        1,290,000 LBP
                    </div>
                    <div class='item-wrapper_cart_heart'>
                        <a class='heart off' href='#'>
                            <img src='img/heart-off.png' />
                        </a>
                        <a class='cart' href='#'>
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
        $dashboardActive = "";
        $productsActive = "";
        $inventoryActive = "";
        $ordersActive = "";
        $warehouseActive = "";
        $contactDetailsActive = "";
        $accountDetailsActive = "";
        $dashboardUrl = MAIN_URL . 'vendor/my-dashboard';
        $productsUrl = MAIN_URL . 'vendor/my-products';
        $inventoryUrl = MAIN_URL . 'vendor/inventory';
        $ordersUrl = MAIN_URL . 'vendor/my-orders';
        $warehouseUrl = MAIN_URL . 'vendor/warehouse';
        $contacturl = MAIN_URL . 'vendor/contact';
        $accountUrl = MAIN_URL . 'vendor/account';
        switch ($activePage) {
            case 'dashboard':
                $dashboardActive = 'active';
                break;
            case 'products':
                $productsActive = 'active';
                break;
            case 'inventory':
                $inventoryActive = 'active';
                break;
            case 'orders':
                $ordersActive = 'active';
                break;
            case 'warehouse':
                $warehouseActive = 'active';
                break;
            case 'contact':
                $contactDetailsActive = 'active';
                break;
            case 'account':
                $accountDetailsActive = 'active';
                break;
            default:
                $dashboardActive = 'active';
        }
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
}
