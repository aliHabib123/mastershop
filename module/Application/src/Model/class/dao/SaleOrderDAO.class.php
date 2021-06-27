<?php
/**
 * Intreface DAO
 */
interface SaleOrderDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SaleOrder 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param saleOrder primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SaleOrder saleOrder
 	 */
	public function insert($saleOrder);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SaleOrder saleOrder
 	 */
	public function update($saleOrder);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByParentId($value);

	public function queryByNumItemsSold($value);

	public function queryByTotalSales($value);

	public function queryByTaxTotal($value);

	public function queryByShippingTotal($value);

	public function queryByNetTotal($value);

	public function queryByStatus($value);

	public function queryBySuccessIndicator($value);

	public function queryByPaymentType($value);

	public function queryByDeliveryStatus($value);

	public function queryByReference($value);

	public function queryByCustomerId($value);

	public function queryByNote($value);

	public function queryByAddressId($value);

	public function queryByDeliveryAddress($value);

	public function queryByCreatedAt($value);

	public function queryByCreatedAtGmt($value);

	public function queryByUpdatedAt($value);


	public function deleteByParentId($value);

	public function deleteByNumItemsSold($value);

	public function deleteByTotalSales($value);

	public function deleteByTaxTotal($value);

	public function deleteByShippingTotal($value);

	public function deleteByNetTotal($value);

	public function deleteByStatus($value);

	public function deleteBySuccessIndicator($value);

	public function deleteByPaymentType($value);

	public function deleteByDeliveryStatus($value);

	public function deleteByReference($value);

	public function deleteByCustomerId($value);

	public function deleteByNote($value);

	public function deleteByAddressId($value);

	public function deleteByDeliveryAddress($value);

	public function deleteByCreatedAt($value);

	public function deleteByCreatedAtGmt($value);

	public function deleteByUpdatedAt($value);


}
?>