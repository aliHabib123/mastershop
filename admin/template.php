<?php
require "session_start.php";
include("fckeditor/fckeditor.php");
include "connect.php";
include "change_format.php";
include "config.php";
require_once '../module/Application/src/Model/include_dao.php';

if (isset($_REQUEST['act'])) {
	$act = $_REQUEST['act'];
	$sql = "select * from cms_msg where Msg_ID=$act";
	$result = mysqli_query($_SESSION['db_conn'], $sql);
	$msg = mysqli_fetch_array($result);
	$text = $msg['Msg_Description'];
	if ($act == 4) {
		$text = '<font color="red">' . $msg['Msg_Description'] . '</font>';
	}
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>CMS | By Thirteencube</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="MobileOptimized" content="320">
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="../public/fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap.css" />
	<!-- END PAGE LEVEL STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link href="assets/css/style-metronic.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
	<!-- END THEME STYLES -->
	<!-- IMAGE AND FILES -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<!-- SWITCH BUTTONS ON/OFF -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css" />
	<!-- DATE TIME -->
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />
	<link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />
	<script type="text/javascript">
		function deleteAjax(link, id) {
			if (confirm("You're going to delete this record and all relevant records\nAre you sure you want to proceed?") == false) {
				return;
			}
			$.ajax({
				type: "GET",
				url: 'delete_' + link + '.php?id=' + id,
				cache: false,
				success: function(data) {
					data = JSON.parse(data);
					if (data.status) {
						$('#' + id).fadeOut();
					} else {
						alert(data.msg);
					}
				}
			});

		}
	</script>
	<script type="text/javascript">
		const mainUrl = '<?php echo SITE_LINK; ?>';
		const adminUrl = '<?php echo ADMIN_LINK; ?>';
	</script>
</head>
<!-- END HEAD -->

<body class="page-header-fixed">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="header-inner">
			<!-- BEGIN LOGO -->
			<a class="navbar-brand" href="https://thirteencube.com" target="_blank">
				<img src="http://www.thirteencube.com/public/images/logo.png" alt="logo" class="img-responsive" />
			</a>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER -->
			<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<img src="assets/img/menu-toggler.png" alt="" />
			</a>
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						Welcome
						<span class="username"><?php echo $_SESSION['adminName'] ?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="edit_cms_admin.php"><i class="fa fa-user"></i> Change Password</a>
						</li>
						<!-- 
						<li>
							<a href="page_calendar.html"><i class="fa fa-calendar"></i> My Calendar</a>
						</li>
						-->
						<!-- <li><a href="edit_cms_general.php?id=1"><i class="fa fa-envelope"></i> Notification Email</a>
						</li> -->
						<!-- 
						<li>
							<a href="#"><i class="fa fa-tasks"></i> My Tasks <span class="badge badge-success">7</span></a>

						</li>
						-->
						<li class="divider"></li>
						<li><a href="javascript:;" id="trigger_fullscreen"><i class="fas fa-expand"></i> Full Screen</a>
						</li>
						<!-- 
						<li>
							<a href="extra_lock.html"><i class="fa fa-lock"></i> Lock Screen</a>
						</li> 
						-->
						<li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->

			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start active">
					<a href="main.php">
						<i class="fa fa-home"></i>
						<span class="title">Home</span>
					</a>
				</li>

				<li class="">
					<a href="display_banner.php">
						<i class="fas fa-pager"></i>
						<span class="title">Banners</span>
					</a>
				</li>

				<li class="">
					<a href="display_page.php">
						<i class="fas fa-columns"></i>
						<span class="title">Pages</span>
					</a>
				</li>
				<!-- <li class="">
					<a href="display_ad.php">
						<i class="fas fa-ad"></i>
						<span class="title">Ads</span>
					</a>
				</li> -->

				<li>
					<a class="active" href="javascript:;">
					<i class="fas fa-ad"></i>
					<span class="title">Ads</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<!-- <li>
							<a href="accounting_dashboard.php">
								Dashboard
							</a>
						</li> -->
						<li>
						<a href="display_ad.php">
								Homepage Ads
							</a>
						</li>
						<li>
						<a href="display_ad1.php">
								Inner Ads
							</a>
						</li>

					</ul>
				</li>

				<li class="">
					<a href="display_social_media.php">
						<i class="fas fa-share-alt"></i>
						<span class="title">Social Media</span>
					</a>
				</li>
				<li class="">
					<a href="display_supplier.php">
						<i class="fas fa-users"></i>
						<span class="title">Suppliers</span>
					</a>
				</li>
				<li class="">
					<a href="display_item_category.php">
						<i class="fas fa-object-group"></i>
						<span class="title">Categories</span>
					</a>
				</li>
				<li class="">
					<a href="display_item_brand.php">
						<i class="far fa-object-group"></i>
						<span class="title">Brands</span>
					</a>
				</li>
				<li class="">
					<a href="display_product.php">
						<i class="fas fa-store"></i>
						<span class="title">Products</span>
					</a>
				</li>
				<li class="">
					<a href="display_orders.php">
						<i class="fas fa-file-invoice-dollar"></i>
						<span class="title">Sale Orders</span>
					</a>
				</li>
				<li>
					<a class="active" href="javascript:;">
						<i class="fas fa-dollar-sign"></i>
						<span class="title">Accounting</span>
						<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<!-- <li>
							<a href="accounting_dashboard.php">
								Dashboard
							</a>
						</li> -->
						<li>
							<a href="display_reports.php">
								Reports
							</a>
						</li>

					</ul>
				</li>

				<li class="">
					<a href="display_options.php">
						<i class="fas fa-cogs"></i>
						<span class="title">Options</span>
					</a>
				</li>
			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->

		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title note note-info">YOUR WEBSITE CMS</h3>
					<?php if (isset($text) && $text != "") { ?>
						<div class="note note-success">
							<h4 class="block"><?php echo $text ?></h4>
						</div>
					<?php } ?>
					<?php
					if (function_exists('breadCrumbs')) {
						echo breadCrumbs();
					}
					?>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<?php echo main() ?>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->

	<!-- BEGIN FOOTER -->

	<div class="footer">
		<div class="footer-inner">
			<div><?php echo date('Y'); ?> &copy; Powered by <a href="http://thirteencube.com">Thirteencube</a> | All rights reserved </div>
		</div>
		<div class="footer-tools">
			<span class="go-top">
				<i class="fa fa-angle-up"></i>
			</span>
		</div>
	</div>

	<!-- END FOOTER -->

	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

	<!-- BEGIN CORE PLUGINS -->
	<!--[if lt IE 9]>
	<script src="assets/plugins/respond.min.js"></script>
	<script src="assets/plugins/excanvas.min.js"></script> 
	<![endif]-->
	<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap2-typeahead.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script type="text/javascript" src="assets/plugins/fuelux/js/spinner.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="assets/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery-multi-select/js/jquery.quicksearch.js"></script>
	<script src="assets/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
	<script src="assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->

	<script src="../public/js/twbs-pagination-master/jquery.twbsPagination.min.js"></script>
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="assets/scripts/app.js"></script>
	<script src="assets/scripts/form-components.js?v=1.0.0"></script>
	<!-- DATE TIME -->
	<script src="assets/scripts/table-advanced.js"></script>
	<script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>
	<!-- END PAGE LEVEL SCRIPTS -->

	<script>
		jQuery(document).ready(function() {
			// initiate layout and plugins
			App.init();
			FormComponents.init();
			TableAdvanced.init();
			/*
		   $('#sample_2').dataTable( {
		        "paging":   true,
		        "ordering": true,
		        "info":     true,
		        //"order": [[ 0, "desc" ]],
		        "scrollY":        "100px",
		        "scrollCollapse": true,
		  		stateSave: true,
		    } );
			   */
			//supplier-form
			$("#supplier-form").submit(function(e) {
				var formData = new FormData(this);
				var formUrl = $(this).attr("action");
				$.ajax({
					url: formUrl,
					type: "POST",
					dataType: "json",
					data: formData,
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						showMsg(".notice-area", true, "Updating user info...");
					},
					success: function(response) {
						console.log(response);
						showMsg(".notice-area", response.status, response.msg);
						$("html, body").animate({
								scrollTop: $(".notice-area").offset().top - 100
							},
							1000
						);
						if (response.status == true) {
							location.href = adminUrl + "display_supplier.php?act=3";
						} else {

						}
					},
					error: function() {
						showMsg(".notice-area", false, "An error occured, please try again!");
					},
				});
				e.preventDefault();
			});

			$("#options-form").submit(function(e) {
				var formData = new FormData(this);
				var formUrl = $(this).attr("action");
				$.ajax({
					url: formUrl,
					type: "POST",
					dataType: "json",
					data: formData,
					mimeType: "multipart/form-data",
					contentType: false,
					cache: false,
					processData: false,
					beforeSend: function() {
						showMsg(".notice-area", true, "Updating option ...");
					},
					success: function(response) {
						console.log(response);
						showMsg(".notice-area", response.status, response.msg);
						$("html, body").animate({
								scrollTop: $(".notice-area").offset().top - 100
							},
							1000
						);
						if (response.status == true) {
							location.href = adminUrl + "display_options.php?act=3";
						} else {

						}
					},
					error: function() {
						showMsg(".notice-area", false, "An error occured, please try again!");
					},
				});
				e.preventDefault();
			});
		});

		function showMsg(selector, status, msg) {
			let html = `<div class="${status ? "success" : "error"}">${msg}</div>`;
			$(selector).html(html);
		}
	</script>

	<!-- http://datatables.net/examples/styling/compact.html -->

	<!-- BEGIN GOOGLE RECAPTCHA -->

	<script type="text/javascript">
		var RecaptchaOptions = {
			theme: 'custom',
			custom_theme_widget: 'recaptcha_widget'
		};
	</script>
	<script type="text/javascript">
		if (document.getElementById("order-pagination")) {
			<?php
			global $currentPage;
			global $totalPages;
			global $currentPageUrl;
			$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$t = parse_url($url, PHP_URL_QUERY); # output "myqueryhash"
			parse_str($t, $output);
			unset($output['page']);
			$append = "";
			if ($output) {
				$append = '&' . http_build_query($output);
			}
			?>
			const append = '<?php echo $append; ?>';
			//alert(append);
			const currentPageUrl = '<?php echo $currentPageUrl ?>';
			jQuery(function() {
				jQuery("#order-pagination").twbsPagination({
					totalPages: <?php echo $totalPages; ?>,
					visiblePages: 7,
					first: "First",
					last: "Last",
					next: '>',
					prev: '<',
					startPage: <?php echo $currentPage; ?>,
					initiateStartPageClick: false,
					onPageClick: function(event, page) {
						location.href = currentPageUrl + "?page=" + page + append;
					},
				});
			});
		}
	</script>

</body>
<!-- END BODY -->

</html>