<?php
function main()
{
	$itemMySqlExtDAO = new ItemMySqlExtDAO();
	$supplierMySqlExtDAO = new UserMySqlExtDAO();
	$supplierArray = $supplierMySqlExtDAO->select('user_type = 2');
	$suppliers = [];
	foreach($supplierArray as $row){
		$suppliers[$row->id] = $row->companyName;
	}
	//print_r($suppliers);
	$orderBy = "desc";
	$fieldName = "id";
	$condition = "";
	if (isset($_REQUEST["orderBy"])) {
		$orderBy = $_REQUEST["orderBy"];
		$fieldName = $_REQUEST["fieldName"];
	}
	//$condition = " type = '$contentType' and lang = 1 and ";
	if (isset($_REQUEST["keywords"]) && !empty($_REQUEST["keywords"])) {
		$keywords = trim($_REQUEST["keywords"]);
		//$condition .= " title like '%$keywords%' and ";
	}

	$condition .= " 1 order by $fieldName $orderBy ";

	// paging
	$limit = 10000;
	$offset = 0;

	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}


	$condition .= " limit $limit offset $offset ";
	$records = $itemMySqlExtDAO->select($condition);
	?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-globe"></i>PRODUCTS MANAGEMENT
				<!--
				<form name="myform223" action="<?php //echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						Search by banner caption: 
						<input type="text" value="<?php //echo $keywords ?>" name="keywords" id="keywords" style="width:300px; height:20px;"> &nbsp; 
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
							<td><?php echo $row->title?></td>
							<td><img style="max-height: 100px;" src="<?php echo IMAGES_LINK.$row->image?>"/></td>
							<td><?php echo $suppliers[$row->supplierId]; ?></td>
							<td>
								<a class="btn btn-xs yellow" href="edit_product.php?id=<?php echo $row->id;?>">
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