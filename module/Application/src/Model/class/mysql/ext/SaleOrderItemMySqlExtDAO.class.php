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
        $sql = "SELECT
                    a.*,
                    b.title,
                    b.supplier_id,
                    c.email AS supplier_email
                FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                    ON a.`item_id` = b.`id`
                    LEFT OUTER JOIN `user` c
                    ON b.`supplier_id` = c.`id`
                WHERE a.sale_order_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($saleOrderId);
        return $this->getList($sqlQuery);
    }

    public function getSupplierSaleOrderItems($saleOrderId, $supplierId)
    {
        $sql = "SELECT
                    a.*,
                    b.title,
                    b.supplier_id,
                    c.email AS supplier_email
                FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                    ON a.`item_id` = b.`id`
                    LEFT OUTER JOIN `user` c
                    ON b.`supplier_id` = c.`id`
                WHERE a.sale_order_id = ? AND b.`supplier_id` = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($saleOrderId);
        $sqlQuery->set($supplierId);
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
        if ($orderId) {
            $sql .= " AND a.`sale_order_id` = $orderId";
        }
        if ($status) {
            $sql .= " AND b.`status` = '$status'";
        }
        $sql .= " GROUP BY a.`sale_order_id`";
        if ($limit) {
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

    public function getOrdersCount($supplierId, $status = 'paid', $fromDate, $toDate)
    {
        $sql = "SELECT COUNT(*) AS orders_count FROM (
                    SELECT
                    a.*,
                    b.supplier_id,
                    c.`status`
                    FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                        ON a.`item_id` = b.`id`
                    LEFT OUTER JOIN sale_order c
                        ON a.`sale_order_id` = c.`id`
                    WHERE b.`supplier_id` = ? AND c.`status` = ? AND c.`created_at` >= '$fromDate' AND c.`created_at` <= '$toDate' GROUP BY a.`sale_order_id`) AS q1;";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($supplierId);
        $sqlQuery->setString($status);
        return $this->querySingleResult($sqlQuery);
    }

    public function getOrdersPriceTotal($supplierId, $status = 'paid', $fromDate, $toDate)
    {
        $sql = "SELECT SUM(q1.price) AS price_total FROM (
                    SELECT
                    a.*,
                    b.supplier_id,
                    c.`status`
                    FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                        ON a.`item_id` = b.`id`
                    LEFT OUTER JOIN sale_order c
                        ON a.`sale_order_id` = c.`id`
                    WHERE b.`supplier_id` = ? AND c.`status` = ? AND c.`created_at` >= '$fromDate' AND c.`created_at` <= '$toDate') AS q1";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($supplierId);
        $sqlQuery->setString($status);
        return $this->querySingleResult($sqlQuery);
    }
    public function getOrdersCommissionTotal($supplierId, $status = 'paid', $fromDate, $toDate)
    {
        $sql = "SELECT SUM(q1.commission) AS commission_total FROM (
                    SELECT
                    a.*,
                    b.supplier_id,
                    c.`status`
                    FROM
                    sale_order_item a
                    LEFT OUTER JOIN item b
                        ON a.`item_id` = b.`id`
                    LEFT OUTER JOIN sale_order c
                        ON a.`sale_order_id` = c.`id`
                    WHERE b.`supplier_id` = ? AND c.`status` = ? AND c.`created_at` >= '$fromDate' AND c.`created_at` <= '$toDate') AS q1";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($supplierId);
        $sqlQuery->setString($status);
        return $this->querySingleResult($sqlQuery);
    }
}
