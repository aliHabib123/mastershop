<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemCategoryMappingMySqlExtDAO;
use ItemCategoryMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;

class CategoryController extends AbstractActionController
{
    public static function getCategories($cond = '1')
    {
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        return $itemCategoryMySqlExtDAO->select($cond);
    }

    public static function updateOrInsertItemCategory($itemId, $categoryId)
    {
        $itemCategoryMappingMySqlExtDAO = new ItemCategoryMappingMySqlExtDAO;
        $exist = $itemCategoryMappingMySqlExtDAO->queryByItemId($itemId);
        if ($exist) {
            $res = $itemCategoryMappingMySqlExtDAO->updateItemCategory($itemId, $categoryId);
        } else {
            $res = $itemCategoryMappingMySqlExtDAO->insertItemCategory($itemId, $categoryId);
        }
        return $res;
    }
}
