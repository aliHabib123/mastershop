<?php

function main()
{
	global $currentPage;
	global $totalPages;
	global $currentPageUrl;
	$currentPageUrl = ADMIN_LINK . 'display_orders.php';

	// paging
	$limit = 4;
	$offset = 0;
	$page = 1;

	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}

	$saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
	$orderBy = "desc";
	$fieldName = "a.`id`";
	$condition = "";
	$condition .= " 1 order by $fieldName $orderBy ";
	$currentPage = $page;
	$recordsCount = count($saleOrderMySqlExtDAO->selectOrders($condition));
	$totalPages = ceil($recordsCount / $limit);
	$condition .= " limit $limit offset $offset ";
	$records = $saleOrderMySqlExtDAO->selectOrders($condition);
?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				ORDERS MANAGEMENT
			</div>
			<div class="actions">
				<div class="btn-group">
					<a class="btn default" href="#" data-toggle="dropdown">
						Columns
						<i class="fa fa-angle-down"></i>
					</a>
					<div id="sample_2_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
						<label><input type="checkbox" checked data-column="0">ID</label>
						<label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Customer Email"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Num of Items"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Total"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Status"; ?></label>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Customer Email"; ?></th>
						<th><?php echo "Num of Items"; ?></th>
						<th><?php echo "Total"; ?></th>
						<th><?php echo "Status"; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($rc = 0; $rc < count($records); $rc++) {
						$row = $records[$rc]; ?>
						<tr id="<?php echo $row->id; ?>">
							<!-- primary key -->
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->customerEmail; ?></td>
							<td><?php echo $row->numItemsSold; ?></td>
							<td><?php echo number_format($row->netTotal) . " LBP"; ?></td>
							<td><?php echo ucfirst($row->status); ?></td>

							<td>
								<?php /*view_order.php?id=<?php echo $row->id; ?>*/ ?>
								<a class="btn btn-xs yellow" href="javsscript:void(0);">
									View Order
								</a>
							</td>
						</tr>
					<?php
					} ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-12">
					<div id="order-pagination" class="text-center"></div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.dataTables_info,
		.dataTables_paginate,
		.dataTables_length,
		.dataTables_filter {
			display: none;
		}
	</style>
<?php
}
include "template.php"; ?>