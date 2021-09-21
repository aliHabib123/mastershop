<?php
/**
 * Class that operate on table 'item_category'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemCategoryMySqlExtDAO extends ItemCategoryMySqlDAO{

    public function select($condition){
		$sql = "SELECT a.*, (SELECT b.`name` FROM item_category b WHERE b.`id` = a.`translation_id`)  AS 'arabic_name' FROM item_category a WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
}
