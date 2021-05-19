<?php
 require "session_start.php";
function main()
{
    $id=$_REQUEST["id"];
    $bannerMySqlExtDAO = new BannerMySqlExtDAO();
    $banner = $bannerMySqlExtDAO->load($id); ?>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="javascript/pop_up.js"></script>
<script language="JavaScript" type="text/javascript" src="javascript/delete_file_confirmation.js"></script>
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><i class="fa fa-reorder"></i>Edit Banner</div>
	</div>
	<div class="portlet-body form">
	<form action="update_banner.php" method="post" enctype="multipart/form-data" name="frm" id="frm"  class="form-horizontal form-bordered">
	<div class="form-body">
<input name="id" type="hidden" value="<?php echo $banner->id?>" />

	<div class="form-group">
		<label class="col-md-3 control-label">Title</label>
		<div class="col-md-3">
			<input  name="title" type="text"  class="form-control" id="title" value="<?php echo stripslashes($banner->title)?>" placeholder="Enter Banner title">
		</div>
	</div>	
				
	<div class="form-group">
		<label class="col-md-3 control-label">Cover image</label>
		<div class="col-md-9">
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
					<?php
                    if (is_file(IMAGES_PATH.$banner->image)) {?>
					 	<img src="<?php echo IMAGES_PATH.$banner->image?>" alt="<?php echo $banner->image ?>" />
					<?php } ?> 
					<input type="hidden" value="<?php echo $banner->image; ?>" name="current_image"/>
				</div>
				<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
				<div>
					<span class="btn default btn-file">
					<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
					<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
					<input type="file" class="default" name="image"   id="image"/>
					</span>
					<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Is Active</label>
		<div class="col-md-9">
			<div class="make-switch" data-on="warning" data-off="danger">
				<input type="checkbox" class="toggle"  name="active" <?php if ($banner->active=="1") {
                        echo "checked";
                    } ?>/>
			</div>
		</div>
	</div>	
	
	<div class="form-group">
		<label class="control-label col-md-3">Page</label>
		<div class="col-md-4">
			<select  class="form-control select2me" data-placeholder="Select..." name="location" id="location">
			<option selected="selected" value="0">--- Select Location ---</option>
			<?php
            
            // $sql="select * from section ";
            // $result=mysqli_query ($_SESSION["db_conn"], $sql);
            // while($page=mysqli_fetch_object($result)){
            // 	if($page->section_id==$banner->locat)
            // 		$sel="Selected";
            // 			else
            // 		$sel="";
                ?>
				<option value="<?php echo '1'?>" <?php if ($banner->location=='1') {
                    echo 'selected';
                } ?>><?php echo 'Home page'; ?></option>
				<option value="<?php echo '2'?>" <?php if ($banner->location=='2') {
                    echo 'selected';
                } ?>><?php echo 'Another Location'; ?></option>
		   	<?php //}?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Display Order</label>
		<div class="col-md-3">
			<input  name="display_order" type="number"  class="form-control" id="title" value="<?php echo $banner->displayOrder ?>" placeholder="Ex: 1">
		</div>
	</div>
		
		
<br/>
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
					<button type="button" class="btn default"  onclick="javascript:if(confirm('Are you sure you want to leave this page?')) history.back()">Cancel</button>                              
				</div>
			</div>
		</div>
		<br/>
	</div> <!-- end div form body-->
</form>
<?php
}include "template.php";?>