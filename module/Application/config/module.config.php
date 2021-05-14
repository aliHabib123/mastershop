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
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
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
                        'year'       => date('Y'),
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
            Controller\IndexController::class => InvokableFactory::class,
            Controller\DesignController::class => InvokableFactory::class,
            Controller\ProductController::class => InvokableFactory::class,
            Controller\VendorController::class => InvokableFactory::class,
            Controller\HelperController::class => InvokableFactory::class,
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
