<?php
function main()
{
    $bannerImageMySqlExtDAO = new BannerImageMySqlExtDAO();
    $orderBy = "desc";
    $fieldName = "id";
    if (isset($_REQUEST["orderBy"])) {
        $orderBy = $_REQUEST["orderBy"];
        $fieldName = $_REQUEST["fieldName"];
    }
    $condition = "";
    if (isset($_REQUEST["keywords"]) && !empty($_REQUEST["keywords"])) {
        $keywords = trim($_REQUEST["keywords"]);
        $condition .= " title like '%$keywords%' and ";
    }

	if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])) {
        $id = trim($_REQUEST["id"]);
        $condition .= " banner_id = $id and ";
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
    $records = $bannerImageMySqlExtDAO->select($condition); ?>
	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-globe"></i>BANNER IMAGE MANAGEMENT
				<!--
				<form name="myform223" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
					<div>
						Search by banner caption: 
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
						<label><input type="checkbox" checked data-column="0">ID</label>
						<label><input type="checkbox" checked data-column="<?php echo "1"; ?>"><?php echo "Image"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "2"; ?>"><?php echo "Caption 1"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "3"; ?>"><?php echo "Caption 2"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "4"; ?>"><?php echo "Buttton Text"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "5"; ?>"><?php echo "Button Link"; ?></label>
						<label><input type="checkbox" checked data-column="<?php echo "6"; ?>"><?php echo "Parent Banner"; ?></label>
					</div>
				</div>
				<div class="btn-group">
					<a id="sample_editable_1_new" class="btn green" href="new_banner_image.php">
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
						<th><?php echo "Image"; ?></th>
						<th><?php echo "Caption 1"; ?></th>
						<th><?php echo "Caption 2"; ?></th>
						<th><?php echo "Button Text"; ?></th>
						<th><?php echo "Button Link"; ?></th>
						<th><?php echo "Parent Banner"; ?></th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<?php
                    for ($rc = 0; $rc < count($records); $rc++) {
                        $banner = $records[$rc]; ?>
						<tr id="<?php echo $banner->id; ?>">
							<!-- primary key -->
							<td><?php echo $banner->id; ?></td>
							<td><img style="max-height: 100px;" src="<?php echo IMAGES_LINK.$banner->imageName?>"/></td>
							<td><?php echo $banner->caption1; ?></td>
							<td><?php echo $banner->caption2; ?></td>
							
							<td><?php echo $banner->buttonText; ?></td>
							<td><?php echo $banner->buttonLink; ?></td>
							<td><?php echo $banner->bannerId; ?></td>

							<td>
								<a class="btn btn-xs yellow" href="edit_banner_image.php?id=<?php echo $banner->id; ?>">
									Edit
									<i class="fa fa-edit"></i>
								</a>
							</td>
							<td>
								<a class="btn btn-xs red" href="javascript:deleteAjax('banner_image', '<?php echo $banner->id; ?>')">
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