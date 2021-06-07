<?php
/**
 * Class that operate on table 'item_brand_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-05-31 12:29
 */
class ItemBrandMappingMySqlExtDAO extends ItemBrandMappingMySqlDAO{

    public function updateItemBrand($itemId, $brandId){
        $sql = 'UPDATE item_brand_mapping SET brand_id = ?  WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->setNumber($brandId);
		$sqlQuery->setNumber($itemId);
		
		return $this->executeUpdate($sqlQuery);
    }

    public function insertItemBrand($itemId, $brandId){
		$sql = 'INSERT INTO item_brand_mapping (item_id, brand_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($itemId);
		$sqlQuery->setNumber($brandId);

		$id = $this->executeInsert($sqlQuery);
		return $id;
    }
	public function getItemBrand($itemId){
		$sql = "SELECT a.*, b.name, b.image FROM item_brand_mapping a LEFT OUTER JOIN item_brand b ON a.`brand_id`= b.`id` WHERE a.`item_id` = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($itemId);
		return $this->getRow($sqlQuery);
	}
}
?>