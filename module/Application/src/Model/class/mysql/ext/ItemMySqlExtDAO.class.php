<?php

/**
 * Class that operate on table 'item'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemMySqlExtDAO extends ItemMySqlDAO
{
    public function select($condition = '1', $limit = 0, $offset = 0)
    {
        $sql = "SELECT a.*, b.usd_exchange_rate FROM item a LEFT OUTER JOIN user b ON a.`supplier_id` = b.`id` WHERE $condition";

        if ($limit != 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

    public function getItems($categoryId = false, $search = false, $brandId = "", $minPrice = "", $maxPrice = "", $tagId = false, $orderBy = "", $limit = 0, $offset = 0)
    {
        $sql = "SELECT
                    a.*,
                    b.category_id,
                    e.usd_exchange_rate";
        if ($tagId) {
            $sql .= ",c.`tag_id`";
        }
        if ($brandId != "") {
            $sql .= ",d.`brand_id`";
        }
        $sql .= " FROM
                    `item` a
                    LEFT OUTER JOIN `item_category_mapping` b
                    ON a.`id` = b.`item_id`";

        $sql .= "LEFT OUTER JOIN `user` e
                    ON a.`supplier_id` = e.`id`";

        if ($tagId) {
            $sql .= " LEFT OUTER JOIN `item_tag_mapping` c
                        ON a.`id` = c.`item_id`";
        }

        if ($brandId != "") {
            $sql .= " LEFT OUTER JOIN `item_brand_mapping` d
                        ON a.`id` = d.`item_id`";
        }

        $sql .= " WHERE 1";

        if ($minPrice != "") {
            $sql .= " AND a.`regular_price` * e.`usd_exchange_rate` >= $minPrice";
        }

        if ($maxPrice != "") {
            $sql .= " AND a.`regular_price` * e.`usd_exchange_rate` <= $maxPrice";
        }

        if (is_array($categoryId)) {
            if ($categoryId && count($categoryId) > 0) {
                $categoryId = implode(',', $categoryId);
                $sql .= " AND b.`category_id` IN ($categoryId)";
            }
        } else {
            if ($categoryId) {
                $sql .= " AND b.`category_id` = $categoryId";
            }
        }
        if ($tagId) {
            $sql .= " AND c.`tag_id` = $tagId";
        }
        if ($brandId != "") {
            $sql .= " AND d.`brand_id` = $brandId";
        }
        if ($search) {
            $sql .= " AND (a.`title` LIKE '%$search%' OR a.`description` LIKE '%$search%' OR a.`specification` LIKE '%$search%')";
        }
        $sql .= " ORDER BY";

        if ($orderBy != "") {
            $sql .= " " . $orderBy;
        }
        $sql .= "  a.`display_order` ASC, a.`id` DESC";

        if ($limit != 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        //echo $sql;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

    public function getCartItemsByUserId($userId)
    {
        $sql = "SELECT a.*, b.id AS cart_id, b.qty AS cart_qty FROM item a LEFT OUTER JOIN cart b ON a.`id` = b.`item_id` WHERE b.`user_id` = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($userId);
        return $this->getList($sqlQuery);
    }
    public function adminGetItems($condition = '1', $limit = 0, $offset = 0)
    {
        $sql = "SELECT a.*, b.company_name, b.status FROM item a LEFT OUTER JOIN user b ON a.`supplier_id` = b.`id` WHERE $condition";

        if ($limit != 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
    public function queryBySkuAndSupplierId($sku, $supplierId)
    {
        $sql = 'SELECT * FROM item WHERE sku = ? AND supplier_id = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($sku);
        $sqlQuery->set($supplierId);
        return $this->getList($sqlQuery);
    }

    public function queryBySlugAndSupplierId($slug, $supplierId)
    {
        $sql = 'SELECT * FROM item WHERE slug = ? AND supplier_id = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($slug);
        $sqlQuery->set($supplierId);
        return $this->getList($sqlQuery);
    }

    public function queryBySlug($value)
    {
        $sql = 'SELECT a.*, b.usd_exchange_rate FROM item a LEFT OUTER JOIN user b on a.`supplier_id` = b.`id` WHERE slug = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($value);
        return $this->getList($sqlQuery);
    }
}
