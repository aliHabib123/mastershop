<?php
require "session_start.php";
function main()
{
	$id = $_REQUEST["id"];
	$itemBrandMySqlExtDAO = new ItemBrandMySqlExtDAO();
	$res = $itemBrandMySqlExtDAO->load($id); ?>
	<link href="css/css.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="javascript/pop_up.js"></script>
	<script language="JavaScript" type="text/javascript" src="javascript/delete_file_confirmation.js"></script>
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Edit Brand</div>
		</div>
		<div class="portlet-body form">
			<form action="update_item_brand.php" method="post" enctype="multipart/form-data" name="frm" id="frm" class="form-horizontal form-bordered">
				<div class="form-body">
					<input name="id" type="hidden" value="<?php echo $res->id ?>" />

					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-3">
							<input name="name" type="text" class="form-control" id="name" value="<?php echo stripslashes($res->name) ?>" placeholder="Enter Brand Name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Cover image</label>
						<div class="col-md-9">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: auto;">
									<?php
									if (is_file(IMAGES_PATH . $res->image)) { ?>
										<img src="<?php echo IMAGES_PATH . $res->image ?>" alt="<?php echo $res->image ?>" />
									<?php } ?>
									<input type="hidden" value="<?php echo $res->image; ?>" name="current_image" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
								<div>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" class="default" name="image" id="image" />
									</span>
									<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div>
							<span>170 * 70 px</span>
						</div>
					</div>

					<div class="form-group">
						<?php
						$categoriesMySqlExtDAO = new ItemCategoryMySqlExtDAO();
						$categories = $categoriesMySqlExtDAO->select('parent_id = 0');
						$brandCategoryMappingMySqlExtDAO = DAOFactory::getBrandCategoryMappingDAO();
						$brandCatgeoryMapping = $brandCategoryMappingMySqlExtDAO->queryByBrandId($res->id);
						$brandCatgeoryMapping = array_map(function ($a) {
							return $a->categoryId;
						}, $brandCatgeoryMapping); ?>
						<label class="control-label col-md-3">Type</label>
						<div class="col-md-4">
							<select class="form-control select2me" data-placeholder="Select..." name="categories[]" id="categories" multiple>
								<?php
								foreach ($categories as $row) {
									$sel = "";
									if (in_array($row->id, $brandCatgeoryMapping)) {
										$sel = "selected";
									} ?>
									<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>><?php echo $row->name; ?></option>
								<?php
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Display Order</label>
						<div class="col-md-3">
							<input name="display_order" type="number" class="form-control" id="display_order" value="<?php echo $res->displayOrder ?>" placeholder="Ex: 1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Show In Menu</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="show_in_menu" <?php if ($res->showInMenu == "1") { echo "checked"; } ?> />
							</div>
						</div>
					</div>

					<br />
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
								<button type="button" class="btn default" onclick="javascript:if(confirm('Are you sure you want to leave this page?')) history.back()">Cancel</button>
							</div>
						</div>
					</div>
					<br />
				</div> <!-- end div form body-->
			</form>
		<?php
	}
	include "template.php"; ?>