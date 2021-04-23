<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:58
 */
interface UserRoleDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserRole 
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
 	 * @param userRole primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserRole userRole
 	 */
	public function insert($userRole);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserRole userRole
 	 */
	public function update($userRole);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByDisplayOrder($value);

	public function queryByActive($value);


	public function deleteByName($value);

	public function deleteByDisplayOrder($value);

	public function deleteByActive($value);


}
?>