<?php

/**
 * Class that operate on table 'brand_category_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-21 16:28
 */
class BrandCategoryMappingMySqlExtDAO extends BrandCategoryMappingMySqlDAO
{
    public function deleteByBrandIdAndCond($id, $cond = "1")
    {
        $sql = 'DELETE FROM brand_category_mapping WHERE brand_id = ? AND ' . $cond;
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($id);
        return $this->executeUpdate($sqlQuery);
    }

    public function getDistinctCategories()
    {
        $sql = 'SELECT a.*, b.name FROM brand_category_mapping a LEFT OUTER JOIN item_category b ON a.`category_id` = b.`id` GROUP BY a.`category_id`';
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
}
