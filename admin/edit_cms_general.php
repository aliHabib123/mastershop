<?php
 require "session_start.php";
include "class/Cms_general.php";
function main()
{
    include 'config.php';
    $id=$_SESSION["adminId"];
    $cms_general = Cms_general::selectById($id); ?>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><i class="fa fa-reorder"></i>Edit Cms general</div>
	</div>
	<div class="portlet-body form">
	<form action="update_cms_general.php" method="post" enctype="multipart/form-data" name="frm" id="frm"  class="form-horizontal form-bordered >
	<div class="form-body">
<input name="general_id" type="hidden" value="<?php echo $cms_general->general_id?>" />

	<div class="form-group">
		<label class="col-md-3 control-label">Site title</label>
		<div class="col-md-3">
			<input  name="site_title" type="text"  class="form-control" id="site_title" value="<?php echo stripslashes($cms_general->site_title)?>" placeholder="Enter Site title">
		</div>
	</div>	
		
	<div class="form-group">
		<label class="col-md-3 control-label">Email</label>
		<div class="col-md-3">
			<input  name="email" type="text"  class="form-control" id="email" value="<?php echo stripslashes($cms_general->email)?>" placeholder="Enter Email">
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