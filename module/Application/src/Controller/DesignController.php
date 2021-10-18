<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use SaleOrderItemMySqlExtDAO;
use stdClass;
use UserMySqlExtDAO;

class DesignController extends AbstractActionController
{
    public static function mainTitle(string $title)
    {
        $title = strtoupper($title);
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
        $lang = LanguageController::getLanguage();
        $hasDiscount = false;
        $customerId = 0;
        $itemTitle = $item->title;
        $inStock = $item->qty > 0 ? true : false;
        $itemTitle .= '-' . $item->type;
        if ($lang == LanguageController::$ARABIC) {
            if ($item->titleAr != "") {
                $itemTitle = $item->titleAr;
            }
        }
        if (isset($_SESSION['user'])) {
            $customerId = $_SESSION['user']->id;
        }
        $price = ProductController::getFinalPrice(floatval($item->regularPrice) * $item->usdExchangeRate, floatval($item->salePrice) * $item->usdExchangeRate);
        $rawPrice = ProductController::getFinalPrice(floatval($item->regularPrice) * $item->usdExchangeRate, floatval($item->salePrice) * $item->usdExchangeRate, true);
        if ($price != "n/a") {
            if ($item->salePrice) {
                $hasDiscount = true;
                $discount  = ceil(100 - (floatval($item->salePrice) / floatval($item->regularPrice) * 100));
            }
            $price .= " " . _t('lbp');
        }
        $image = ($item->image != "" && $item->image != null && file_exists(BASE_PATH . upload_image_dir . $item->image)) ? HelperController::getImageUrl($item->image) : PRODUCT_PLACEHOLDER_IMAGE_URL;
        $url = MAIN_URL . $lang . '/product/' . $item->slug;

        $imageSrc = "img/heart-off.png";
        if (isset($_SESSION['user'])) {
            $imageSrc = (in_array($item->id, $_SESSION['user']->wishlist)) ? "img/heart-on.png" : "img/heart-off.png";
        }



        $html = "<div class='item-wrapper' data-rate='$item->usdExchangeRate'>
                    <div class='item-wrapper_img'>";
        if ($inStock && $hasDiscount) {
            $html .= "<span class=\"badge\">$discount%</span>";
        }
        if (!$inStock) {
            $html .= "<span class=\"badge-out-of-stock\">Out of stock</span>";
        }
        $html .= "<a href='$url'>
                        <img class='' src='$image' />
                    </a>
                </div>
                <div class='item-wrapper_title'>
                    <a href='$url'>
                    $itemTitle
                    </a>
                </div>
                <div class='item-wrapper_price'>";
        if ($hasDiscount) {
            $html .= "<div class='main-price'>" . number_format(floatval($item->regularPrice) * $item->usdExchangeRate) . " " . _t('lbp') . "</div>";
        }

        $html .= "<div class='final-price'>
                        $price
                        </div>
                    </div>
                    <div class='item-wrapper_cart_heart'>
                        <a class='heart wishlist-add off' href='#' data-item-id='$item->id' data-customer-id='$customerId'>
                            <img class='visible-heart' src='$imageSrc' />
                            <img class='hidden-heart' src='img/heart-on.png' />
                        </a>";

        if ($inStock) {
            if ($item->type == ProductController::$TYPE_SIMPLE) {
                $html .= "<a class='cart cart-add' href='javascript:void(0);' data-item-id='$item->id'>";
            } else {
                $html .= "<a class='cart' href='$url' data-item-id='$item->id'>";
            }

            $html .= "<img class='visible-cart' src='img/cart.png' />
                        <img class='hidden-cart' src='img/cart-on.png' />
                    </a>";
        }

        $html .= "</div>
                </div>";
        return $html;
    }

    public static function orderItem($saleOrder)
    {
        $orderId = $saleOrder->id;
        $status = $saleOrder->status;
        $label = strtoupper(str_replace('-', ' ', $status));
        $date = date('M j, Y | H:i:g A', strtotime($saleOrder->createdAt));
        $url = MAIN_URL . "vendor/order/" . $orderId;

        $userMySqlExtDAO = new UserMySqlExtDAO();
        $customer = $userMySqlExtDAO->load($saleOrder->customerId);
        $customerFullName = $customer->fullName;
        $saleOrderItemsMySqlExtAO = new SaleOrderItemMySqlExtDAO();
        $items = $saleOrderItemsMySqlExtAO->itemsBySupplierIdAndSaleOrderId($orderId, $_SESSION['user']->id);
        $html =  "<div class='order-item'>
                    <div class='row'>
                        <div class='col-md-9'>
                            <div class='order-id'>ORDER #$orderId<span><a href='$url'>VIEW ORDER</a></span></div>
                            <div class='items-wrap'>";
        $total = 0;
        foreach ($items as $item) {
            $total += $item->qty * floatval($item->price);
            $title = $item->name;
            $qty = $item->qty;
            $html .= " <div class='item'>$title<b> X $qty</b></div>";
        }

        $totalLabel = _t('lbp') . " " . number_format($total);
        $comission = $total * 0.1;
        $comissionLabel = _t('lbp') . " " . number_format($comission);
        $finalAmount = _t('lbp') . " " . number_format($total - $comission);

        $html .= "</div>
                            <div class='item-order-details line1'>
                                Customer: $customerFullName | Date: $date
                            </div>
                            <div class='item-order-details line2'>
                                Product Price: $totalLabel | Total Amount: $totalLabel | Commission: $comissionLabel
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='final-amount-label'>Final Amount</div>
                            <div class='final-amount'>$finalAmount</div>
                            <div class='order-status $status'>$label</div>
                        </div>
                    </div>
                </div>";
        return $html;
    }

    public static function customerOrderItem($saleOrder, $saleOrderItems)
    {
        $status = $saleOrder->status;
        $label = strtoupper(str_replace('-', ' ', $status));
        $orderId = $saleOrder->id;
        $date = date('M j, Y | H:i:g A', strtotime($saleOrder->createdAt));
        $url = MAIN_URL . "order/" . $saleOrder->id;
        $currency = _t('lbp');
        $html =  "<div class='order-item'>
                    <div class='row'>
                        <div class='col-md-9'>
                            <div class='order-id'>ORDER #$orderId<span><a href='$url'>VIEW ORDER</a></span></div>
                            <div class='items-wrap'>";
        foreach ($saleOrderItems as $row) {
            if ($row->type == ProductController::$TYPE_VARIATION) {

                $itemMySqlExtDAO = new ItemMySqlExtDAO();
                $parentItem = $itemMySqlExtDAO->queryBySku($row->parentId);
                //print_r($parentItem[0]);
                $html .= "<div class='item'>";
                $html .= $parentItem[0]->title . " X " . $row->qty;
                $html .= "<span class=\"cart-variations\">";
                if ($row->color != "") {
                    $html .= "<div><b>Color: </b>" . $row->color . "</div>";
                }
                if ($row->size != "") {
                    $html .= "<div><b>Size: </b>" . $row->size . "</div>";
                }
                $html .= "</span>";
                $html .= "</div>";
            } else {
                $html .= "<div class='item'>
                            $row->name X $row->qty
                        </div>";
            }
        }
        $html .= "</div>
                            <div class='item-order-details line1'>
                                Date: $date
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='final-amount-label'>Final Amount</div>
                            <div class='final-amount'>$currency $saleOrder->netTotal</div>
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
                    
                </ul>";
        /**<li class='nav-item'>
                        <a class='nav-link $accountDetailsActive' href='$accountUrl'>Account Details</a>
                    </li> */
    }

    public static function cartItem($item)
    {
        $customerId = $_SESSION['user']->id;
        $price = ProductController::getFinalPrice(floatval($item->regularPrice) * $item->usdExchangeRate, floatval($item->salePrice) * $item->usdExchangeRate);
        $rawPrice = ProductController::getFinalPrice(floatval($item->regularPrice) * $item->usdExchangeRate, floatval($item->salePrice) * $item->usdExchangeRate, true);
        $subtotalRaw = $rawPrice * $item->cartQty;
        $subtotal = number_format($subtotalRaw) . " " . _t('lbp');
        if ($price != "n/a") {
            $price .= " " . _t('lbp');
        }
        $image = ($item->image != "" && $item->image != null) ? HelperController::getImageUrl($item->image) : PRODUCT_PLACEHOLDER_IMAGE_URL;
        //$url = MAIN_URL . 'product/' . $item->slug;
        $title = $item->title;
        //print_r($item);

        $html = "<tr id='cart-item-$item->id'>
                    <td>
                        <div class=\"img-wrap\"><img src=\"$image\" class=\"img-thumbnail img-sm\"></div>
                    </td>";
        if ($item->type == ProductController::$TYPE_VARIATION) {
            $itemMySqlExtDAO = new ItemMySqlExtDAO();
            $parentItem = $itemMySqlExtDAO->queryBySku($item->parentId);
            //print_r($item->parentId);
            $html .= "<td>";
            $html .= "<h6 class=\"title text-truncate\">";
            $html .= $parentItem[0]->title;
            $html .= "</h6>";
            $html .= "<span class=\"cart-variations\">";
            if ($item->color != "") {
                $html .= "<div><b>Color: </b>" . $item->color . "</div>";
            }
            if ($item->size != "") {
                $html .= "<div><b>Size: </b>" . $item->size . "</div>";
            }
            $html .= "</span>";
            $html .= "</td>";
        } else {
            $html .= "<td> <h6 class=\"title text-truncate\">$title</h6></td>";
        }

        $html .= "<td><b>$price</b></td>
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

    public static function checkOutItem($item)
    {
        $customerId = $_SESSION['user']->id;
        $price = ProductController::getFinalPrice($item->regularPrice * $item->usdExchangeRate, $item->salePrice * $item->usdExchangeRate);
        $rawPrice = ProductController::getFinalPrice($item->regularPrice * $item->usdExchangeRate, $item->salePrice * $item->usdExchangeRate, true);
        $subtotalRaw = $rawPrice * $item->cartQty;
        $subtotal = number_format($subtotalRaw) . " " . _t('lbp');
        if ($price != "n/a") {
            $price .= " " . _t('lbp');
        }
        $image = ($item->image != "" && $item->image != null) ? HelperController::getImageUrl($item->image) : PRODUCT_PLACEHOLDER_IMAGE_URL;
        //$url = MAIN_URL . 'product/' . $item->slug;
        $title = $item->title;
        //print_r($item);

        $itemMySqlExtDAO = new ItemMySqlExtDAO();
        $parentItem = $itemMySqlExtDAO->queryBySku($item->parentId);

        $html = "<tr id='cart-item-$item->id'>";
        if ($item->type == ProductController::$TYPE_VARIATION) {
            $html .= "<td>";
            $html .= "<h6 class=\"title text-truncate\">";
            $html .= $parentItem[0]->title;
            $html .= " <b>X $item->cartQty</b>";
            $html .= "</h6>";
            $html .= "<span class=\"cart-variations\">";
            if ($item->color != "") {
                $html .= "<div><b>Color: </b>" . $item->color . "</div>";
            }
            if ($item->size != "") {
                $html .= "<div><b>Size: </b>" . $item->size . "</div>";
            }
            $html .= "</span>";
            $html .= "</td>";
        } else {
            $html .= "<td> <h6 class=\"title text-truncate\">$title <b>X $item->cartQty</b></h6></td>";
        }
        $html .= "<td class='text-right'>
                        <b class='item-subtotal'>$subtotal</b>
                    </td>
                </tr>";

        $obj = new stdClass();
        $obj->html = $html;
        $obj->subtotal = $subtotalRaw;
        return $obj;
    }

    public static function compactCartItems($cartItems)
    {
        $lang = LanguageController::getLanguage();
        $html = "";
        if (count($cartItems) > 0) {
            $cartUrl =  MAIN_URL . $lang . '/my-cart';
            $checkoutUrl = MAIN_URL . $lang . '/checkout';
            $currency = _t('lbp');
            foreach ($cartItems as $row) {
                $cartItemImage = PRODUCT_PLACEHOLDER_THUMBNAIL_URL;
                if ($row->image != "" && @getimagesize(BASE_PATH . upload_image_dir . $row->image)) {
                    $cartItemImage = HelperController::getImageUrl($row->image);
                }
                $title = substr($row->title, 0, 500);
                $id = $row->id;
                $price = ProductController::getFinalPrice($row->regularPrice * $row->usdExchangeRate, $row->salePrice * $row->usdExchangeRate);
                $html .= "<div class=\"compact-cart-item\" id='product_$id'>
                            <div class=\"row\">
                                <div class=\"col-md-3 compact-cart-img\">
                                    <img src=\"$cartItemImage\" />
                                </div>
                                <div class=\"col-md-9\">
                                    <div class=\"compact-cart-title\">
                                        $title
                                    </div>
                                    <div class=\"compact-cart-price\">
                                        $price $currency
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
            $html .= "<div class=\"compact-cart-buttons\">
            <a href=\"$cartUrl\" class=\"to-cart\">" . _t('continueCart') . "</a>
            <a href=\"$checkoutUrl\" class=\"to-checkout\">" . _t('continueCheckout') . "</a>
        </div>";
        } else {
            $html = "<h4 style=\"text-align: center;width: 100%;\">No items in cart!</h4>";
        }
        return $html;
    }
}
