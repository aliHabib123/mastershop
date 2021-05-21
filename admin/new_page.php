<?php function main(){
	$translate = false;
	$pageId = 0;
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$pageId = $_GET['id'];
		$translate = true;
	}?>
		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><i class="fa fa-reorder"></i>Create Page</div>
	</div>
	<div class="portlet-body form">
	<form action="insert_page.php" method="post" enctype="multipart/form-data" name="frm" id="frm"  class="form-horizontal form-bordered">
	<div class="form-body">
				<input type="hidden" name="translation_id" value="<?php echo $pageId;?>"/>

	<div class="form-group">
		<label class="col-md-3 control-label">Title</label>
		<div class="col-md-3">
			<input  name="title" type="text"  class="form-control" id="title" value="" placeholder="Enter Page Title">
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
					<input type="file" class="default" name="image"   id="image"/>
					</span>
					<a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
      <label class="col-md-3 control-label">Details</label>
      	<div class="form-group">
	      <?php
	      	$fck = new FCKeditor ( "details");
			$fck->BasePath = "fckeditor/";
			$fck->Value = "";
			$fck->Config["EnterMode"] = "br"; 
			$fck->Create ();
	      ?>
		</div>
    </div>
	<div class="form-group" style="display:none">
		<label class="control-label col-md-3">Language</label>
		<div class="col-md-4">
			<select  class="form-control select2me" data-placeholder="Select..." name="lang" id="lang">
			<option selected="selected" value="0">--- Select Language ---</option>
			   <option value="1" <?php if(!$translate){echo 'selected';}?>>English</option>
			   <option value="2" <?php if($translate){echo 'selected';}?>>Arabic</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Display Order</label>
		<div class="col-md-3">
			<input  name="display_order" type="number"  class="form-control" id="title" value="0" placeholder="Ex: 1">
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
</div>
</div>
<?php  }include "template.php";?>