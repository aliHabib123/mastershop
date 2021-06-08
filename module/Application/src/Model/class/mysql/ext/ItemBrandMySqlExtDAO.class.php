<?php

/**
 * Class that operate on table 'item_brand'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2021-04-23 23:35
 */
class ItemBrandMySqlExtDAO extends ItemBrandMySqlDAO
{

	public function select($condition)
	{
		$sql = "SELECT * FROM item_brand WHERE $condition";
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}

	public function getBrandsByCategoryId($categoryId)
	{
		$sql = "SELECT a.*, b.category_id FROM item_brand a LEFT OUTER JOIN brand_category_mapping b ON a.`id` = b.`brand_id` WHERE b.`category_id` = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($categoryId);
		return $this->getList($sqlQuery);
	}
}
