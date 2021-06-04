<?php
/**
 * Class that operate on table 'item_category'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemCategoryMySqlExtDAO extends ItemCategoryMySqlDAO{

    public function select($condition){
		$sql = "SELECT * FROM item_category WHERE $condition";
		//print_r($sql);echo '<br>';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
}
