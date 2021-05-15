<?php

function main()
{
	$userMySqlExtDAO = new UserMySqlExtDAO();
	$orderBy = "desc";
	$fieldName = "id";
	if (isset($_REQUEST["orderBy"])) {
		$orderBy = $_REQUEST["orderBy"];
		$fieldName = $_REQUEST["fieldName"];
	}
	$condition = "";
	if (isset($_REQUEST["keywords"]) && !empty($_REQUEST["keywords"])) {
		$keywords = trim($_REQUEST["keywords"]);
		$condition .= " (first_name like '%$keywords%' OR last_name like '%$keywords%' OR middle_name like '%$keywords%') and ";
	}

	$condition .= " 1 order by $fieldName $orderBy ";

	// paging
	$limit = 1125;
	$offset = 0;
	if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
		$page = $_REQUEST["page"];
		$offset = ($page - 1) * $limit;
	}

	$condition .= " limit $limit offset $offset ";
	$records = $userMySqlExtDAO->select($condition); ?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-globe"></i>CMS ADMIN MANAGEMENT
				<!--
				<form name="myform223" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						Search by admin name: 
						<input type="text" value="<?php echo $keywords ?>" name="keywords" id="keywords" style="width:300px; height:20px;"> &nbsp; 
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
						<label><input type="checkbox" checked data-column="0">ID</label><label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Admin name"; ?></label><label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "User name"; ?></label><label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Password"; ?></label><label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Email"; ?></label>
					</div>
				</div>
				<div class="btn-group">
					<a id="sample_editable_1_new" class="btn green" href="new_cms_admin.php">
						Add New <i class="fa fa-plus"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php echo "Admin name"; ?></th>
						<th><?php echo "Email"; ?></th>
						<th></th>
						<th></th>

					</tr>
				</thead>
				<tbody>

					<?php

					for ($rc = 0; $rc < count($records); $rc++) {
						$cms_admin = $records[$rc]; ?>
						<tr id="<?php echo $cms_admin->id; ?>">
							<!-- primary key -->
							<td><?php echo $cms_admin->id; ?></td>
							<td><?php echo $cms_admin->firstName; ?></td>
							<td><?php echo $cms_admin->email ?></td>

							<td>
								<a class="btn btn-xs yellow" href="edit_cms_admin.php?id=<?php echo $cms_admin->id ?>">
									Edit
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td>
								<a class="btn btn-xs red" href="javascript:deleteAjax('cms_admin', '<?php echo $cms_admin->id; ?>')">
									<i class="fa fa-times"></i>
									Delete
								</a>
							</td>
						</tr>
					<?php
					} ?>
				</tbody>
			</table>
		</div>
	</div>
<?php
}
include "template.php"; ?>