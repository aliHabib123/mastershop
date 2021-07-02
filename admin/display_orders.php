<?php

function main()
{
	global $currentPage;
	global $totalPages;
	global $currentPageUrl;
	$currentPageUrl = ADMIN_LINK . 'display_orders.php';

	$statuses = [
		'paid',
		'canceled',
		'failed',
		'pending',
	];

	// paging
	$limit = 20;
	$offset = 0;
	$page = 1;
	$condition = "";

	$supplierMySqlExtDAO = new UserMySqlExtDAO();
	$supplierId = isset($_GET['supplier_id']) && !empty($_GET['supplier_id']) ? filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT) : false;
	$suppliers = $supplierMySqlExtDAO->select("user_type = 2 and status IN  ('active', 'inactive')");


	$fromReports = isset($_GET['from_reports']) && !empty($_GET['from_reports']) ? true : false;

	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}
	$status = isset($_GET['status']) && !empty($_GET['status']) ? filter_var($_GET['status'], FILTER_SANITIZE_STRING) : false;
	if ($status) {
		$condition .= " a.`status` = '$status' AND";
	}

	$displayFromDate = "";
	$fromDate = isset($_GET['from_date']) && $_GET['from_date'] != "" ? filter_var($_GET['from_date'], FILTER_SANITIZE_STRING) : "";
	if ($fromDate != "") {
		$fromDate = DateTime::createFromFormat('d/m/Y', $fromDate);
		$fromDate = $fromDate->format('Y-m-d 00:00:00');
		$condition .= " a.`created_at` >= '$fromDate' AND";
		$displayFromDate = date('d/m/Y', strtotime($fromDate));
	}

	$displayToDate = "";
	$toDate = isset($_GET['to_date']) && $_GET['to_date'] != "" ? filter_var($_GET['to_date'], FILTER_SANITIZE_STRING) : "";
	if ($toDate != "") {
		$toDate = DateTime::createFromFormat('d/m/Y', $toDate);
		$toDate = $toDate->format('Y-m-d 23:59:59');
		$condition .= " a.`created_at` <= '$toDate' AND";
		$displayToDate = date('d/m/Y', strtotime($toDate));
	}

	$orderId = isset($_GET['order_id']) && $_GET['order_id'] != "" ? filter_var($_GET['order_id'], FILTER_SANITIZE_STRING) : "";
	if ($orderId != "") {
		$condition .= " a.`id` = '$orderId' AND";
	}

	if ($supplierId) {
		$condition .= " d.`supplier_id`= '$supplierId' AND";
	}

	$saleOrderMySqlExtDAO = new SaleOrderMySqlExtDAO();
	$orderBy = "desc";
	$fieldName = "a.`id`";

	$condition .= " 1 GROUP BY a.`id` order by $fieldName $orderBy ";
	$currentPage = $page;
	$recordsCount = count($saleOrderMySqlExtDAO->selectOrders($condition));
	$totalPages = ceil($recordsCount / $limit);
	$condition .= " limit $limit offset $offset ";
	$records = $saleOrderMySqlExtDAO->selectOrders($condition); ?>
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
						<label><input type="checkbox" checked data-column="<?php echo "5"; ?>"><?php echo "Order Date"; ?></label>
					</div>
				</div>
			</div>
		</div>
		<?php if (!$fromReports) { ?>
			<div class="portlet-body">
				<div class="search-form">
					<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
						<div class="row">
							<div class="col-md-3">
								<div class="form-gdroup">
									<label class="control-label">Order Status</label>
									<select class="form-control select2me" data-placeholder="Select Tag..." name="status" id="status">
										<option selected="selected" value="">--- Select Status ---</option>
										<?php
										foreach ($statuses as $row) {
											//echo $row->id."<br>";
											$sel = "";
											if ($row == $status) {
												$sel = "selected";
											} ?>
											<option value="<?php echo $row; ?>" <?php echo $sel; ?>><?php echo ucfirst($row); ?></option>
										<?php
										} ?>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<label class="control-label">Supplier</label>
								<select class="form-control select2me" data-placeholder="Select Supplier..." name="supplier_id" id="supplier_id">
									<option selected="selected" value="">--- Select Supplier ---</option>
									<?php
									foreach ($suppliers as $row) {
										//echo $row->id."<br>";
										$sel = "";
										if ($row->id == $supplierId) {
											$sel = "selected";
										} ?>
										<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>><?php echo $row->companyName; ?></option>
									<?php
									} ?>
								</select>
							</div>

							<div class="col-md-3">
								<div class="form-dgroup">
									<label class="control-label">From Date</label>
									<input class="form-control  date-picker" size="16" type="text" value="<?php echo $displayFromDate ?>" name="from_date" id="from_date" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-dgroup">
									<label class="control-label">To Date</label>
									<input class="form-control  date-picker" size="16" type="text" value="<?php echo $displayToDate; ?>" name="to_date" id="to_date" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-dgroup">
									<label class="control-label">ID</label>
									<input class="form-control " size="16" type="text" value="<?php echo $orderId; ?>" name="order_id" id="order_id" />
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12" style="margin-top: 25px;">
								<button type="submit" class="btn btn-primary">Filter</button>
								<button type="button" onclick="window.location.href='<?php echo $currentPageUrl; ?>'" class="btn btn-primary">Reset Filters</button>
							</div>
						</div>

					</form>
				</div>
			</div>

		<?php
		} ?>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Customer Email"; ?></th>
						<th><?php echo "Num of Items"; ?></th>
						<th><?php echo "Total"; ?></th>
						<th><?php echo "Status"; ?></th>
						<th><?php echo "Order Date"; ?></th>
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
							<td><?php echo date('d/m/Y h:i A', strtotime($row->createdAt)); ?></td>
							<td>
								<a class="btn btn-xs yellow" href="view_order.php?id=<?php echo $row->id; ?>">
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