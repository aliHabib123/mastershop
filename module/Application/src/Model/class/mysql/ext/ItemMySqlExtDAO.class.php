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
        $sql = "SELECT * FROM item WHERE $condition";

        if ($limit != 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }

        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

    public function getItems($categoryId = false, $search = false, $tagId = false, $limit = 0, $offset = 0)
    {
        $sql = "SELECT
                    a.*,
                    b.category_id";
        if ($tagId) {
            $sql .= ",c.`tag_id`";
        }
        $sql .= " FROM
                    `item` a
                    LEFT OUTER JOIN `item_category_mapping` b
                    ON a.`id` = b.`item_id`";

        if ($tagId) {
            $sql .= " LEFT OUTER JOIN `item_tag_mapping` c
                        ON a.`id` = c.`item_id`";
        }

        $sql .= " WHERE 1";
        if ($categoryId) {
            $sql .= " AND b.`category_id` = $categoryId";
        }
        if ($tagId) {
            $sql .= " AND c.`tag_id` = $tagId";
        }
        if ($search) {
            $sql .= " AND (a.`title` LIKE '%$search%' OR a.`description` LIKE '%$search%' OR a.`specification` LIKE '%$search%')";
        }
        $sql .= " ORDER BY a.`display_order` ASC, a.`id` DESC";

        if ($limit != 0) {
            $sql .= " LIMIT $limit OFFSET $offset";
        }
        //echo $sql;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
}
