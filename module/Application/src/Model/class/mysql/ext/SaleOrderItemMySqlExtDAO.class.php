<?php

/**
 * Class that operate on table 'sale_order_item'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class SaleOrderItemMySqlExtDAO extends SaleOrderItemMySqlDAO
{

    public function getSaleOrderItems($saleOrderId)
    {
        $sql = "SELECT a.*, b.title FROM sale_order_item a LEFT OUTER JOIN item b ON a.`item_id` = b.`id` WHERE a.sale_order_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($saleOrderId);
        return $this->getList($sqlQuery);
    }
}
