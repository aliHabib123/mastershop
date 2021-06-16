<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class PaymentController extends AbstractActionController
{
    public static $PENDING = 'pending';
    public static $IN_PROGRESS = 'in-progress';
    public static $PAID = 'paid';
    public static $COMPLETE = 'complete';
    public static $FAILED = 'failed';
}
