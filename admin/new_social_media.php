<?php function main(){?>
		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><i class="fa fa-reorder"></i>Create Social Media Item</div>
	</div>
	<div class="portlet-body form">
	<form action="insert_social_media.php" method="post" enctype="multipart/form-data" name="frm" id="frm"  class="form-horizontal form-bordered">
	<div class="form-body">

	<div class="form-group">
		<label class="col-md-3 control-label">Title</label>
		<div class="col-md-3">
			<input  name="title" type="text"  class="form-control" id="title" value="" placeholder="Enter Title">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Link</label>
		<div class="col-md-3">
			<input  name="custom_url" type="text"  class="form-control" id="custom_url" value="" placeholder="Enter Link">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Display Order</label>
		<div class="col-md-3">
			<input  name="display_order" type="number"  class="form-control" id="display_order" value="0" placeholder="Ex: 1">
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