<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface DeliveryDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Delivery 
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
 	 * @param delivery primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Delivery delivery
 	 */
	public function insert($delivery);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Delivery delivery
 	 */
	public function update($delivery);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByOrderId($value);

	public function queryByDeliveryCompanyId($value);

	public function queryByDeliveryStateId($value);

	public function queryByDriverId($value);

	public function queryByCreatedAt($value);

	public function queryByUpdatedAt($value);

	public function queryByDeliveryHistory($value);


	public function deleteByOrderId($value);

	public function deleteByDeliveryCompanyId($value);

	public function deleteByDeliveryStateId($value);

	public function deleteByDriverId($value);

	public function deleteByCreatedAt($value);

	public function deleteByUpdatedAt($value);

	public function deleteByDeliveryHistory($value);


}
?>