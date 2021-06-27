<?php
require "session_start.php";
function main()
{
	$id = $_REQUEST["id"];
	$itemMySqlExtDAO = new ItemMySqlExtDAO();
	$itemTagMappingMySqlExtDAO = new ItemTagMappingMySqlExtDAO();
	$mapping = $itemTagMappingMySqlExtDAO->queryByItemId($id);
	$tags = [
		'todays-deals' => false,
		'latest-arrivals' => false,
		'picked-for-you' => false,
		'best-offers' => false,
		'spotlight' => false,
		'promotions' => false,
	];
	foreach ($mapping as $map) {
		if ($map->tagId == 1) {
			$tags['todays-deals'] = true;
		}
		if ($map->tagId == 2) {
			$tags['latest-arrivals'] = true;
		}
		if ($map->tagId == 3) {
			$tags['picked-for-you'] = true;
		}
		if ($map->tagId == 5) {
			$tags['best-offers'] = true;
		}
		if ($map->tagId == 6) {
			$tags['spotlight'] = true;
		}
		if ($map->tagId == 7) {
			$tags['promotions'] = true;
		}
	}
	$item = $itemMySqlExtDAO->load($id);
?>
	<link href="css/css.css" rel="stylesheet" type="text/css" />
	<script language="JavaScript" type="text/javascript" src="javascript/pop_up.js"></script>
	<script language="JavaScript" type="text/javascript" src="javascript/delete_file_confirmation.js"></script>
	<div class="portlet box green">
		<div class="portlet-title">
			<div class="caption"><i class="fa fa-reorder"></i>Edit Product</div>
		</div>
		<div class="portlet-body form">
			<form action="update_product.php" method="post" enctype="multipart/form-data" name="frm" id="frm" class="form-horizontal form-bordered">
				<div class="form-body">
					<input name="id" type="hidden" value="<?php echo $item->id ?>" />
					<input name="slug" type="hidden" value="<?php echo $item->slug ?>" />

					<div class="form-group">
						<label class="col-md-3 control-label">Title</label>
						<div class="col-md-9">
							<input readonly name="title" type="text" class="form-control" id="title" value="<?php echo stripslashes($item->title) ?>" placeholder="Enter Page title">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Image</label>
						<div class="col-md-9">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
									<?php
									if (is_file(IMAGES_PATH . $item->image)) { ?>
										<img src="<?php echo IMAGES_PATH . $item->image ?>" alt="<?php echo $item->image ?>" />
									<?php } ?>
									<input type="hidden" value="<?php echo $item->image; ?>" name="current_image" />
								</div>
								<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Is Todays Deals</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="todays_deals" <?php if ($tags['todays-deals']) {
																								echo "checked";
																							} ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Latest Arrivals</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="latest_arrivals" <?php if ($tags['latest-arrivals']) {
																									echo "checked";
																								} ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Picked For You</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="picked_for_you" <?php if ($tags['picked-for-you']) {
																								echo "checked";
																							} ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Best Offers</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="best_offers" <?php if ($tags['best-offers']) {
																								echo "checked";
																							} ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Spotlight</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="spotlight" <?php if ($tags['spotlight']) {
																							echo "checked";
																						} ?> />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Is Promotions</label>
						<div class="col-md-9">
							<div class="make-switch" data-on="warning" data-off="danger">
								<input type="checkbox" class="toggle" name="promotions" <?php if ($tags['promotions']) {
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
		<?php
	}
	include "template.php"; ?>