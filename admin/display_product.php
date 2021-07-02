<?php
function main()
{
	global $currentPage;
	global $totalPages;
	global $currentPageUrl;
	$currentPageUrl = ADMIN_LINK . 'display_product.php';

	$limit = 25;
	$offset = 0;
	$orderBy = "desc";
	$fieldName = "a.`id`";
	$page = 1;

	$itemMySqlExtDAO = new ItemMySqlExtDAO();
	$supplierMySqlExtDAO = new UserMySqlExtDAO();
	$itemTagMySqlExtDAO = new ItemTagMySqlExtDAO();
	$categoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();

	$supplierId = isset($_GET['supplier_id']) && !empty($_GET['supplier_id']) ? filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT) : false;
	$suppliers = $supplierMySqlExtDAO->select("user_type = 2 and status IN  ('active', 'inactive')");

	$tagId = isset($_GET['tag_id']) && !empty($_GET['tag_id']) ? filter_var($_GET['tag_id'], FILTER_SANITIZE_NUMBER_INT) : false;
	$tags = $itemTagMySqlExtDAO->queryByType('static');

	$categoryId = isset($_GET['category_id']) && !empty($_GET['category_id']) ? filter_var($_GET['category_id'], FILTER_SANITIZE_NUMBER_INT) : false;

	$level1Categories = $categoryMySqlExtDAO->select('parent_id = 0 ORDER BY display_order ASC, name ASC, id DESC');

	$condition = " b.`status` IN ('active', 'inactive') AND";
	if (isset($_GET["orderBy"])) {
		$orderBy = $_GET["orderBy"];
		$fieldName = $_GET["fieldName"];
	}

	if ($supplierId) {
		$condition .= " a.`supplier_id`= '$supplierId' AND";
	}

	if ($tagId) {
		$condition .= " c.`tag_id`= '$tagId' AND";
	}

	$selectedCategory = "";
	if ($categoryId) {
		$categoryArray = explode('-', $categoryId);
		$selectedCategory = $categoryArray[0];
		if (count($categoryArray) == 3) {
			$condition .= " d.`category_id`= '$selectedCategory' AND";
		} elseif (count($categoryArray) == 2) {
			$categoriesLevel2 = $categoryMySqlExtDAO->select("parent_id = '" . $categoryArray[0] . "'");
			$inCategoryArray = [];
			foreach ($categoriesLevel2 as $row) {
				array_push($inCategoryArray, $row->id);
			}
			$condition .= " d.`category_id` IN (" . implode(',', $inCategoryArray) . ") AND";
		} else {
			$categoriesLevel2 = $categoryMySqlExtDAO->select("parent_id = " . $categoryArray[0]);
			$inCategoryArray = [];
			foreach ($categoriesLevel2 as $row) {
				//array_push($inCategoryArray, $row->id);
				$categoriesLevel3 = $categoryMySqlExtDAO->select("parent_id = " . $row->id);
				foreach ($categoriesLevel3 as $row1) {
					array_push($inCategoryArray, $row1->id);
				}
			}
			$condition .= " d.`category_id` IN (" . implode(',', $inCategoryArray) . ") AND";
		}
	}

	$condition .= " 1 GROUP BY a.`id` order by $fieldName $orderBy";

	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}

	$currentPage = $page;
	$recordsCount = count($itemMySqlExtDAO->adminGetItems($condition));
	$totalPages = ceil($recordsCount / $limit);
	$condition .= " limit $limit offset $offset ";
	$records = $itemMySqlExtDAO->adminGetItems($condition);
?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				PRODUCTS MANAGEMENT
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
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Price"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Sale Price"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Image"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "5"; ?>"><?php echo "Supplier"; ?></label></label>
					</div>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<div class="search-form">
				<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>">
					<div class="form-group">
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
							<label class="control-label">Tag</label>
							<select class="form-control select2me" data-placeholder="Select Tag..." name="tag_id" id="tag_id">
								<option selected="selected" value="">--- Select Tag ---</option>
								<?php
								foreach ($tags as $row) {
									//echo $row->id."<br>";
									$sel = "";
									if ($row->id == $tagId) {
										$sel = "selected";
									} ?>
									<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>><?php echo $row->name; ?></option>
								<?php
								} ?>
							</select>
						</div>
						<div class="col-md-6">
							<label class="control-label">Category</label>
							<select class="form-control select2me" data-placeholder="Select Supplier..." name="category_id" id="category_id">
								<option selected="selected" value="">--- Select Supplier ---</option>
								<?php
								foreach ($level1Categories as $row) {
									//echo $row->id."<br>";
									$sel = "";
									if ($row->id == $selectedCategory) {
										$sel = "selected";
									} ?>
									<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>><?php echo $row->name; ?></option>
									<?php $level2Categories = $categoryMySqlExtDAO->select("parent_id = $row->id and active = 1 ORDER BY  name ASC, id DESC"); ?>
									<?php foreach ($level2Categories as $row2) {
										$sel = "";
										if ($row2->id == $selectedCategory) {
											$sel = "selected";
										} ?>
										<option value="<?php echo $row2->id . '-' . $row->id; ?>" <?php echo $sel; ?>><?php echo $row2->name . " <b>in (" . $row->name . ")</b>"; ?></option>
										<?php $level3Categories = $categoryMySqlExtDAO->select("parent_id = $row2->id and active = 1 ORDER BY name ASC, id DESC"); ?>
										<?php foreach ($level3Categories as $row3) {
											$sel = "";
											if ($row3->id == $selectedCategory) {
												$sel = "selected";
											} ?>
											<option value="<?php echo $row3->id . '-' .  $row2->id . '-' . $row->id; ?>" <?php echo $sel; ?>><?php echo $row3->name . " <b>in (" . $row2->name . ")" . " in (" . $row->name . ")</b>"; ?></option>
										<?php } ?>
									<?php } ?>
								<?php
								} ?>
							</select>
						</div>

					</div>
					<div class="form-group">

					</div>
					<button type="submit" class="btn btn-primary">Filter</button>
					<button type="button" onclick="window.location.href='<?php echo $currentPageUrl; ?>'" class="btn btn-primary">Reset Filters</button>
				</form>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Title"; ?></th>
						<th><?php echo "Price"; ?></th>
						<th><?php echo "Sale Price"; ?></th>
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
							<td align="center"><?php echo number_format(floatval($row->regularPrice)). " LBP"; ?></td>
							<td align="center"><?php echo $row->salePrice != 0 ? $row->salePrice : '<i style="color:red;" class="fas fa-times"></i>';?></td>
							<td><img style="max-height: 70px;" src="<?php echo IMAGES_LINK . $row->image ?>" /></td>
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
<?php  }
include "template.php"; ?>