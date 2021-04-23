<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:56
 */
interface UserAddressDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserAddress 
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
 	 * @param userAddres primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserAddress userAddres
 	 */
	public function insert($userAddres);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserAddress userAddres
 	 */
	public function update($userAddres);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByAddress($value);

	public function queryByUserId($value);


	public function deleteByAddress($value);

	public function deleteByUserId($value);


}
?>