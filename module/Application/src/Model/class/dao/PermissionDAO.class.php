<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface PermissionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Permission 
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
 	 * @param permission primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Permission permission
 	 */
	public function insert($permission);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Permission permission
 	 */
	public function update($permission);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByPermissionName($value);


	public function deleteByPermissionName($value);


}
?>