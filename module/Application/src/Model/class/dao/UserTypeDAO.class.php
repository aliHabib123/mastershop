<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface UserTypeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserType 
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
 	 * @param userType primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserType userType
 	 */
	public function insert($userType);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserType userType
 	 */
	public function update($userType);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTypeName($value);


	public function deleteByTypeName($value);


}
?>