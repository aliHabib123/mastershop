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
        $html = "<div class=\"main-title centered\">$title</div>";
        return $html;
    }
    public static function item(){
        $html = "<div class=\"item-wrapper\">
        <div class=\"item-wrapper_img\">
            <a href=\"#\">
                <img src=\"img/product.png\" />
            </a>
        </div>
        <div class=\"item-wrapper_title\">
            <a href=\"#\">
            Tefal Fondue Inox & Design
            </a>
        </div>
        <div class=\"item-wrapper_price\">
            1,290,000 LBP
        </div>
        <div class=\"item-wrapper_cart_heart\">
            <a class=\"heart off\" href=\"#\">
                <img src=\"img/heart-off.png\" />
            </a>
            <a class=\"cart\" href=\"#\">
                <img src=\"img/cart.png\" />
            </a>
        </div>
    </div>";
    return $html;
    }
}
