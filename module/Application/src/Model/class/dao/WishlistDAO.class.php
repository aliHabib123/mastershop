<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface WishlistDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Wishlist 
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
 	 * @param wishlist primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Wishlist wishlist
 	 */
	public function insert($wishlist);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Wishlist wishlist
 	 */
	public function update($wishlist);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByCustomerId($value);


	public function deleteByItemId($value);

	public function deleteByCustomerId($value);


}
?>