<?php
/**
 * Intreface DAO
 */
interface CityDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return City 
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
 	 * @param city primary key
 	 */
	public function delete($city);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param City city
 	 */
	public function insert($city);
	
	/**
 	 * Update record in table
 	 *
 	 * @param City city
 	 */
	public function update($city);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByLat($value);

	public function queryByLng($value);

	public function queryByCountry($value);

	public function queryByIso2($value);

	public function queryByAdminName($value);

	public function queryByCapital($value);

	public function queryByPopulation($value);

	public function queryByPopulationProper($value);


	public function deleteByLat($value);

	public function deleteByLng($value);

	public function deleteByCountry($value);

	public function deleteByIso2($value);

	public function deleteByAdminName($value);

	public function deleteByCapital($value);

	public function deleteByPopulation($value);

	public function deleteByPopulationProper($value);


}
?>