<?php
require "session_start.php";
function main()
{
	$id = $_REQUEST["id"];
	$itemCategoryMySqlExtDAO = new ItemcategoryMySqlExtDAO();
	$allCategories = $itemCategoryMySqlExtDAO->queryAllOrderBy('name DESC');
	$category = $itemCategoryMySqlExtDAO->load($id); ?>
	<link href="css/css.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="javascript/pop_up.js"></script>
	<script language="JavaScript" type="text/javascript" src="javascript/delete_file_confirmation.js"></script>
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Edit Item Category</div>
		</div>
		<div class="portlet-body form">
			<form action="update_item_category.php" method="post" enctype="multipart/form-data" name="frm" id="frm" class="form-horizontal form-bordered">
				<div class="form-body">
					<input name="id" type="hidden" value="<?php echo $category->id;?>" />
					<input name="slug" type="hidden" value="<?php echo $category->slug; ?>" />

					<div class="form-group">
						<label class="col-md-3 control-label">Name</label>
						<div class="col-md-3">
							<input name="name" type="text" class="form-control" id="title" value="<?php echo stripslashes($category->name) ?>" placeholder="Enter Category Name">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Image</label>
						<div class="col-md-9">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<?php
									if (is_file(IMAGES_PATH . $category->image)) { ?>
										<img src="<?php echo IMAGES_PATH . $category->image ?>" alt="<?php echo $category->image ?>" />
									<?php } ?>
									<input type="hidden" value="<?php echo $category->image; ?>" name="current_image" />
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
									<?php
									if (is_file(IMAGES_PATH . $category->bannerImage)) { ?>
										<img src="<?php echo IMAGES_PATH . $category->bannerImage ?>" alt="<?php echo $category->bannerImage ?>" />
									<?php } ?>
									<input type="hidden" value="<?php echo $category->bannerImage; ?>" name="current_banner_image" />
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
						<label class="col-md-3 control-label">Is Active</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="active" <?php if ($category->active == "1") { echo "checked"; } ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Featured</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="is_featured" <?php if ($category->isFeatured == "1") { echo "checked"; } ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Parent Category</label>
						<div class="col-md-4">
							<select  class="form-control select2me" data-placeholder="Select..." name="parent_id" id="parent_id">
							<option selected="selected" value="0">--- None ---</option>
							<?php 
							foreach($allCategories as $row){
								$sel ="";
								if($row->id == $category->parentId){
									$sel ="selected";
								}?>
								<option value="<?php echo $row->id;?>" <?php echo $sel;?>><?php echo $row->name;?></option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Display Order</label>
						<div class="col-md-3">
							<input name="display_order" type="number" class="form-control" id="display_order" value="<?php echo $category->displayOrder ?>" placeholder="Ex: 1">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Mega Menu Display Order</label>
						<div class="col-md-3">
							<input name="mega_menu_display_order" type="number" class="form-control" id="mega_menu_display_order" value="<?php echo $category->megaMenuDisplayOrder;?>" placeholder="Ex: 1">
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