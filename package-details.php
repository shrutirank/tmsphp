<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['submit2'])) {
	$pid = intval($_GET['pkgid']);
	$useremail = $_SESSION['login'];
	$fromdate = $_POST['fromdate'];
	$todate = $_POST['todate'];
	$comment = $_POST['comment'];
	$subject = $_POST['subject'];
	$chil = $_POST['chil'];
	$totalPeople = $_POST['totalPeople'];
	$status = 0;
	$sql = "INSERT INTO tblbooking(PackageId,UserEmail,FromDate,ToDate,Comment,subject,chil,totalPeople,status) VALUES(:pid,:useremail,:fromdate,:todate,:comment,:subject,:chil,:totalPeople,:status)";
	$query = $dbh->prepare($sql);
	$query->bindParam(':pid', $pid, PDO::PARAM_STR);
	$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
	$query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
	$query->bindParam(':todate', $todate, PDO::PARAM_STR);
	$query->bindParam(':comment', $comment, PDO::PARAM_STR);
	$query->bindParam(':subject', $subject, PDO::PARAM_STR);
  	$query->bindParam(':chil', $chil, PDO::PARAM_STR);
 	$query->bindParam(':totalPeople', $totalPeople, PDO::PARAM_STR);
	$query->bindParam(':status', $status, PDO::PARAM_STR);
	$query->execute();
	$lastInsertId = $dbh->lastInsertId();
	if ($lastInsertId) {
		$msg = "Booked Successfully";
	} else {
		$error = "Something went wrong. Please try again";
	}
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<title> Package Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
	<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- Custom Theme files -->
	<script src="js/jquery-1.12.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!--animate-->
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="js/wow.min.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		new WOW().init();
	</script>
	<script src="js/jquery-ui.js"></script>
	<script>
		$(function() {
			$("#datepicker,#datepicker1").datepicker();
		});
	</script>
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

		.section {
			position: relative;
			height: 100vh;
		}

		.section .section-center {
			position: absolute;
			top: 50%;
			left: 0;
			right: 0;
			-webkit-transform: translateY(-50%);
			transform: translateY(-50%);
		}

		#booking {
			font-family: 'Cabin', sans-serif;
			background-color: #f7f9fa;
		}

		.booking-form {
			position: relative;
			max-width: 642px;
			width: 100%;
			margin: auto;
			background: #fff;
			-webkit-box-shadow: 0px 5px 10px -5px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 5px 10px -5px rgba(0, 0, 0, 0.3);
		}

		.booking-form>.booking-bg {
			position: absolute;
			left: 0px;
			top: 0px;
			bottom: 0px;
			width: 250px;
			background-image: url('../img/background.jpg');
			background-size: cover;
			background-position: center;
		}

		.booking-form>form {
			margin-left: 250px;
			padding: 30px;
			border: 1px solid #f9fafc;
			border-left: 0px;
		}

		.booking-form .form-header {
			margin-bottom: 30px;
		}

		.booking-form .form-header h2 {
			margin: 0;
			margin-bottom: 0px;
			font-weight: 700;
			color: #122244;
			font-size: 35px;
			text-transform: capitalize;
		}

		.booking-form .form-group {
			position: relative;
			margin-bottom: 20px;
		}

		.booking-form .form-control {
			background-color: #f7f9fa;
			height: 40px;
			padding: 0px 10px;
			border-radius: 0px;
			-webkit-transition: 0.2s;
			transition: 0.2s;
			color: #122244;
			border: 0px;
			font-size: 16px;
			font-weight: 700;
			-webkit-box-shadow: inset 0 1px 4px rgba(181, 193, 204, 0.3);
			box-shadow: inset 0 1px 4px rgba(181, 193, 204, 0.3);
		}

		.booking-form .form-control::-webkit-input-placeholder {
			color: #dde3e8;
		}

		.booking-form .form-control:-ms-input-placeholder {
			color: #dde3e8;
		}

		.booking-form .form-control::placeholder {
			color: #dde3e8;
		}

		.booking-form .form-control:focus {
			-webkit-box-shadow: inset 0 1px 4px rgba(181, 193, 204, 0.3);
			box-shadow: inset 0 1px 4px rgba(181, 193, 204, 0.3);
		}

		.booking-form input[type="date"].form-control:invalid {
			color: #dde3e8;
		}

		.booking-form select.form-control {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
		}

		.booking-form select.form-control+.select-arrow {
			position: absolute;
			right: 0px;
			bottom: 4px;
			width: 32px;
			line-height: 32px;
			height: 32px;
			text-align: center;
			pointer-events: none;
		}

		.booking-form select.form-control+.select-arrow:after {
			content: '\279C';
			display: block;
			-webkit-transform: rotate(90deg);
			transform: rotate(90deg);
			color: #dddee9;
			font-size: 14px;
		}

		.booking-form .form-label {
			color: #b5c1cc;
			font-weight: 700;
			-webkit-transition: 0.2s;
			transition: 0.2s;
			text-transform: uppercase;
			line-height: 24px;
			height: 24px;
			font-size: 14px;
			z-index: 1;
		}

		.booking-form .form-btn {
			margin-top: 10px;
		}

		.booking-form .submit-btn {
			color: #fff;
			background-color: #6499ff;
			font-weight: 700;
			padding: 13px 35px;
			font-size: 16px;
			border: none;
			width: 100%;
		}

		@media only screen and (max-width: 480px) {
			.booking-form>.booking-bg {
				display: none;
			}

			.booking-form>form {
				margin-left: 0px;
			}
		}
	</style>
	
</head>

<body>
	<!-- top-header -->
	<?php include('includes/header.php'); ?>
	<div class="banner-3">
		<div class="container">
			<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Package Details</h1>
		</div>
	</div>
	<!--- /banner ---->
	<!--- selectroom ---->
	<div class="selectroom">
		<div class="container">
			<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
			else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
			<?php
			$pid = intval($_GET['pkgid']);
			$sql = "SELECT * from tbltourpackages where PackageId=:pid";
			$query = $dbh->prepare($sql);
			$query->bindParam(':pid', $pid, PDO::PARAM_STR);
			$query->execute();
			$results = $query->fetchAll(PDO::FETCH_OBJ);
			$cnt = 1;
			if ($query->rowCount() > 0) {
				# print_r($results);
				foreach ($results as $result) {	?>

					<form name="book" method="post">
						<div class="selectroom_top">
							<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
								<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage); ?>" class="img-responsive" alt="">
							</div>
							<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
								<h2><?php echo htmlentities($result->PackageName); ?></h2>
								<p class="dow">#PKG-<?php echo htmlentities($result->PackageId); ?></p>
								<p><b>Price: </b>₹<?php echo htmlentities($result->PackagePrice); ?></p>
								<p><b>From Date: </b><?php echo htmlentities($result->fdate); ?></p>
								<p><b>To Date: </b><?php echo htmlentities($result->tdate); ?></p>
								<p><b>Package Type :</b> <?php echo htmlentities($result->PackageType); ?></p>
								<p><b>No. of Days : </b> <?php echo htmlentities($result->noofday); ?> Days</p>
								<p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
								<p><b>Features: </b> <?php echo htmlentities($result->PackageFetures); ?></p>
								
								<p><b>HotelDetails: </b><?php echo htmlentities($result->HotelDetails); ?></p>
								<div class="rom-btm">
									<div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
										<img src="admin/pacakgeimages/<?php echo htmlentities($result->HotelImage); ?>" class="img-responsive" alt="">
									</div>
								</div><br /><br /><br /><br /><br /><br />
								<p><b>Vehicle: </b><?php echo htmlentities($result->Vehicle); ?></p>
								<p><b>Offer: </b><?php echo htmlentities($result->Offer);?>%</p>
								<p><b>Offer Expire Date : </b><?php echo htmlentities($result->offer_edate);?></p>
					
								<div class="ban-bottom">

								</div>
								<div class="clearfix"></div>
							</div>

							<h3>Package Details</h3>
							<p style="padding-top: 1%"><?php echo htmlentities($result->PackageDetails); ?> </p>
							<div class="clearfix">

							</div>

						</div>
						
						
     



						<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
							<ul>


							<?php
								if (!$msg) {
									if ($_SESSION['login']) {
										$_SESSION['tour_price'] = $results[0]->PackagePrice;
								?>
										<li class="spe" align="center">
											<!--<a href="payment.php">

		<input name="newThread" type="button" value="online-payment" class="btn-primary btn"  /></a>-->
		
											<a href="booking.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="view" name="submit2">BOOK</a>

											<div class="clearfix"></div>
							</ul>



							</li>
						</div>
					<?php } else { ?>
						<li class="spe" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn"> Book</a>
						</li>
				<?php }
								} ?>

					<!--</form>-->
			<?php }
			} ?>


		</div>
	</div>
	<!--- /selectroom ---->
	<!--- /footer-top ---->
		<?php include('includes/footer.php'); ?>
		<!-- signup -->
		<?php include('includes/signup.php'); ?>
		<!-- //signu -->
		<!-- signin -->
		<?php include('includes/signin.php'); ?>
		<!-- //signin -->
		<!-- write us -->
		<?php include('includes/write-us.php'); ?>
		<script>
			let child = document.getElementById('chil');
			let adult = document.getElementById('subject');
			let total = document.getElementById('totalPeople');
			console.log(total)

			child.addEventListener('change', (e) => {
				total.value = parseInt(child.value) + parseInt(adult.value);
				document.cookie=`total=${total.value}`;
			})
			adult.addEventListener('change', (e) => {
				total.value = parseInt(child.value) + parseInt(adult.value);
				document.cookie=`total=${total.value}`;
			})
		</script>
</body>

</html>