<?php
/**
 * Class that operate on table 'sale_order'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class SaleOrderMySqlExtDAO extends SaleOrderMySqlDAO{

    public function getOrders($customerId, $fromDate = false, $toDate = false, $status = false){
		$sql = "SELECT * FROM sale_order WHERE customer_id = ?";
        if($status){
            $sql .= " AND status = ?";
        }
        $sql .= " ORDER BY created_at DESC";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($customerId);

        if($status){
            $sqlQuery->setString($status);
        }
		return $this->getList($sqlQuery);
	}
	
}
?>