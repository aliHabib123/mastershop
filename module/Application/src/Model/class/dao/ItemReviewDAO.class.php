<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2021-05-14 19:34
 */
interface ItemReviewDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemReview 
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
 	 * @param itemReview primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemReview itemReview
 	 */
	public function insert($itemReview);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemReview itemReview
 	 */
	public function update($itemReview);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByItemId($value);

	public function queryByDescription($value);

	public function queryByStars($value);

	public function queryByUserId($value);

	public function queryBySpam($value);

	public function queryByCreatedAt($value);


	public function deleteByItemId($value);

	public function deleteByDescription($value);

	public function deleteByStars($value);

	public function deleteByUserId($value);

	public function deleteBySpam($value);

	public function deleteByCreatedAt($value);


}
?>