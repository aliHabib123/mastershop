<?php
ini_set('display_errors', '0');
error_reporting(E_ALL ^ E_NOTICE);

require "session_start.php";

include("fckeditor/fckeditor.php");
include 'class/Company.php';
include "connect.php";

include "change_format.php";

include "config.php";


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

$companyArray = Company::select(1);
if ($_POST) {
    $companyId = $_POST['companyId'];
    $_SESSION['companyId'] = $companyId;
}


if ($_SESSION['companyId'] == "") {
    $_SESSION['companyId'] = "1";
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

	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

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



	<link rel="shortcut icon" href="favicon.ico" />



	<script type="text/javascript">
		function deleteAjax(link, id) {

			if (confirm("You're going to delete this record and all relevant records\n\n\\nAre you sure you want to proceed?") == false) {

				return;

			}

			$.ajax({

				type: "GET",

				url: 'delete_' + link + '.php?id=' + id,

				cache: false,

				success: function() {

					$('#' + id).fadeOut();

				}

			});

		}
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

						<li><a href="edit_cms_general.php?id=1"><i class="fa fa-envelope"></i> Notification Email</a>

						</li>

						<!-- 

						<li>

							<a href="#"><i class="fa fa-tasks"></i> My Tasks <span class="badge badge-success">7</span></a>

						</li>

						-->

						<li class="divider"></li>

						<li><a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a>

						</li>

						<!-- 

						<li>

							<a href="extra_lock.html"><i class="fa fa-lock"></i> Lock Screen</a>

						</li> 

						-->

						<li><a href="login.php"><i class="fa fa-key"></i> Log Out</a>

						</li>

					</ul>

				</li>

				<!-- END USER LOGIN DROPDOWN -->

			</ul>

			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="margin: 0px;">
				<select style="margin-top: 15px;" name="companyId" id="companyId" onChange="submit()">

					<?php foreach ($companyArray as $rowSite) { ?>
						<option value="<?php echo $rowSite->company_id; ?>" <?php if ($_SESSION['companyId'] == $rowSite->company_id) {
    echo 'selected="selected"';
} ?>>
							<?php echo $rowSite->company_name; ?>
						</option>
					<?php } ?>
				</select>
			</form>

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

			<!-- *********************USE THE FOLLOWING ICONS FOR EACH MENU ITEM -->

			<!-- 

		<i class="fa fa-briefcase"></i>

		<i class="fa fa-clock-o"></i>

		<i class="fa fa-cogs"></i>

		<i class="fa fa-comments"></i>

		<i class="fa fa-font"></i>

		<i class="fa fa-coffee"></i>

		<i class="fa fa-bell"></i>

		<i class="fa fa-group"></i>

		<i class="fa fa-envelope-o"></i>

		<i class="fa fa-calendar"></i>

		<i class="fa fa-warning"></i>

		<i class="fa fa-plus"></i>

		<i class="fa fa-bolt"></i>

		<i class="fa fa-bullhorn"></i>

		<i class="fa fa-tasks"></i>

		<i class="fa fa-angle-down"></i>

		<i class="fa fa-user"></i>

		<i class="fa fa-lock"></i>

		<i class="fa fa-key"></i>

		<i class="fa fa-home"></i> 

		<i class="fa fa-gift"></i> 

		<i class="fa fa-bookmark-o"></i> 

		<i class="fa fa-table"></i> 

		<i class="fa fa-sitemap"></i> 

		<i class="fa fa-leaf"></i>

		 -->





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


				<li <?php if (
                        $_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 1

                        || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8
                    ) { ?> style="display: none" <?php } ?> class="">

					<a href="display_tour.php">

						<i class="fa fa-leaf"></i>

						<span class="title">Tours</span>

					</a>

				</li>



				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 1  || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_package.php">

						<i class="fa fa-envelope-o"></i>

						<span class="title">Packages</span>

					</a>

				</li>
				<?php if ($_SESSION['companyId'] == 2) { ?>
					<li class="">

						<a href="display_value.php">

							<i class="fa fa-heart"></i>

							<span class="title">Values</span>

						</a>

					</li>
				<?php } ?>



				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_offer.php">

						<i class="fa fa-table"></i>

						<span class="title">Offers</span>

					</a>

				</li>





				<li <?php if ($_SESSION['companyId'] == 4) { ?> <?php } ?>class="">

					<a href="display_testimonial.php">

						<i class="fa fa-bookmark-o"></i>

						<span class="title">Testimonials</span>

					</a>

				</li>





				<li <?php if ($_SESSION['companyId'] == 1) { ?> style="display: none" <?php } ?> class="">

					<a href="display_service.php">

						<i class="fa fa-gift"></i>

						<span class="title">Services</span>

					</a>

				</li>




				<?php if ($_SESSION['companyId'] != 1) { ?>
					<li class="">

						<a href="display_partner.php">

							<i class="fa fa-user"></i>

							<span class="title">Corporate Area Members</span>

						</a>

					</li>

				<?php } ?>

				<li class="">

					<a href="display_partner_document.php">

						<i class="fa fa-user"></i>

						<span class="title">Partner Documents</span>

					</a>

				</li>

				<li <?php if ($_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 4) { ?> style="display: none" <?php } ?> class="">

					<a href="display_department.php">

						<i class="fa fa-group"></i>

						<span class="title">Department</span>

					</a>

				</li>

				<li class="">

					<a href="display_team_member.php">

						<i class="fa fa-group"></i>

						<span class="title">Team Members</span>

					</a>

				</li>

				<li <?php if ($_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_award.php">

						<i class="fa fa-group"></i>

						<span class="title">Wall Of Fame</span>

					</a>

				</li>





				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?>>

					<a class="active" href="javascript:;">

						<i class="fa fa-bell"></i>

						<span class="title">Jobs</span>

						<span class="arrow "></span>

					</a>

					<ul class="sub-menu">

						<li>

							<a href="display_vacancy.php">

								Vacancies

							</a>

						</li>

						<li>

							<a href="display_applicant.php">

								Applicants

							</a>

						</li>

					</ul>

				</li>







				<li class="">

					<a href="display_page.php">

						<i class="fa fa-tasks"></i>

						<span class="title">Pages</span>

					</a>

				</li>







				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_event.php">

						<i class="fa fa-calendar"></i>

						<span class="title">Events</span>

					</a>

				</li>







				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_document.php">

						<i class="fa fa-envelope-o"></i>

						<span class="title">Documents</span>

					</a>

				</li>







				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_blog.php">

						<i class="fa fa-comments"></i>

						<span class="title">Blog</span>

					</a>

				</li>







				<li class="">

					<a href="display_banner.php">

						<i class="fa fa-gift"></i>

						<span class="title">Banners</span>

					</a>

				</li>
				<?php if ($_SESSION['companyId'] != 3 && $_SESSION['companyId'] != 4 && $_SESSION['companyId'] != 2 && $_SESSION['companyId'] != 5 && $_SESSION['companyId'] != 8 && $_SESSION['companyId'] != 6) { ?>
					<li class="">

						<a href="display_affiliation.php">

							<i class="fa fa-gift"></i>

							<span class="title">Affiliations</span>

						</a>

					</li>
				<?php } ?>


				<?php if ($_SESSION['companyId'] == 8) { ?>
					<li class="">

						<a href="display_car.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Cars</span>

						</a>

					</li>
				<?php } ?>
				<?php if ($_SESSION['companyId'] == 3) { ?>
					<li class="">

						<a href="display_tech.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Travel Technology</span>

						</a>

					</li>

				<?php } ?>
				<?php if ($_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2) { ?>
					<li class="">

						<a href="display_album.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Album</span>

						</a>

					</li>

					<li class="">

						<a href="display_album_photo.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Album Photos</span>

						</a>

					</li>
					<li class="">

						<a href="display_client.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Client</span>

						</a>

					</li>

				<?php } ?>

				<?php if ($_SESSION['companyId'] == 1) { ?>
					<li class="">

						<a href="display_video.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Video</span>

						</a>

					</li>
				<?php } ?>

				<?php if ($_SESSION['companyId'] == 4) { ?>
					<li class="">

						<a href="display_video.php">

							<i class="fa fa-cogs"></i>

							<span class="title">Our Lebanon</span>

						</a>

					</li>
				<?php } ?>


				<li <?php if ($_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_calendar.php">

						<i class="fa fa-table"></i>

						<span class="title">Calendar</span>

					</a>

				</li>
				<li <?php if ($_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 3 || $_SESSION['companyId'] == 4 || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8) { ?> style="display: none" <?php } ?> class="">

					<a href="display_registrations.php">

						<i class="fa fa-table"></i>

						<span class="title">Registrations</span>

					</a>

				</li>



				<li <?php if (
                        $_SESSION['companyId'] == 6 || $_SESSION['companyId'] == 7 || $_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 4
                        || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8
                    ) { ?> style="display: none" <?php } ?> class="">

					<a href="display_solution.php">

						<i class="fa fa-table"></i>

						<span class="title">Solutions</span>

					</a>

				</li>
				<li <?php if (
                        $_SESSION['companyId'] == 6 ||  $_SESSION['companyId'] == 1 || $_SESSION['companyId'] == 4
                        || $_SESSION['companyId'] == 2 || $_SESSION['companyId'] == 5 || $_SESSION['companyId'] == 8
                    ) { ?> style="display: none" <?php } ?> class="">

					<a href="display_travel_tip.php">
						<i class="fa fa-table"></i>
						<span class="title">Tips</span>
					</a>

				</li>
				<li class="">
					<a href="display_company.php">
						<i class="fa fa-cogs"></i>
						<span class="title">Companies</span>
					</a>
				</li>
			</ul>

			<!-- END SIDEBAR MENU -->

		</div>

		<!-- END SIDEBAR -->

		<!-- BEGIN PAGE -->

		<div class="page-content">

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

							<h4 class="modal-title">Modal title</h4>

						</div>

						<div class="modal-body">

							Widget settings form goes here

						</div>

						<div class="modal-footer">

							<button type="button" class="btn blue">Save changes</button>

							<button type="button" class="btn default" data-dismiss="modal">Close</button>

						</div>

					</div>

					<!-- /.modal-content -->

				</div>

				<!-- /.modal-dialog -->

			</div>

			<!-- /.modal -->

			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<!-- BEGIN STYLE CUSTOMIZER -->

			<div class="theme-panel hidden-xs hidden-sm">

				<div class="toggler"></div>

				<div class="toggler-close"></div>

				<div class="theme-options">

					<div class="theme-option theme-colors clearfix">

						<span>THEME COLOR</span>

						<ul>

							<li class="color-black current color-default" data-style="default"></li>

							<li class="color-blue" data-style="blue"></li>

							<li class="color-brown" data-style="brown"></li>

							<li class="color-purple" data-style="purple"></li>

							<li class="color-grey" data-style="grey"></li>

							<li class="color-white color-light" data-style="light"></li>

						</ul>

					</div>

					<div class="theme-option">

						<span>Layout</span>

						<select class="layout-option form-control input-small">

							<option value="fluid" selected="selected">Fluid</option>

							<option value="boxed">Boxed</option>

						</select>

					</div>

					<div class="theme-option">

						<span>Header</span>

						<select class="header-option form-control input-small">

							<option value="fixed" selected="selected">Fixed</option>

							<option value="default">Default</option>

						</select>

					</div>

					<div class="theme-option">

						<span>Sidebar</span>

						<select class="sidebar-option form-control input-small">

							<option value="fixed">Fixed</option>

							<option value="default" selected="selected">Default</option>

						</select>

					</div>

					<div class="theme-option">

						<span>Footer</span>

						<select class="footer-option form-control input-small">

							<option value="fixed">Fixed</option>

							<option value="default" selected="selected">Default</option>

						</select>

					</div>

				</div>

			</div>

			<!-- END BEGIN STYLE CUSTOMIZER -->

			<!-- BEGIN PAGE HEADER-->

			<div class="row">

				<div class="col-md-12">

					<!-- BEGIN PAGE TITLE & BREADCRUMB-->

					<h3 class="page-title note note-info" align="center">

						YOUR WEBSITE CMS

					</h3>

					<?php if ($text != "") { ?>

						<div class="note note-success">

							<h4 class="block"><?php echo $text ?></h4>

						</div>

					<?php } ?>

					<!--

					<ul class="page-breadcrumb breadcrumb">

						<li class="btn-group">

							<button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">

							<span>Actions</span> <i class="fa fa-angle-down"></i>

							</button>

							<ul class="dropdown-menu pull-right" role="menu">

								<li><a href="#">Action</a></li>

								<li><a href="#">Another action</a></li>

								<li><a href="#">Something else here</a></li>

								<li class="divider"></li>

								<li><a href="#">Separated link</a></li>

							</ul>

						</li>

					

						<li>

							<i class="fa fa-home"></i>

							<a href="index.html">Home</a> 

							<i class="fa fa-angle-right"></i>

						</li>

						<li>

							<a href="#">Data Tables</a>

							<i class="fa fa-angle-right"></i>

						</li>

						<li><a href="#">Advanced Tables</a></li>

					</ul>

					 -->

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

			<div><?php echo date('Y');?> &copy; Powered by <a href="http://thirteencube.com">Thirteencube</a> | All rights reserved </div>

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

	<!-- BEGIN PAGE LEVEL SCRIPTS -->

	<script src="assets/scripts/app.js"></script>

	<script src="assets/scripts/form-components.js"></script>



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

		        "order": [[ 0, "desc" ]],

		        "bDestroy":true

		    } );

			

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

		});
	</script>

	<!-- http://datatables.net/examples/styling/compact.html -->

	<!-- BEGIN GOOGLE RECAPTCHA -->

	<script type="text/javascript">
		var RecaptchaOptions = {

			theme: 'custom',

			custom_theme_widget: 'recaptcha_widget'

		};
	</script>




</body>

<!-- END BODY -->

</html>