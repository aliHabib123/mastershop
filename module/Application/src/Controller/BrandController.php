<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemBrandMappingMySqlExtDAO;
use ItemBrandMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;

class BrandController extends AbstractActionController
{
    public static function getBrands()
    {
        $itemBrandMySqlExtDAO = new ItemBrandMySqlExtDAO();
        return $itemBrandMySqlExtDAO->queryAll();
    }

    public static function updateOrInsertItemBrand($itemId, $brandId)
    {
        $itemBrandMappingMySqlExtDAO = new ItemBrandMappingMySqlExtDAO();
        $exist = $itemBrandMappingMySqlExtDAO->queryByItemId($itemId);
        if ($exist) {
            $res = $itemBrandMappingMySqlExtDAO->updateItemBrand($itemId, $brandId);
        } else {
            $res = $itemBrandMappingMySqlExtDAO->insertItemBrand($itemId, $brandId);
        }
        return $res;
    }
}
