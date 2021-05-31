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
}
?>