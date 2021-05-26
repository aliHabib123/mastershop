<?php

declare(strict_types=1);

namespace Application\Controller;

use ItemCategoryMySqlExtDAO;
use Laminas\Mvc\Controller\AbstractActionController;

class CategoryController extends AbstractActionController
{
    public static function getCategories($cond = '1'){
        $itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
        return $itemCategoryMySqlExtDAO->select($cond);
    }
}
