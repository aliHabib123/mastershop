<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class PaymentController extends AbstractActionController
{
    public static $PENDING = 'pending';
    public static $PAID = 'paid';
    public static $FAILED = 'failed';
    public static $CANCELED = 'canceled';

    public static $PAYMENT_CASH_ON_DELIVERY = 'cash-on-delivery';
    public static $PAYMENT_ONLINE = 'pay-online';
    
}
