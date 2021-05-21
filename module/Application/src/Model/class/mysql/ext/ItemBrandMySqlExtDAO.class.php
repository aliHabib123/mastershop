<?php
/**
 * Class that operate on table 'item_brand'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemBrandMySqlExtDAO extends ItemBrandMySqlDAO{

    public function select($condition){
		$sql = "SELECT * FROM item_brand WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
}
