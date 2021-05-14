<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface CartDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Cart 
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
 	 * @param cart primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Cart cart
 	 */
	public function insert($cart);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Cart cart
 	 */
	public function update($cart);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByQty($value);

	public function queryByUserId($value);

	public function queryByCreatedAt($value);


	public function deleteByItemId($value);

	public function deleteByQty($value);

	public function deleteByUserId($value);

	public function deleteByCreatedAt($value);


}
?>