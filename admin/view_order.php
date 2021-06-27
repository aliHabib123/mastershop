<?php
require "session_start.php";
function main()
{
	$id = $_REQUEST["id"];
	$saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
	$saleOrderItemMySqlExtDAO = new SaleOrderItemMySqlExtDAO();
	$itemMySqlExtDAO = new ItemMySqlExtDAO();
	$userMySqlExtDAO = new UserMySqlExtDAO();
	$saleOrder = $saleOrderMySqlExtDAO->load($id);
	$saleOrderItems  = $saleOrderItemMySqlExtDAO->getSaleOrderItems($id);
	$customerInfo = $userMySqlExtDAO->load($saleOrder->customerId);
?>
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Order #<?php echo $saleOrder->id; ?></div>
		</div>
		<div class="portlet-body">

			<h2>Items</h2>
			<table class="table table-striped table-bordered table-hover table-full-width">
				<thead>
					<tr>
						<td><b>ID</b></td>
						<td><b>SKU</b></td>
						<td><b>Title</b></td>
						<td><b>Vendor</b></td>
						<td><b>Qty</b></td>
						<td><b>Price</b></td>
						<td><b>SubTotal</b></td>
						<td><b>Commission</b></td>
					</tr>
				</thead>
				<tbody>
					<?php
					$total = 0;
					$commissionTotal = 0;
					foreach ($saleOrderItems as $row) {
						$saleOrderItem = $saleOrderItemMySqlExtDAO->load($row->id);
						$item = $itemMySqlExtDAO->loadItem($row->itemId);
						$price = floatval($saleOrderItem->price);
						$subtotal = $price * $saleOrderItem->qty;
						$total += $subtotal;
						$commission = $saleOrderItem->commission;
						$commissionTotal += $commission;
					?>
						<tr>
							<td><?php echo $item->id; ?></td>
							<td><?php echo $item->sku; ?></td>
							<td><?php echo $item->title; ?></td>
							<td><?php echo $item->companyName; ?></td>
							<td><?php echo $saleOrderItem->qty; ?></td>
							<td><?php echo number_format($price) . " LBP"; ?></td>
							<td><?php echo number_format($subtotal) . " LBP"; ?></td>
							<td><?php echo number_format($saleOrderItem->commission) . " LBP"; ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="7" align="right"><b>Total Commission</b></td>
						<td colspan="1"><?php echo number_format($commissionTotal) . " LBP"; ?></td>
					</tr>
					<tr>
						<td colspan="6" align="right"><b>Products Total</b></td>
						<td colspan="2"><?php echo number_format($total) . " LBP"; ?></td>
					</tr>
					<tr>
						<td colspan="6" align="right"><b>Shipping</b></td>
						<td colspan="2"><?php echo number_format($saleOrder->shippingTotal) . " LBP"; ?></td>
					</tr>
					<tr>
						<td colspan="6" align="right"><b>Net Total</b></td>
						<td colspan="2"><?php echo number_format($saleOrder->shippingTotal + $total) . " LBP"; ?></td>
					</tr>
				</tbody>
			</table>

			<h2>Order Details</h2>
			<table class="table table-bordered table-hover table-full-width">
				<tbody>
					<tr>
						<td width="20%"><b>ID</b></td>
						<td><?php echo $saleOrder->id; ?></td>
					</tr>
					<tr>
						<td width="20%"><b>Status</b></td>
						<td><?php echo ucfirst($saleOrder->status); ?></td>
					</tr>
					<tr>
						<td width="20%"><b>Payment Method</b></td>
						<td><?php echo ucfirst(str_replace('-', ' ', $saleOrder->paymentType)); ?></td>
					</tr>
					<tr>
						<td width="20%"><b>Customer Name</b></td>
						<td><?php echo $customerInfo->fullName; ?></td>
					</tr>
					<tr>
						<td width="20%"><b>Customer Email</b></td>
						<td><?php echo $customerInfo->email; ?></td>
					</tr>
					<tr>
						<td width="20%"><b>Delivery Address</b></td>
						<td><?php echo $saleOrder->deliveryAddress; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	<?php
}
include "template.php"; ?>