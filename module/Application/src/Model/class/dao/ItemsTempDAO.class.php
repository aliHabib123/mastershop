<?php
/**
 * Intreface DAO
 */
interface ItemsTempDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return ItemsTemp 
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
 	 * @param itemsTemp primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param ItemsTemp itemsTemp
 	 */
	public function insert($itemsTemp);
	
	/**
 	 * Update record in table
 	 *
 	 * @param ItemsTemp itemsTemp
 	 */
	public function update($itemsTemp);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByImage1($value);

	public function queryByImage2($value);

	public function queryByImage3($value);

	public function queryByImage4($value);

	public function queryByTitle($value);

	public function queryByCategory($value);

	public function queryBySubCategory($value);

	public function queryByProductCategory($value);

	public function queryBySku($value);

	public function queryByDescription($value);

	public function queryBySpecs($value);

	public function queryByColor($value);

	public function queryBySize($value);

	public function queryByWeight($value);

	public function queryByDimension($value);

	public function queryByBrandName($value);

	public function queryByStock($value);

	public function queryByPrice($value);

	public function queryBySpecialPrice($value);

	public function queryByWarranty($value);

	public function queryByExchange($value);

	public function queryByTitleAr($value);

	public function queryByDescriptionAr($value);

	public function queryBySpecsAr($value);

	public function queryByColorAr($value);

	public function queryBySizeAr($value);

	public function queryByDimensionsAr($value);

	public function queryByWarrantyAr($value);

	public function queryByExchangeAr($value);

	public function queryBySupplierId($value);

	public function queryByProcessed($value);


	public function deleteByImage1($value);

	public function deleteByImage2($value);

	public function deleteByImage3($value);

	public function deleteByImage4($value);

	public function deleteByTitle($value);

	public function deleteByCategory($value);

	public function deleteBySubCategory($value);

	public function deleteByProductCategory($value);

	public function deleteBySku($value);

	public function deleteByDescription($value);

	public function deleteBySpecs($value);

	public function deleteByColor($value);

	public function deleteBySize($value);

	public function deleteByWeight($value);

	public function deleteByDimension($value);

	public function deleteByBrandName($value);

	public function deleteByStock($value);

	public function deleteByPrice($value);

	public function deleteBySpecialPrice($value);

	public function deleteByWarranty($value);

	public function deleteByExchange($value);

	public function deleteByTitleAr($value);

	public function deleteByDescriptionAr($value);

	public function deleteBySpecsAr($value);

	public function deleteByColorAr($value);

	public function deleteBySizeAr($value);

	public function deleteByDimensionsAr($value);

	public function deleteByWarrantyAr($value);

	public function deleteByExchangeAr($value);

	public function deleteBySupplierId($value);

	public function deleteByProcessed($value);


}
?>