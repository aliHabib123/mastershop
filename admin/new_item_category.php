<?php function main()
{
	$itemCategoryMySqlExtDAO = new ItemCategoryMySqlExtDAO();
	$allCategories = $itemCategoryMySqlExtDAO->queryAllOrderBy('name DESC');
	//print_r($_SESSION['companyId']);
?>



	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Create Category</div>
		</div>
		<div class="portlet-body form">
			<form action="insert_item_category.php" method="post" enctype="multipart/form-data" name="frm" id="frm" class="form-horizontal form-bordered">
				<?php
				$subParentID = (isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['subId']) && !empty($_REQUEST['subId'])) ? $_REQUEST['id'] : 0;
				?>
				<input type="hidden" name="main_parent_id" value="<?php echo $subParentID; ?>" />

				<div class="form-body">


					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-3">
							<input name="name" type="text" class="form-control" id="name" value="" placeholder="Enter Category Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Image</label>
						<div class="col-md-9">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<!-- <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> -->
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
							<span>245 * 245 px</span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Banner Image</label>
						<div class="col-md-9">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<!-- <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> -->
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
								<div>
									<span class="btn default btn-file">
										<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
										<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
										<input type="file" class="default" name="banner_image" id="banner_image" />
									</span>
									<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
								</div>
							</div>
							<span>1400 * 220 px</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Parent Category</label>
						<div class="col-md-4">
							<select class="form-control select2me" data-placeholder="Select..." name="parent_id" id="parent_id">
								<option selected="selected" value="0">--- None ---</option>
								<?php
								foreach ($allCategories as $row) {
									$sel = "";
									if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
										if (isset($_REQUEST['subId']) && !empty($_REQUEST['subId'])) {
											if ($_REQUEST['subId'] == $row->id) {
												$sel = "selected";
											}
										} else {
											if ($_REQUEST['id'] == $row->id) {
												$sel = "selected";
											}
										}
									}
								?>
									<option value="<?php echo $row->id; ?>" <?php echo $sel; ?>><?php echo $row->name; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Display Order</label>
						<div class="col-md-3">
							<input name="display_order" type="number" class="form-control" id="display_order" value="0" placeholder="Ex: 1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mega Menu Display Order</label>
						<div class="col-md-3">
							<input name="mega_menu_display_order" type="number" class="form-control" id="mega_menu_display_order" value="0" placeholder="Ex: 1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is active</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" checked class="toggle" name="active" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Featured</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="is_featured" />
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
		</div>
	</div>
<?php  }
include "template.php"; ?>