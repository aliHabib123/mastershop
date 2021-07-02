<?php

/**
 * Class that operate on table 'sale_order'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class SaleOrderMySqlExtDAO extends SaleOrderMySqlDAO
{
    public function getOrders($customerId, $fromDate = false, $toDate = false, $status = false)
    {
        $sql = "SELECT * FROM sale_order WHERE customer_id = ?";
        if ($status) {
            $sql .= " AND status = ?";
        }
        if ($fromDate) {
            $sql .= " AND created_at >= ?";
        }
        if ($toDate) {
            $sql .= " AND created_at <= ?";
        }

        $sql .= " AND (`status` = 'paid' OR payment_type = 'cash-on-delivery')";
        $sql .= " ORDER BY created_at DESC";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($customerId);

        if ($status) {
            $sqlQuery->setString($status);
        }
        if ($fromDate) {
            $sqlQuery->setString($fromDate);
        }
        if ($toDate) {
            $sqlQuery->setString($toDate);
        }
        return $this->getList($sqlQuery);
    }

    public function selectOrders($condition = "1")
    {
        $sql = "SELECT
                    a.*,
                    b.email,
                    c.item_id,
                    d.supplier_id
                FROM
                    sale_order a
                    LEFT OUTER JOIN `user` b
                    ON a.`customer_id` = b.`id`
                    LEFT OUTER JOIN `sale_order_item` c
                    ON c.`sale_order_id` = a.`id`
                    LEFT OUTER JOIN `item` d
                    ON d.`id` = c.`item_id`
                WHERE b.`user_type` = 3 AND $condition";
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
}