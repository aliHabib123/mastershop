<?php
function main()
{
    $itemCategoryMySqlExtDAO = new ItemcategoryMySqlExtDAO();
    $orderBy = "desc";
    $fieldName = "a.`id`";
    if (isset($_REQUEST["orderBy"])) {
        $orderBy = $_REQUEST["orderBy"];
        $fieldName = $_REQUEST["fieldName"];
    }
    $condition = "";
    if (isset($_REQUEST["keywords"]) && !empty($_REQUEST["keywords"])) {
        $keywords = trim($_REQUEST["keywords"]);
        $condition .= " a.`name` like '%$keywords%' and ";
    }

    $subIdSet = false;
    $idIsSet = false;
    if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
        $id = trim($_REQUEST["id"]);
        if (isset($_REQUEST["subId"]) && !empty($_REQUEST["subId"])) {
            $subId = trim($_REQUEST["subId"]);
            $condition .= " a.`parent_id` = '$subId' and ";
            $subIdSet = true;
        } else {
            $condition .= " a.`parent_id` = '$id' and ";
        }
        $idIsSet = true;
    } else {
        $condition .= " a.`parent_id` = '0' and ";
    }

	$condition .= " a.`lang_id` = 1 AND ";

    $condition .= " 1 order by $fieldName $orderBy ";

    // paging
    $limit = 10000;
    $offset = 0;

    if (isset($_REQUEST["page"]) && !empty($_REQUEST["page"])) {
        $page = $_REQUEST["page"];
        $offset = ($page - 1) * $limit;
    }


    $condition .= " limit $limit offset $offset ";
    $records = $itemCategoryMySqlExtDAO->select($condition); ?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-globe"></i>CATEGORIES MANAGEMENT
			</div>
			<div class="actions">
				<div class="btn-group">
					<a class="btn default" href="#" data-toggle="dropdown">
						Columns
						<i class="fa fa-angle-down"></i>
					</a>
					<div id="sample_2_column_toggler" class="dropdown-menu hold-on-click dropdown-checkboxes pull-right">
						<label><input type="checkbox" checked data-column="0">ID</label>
						<label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Name"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Arabic Name"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Image"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Parent"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "5"; ?>"><?php echo "Display Order"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "6"; ?>"><?php echo "Active"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "7"; ?>"><?php echo "Featured"; ?></label>
					</div>
				</div>
				<div class="btn-group">
					<?php
                    $queryParams = "";
    if ($idIsSet) {
        $queryParams = "?id=" . $id;
    }
    if ($subIdSet) {
        $queryParams .= "&subId=" . $subId;
    } ?>
					<a id="sample_editable_1_new" class="btn green" href="new_item_category.php<?php echo $queryParams; ?>">
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
						<th><?php echo "Name"; ?></th>
						<th><?php echo "Arabic Name"; ?></th>
						<th><?php echo "Image"; ?></th>
						<th><?php echo "Parent"; ?></th>
						<th><?php echo "Display Order"; ?></th>
						<th><?php echo "Active"; ?></th>
						<th><?php echo "Featured"; ?></th>
						<th></th>
						<th></th>
						<th></th>
						<?php if (!$subIdSet) {?>
							<th></th>
							<?php } ?>
					</tr>
				</thead>
				<tbody>

					<?php
                    for ($rc = 0; $rc < count($records); $rc++) {
                        $row = $records[$rc]; ?>
						<tr id="<?php echo $row->id; ?>">
							<!-- primary key -->
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->name ?></td>
							<td><?php echo $row->arabicName ?></td>
							<td align="center">
								<?php if ($row->image) { ?>
									<img style="max-height: 70px;" src="<?php echo IMAGES_LINK . $row->image ?>" />
								<?php } else { ?>
									<i style="color:red;" class="fas fa-times"></i>
								<?php } ?>
							</td>
							<td align="center"><?php echo $row->parentId; ?></td>
							<td align="center"><?php echo $row->displayOrder; ?></td>
							<td align="center"><?php echo $row->active == 1 ? '<i style="color:green" class="fas fa-check"></i>' : '<i style="color:red;" class="fas fa-times"></i>' ; ?></td>
							<td align="center"><?php echo $row->isFeatured == 1 ? '<i style="color:green" class="fas fa-check"></i>' : '<i style="color:red;" class="fas fa-times"></i>'; ?></td>

							<td>
								<a class="btn btn-xs yellow" href="edit_item_category.php?id=<?php echo $row->id; ?>">
									Edit
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td>
								<a class="btn btn-xs yellow" href="translate_item_category.php?id=<?php echo $row->id; ?>">
									Edit Translation
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td>
								<a class="btn btn-xs red" href="javascript:deleteAjax('item_category', '<?php echo $row->id; ?>')">
									<i class="fa fa-times"></i>
									Delete
								</a>
							</td>
							<?php
                            $queryParamsArray1 = [];
                        if ($idIsSet) {
                            $queryParamsArray1['id'] = $_REQUEST['id'];
                            $queryParamsArray1['subId'] = $row->id;
                        } else {
                            $queryParamsArray1['id'] = $row->id;
                        }
                        $queryString1 = http_build_query($queryParamsArray1); ?>
							<?php if (!$subIdSet) {?>
							<td>
								<a class="btn btn-xs green" href="display_item_category.php?<?php echo $queryString1; ?>">
									<i class="fa fa-picture-o"></i>
									Sub Categories
								</a>
							</td>
							<?php } ?>
						</tr>
					<?php
                    } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php
}

function breadCrumbs()
{
    $itemCategoryMySqlExtDAO = new ItemcategoryMySqlExtDAO();
    $idSet = false;
    if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
        $idSet = true;
    }
    $subIdSet = false;
    if (isset($_REQUEST["subId"]) && !empty($_REQUEST["subId"])) {
        $subIdSet = true;
    } ?>
	<ul class="page-breadcrumb breadcrumb">

		<!-- <li class="btn-group">
	<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
	<span>Actions</span> <i class="fa fa-angle-down"></i>
	</button>
	<ul class="dropdown-menu pull-right" role="menu">
		<li><a href="#">Action</a></li>
		<li><a href="#">Another action</a></li>
		<li><a href="#">Something else here</a></li>
		<li class="divider"></li>
		<li><a href="#">Separated link</a></li>
	</ul>
</li> -->



		<li>
			<a href="display_item_category.php">Categories</a>
			<?php if ($idSet) { ?><i class="fa fa-angle-right"></i><?php } ?>
		</li>

		<?php if ($idSet) {
        $categoryInfo = $itemCategoryMySqlExtDAO->load($_REQUEST['id']); ?>
			<li>
				<a href="display_item_category.php?id=<?php echo $_REQUEST['id']; ?>"><?php echo $categoryInfo->name; ?></a>
				<?php if ($subIdSet) { ?><i class="fa fa-angle-right"></i><?php } ?>
			</li>
		<?php
    } ?>
		<?php if ($subIdSet) {
        $subCategoryInfo = $itemCategoryMySqlExtDAO->load($_REQUEST['subId']); ?>
			<li><a href="display_item_category.php?id=<?php echo $_REQUEST['id']; ?>&subId=<?php echo $_REQUEST['subId']; ?>"><?php echo $subCategoryInfo->name; ?></a></li>
		<?php
    } ?>

	</ul>
<?php
}
include "template.php"; ?>