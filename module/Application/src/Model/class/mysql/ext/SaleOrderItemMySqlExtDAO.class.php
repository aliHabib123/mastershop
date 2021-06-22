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

    public function getSalOrderItemsIdsBySupplier($supplierId, $orderId, $status, $limit = false, $offset = 0)
    {
        $sql = "SELECT
                    a.*,
                    b.status,
                    b.created_at
                FROM
                    `sale_order_item` a
                LEFT OUTER JOIN `sale_order` b
                ON a.`sale_order_id` = b.`id`
                WHERE a.`item_id` IN
                    (SELECT
                    id
                    FROM
                    item
                    WHERE supplier_id = $supplierId)";
                    if($orderId){
                        $sql .= " AND a.`sale_order_id` = $orderId";
                    }
                    if($status){
                        $sql .= " AND b.`status` = '$status'";
                    }
        $sql .= " GROUP BY a.`sale_order_id`";
        if($limit){
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        //echo $sql;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

    public function itemsBySupplierIdAndSaleOrderId($saleOrderId, $supplierId)
    {
        $sql = "SELECT
                    a.*,
                    b.title
                FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                    ON a.`item_id` = b.`id`
                WHERE a.sale_order_id = $saleOrderId
                    AND a.item_id IN
                    (SELECT
                    id
                    FROM
                    item
                    WHERE supplier_id = $supplierId)";
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
}
