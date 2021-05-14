<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface WarehouseDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Warehouse 
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
 	 * @param warehouse primary key
 	 */
	public function delete($warehouse_id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Warehouse warehouse
 	 */
	public function insert($warehouse);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Warehouse warehouse
 	 */
	public function update($warehouse);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTitle($value);

	public function queryByCompanyId($value);

	public function queryByContactId($value);

	public function queryByActive($value);

	public function queryByCreatedAt($value);

	public function queryByUpdatedAt($value);


	public function deleteByTitle($value);

	public function deleteByCompanyId($value);

	public function deleteByContactId($value);

	public function deleteByActive($value);

	public function deleteByCreatedAt($value);

	public function deleteByUpdatedAt($value);


}
?>