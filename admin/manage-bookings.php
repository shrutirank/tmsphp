<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	// code for cancel
	if (isset($_REQUEST['bkid'])) {
		$bid = intval($_GET['bkid']);
		$status = 2;
		$cancelby = 'a';
		$sql = "UPDATE tblbooking SET status=:status,CancelledBy=:cancelby WHERE  BookingId=:bid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':cancelby', $cancelby, PDO::PARAM_STR);
		$query->bindParam(':bid', $bid, PDO::PARAM_STR);
		$query->execute();

		$msg = "Booking Cancelled successfully";
	}


	if (isset($_REQUEST['bckid'])) {
		$bcid = intval($_GET['bckid']);
		$status = 1;
		$cancelby = 'a';
		$sql = "UPDATE tblbooking SET status=:status WHERE BookingId=:bcid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $status, PDO::PARAM_STR);
		$query->bindParam(':bcid', $bcid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Booking Confirm successfully";
	}
?>
	<?php

	if (isset($_POST['vreport'])) {
		ob_clean();
		require_once('vendor/autoload.php');
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0]);
		$pdfcontent .= '<div class="main">

 <h2>Shyaam Holidays</h2>
 
 D2069, Central Bazar, Varachha, Surat, Gujarat ,India. <br>
 Email:shyaamholiday@gmail.com | Mo:+91 97266 26668,+91 97266 26667
 </p>
 <p style="margin-left: 40rem;margin-right: 5px;margin-top: -2rem;">Date: ' . date('d-m-Y') . '</p>
 </div>
 <hr class="bg-dark">
 <center><h2><u>Booking Reports</u></h2></center>
 
 ;
									<div class="section">
									<table style="border-collapse: collapse;border-spacing: 0px;margin-top:25px;display: table;box-sizing: border-box;text-indent: initial;border: 2px solid #000;border-color: grey;">
										<thead>
										  <tr>
										  <th>Booikn id</th>
											<th>Name</th>
											<th>Mobile No.</th>
											<th>Email Id</th>
											<th>Package </th>
											<th>Payment</th>
											<th>Adult</th>
											<th>Childern</th>
											<th>Status </th>
											<th>Reg Date </th>
											<th>Action </th>
										  </tr>
										</thead>
										<tbody>';
		$sql = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,tblbooking.ToDate as tdate,tblbooking.pay as pay,tblbooking.subject as subject,tblbooking.chil as chil,tblbooking.status as status,tblbooking.RegDate as RegDate,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join ( SELECT * FROM tblbooking where ( RegDate>='$_POST[sdate]' && RegDate<='$_POST[edate]' ) order by BookingId desc ) tblbooking on tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";

		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		$cnt = 1;
		if ($query->rowCount() > 0) {
			foreach ($results as $result) {

				$pdfcontent .= '<tr>
												<td>#BK-' . htmlentities($result->bookid) . '</td>
												<td>' . htmlentities($result->fname) . '</td>
												<td>' . htmlentities($result->mnumber) . '</td>
												<td>' . htmlentities($result->email) . '</td>
												<td>' . htmlentities($result->pckname) . '</td>
												<td>' . htmlentities($result->pay) . '</td>
												<td>' . htmlentities($result->subject) . '</td>
												<td>' . htmlentities($result->chil) . '</td>
												<td>' . htmlentities($result->RegDate) . '</td>
												<td>';

				if ($result->status == 0) {
					echo "Pending";
				}
				if ($result->status == 1) {
					echo "Confirmed";
				}
				if ($result->status == 2 and  $result->cancelby == 'a') {
					echo "Canceled by you at " . $result->upddate;
				}
				if ($result->status == 2 and $result->cancelby == 'u') {
					echo "Canceled by User at " . $result->upddate;
				}

				$pdfcontent .= '</td>';
				if ($result->status == 2) {

					$pdfcontent .= '<td>Cancelled</td>';
				}
				$pdfcontent .= '</tr>';
				$cnt = $cnt + 1;
			}
		}
		$pdfcontent .= '</tbody>
									</table>
									</div>
								</div>';

		$mpdf->WriteHTML($pdfcontent);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->SetJS('this.print();');
		$mpdf->Output('Report.pdf', 'I');
	}

	if (isset($_POST['dreport'])) {
		ob_clean();
		require_once('vendor/autoload.php');
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0]);
		$pdfcontent .= '<div class="main">
									<div class="section">
									<table style="border-collapse: collapse;border-spacing: 0px;margin-top:25px;display: table;box-sizing: border-box;text-indent: initial;border: 2px solid #000;border-color: grey;">
										<thead>
										  <tr>
										  <th>Booikn id</th>
											<th>Name</th>
											<th>Mobile No.</th>
											<th>Email Id</th>
											<th>Package </th>
											<th>Payment</th>
											<th>Adult</th>
											<th>Childern</th>
											<th>Status </th>
											<th>Reg Date </th>
											<th>Action </th>
										  </tr>
										</thead>
										<tbody>';
		$sql = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,tblbooking.ToDate as tdate,tblbooking.pay as pay,tblbooking.subject as subject,tblbooking.chil as chil,tblbooking.status as status,tblbooking.RegDate as RegDate,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join ( SELECT * FROM tblbooking where ( RegDate>='$_POST[sdate]' && RegDate<='$_POST[edate]' ) order by BookingId desc ) tblbooking on tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";

		$query = $dbh->prepare($sql);
		$query->execute();
		$results = $query->fetchAll(PDO::FETCH_OBJ);
		$cnt = 1;
		if ($query->rowCount() > 0) {
			foreach ($results as $result) {

				$pdfcontent .= '<tr>
												<td>#BK-' . htmlentities($result->bookid) . '</td>
												<td>' . htmlentities($result->fname) . '</td>
												<td>' . htmlentities($result->mnumber) . '</td>
												<td>' . htmlentities($result->email) . '</td>
												<td>' . htmlentities($result->pckname) . '</td>
												<td>' . htmlentities($result->pay) . '</td>
												<td>' . htmlentities($result->subject) . '</td>
												<td>' . htmlentities($result->chil) . '</td>
												<td>' . htmlentities($result->RegDate) . '</td>
												<td>';

				if ($result->status == 0) {
					echo "Pending";
				}
				if ($result->status == 1) {
					echo "Confirmed";
				}
				if ($result->status == 2 and  $result->cancelby == 'a') {
					echo "Canceled by you at " . $result->upddate;
				}
				if ($result->status == 2 and $result->cancelby == 'u') {
					echo "Canceled by User at " . $result->upddate;
				}

				$pdfcontent .= '</td>';
				if ($result->status == 2) {

					$pdfcontent .= '<td>Cancelled</td>';
				}
				$pdfcontent .= '</tr>';
				$cnt = $cnt + 1;
			}
		}
		$pdfcontent .= '</tbody>
									</table>
									</div>
								</div>';

		$mpdf->WriteHTML($pdfcontent);
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->list_indent_first_level = 0;
		$mpdf->SetJS('this.print();');
		$mpdf->Output('Report.pdf', 'D');
	}
	?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>Shyaam Holidays | Admin manage Bookings</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="application/x-javascript">
			addEventListener("load", function() {
				setTimeout(hideURLbar, 0);
			}, false);

			function hideURLbar() {
				window.scrollTo(0, 1);
			}
		</script>
		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet">
		<script src="js/jquery-2.1.4.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/table-style.css" />
		<link rel="stylesheet" type="text/css" href="css/basictable.css" />
		<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script type="text/javascript">
			$(document).ready(function() {
				$('#table').basictable();

				$('#table-breakpoint').basictable({
					breakpoint: 768
				});

				$('#table-swap-axis').basictable({
					swapAxis: true
				});

				$('#table-force-off').basictable({
					forceResponsive: false
				});

				$('#table-no-resize').basictable({
					noResize: true
				});

				$('#table-two-axis').basictable();

				$('#table-max-height').basictable({
					tableWrapper: true
				});

				$('#sdate').datepicker({
					format: 'yyyy/mm/dd',
					autoclose: true
				});
				$('#edate').datepicker({
					format: 'yyyy/mm/dd',
					autoclose: true
				});
			});
		</script>
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>
	</head>

	<body>
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>
					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Manage Bookings</li>
				</ol>
				<div class="agile-grids">
					<!-- tables -->
					<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
					<div class="agile-tables">
						<div class="w3l-table-info">
							<h2>Manage Bookings</h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<form class="form-inline" action="" name="form1" method="post">
								<div class="form-group">
									<label for="sdate">Select Start Date</label>
									<input type="text" autocomplete="off" name="sdate" id="sdate" placeholder="Click here to open calender" value="<?php echo $_POST['sdate']; ?>">
								</div>
								<div class="form-group">
									<label for="edate">Select End Date</label>
									<input type="text" autocomplete="off" name="edate" id="edate" placeholder="Click here to open calender" value="<?php echo $_POST['edate']; ?>">
								</div>

								<button><a href="Report/index.php">php Report </button>
								<button type="submit" name="report">Report</button>
								<?php if (isset($_POST['report'])) { ?>
									<button type="submit" name="vreport">View Report</button>
									<button type="submit" name="dreport">Download Report</button>

								<?php } ?>
							</form>
							<?php
							if (isset($_POST['report'])) {
							?>
								<table id="table">
									<thead>
										<tr>
											<th>Booikn id</th>
											<th>Name</th>
											<th>Mobile No.</th>
											<th>Email Id</th>
											<th>Package </th>
											<th>Payment</th>
											<th>Adult</th>
											<th>Childern</th>
											<th>Status </th>
											<th>Reg Date </th>
											<th>Action </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,tblbooking.ToDate as tdate,tblbooking.pay as pay,tblbooking.subject as subject,tblbooking.chil as chil,tblbooking.status as status,tblbooking.RegDate as RegDate,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join ( SELECT * FROM tblbooking where ( RegDate>='$_POST[sdate]' && RegDate<='$_POST[edate]' ) order by BookingId desc ) tblbooking on tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";

										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);

										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>
												<tr>
													<td>#BK-<?php echo htmlentities($result->bookid); ?></td>
													<td><?php echo htmlentities($result->fname); ?></td>
													<td><?php echo htmlentities($result->mnumber); ?></td>
													<td><?php echo htmlentities($result->email); ?></td>
													<td><?php echo htmlentities($result->pckname); ?></td>

													<td><?php echo htmlentities($result->pay); ?></td>
													<td><?php echo htmlentities($result->subject); ?></td>
													<td><?php echo htmlentities($result->chil); ?></td>
													<td><?php echo htmlentities($result->RegDate); ?></td>
													<td>
														<?php
														if ($result->status == 0) {
															echo "Pending";
														}
														if ($result->status == 1) {
															echo "Confirmed";
														}
														if ($result->status == 2 and  $result->cancelby == 'a') {
															echo "Canceled by you at " . $result->upddate;
														}
														if ($result->status == 2 and $result->cancelby == 'u') {
															echo "Canceled by User at " . $result->upddate;
														}
														?>
													</td>

													<?php if ($result->status == 2) {
													?>
														<td>Cancelled</td>
													<?php } else { ?>
														<td><a href="manage-bookings.php?bkid=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('Do you really want to cancel booking')">Cancel</a> / <a href="manage-bookings.php?bckid=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('booking has been confirm')">Confirm</a></td>
													<?php } ?>
												</tr>
										<?php $cnt = $cnt + 1;
											}
										}
										?>
									</tbody>
								</table>
							<?php
							} else {
							?>
								<table id="table">
									<thead>
										<tr>
											<th>Booikn id</th>
											<th>Name</th>
											<th>Mobile No.</th>
											<th>Email Id</th>
											<th>Package </th>
											<th>Payment</th>
											<th>Adult</th>
											<th>Childern</th>
											<th>Status </th>
											<th>Action </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,tblbooking.ToDate as tdate,tblbooking.pay as pay,tblbooking.subject as subject,tblbooking.chil as chil,tblbooking.status as status,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join  tblbooking on tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";
										$query = $dbh->prepare($sql);
										$query->execute();
										$results = $query->fetchAll(PDO::FETCH_OBJ);
										$cnt = 1;
										if ($query->rowCount() > 0) {
											foreach ($results as $result) {
										?>
												<tr>
													<td>#BK-<?php echo htmlentities($result->bookid); ?></td>
													<td><?php echo htmlentities($result->fname); ?></td>
													<td><?php echo htmlentities($result->mnumber); ?></td>
													<td><?php echo htmlentities($result->email); ?></td>
													<td><?php echo htmlentities($result->pckname); ?></td>

													<td><?php echo htmlentities($result->pay); ?></td>
													<td><?php echo htmlentities($result->subject); ?></td>
													<td><?php echo htmlentities($result->chil); ?></td>
													<td>
														<?php
														if ($result->status == 0) {
															echo "Pending";
														}
														if ($result->status == 1) {
															echo "Confirmed";
														}
														if ($result->status == 2 and  $result->cancelby == 'a') {
															echo "Canceled by you at " . $result->upddate;
														}
														if ($result->status == 2 and $result->cancelby == 'u') {
															echo "Canceled by User at " . $result->upddate;
														}
														?>
													</td>

													<?php if ($result->status == 2) {
													?><td>Cancelled</td>
													<?php } else { ?>
														<td><a href="manage-bookings.php?bkid=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('Do you really want to cancel booking')">Cancel</a> / <a href="manage-bookings.php?bckid=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('booking has been confirm')">Confirm</a></td>
													<?php } ?>
												</tr>
										<?php $cnt = $cnt + 1;
											}
										}
										?>
									</tbody>
								</table>
							<?php
							}
							?>
						</div>
					</div>
					<!-- script-for sticky-nav -->
					<script>
						$(document).ready(function() {
							var navoffeset = $(".header-main").offset().top;
							$(window).scroll(function() {
								var scrollpos = $(window).scrollTop();
								if (scrollpos >= navoffeset) {
									$(".header-main").addClass("fixed");
								} else {
									$(".header-main").removeClass("fixed");
								}
							});

						});
					</script>
					<!-- /script-for sticky-nav -->
					<!--inner block start here-->
					<div class="inner-block">

					</div>
					<!--inner block end here-->
					<!--copy rights start here-->
					<?php include('includes/footer.php'); ?>
					<!--COPY rights end here-->
				</div>
			</div>
			<!--//content-inner-->
			<!--/sidebar-menu-->
			<?php include('includes/sidebarmenu.php'); ?>
			<div class="clearfix"></div>
		</div>
		<script>
			var toggle = true;

			$(".sidebar-icon").click(function() {
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({
						"position": "absolute"
					});
				} else {
					$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function() {
						$("#menu span").css({
							"position": "relative"
						});
					}, 400);
				}

				toggle = !toggle;
			});
		</script>
		<!--js -->
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- /Bootstrap Core JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	</body>

	</html>
<?php } ?>