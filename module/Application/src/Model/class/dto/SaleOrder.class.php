<?php
	/**
	 * Object represents table 'sale_order'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2021-05-14 19:34	 
	 */
	class SaleOrder{
		
		var $id;
		var $parentId;
		var $numItemsSold;
		var $totalSales;
		var $taxTotal;
		var $shippingTotal;
		var $netTotal;
		var $status;
		var $customerId;
		var $note;
		var $addressId;
		var $createdAt;
		var $createdAtGmt;
		var $updatedAt;
		
	}
?>