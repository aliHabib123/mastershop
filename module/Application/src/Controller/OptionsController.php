<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemBrandMappingMySqlExtDAO;
use ItemBrandMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;
use OptionsMySqlExtDAO;

class OptionsController extends AbstractActionController
{
    public static $SHIPPING_INSIDE_BEIRUT = 'shipping_in_beirut';
    public static $SHIPPING_OUTSIDE_BEIRUT = 'shipping_outside_beirut';
    public static $HEADER_LOCATION = 'header_location';
    public static $HEADER_PHONE_NUMBERS = 'header_phone_numbers';
    public static $HEADER_OPENING_HOURS = 'header_opening_hours';

    public static function getOption($adminName)
    {
        $optionMySqlExtDAO = new OptionsMySqlExtDAO();
        $res = $optionMySqlExtDAO->queryByAdminName($adminName);
        if ($res[0]->type == 1) {
            return $res[0]->value;
        }
        return $res[0]->valueText;
    }
}
