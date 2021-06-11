<?php
function main()
{
	$limit = 10000;
	$offset = 0;
	$orderBy = "desc";
	$fieldName = "a.`id`";

	$itemMySqlExtDAO = new ItemMySqlExtDAO();
	$supplierMySqlExtDAO = new UserMySqlExtDAO();

	$supplierId = isset($_GET['supplier_id']) && !empty($_GET['supplier_id']) ? filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT) : false;
	$suppliers = $supplierMySqlExtDAO->select("user_type = 2 and status IN  ('active', 'inactive')");


	$condition = " b.`status` IN ('active', 'inactive') AND";
	if (isset($_GET["orderBy"])) {
		$orderBy = $_GET["orderBy"];
		$fieldName = $_GET["fieldName"];
	}

	if ($supplierId) {
		$condition = " a.`supplier_id`= '$supplierId' AND";
	}

	$condition .= " 1 order by $fieldName $orderBy ";



	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}


	$condition .= " limit $limit offset $offset ";
	$records = $itemMySqlExtDAO->adminGetItems($condition);
	//print_r($records);
?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				PRODUCTS MANAGEMENT
				<!--
				<form name="myform223" action="<?php //echo $_SERVER['PHP_SELF'] 
												?>" method="post">
					<div>
						Search by banner caption: 
						<input type="text" value="<?php //echo $keywords 
													?>" name="keywords" id="keywords" style="width:300px; height:20px;"> &nbsp; 
						<input type="submit" style="" value="   Search   " />
					</div>
				</form>
				-->
			</div>
			<div class="actions">
				<div class="btn-group">
					<a class="btn default" href="#" data-toggle="dropdown">
						Columns
						<i class="fa fa-angle-down"></i>
					</a>
					<div id="sample_2_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
						<label><input type="checkbox" checked data-column="0">ID</label>
						<label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Title"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Image"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Supplier"; ?></label></label>
					</div>
				</div>
				<!-- <div class="btn-group">
					<a id="sample_editable_1_new" class="btn green" href="new_page.php">
						Add New <i class="fa fa-plus"></i>
					</a>
				</div> -->
			</div>
		</div>
		<div class="portlet-body">
			<div class="search-form">
				<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>">
					<div class="form-group">
						<?php
						?>

						<div class="col-md-4">
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
					</div>
					<button type="submit" class="btn btn-primary">Filter</button>
				</form>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Title"; ?></th>
						<th><?php echo "Image"; ?></th>
						<th><?php echo "Supplier"; ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
					for ($rc = 0; $rc < count($records); $rc++) {
						$row = $records[$rc];
					?>
						<tr id="<?php echo $row->id; ?>">
							<!-- primary key -->
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->title ?></td>
							<td><img style="max-height: 100px;" src="<?php echo IMAGES_LINK . $row->image ?>" /></td>
							<td><?php echo $row->companyName; ?></td>
							<td>
								<a class="btn btn-xs yellow" href="edit_product.php?id=<?php echo $row->id; ?>">
									Edit
									<i class="fa fa-edit"></i>
								</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php  }
include "template.php"; ?>