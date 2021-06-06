<?php
/**
 * Class that operate on table 'cart'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class CartMySqlExtDAO extends CartMySqlDAO{

    public function getCartItems($itemId, $userId){
        $sql = "select * from cart where item_id = ? AND user_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($itemId);
        $sqlQuery->set($userId);
        return $this->getRow($sqlQuery);
    }

    public function incrementCartItems($itemId, $userId, $qty){
        $sql = "update cart set qty = ? WHERE item_id = ? AND user_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($qty);
        $sqlQuery->set($itemId);
        $sqlQuery->set($userId);
        return $this->executeUpdate($sqlQuery);
    }

    public function updateCartQty($itemId, $userId, $qty){
        $sql = "update cart set qty = ? WHERE item_id = ? AND user_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($qty);
        $sqlQuery->set($itemId);
        $sqlQuery->set($userId);
        return $this->executeUpdate($sqlQuery);
    }
    public function deleteCartQty($itemId, $userId){
        $sql = "delete FROM cart WHERE item_id = ? AND user_id = ?";
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($itemId);
        $sqlQuery->set($userId);
        return $this->executeUpdate($sqlQuery);
    }
}
?>