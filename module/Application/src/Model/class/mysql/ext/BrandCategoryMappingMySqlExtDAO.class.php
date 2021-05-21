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
        $sql = 'DELETE FROM brand_category_mapping WHERE brand_id = ? AND '.$cond;
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($id);
        return $this->executeUpdate($sqlQuery);
    }
}
