<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:57
 */
interface UserAddressesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return UserAddresses 
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
 	 * @param userAddresse primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserAddresses userAddresse
 	 */
	public function insert($userAddresse);
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserAddresses userAddresse
 	 */
	public function update($userAddresse);	

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