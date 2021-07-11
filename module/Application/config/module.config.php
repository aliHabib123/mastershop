<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/[:lang]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'lang' => 'en',
                    ],
                    'constraints' => [
                        'lang' => '(en|ar)',
                    ],
                ],
            ],
            'test' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/test',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'test',
                    ],
                ],
            ],
            'products' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/products[/:cat1][/:cat2][/:cat3][/]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'index',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'productDetails' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/product[/:slug][/]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'details',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'todaysDeals' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/todays-deals[/]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'todaysDeals',
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'latestArrivals' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/latest-arrivals[/]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'latestArrivals',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'promotions' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/promotions[/]',
                    'defaults' => [
                        'controller' => Controller\ProductController::class,
                        'action'     => 'promotions',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            // Supplier Routes
            'contactDetails' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/contact[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'contactDetails',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'vendorContactUpdate' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/vendor/contact-update',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'vendorContactUpdate',
                    ],
                ],
            ],
            'accountDetails' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/account[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'accountDetails',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'warehouseDetails' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/warehouse[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'warehouseDetails',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'inventory' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/inventory[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'inventory',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'myProducts' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/my-products[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'myProducts',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'vendorMyOrders' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/my-orders[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'myOrders',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'vendorOrderDetails' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/vendor/order/:id',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'vendorOrderDetails',
                    ],
                    'constraints' => array(
                        'id' => '[0-9]+'
                ),
                ],
            ],
            'myDashboard' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vendor/my-dashboard[/]',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'myDashboard',
                        'year'       => date('Y'),
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'submitImport' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/submit-import',
                    'defaults' => [
                        'controller' => Controller\ImportController::class,
                        'action'     => 'submitImport',
                    ],
                ],
            ],
            'insertBatch' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/insert-batch',
                    'defaults' => [
                        'controller' => Controller\ImportController::class,
                        'action'     => 'insertBatch',
                    ],
                ],
            ],
            'deleteDeletedItems' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/delete-deleted',
                    'defaults' => [
                        'controller' => Controller\ImportController::class,
                        'action'     => 'deleteDeletedItems',
                    ],
                ],
            ],
            //clean-temp-table
            'cleanTempTable' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/clean-temp-table',
                    'defaults' => [
                        'controller' => Controller\ImportController::class,
                        'action'     => 'cleanTempTable',
                    ],
                ],
            ],
            'addWarehouse' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/add-warehouse',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'addWarehouse',
                    ],
                ],
            ],
            'deleteWarehouse' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/delete-warehouse',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'deleteWarehouse',
                    ],
                ],
            ],
            'editWarehouse' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/edit-warehouse',
                    'defaults' => [
                        'controller' => Controller\VendorController::class,
                        'action'     => 'editWarehouse',
                    ],
                ],
            ],
            'vendorLogin' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/vendor-login',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'vendorLogin',
                    ],
                ],
            ],
            'submitVendorLogin' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/submit-vendor-login',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'submitVendorLogin',
                    ],
                ],
            ],
            // End supplier routes

            //Facebook
            'facebookCallback' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/facebook-callback',
                    'defaults' => [
                        'controller' => Controller\FacebookController::class,
                        'action'     => 'callback',
                    ],
                ],
            ],
            //End Facebook

            // User Routes
            'forgotPassword' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/forgot-password/:userType',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'forgotPassword',
                    ],
                    'constraints' => [
                        'userType' => '(2|3)',
                    ],
                ],
            ],
            'forgotPasswordSubmit' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/forgot-password-submit/:userType',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'forgotPasswordSubmit',
                    ],
                    'constraints' => [
                        'userType' => '(2|3)',
                    ],
                ],
            ],
            'resetPassword' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/reset-password/:userType',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'resetPassword',
                    ],
                    'constraints' => [
                        'userType' => '(2|3)',
                    ],
                ],
            ],
            'loginRequired' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login-required',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'loginRequired',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'submitRegister' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/submit-register',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'submitRegister',
                    ],
                ],
            ],
            'submitLogin' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/submit-login',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'submitLogin',
                    ],
                ],
            ],
            'myProfile' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/my-profile',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'myProfile',
                    ],
                ],
            ],
            'myOrders' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/my-orders',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'myOrders',
                    ],
                ],
            ],
            'orderDetails' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/order/:id',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'orderDetails',
                    ],
                    'constraints' => array(
                        'id' => '[0-9]+'
                ),
                ],
            ],
            'myWishlist' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/my-wishlist',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'myWishlist',
                    ],
                ],
            ],

            'addToWishlist' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/add-to-wishlist',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'addToWishlist',
                    ],
                ],
            ],

            'deleteFromWishlist' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/delete-from-wishlist',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'deleteFromWishlist',
                    ],
                ],
            ],
            'myCart' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/my-cart',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'myCart',
                    ],
                ],
            ],
            'addToCart' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/add-to-cart',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'addToCart',
                    ],
                ],
            ],
            'deleteFromCart' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/delete-from-cart',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'deleteFromCart',
                    ],
                ],
            ],
            'updateCart' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/update-cart',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'updateCart',
                    ],
                ],
            ],
            'checkout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/checkout',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'checkout',
                    ],
                ],
            ],
            'getShippingPrice' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/get-shipping-price',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'getShippingPrice',
                    ],
                ],
            ],
            'getCheckoutItems' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/get-checkout-items',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'getCheckoutItems',
                    ],
                ],
            ],
            'pay' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/pay',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'pay',
                    ],
                ],
            ],
            'payError' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/payment-error',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'payError',
                    ],
                ],
            ],
            'orderComplete' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/order-complete',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'orderComplete',
                    ],
                ],
            ],
            'orderResult' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/order-result',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'orderResult',
                    ],
                ],
            ],
            'orderCancel' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/order-cancel',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'orderCancel',
                    ],
                ],
            ],
            'orderError' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/order-error',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'orderError',
                    ],
                ],
            ],
            'updateUser' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/update-user',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action'     => 'updateUser',
                    ],
                ],
            ],
            // End User Routes
            'content' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/page[/:slug][/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'content',
                    ],
                    'constraints' => [
                        'year' => '\d{4}',
                    ],
                ],
            ],
            'contactUs' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact-us',
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contactSubmit' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact-submit',
                    'defaults' => [
                        'controller' => Controller\ContactController::class,
                        'action'     => 'contactSubmit',
                    ],
                ],
            ],
            'careers' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/careers',
                    'defaults' => [
                        'controller' => Controller\CareerController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'career' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/career/:id',
                    'defaults' => [
                        'controller' => Controller\CareerController::class,
                        'action'     => 'details',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action][/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ContentController::class => InvokableFactory::class,
            Controller\UserController::class => InvokableFactory::class,
            Controller\FacebookController::class => InvokableFactory::class,
            Controller\GoogleController::class => InvokableFactory::class,
            Controller\IndexController::class => InvokableFactory::class,
            Controller\DesignController::class => InvokableFactory::class,
            Controller\ProductController::class => InvokableFactory::class,
            Controller\CategoryController::class => InvokableFactory::class,
            Controller\BrandController::class => InvokableFactory::class,
            Controller\VendorController::class => InvokableFactory::class,
            Controller\HelperController::class => InvokableFactory::class,
            Controller\ImportController::class => InvokableFactory::class,
            Controller\MailController::class => InvokableFactory::class,
            Controller\EcommerceMailController::class => InvokableFactory::class,
            Controller\ContactController::class => InvokableFactory::class,
            Controller\CareerController::class => InvokableFactory::class,
            Controller\MPGSController::class => InvokableFactory::class,
            Controller\PaymentController::class => InvokableFactory::class,
            Controller\OptionsController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
