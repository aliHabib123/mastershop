<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface DeliveryStateDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return DeliveryState 
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
 	 * @param deliveryState primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DeliveryState deliveryState
 	 */
	public function insert($deliveryState);
	
	/**
 	 * Update record in table
 	 *
 	 * @param DeliveryState deliveryState
 	 */
	public function update($deliveryState);	

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