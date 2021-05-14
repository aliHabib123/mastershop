<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface RolePermissionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return RolePermission 
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
 	 * @param rolePermission primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param RolePermission rolePermission
 	 */
	public function insert($rolePermission);
	
	/**
 	 * Update record in table
 	 *
 	 * @param RolePermission rolePermission
 	 */
	public function update($rolePermission);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByRoleId($value);

	public function queryByPermissionId($value);


	public function deleteByRoleId($value);

	public function deleteByPermissionId($value);


}
?>