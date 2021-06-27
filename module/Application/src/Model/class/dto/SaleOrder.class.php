<?php
	/**
	 * Object represents table 'sale_order'
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

		var $successIndicator;

		var $paymentType;

		var $deliveryStatus;

		var $reference;

		var $customerId;

		var $note;

		var $addressId;

		var $deliveryAddress;

		var $createdAt;

		var $createdAtGmt;

		var $updatedAt;

		//++
		var $customerEmail;
	}
?>