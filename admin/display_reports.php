<?php

function main()
{
	global $currentPage;
	global $totalPages;
	global $currentPageUrl;
	$currentPageUrl = ADMIN_LINK . 'display_reports.php';

	$userMySqlExtDAO = new UserMySqlExtDAO();
	$suppliers = $userMySqlExtDAO->queryByUserType(2);

	$currentPage = 1;
	$totalPages = 1;

	// Get First And last Day in current Month
	$date = date('Y-m-d');
	$first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
	$first_date = date("d/m/Y", $first_date_find);
	$last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
	$last_date = date("d/m/Y", $last_date_find);

	$fromDate = isset($_GET['from_date']) && $_GET['from_date'] != "" ? filter_var($_GET['from_date'], FILTER_SANITIZE_STRING) : $first_date;
	$fromDate = DateTime::createFromFormat('d/m/Y', $fromDate);
	$fromDate = $fromDate->format('Y-m-d 00:00:00');
	$displayFromDate = date('d/m/Y', strtotime($fromDate));

	$toDate = isset($_GET['to_date']) && $_GET['to_date'] != "" ? filter_var($_GET['to_date'], FILTER_SANITIZE_STRING) : $last_date;
	$toDate = DateTime::createFromFormat('d/m/Y', $toDate);
	$toDate = $toDate->format('Y-m-d 23:59:59');
	$displayToDate = date('d/m/Y', strtotime($toDate));

	//echo $fromDate." ".$toDate;

	$saleOrderItemMySqlExtA =  new SaleOrderItemMySqlExtDAO(); ?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				Accounting Reports
			</div>
			<div class="actions">
				<div class="btn-group">
					<a class="btn default" href="#" data-toggle="dropdown">
						Columns
						<i class="fa fa-angle-down"></i>
					</a>
					<div id="sample_2_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
						<label><input type="checkbox" checked data-column="0">ID</label>
						<label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Company Name"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Num of Orders"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Products Total"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Commission Total"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "5"; ?>"><?php echo "To Be Paid"; ?></label>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="search-form">
				<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
					<div class="row">
						<div class="col-md-3">
							<div class="form-dgroup">
								<label class="control-label">From Date</label>
								<input class="form-control  date-picker" size="16" type="text" value="<?php echo $displayFromDate ?>" name="from_date" id="from_date" readonly />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-dgroup">
								<label class="control-label">To Date</label>
								<input class="form-control  date-picker" size="16" type="text" value="<?php echo $displayToDate; ?>" name="to_date" id="to_date" readonly />
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
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Company"; ?></th>
						<th><?php echo "Num of Orders"; ?></th>
						<th><?php echo "Products Total"; ?></th>
						<th><?php echo "Commission Total"; ?></th>
						<th><?php echo "To Be Paid"; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($rc = 0; $rc < count($suppliers); $rc++) {
						$row = $suppliers[$rc];
						$status = 'paid';
						$ordersCount = $saleOrderItemMySqlExtA->getOrdersCount($row->id, $status, $fromDate, $toDate);
						$ordersTotalPrice = $saleOrderItemMySqlExtA->getOrdersPriceTotal($row->id, $status, $fromDate, $toDate);
						$ordersTotalCommission = $saleOrderItemMySqlExtA->getOrdersCommissionTotal($row->id, $status, $fromDate, $toDate); ?>
						<tr id="<?php echo $row->id; ?>">
							<!-- primary key -->
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->companyName; ?></td>
							<td><?php echo $ordersCount; ?></td>
							<td><?php echo number_format(floatval($ordersTotalPrice)) . " LBP"; ?></td>
							<td><?php echo number_format(floatval($ordersTotalCommission)) . " LBP"; ?></td>
							<td><?php echo number_format(floatval($ordersTotalPrice) - floatval($ordersTotalCommission)) . " LBP"; ?></td>
							<td>
								<a class="btn btn-xs yellow" href="<?php echo ADMIN_LINK .'display_orders.php?status=paid&supplier_id='.$row->id.'&from_date='.$displayFromDate.'&to_date='.$displayToDate.'&from_reports=1';?>">
									View Orders
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