<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:50
 */
interface DeliveryStatusDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return DeliveryStatus 
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
 	 * @param deliveryStatu primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DeliveryStatus deliveryStatu
 	 */
	public function insert($deliveryStatu);
	
	/**
 	 * Update record in table
 	 *
 	 * @param DeliveryStatus deliveryStatu
 	 */
	public function update($deliveryStatu);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByStatus($value);

	public function queryByDisplayOrder($value);


	public function deleteByStatus($value);

	public function deleteByDisplayOrder($value);


}
?>