<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$pid=intval($_GET['pid']);	
if(isset($_POST['submit']))
{
$pname=$_POST['packagename'];
$ptype=$_POST['packagetype'];	
$plocation=$_POST['packagelocation'];
$pprice=$_POST['packageprice'];	
$fdate=$_POST['fdate'];
$tdate=$_POST['tdate'];	
$pfeatures=$_POST['packagefeatures'];
$pdetails=$_POST['packagedetails'];	
$noofday=$_POST['noofday'];	
$pimage=$_FILES["packageimage"]["name"];
$pHotelDetails=$_POST['HotelDetails'];	
$pVehicle=$_POST['Vehicle'];
$Offer=$_POST['Offer'];
$poffer_edate=$_POST['offer_edate'];
$phimage=$_FILES["hotelimage"]["name"];
$sql="update TblTourPackages set PackageName=:pname,PackageType=:ptype,PackageLocation=:plocation,PackagePrice=:pprice,fdate=:fdate,tdate=:tdate,PackageFetures=:pfeatures,noofday=:noofday,PackageDetails=:pdetails,HotelDetails=:pHotelDetails,Vehicle=:pVehicle,Offer=:Offer,offer_edate=:poffer_edate where PackageId=:pid";
$query = $dbh->prepare($sql);
$query->bindParam(':pname',$pname,PDO::PARAM_STR);
$query->bindParam(':ptype',$ptype,PDO::PARAM_STR);
$query->bindParam(':plocation',$plocation,PDO::PARAM_STR);
$query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
$query->bindParam(':fdate',$fdate,PDO::PARAM_STR);
$query->bindParam(':tdate',$tdate,PDO::PARAM_STR);
$query->bindParam(':pfeatures',$pfeatures,PDO::PARAM_STR);
$query->bindParam(':noofday',$noofday,PDO::PARAM_STR);
$query->bindParam(':pdetails',$pdetails,PDO::PARAM_STR);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':pHotelDetails',$pHotelDetails,PDO::PARAM_STR);
$query->bindParam(':pVehicle',$pVehicle,PDO::PARAM_STR);
$query->bindParam(':Offer',$Offer,PDO::PARAM_STR);
$query->bindParam(':poffer_edate',$poffer_edate,PDO::PARAM_STR);
$query->execute();
$msg="Package Updated Successfully";
}

	?>



<!DOCTYPE HTML>
<html>
<head>
<title>Shyaam Holidays| Admin Package Creation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
              <!--header start here-->
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Update Tour Package </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Update Package</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
						
<?php 
$pid=intval($_GET['pid']);
$sql = "SELECT * from TblTourPackages where PackageId=:pid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Create Package" value="<?php echo htmlentities($result->PackageName);?>" >
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
									<div class="col-sm-8">
									<select  name="packagetype" class="form-control" id="packagetype" >

	<option>Family Package</option>
	<option>Group Tour</option>
	<option>One Day Picnic</option>
	<option>Collage Party</option>
	<option>Diwali Special</option>
</select>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Location</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder=" Package Location" value="<?php echo htmlentities($result->PackageLocation);?>" >
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packageprice" id="packageprice" placeholder=" Package Price " pattern="\d{1,9}" value="<?php echo htmlentities($result->PackagePrice);?>">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">From Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="fdate" id="fdate" value="<?php echo htmlentities($result->fdate);?>">
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">To Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="tdate" id="tdate" value="<?php echo htmlentities($result->tdate);?>">
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Hotel Details</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="5" cols="50" minlength="5"  name="HotelDetails" id="HotelDetails" placeholder="HotelDetails"><?php echo htmlentities($result->HotelDetails);?></textarea> 
									</div>
</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle</label>
									<div class="col-sm-8">
									<select  name="Vehicle" class="form-control" id="Vehicle" >

	<option>Luxurious Bus</option>
	<option>Slepping Bus</option>
	<option>Sitting Bus</option>
	<option>Teveller</option>
	<option>Car</option>
</select>
									</div>
								</div>	

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Features</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" minlength="5" name="packagefeatures" id="packagefeatures" placeholder="Package Features Eg-free Pickup-drop facility" value="<?php echo htmlentities($result->PackageFetures);?>" >
									</div>
								</div>	
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">No. of Days</label>
									<div class="col-sm-8">
										<input class="form-control" name="noofday" id="noofday" placeholder="No. of days" value="<?php echo htmlentities($result->noofday);?>"></input> 
									</div>
								</div>	
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Package Details</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="5" cols="50" minlength="5" name="packagedetails" id="packagedetails" placeholder="Package Details" ><?php echo htmlentities($result->PackageDetails);?></textarea> 
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Offer</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="Offer" id="Offer" value="<?php echo htmlentities($result->Offer);?>%"> 
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Offer Expiry date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="offer_edate" id="offer_edate"  value="<?php echo htmlentities($result->offer_edate);?>" >
									</div>
								</div>		
															
<div class="form-group">
<label for="focusedinput" class="col-sm-2 control-label">Package Image</label>
<div class="col-sm-8">
<img src="pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" width="200">&nbsp;&nbsp;&nbsp;<a href="change-image.php?imgid=<?php echo htmlentities($result->PackageId);?>">Change Image</a>
</div>
</div>
<div class="form-group">
<label for="focusedinput" class="col-sm-2 control-label">Hotel Image</label>
<div class="col-sm-8">
<img src="pacakgeimages/<?php echo htmlentities($result->HotelImage);?>" width="200">&nbsp;&nbsp;&nbsp;<a href="change-hotelimage.php?imgid1=<?php echo htmlentities($result->PackageId);?>">Change Image</a>
</div>
</div>
<div class="form-group">
									<label for=."col-sm-8">
<?php echo htmlentities($result->UpdationDate);?>
									</div>
								</div>		
								<?php }} ?>

								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submit" class="btn-primary btn">Update</button>
				<br><br>
			</div>
		</div>
						
				
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

<!-- script-for sticky-nav -->
<script>
	var date = new Date();
	var tdate = date.getDate();
	var month = date.getMonth() + 1;
	if(tdate < 10){
	tdate = '0' + tdate;
	}
	if(month < 10)
	{
		month = '0' + month;
	}
	var year = date.getUTCFullYear();
	var minDate = year + "-" + month + "-" + tdate; 
	document.getElementById("fdate").setAttribute('min', minDate);
	document.getElementById("tdate").setAttribute('min', minDate);
	</script>
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
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
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
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

</body>
</html>

<?php } ?>