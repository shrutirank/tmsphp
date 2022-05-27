<?php
session_start();
error_reporting(0);
$server = "localhost";
$username = "root";
$password = "";
$dbname = "tms";

$conn = mysqli_connect($server , $username , $password , $dbname);

if(isset($_POST['replay']))
{
	if(!empty($_POST['name']) && !empty($_POST['type']) && !empty($_POST['price']) && !empty($_POST['location']) && !empty($_POST['fdate']) && !empty($_POST['tdate']))
	{
		$name = $_POST['name'];
		$type = $_POST['type'];
		$price = $_POST['price'];
		$location = $_POST['location'];
		$fdate = $_POST['fdate'];
		$tdate = $_POST['tdate'];

		$query = "INSERT INTO tblcustomizedpackage(pname,ptype,pprice,plocation,pfdate,ptdate) values('$name' , '$type' , '$price' , '$location' , '$fdate' , '$tdate' )";

		$run = mysqli_query($conn,$query) or die ("Error connecting to database");
		if($run)
		{
			$_SESSION['msg']="customize packge submitted successfully ";
			header('location:thankyou.php');
		}
		else
		{
			echo "from not submitted";
		}
	}
	else
	{
		echo "all fild required";
	}

}

?>




<!DOCTYPE HTML>
<html>
<head>
<title>Shyaam Holidays</title>
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
	<script>
		 new WOW().init();
	</script>
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
<!--//end-animate-->
</head>
<body>
<!-- top-header -->
<div class="top-header">
<?php include('includes/header.php');?>
<div class="banner-3 ">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Shyaam Holidays</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- privacy ---->
<div class="privacy">
	<div class="container">
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Customized form</h3>
		<form action="#" method="post">
		 
	<p style="width: 350px;">
<b>Package Name:</b>  <input type="text" name="name" class="form-control" id="pname" placeholder="Package Name" pattern="[A-Za-z].{2,}" required="">
	</p> 
<p style="width: 350px;">
<b>Package Type</b>  <input type="text" name="type" class="form-control" id="ptype" placeholder="Package Type" pattern="[A-Za-z].{2,}" required="">
	</p> 

	<p style="width: 350px;">
<b>Price</b>  <input type="txt" name="price" class="form-control" id="pprice" pattern="\d{1,9}"  placeholder="Price" required="">
	</p> 

	<p style="width: 350px;">
<b>Location</b>  <input type="text" name="location" class="form-control" id="plocation" pattern="[A-Za-z].{2,}" placeholder="Location" required="">
	</p> 
	<p style="width: 350px;">
<b>From Date</b>  <input type="date" name="fdate" class="form-control"  id="pfdate"   required=""></textarea> 
	</p> 
  <p style="width: 350px;">
<b>To Date</b>  <input type="date" name="tdate" class="form-control"  id="ptdate"   required=""></textarea> 
	</p> 

			<p style="width: 350px;">
<button type="submit" name="replay" class="btn-primary btn">Submit</button>
			</p>
			</form>

		
	</div>
</div>
<!--- /privacy ---->
<!--- footer-top ---->
<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>
</body>
</html>