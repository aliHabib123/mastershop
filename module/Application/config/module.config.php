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
            'myOrders' => [
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
