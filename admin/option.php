<?php function main()
{
	$optionMySqlExtDAO = new OptionsMySqlExtDAO();
	$id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;
	$option = $optionMySqlExtDAO->load($id);
	$admin_name =  $option->adminName;
	$name =  $option->name;
	$value =  $option->type == 1 ? $option->value : $option->valueText;
?>

	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Edit Option <?php echo $name; ?></div>
		</div>
		<div class="portlet-body form">
			<div class="notice-area"></div>
			<form action="update_option.php" method="post" enctype="multipart/form-data" name="frm" id="options-form" class="form-horizontal form-bordered">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Option Name*</label>
						<div class="col-md-9">
							<input readonly name="company_name" type="text" class="form-control required" id="name" value="<?php echo $name; ?>" placeholder="">
						</div>
					</div>
					<?php if ($option->type == 1) { ?>
						<div class="form-group">
							<label class="col-md-3 control-label">Option Value*</label>
							<div class="col-md-3">
								<input name="value" type="text" class="form-control" id="first_name required" value="<?php echo $value; ?>" placeholder="Enter Value">
							</div>
						</div>
					<?php } else { ?>
						<div class="form-group">
							<label class="col-md-3 control-label">Option Value*</label>
							<div class="form-group">
								<?php
								$fck = new FCKeditor("value");
								$fck->BasePath = "fckeditor/";
								$fck->Value = $value;
								$fck->Config["EnterMode"] = "br";
								$fck->Create(); ?>
							</div>
						</div>
					<?php } ?>


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