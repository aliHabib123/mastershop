<?php
/**
 * Class that operate on table 'sale_order'. Database Mysql.
 */
class SaleOrderMySqlDAO implements SaleOrderDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SaleOrderMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM sale_order WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sale_order';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sale_order ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param saleOrder primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM sale_order WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SaleOrderMySql saleOrder
 	 */
	public function insert($saleOrder){
		$sql = 'INSERT INTO sale_order (parent_id, num_items_sold, total_sales, tax_total, shipping_total, net_total, status, success_indicator, payment_type, delivery_status, reference, customer_id, note, address_id, delivery_address, created_at, created_at_gmt, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($saleOrder->parentId);
		$sqlQuery->setNumber($saleOrder->numItemsSold);
		$sqlQuery->set($saleOrder->totalSales);
		$sqlQuery->set($saleOrder->taxTotal);
		$sqlQuery->set($saleOrder->shippingTotal);
		$sqlQuery->set($saleOrder->netTotal);
		$sqlQuery->set($saleOrder->status);
		$sqlQuery->set($saleOrder->successIndicator);
		$sqlQuery->set($saleOrder->paymentType);
		$sqlQuery->set($saleOrder->deliveryStatus);
		$sqlQuery->set($saleOrder->reference);
		$sqlQuery->set($saleOrder->customerId);
		$sqlQuery->set($saleOrder->note);
		$sqlQuery->set($saleOrder->addressId);
		$sqlQuery->set($saleOrder->deliveryAddress);
		$sqlQuery->set($saleOrder->createdAt);
		$sqlQuery->set($saleOrder->createdAtGmt);
		$sqlQuery->set($saleOrder->updatedAt);

		$id = $this->executeInsert($sqlQuery);	
		$saleOrder->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SaleOrderMySql saleOrder
 	 */
	public function update($saleOrder){
		$sql = 'UPDATE sale_order SET parent_id = ?, num_items_sold = ?, total_sales = ?, tax_total = ?, shipping_total = ?, net_total = ?, status = ?, success_indicator = ?, payment_type = ?, delivery_status = ?, reference = ?, customer_id = ?, note = ?, address_id = ?, delivery_address = ?, created_at = ?, created_at_gmt = ?, updated_at = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($saleOrder->parentId);
		$sqlQuery->setNumber($saleOrder->numItemsSold);
		$sqlQuery->set($saleOrder->totalSales);
		$sqlQuery->set($saleOrder->taxTotal);
		$sqlQuery->set($saleOrder->shippingTotal);
		$sqlQuery->set($saleOrder->netTotal);
		$sqlQuery->set($saleOrder->status);
		$sqlQuery->set($saleOrder->successIndicator);
		$sqlQuery->set($saleOrder->paymentType);
		$sqlQuery->set($saleOrder->deliveryStatus);
		$sqlQuery->set($saleOrder->reference);
		$sqlQuery->set($saleOrder->customerId);
		$sqlQuery->set($saleOrder->note);
		$sqlQuery->set($saleOrder->addressId);
		$sqlQuery->set($saleOrder->deliveryAddress);
		$sqlQuery->set($saleOrder->createdAt);
		$sqlQuery->set($saleOrder->createdAtGmt);
		$sqlQuery->set($saleOrder->updatedAt);

		$sqlQuery->set($saleOrder->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sale_order';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByParentId($value){
		$sql = 'SELECT * FROM sale_order WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNumItemsSold($value){
		$sql = 'SELECT * FROM sale_order WHERE num_items_sold = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTotalSales($value){
		$sql = 'SELECT * FROM sale_order WHERE total_sales = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByTaxTotal($value){
		$sql = 'SELECT * FROM sale_order WHERE tax_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByShippingTotal($value){
		$sql = 'SELECT * FROM sale_order WHERE shipping_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNetTotal($value){
		$sql = 'SELECT * FROM sale_order WHERE net_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByStatus($value){
		$sql = 'SELECT * FROM sale_order WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySuccessIndicator($value){
		$sql = 'SELECT * FROM sale_order WHERE success_indicator = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPaymentType($value){
		$sql = 'SELECT * FROM sale_order WHERE payment_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeliveryStatus($value){
		$sql = 'SELECT * FROM sale_order WHERE delivery_status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByReference($value){
		$sql = 'SELECT * FROM sale_order WHERE reference = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCustomerId($value){
		$sql = 'SELECT * FROM sale_order WHERE customer_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNote($value){
		$sql = 'SELECT * FROM sale_order WHERE note = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAddressId($value){
		$sql = 'SELECT * FROM sale_order WHERE address_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDeliveryAddress($value){
		$sql = 'SELECT * FROM sale_order WHERE delivery_address = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAt($value){
		$sql = 'SELECT * FROM sale_order WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedAtGmt($value){
		$sql = 'SELECT * FROM sale_order WHERE created_at_gmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedAt($value){
		$sql = 'SELECT * FROM sale_order WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByParentId($value){
		$sql = 'DELETE FROM sale_order WHERE parent_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNumItemsSold($value){
		$sql = 'DELETE FROM sale_order WHERE num_items_sold = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTotalSales($value){
		$sql = 'DELETE FROM sale_order WHERE total_sales = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByTaxTotal($value){
		$sql = 'DELETE FROM sale_order WHERE tax_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByShippingTotal($value){
		$sql = 'DELETE FROM sale_order WHERE shipping_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNetTotal($value){
		$sql = 'DELETE FROM sale_order WHERE net_total = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByStatus($value){
		$sql = 'DELETE FROM sale_order WHERE status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySuccessIndicator($value){
		$sql = 'DELETE FROM sale_order WHERE success_indicator = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPaymentType($value){
		$sql = 'DELETE FROM sale_order WHERE payment_type = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeliveryStatus($value){
		$sql = 'DELETE FROM sale_order WHERE delivery_status = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByReference($value){
		$sql = 'DELETE FROM sale_order WHERE reference = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCustomerId($value){
		$sql = 'DELETE FROM sale_order WHERE customer_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNote($value){
		$sql = 'DELETE FROM sale_order WHERE note = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAddressId($value){
		$sql = 'DELETE FROM sale_order WHERE address_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDeliveryAddress($value){
		$sql = 'DELETE FROM sale_order WHERE delivery_address = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAt($value){
		$sql = 'DELETE FROM sale_order WHERE created_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedAtGmt($value){
		$sql = 'DELETE FROM sale_order WHERE created_at_gmt = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedAt($value){
		$sql = 'DELETE FROM sale_order WHERE updated_at = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return SaleOrderMySql 
	 */
	protected function readRow($row){
		$saleOrder = new SaleOrder();
		
		$saleOrder->id = $row['id'];
		$saleOrder->parentId = $row['parent_id'];
		$saleOrder->numItemsSold = $row['num_items_sold'];
		$saleOrder->totalSales = $row['total_sales'];
		$saleOrder->taxTotal = $row['tax_total'];
		$saleOrder->shippingTotal = $row['shipping_total'];
		$saleOrder->netTotal = $row['net_total'];
		$saleOrder->status = $row['status'];
		$saleOrder->successIndicator = $row['success_indicator'];
		$saleOrder->paymentType = $row['payment_type'];
		$saleOrder->deliveryStatus = $row['delivery_status'];
		$saleOrder->reference = $row['reference'];
		$saleOrder->customerId = $row['customer_id'];
		$saleOrder->note = $row['note'];
		$saleOrder->addressId = $row['address_id'];
		$saleOrder->deliveryAddress = $row['delivery_address'];
		$saleOrder->createdAt = $row['created_at'];
		$saleOrder->createdAtGmt = $row['created_at_gmt'];
		$saleOrder->updatedAt = $row['updated_at'];

		// ++
		$saleOrder->customerEmail = (isset($row['email'])) ? $row['email'] : "";

		return $saleOrder;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return SaleOrderMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>