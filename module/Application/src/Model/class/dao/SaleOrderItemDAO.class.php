<?php
/**
 * Intreface DAO
 */
interface SaleOrderItemDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SaleOrderItem 
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
 	 * @param saleOrderItem primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SaleOrderItem saleOrderItem
 	 */
	public function insert($saleOrderItem);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SaleOrderItem saleOrderItem
 	 */
	public function update($saleOrderItem);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryBySaleOrderId($value);

	public function queryByItemId($value);

	public function queryByQty($value);

	public function queryByPrice($value);

	public function queryByCommission($value);

	public function queryByMeta($value);


	public function deleteBySaleOrderId($value);

	public function deleteByItemId($value);

	public function deleteByQty($value);

	public function deleteByPrice($value);

	public function deleteByCommission($value);

	public function deleteByMeta($value);


}
?>