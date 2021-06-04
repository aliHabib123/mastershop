<?php
/**
 * Class that operate on table 'wishlist'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class WishlistMySqlExtDAO extends WishlistMySqlDAO
{
    public function deleteFromWishlist($wishlist)
    {
        $sql = 'DELETE FROM wishlist WHERE item_id = ? AND customer_id = ?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($wishlist->itemId);
        $sqlQuery->set($wishlist->customerId);
        return $this->executeUpdate($sqlQuery);
    }
}
