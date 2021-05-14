<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class DesignController extends AbstractActionController
{
    public static function mainTitle(string $title){
        $html = "<div class='main-title centered'>$title</div>";
        return $html;
    }
    public static function secondaryTitle(string $title){
        $html = "<div class='secondary-title'>$title</div>";
        return $html;
    }
    public static function item(){
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

    public static function orderItem($status, $label, $orderId){
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
}
