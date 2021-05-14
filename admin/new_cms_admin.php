<?php function main() {?>

		
<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption"><i class="fa fa-reorder"></i>Create Cms admin</div>
	</div>
	<div class="portlet-body form">
	<form action="insert_cms_admin.php" method="post" enctype="multipart/form-data" name="frm" id="frm"  class="form-horizontal form-bordered >
	<div class="form-body">
				

	<div class="form-group">
		<label class="col-md-3 control-label">Admin name</label>
		<div class="col-md-3">
			<input  name="admin_name" type="text"  class="form-control" id="admin_name" value="" placeholder="Enter Admin name">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">User name</label>
		<div class="col-md-3">
			<input  name="user_name" type="text"  class="form-control" id="user_name" value="" placeholder="Enter User name">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Password</label>
		<div class="col-md-4">
			<div class="input-group">
				<input type="password" class="form-control" placeholder="Password"  name="password" id="password">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label">Email</label>
		<div class="col-md-3">
			<input  name="email" type="text"  class="form-control" id="email" value="" placeholder="Enter Email">
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