<?php
/**
 * Class that operate on table 'item_category_mapping'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemCategoryMappingMySqlExtDAO extends ItemCategoryMappingMySqlDAO{

    public function updateItemCategory($itemId, $categoryId){
        $sql = 'UPDATE item_category_mapping SET category_id = ?  WHERE item_id = ?';
		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->setNumber($categoryId);
		$sqlQuery->setNumber($itemId);
		
		return $this->executeUpdate($sqlQuery);
    }

    public function insertItemCategory($itemId, $categoryId){
		$sql = 'INSERT INTO item_category_mapping (item_id, category_id) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($itemId);
		$sqlQuery->setNumber($categoryId);

		$id = $this->executeInsert($sqlQuery);
		return $id;
    }
	
	public function getItemCategory($itemId){
		$sql = "SELECT a.*, b.name, b.parent_id FROM item_category_mapping a LEFT OUTER JOIN item_category b ON a.`category_id`= b.`id` WHERE a.`item_id` = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($itemId);
		return $this->getRow($sqlQuery);
	}

	public function getListOfItemsInCategory($categoryId, $excludeId){
		$sql = "SELECT * FROM item_category_mapping WHERE category_id = ? AND item_id != ? ORDER BY RAND() LIMIT 10 OFFSET 0";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($categoryId);
		$sqlQuery->set($excludeId);
		return $this->getList($sqlQuery);
	}
}
?>