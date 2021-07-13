<?php function main()
{
	$userMySqlExtDAO = new UserMySqlExtDAO();
	$id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : 0;
	$action = filter_var($_GET['action'], FILTER_SANITIZE_STRING);
	if ($id != 0) {
		$userInfo = $userMySqlExtDAO->load($id);
	}
	$companyName = ($action == 'edit') ? $userInfo->companyName : "";
	$firstName = ($action == 'edit') ? $userInfo->firstName : "";
	$middleName = ($action == 'edit') ? $userInfo->middleName : "";
	$lastName = ($action == 'edit') ? $userInfo->lastName : "";
	$email = ($action == 'edit') ? $userInfo->email : "";
	$mobile = ($action == 'edit') ? $userInfo->mobile : "";
	$tel1 = ($action == 'edit') ? $userInfo->tel1 : "";
	$tel2 = ($action == 'edit') ? $userInfo->tel2 : "";
	$commission = ($action == 'edit') ? $userInfo->companyCommission : "";
	$usd_exchange_rate = ($action == 'edit') ? $userInfo->usdExchangeRate : "";
	$active = ($action == 'edit') ? $userInfo->status : 'inactive';
?>

	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i><?php echo ucfirst($action) ?> Supplier</div>
		</div>
		<div class="portlet-body form">
			<div class="notice-area"></div>
			<form action="update_supplier.php" method="post" enctype="multipart/form-data" name="frm" id="supplier-form" class="form-horizontal form-bordered">
				<input type="hidden" name="action" value="<?php echo $action; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-3 control-label">Company Name*</label>
						<div class="col-md-3">
							<input name="company_name" type="text" class="form-control required" id="company_name" value="<?php echo $companyName; ?>" placeholder="Enter Company Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">First Name*</label>
						<div class="col-md-3">
							<input name="first_name" type="text" class="form-control" id="first_name required" value="<?php echo $firstName; ?>" placeholder="Enter First Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Middle Name</label>
						<div class="col-md-3">
							<input name="middle_name" type="text" class="form-control" id="middle_name" value="<?php echo $middleName; ?>" placeholder="Enter Middle Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Last Name*</label>
						<div class="col-md-3">
							<input name="last_name" type="text" class="form-control" id="last_name required" value="<?php echo $lastName; ?>" placeholder="Enter Last Name">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Email Address*</label>
						<div class="col-md-3">
							<input name="email" type="email" class="form-control required" id="email" value="<?php echo $email; ?>" placeholder="Enter Email Address">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Mobile Number</label>
						<div class="col-md-3">
							<input name="mobile" type="text" class="form-control" id="mobile" value="<?php echo $mobile; ?>" placeholder="Enter Mobile Number">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Work Number 1</label>
						<div class="col-md-3">
							<input name="tel1" type="text" class="form-control" id="tel1" value="<?php echo $tel1; ?>" placeholder="Enter Work Number 1">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Work Number 2</label>
						<div class="col-md-3">
							<input name="tel2" type="text" class="form-control" id="tel2" value="<?php echo $tel2; ?>" placeholder="Enter Work Number 2">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Commission in %*</label>
						<div class="col-md-3">
							<input name="commission" type="number" class="form-control" id="commission" value="<?php echo $commission; ?>" placeholder="Enter Commission in %">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">USD Exchange Rate*</label>
						<div class="col-md-3">
							<input name="usd_exchange_rate" type="number" class="form-control" id="usd_exchange_rate" value="<?php echo $usd_exchange_rate; ?>" placeholder="Enter USD exchange rate">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is active</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="active" <?php if ($active == 'active') {
																						echo "checked";
																					} ?> />
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