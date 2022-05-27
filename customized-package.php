 <?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit1']))
{

$type=$_POST['type'];	

$state=$_POST['state'];
$city=$_POST['city'];	
$fdate=$_POST['fdate'];
$tdate=$_POST['tdate'];
$adult=$_POST['adult'];
$child=$_POST['child'];
$email=$_SESSION['login'];
$sql="INSERT INTO  tblcustomizedpackage(ptype,state,city,pfdate,ptdate,adult,child,UserEmail) VALUES(:type,:state,:city,:fdate,:tdate,:adult,:child,:email)";
$query = $dbh->prepare($sql);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->bindParam(':state',$state,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':fdate',$fdate,PDO::PARAM_STR);
$query->bindParam(':tdate',$tdate,PDO::PARAM_STR);
$query->bindParam(':adult',$adult,PDO::PARAM_STR);
$query->bindParam(':child',$child,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="customized package  Successfully submited";
}
else 
{
$error="Something went wrong. Please try again";
}

}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Shyaam Holidays</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Tourism Management System In PHP" />
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 	
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="jquery.js"></script>
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
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Customized Pacakge</h3>
		<form name="f1" method="post">
		 <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
	<!--<p style="width: 350px;">
		
			<b>Package Name</b>  <input type="text" name="name" class="form-control" id="name" placeholder="Pacakge Name" pattern="[A-Za-z]{2,10}" required="">
	</p> -->
<p style="width: 350px;">
<b>Package Type</b>  <select  name="type" class="form-control" id="type"  required="">
	<option>Family Package</option>
	<option>Group Tour</option>
	<option>One Day Picnic</option>
	<option>Collage Party</option>
	<option>Diwali Special</option>
</select>
	</p> 

	<!--<p style="width: 350px;">
<b>Package Price</b>  <input type="text" name="price" class="form-control" id="price"pattern="\d{1,9}"  placeholder="Price" required="">
	</p> -->

	<p style="width: 350px;">
<b>Location:</b><br>
<b>State</b>
<select class="form-control" id="state" name="state"   onchange="myfun(this.value)" required	>
<?php
$conn=mysqli_connect("localhost","root","");
mysqli_select_db($conn,"tms");
$q="select * from state";
$result=mysqli_query($conn,$q);
while ($row=mysqli_fetch_array($result))
{
?>

	<option value="<?php echo $row['state_id'];?>"><?php echo $row['sname']; ?></option>
	<?php 	
}
?>

								</select>    
								
<b>City</b>
 <select class="form-control" id="city" name="city" required>city

                         </select>
	</p> 
	<p style="width: 350px;">
<b>From Date</b>  <input type="date" name="fdate" class="form-control"  id="fdate"  placeholder="From Date" required="" ></input> 
	</p> 
	<p style="width: 350px;">
<b>To Date</b>  <input type="date" name="tdate" class="form-control" id="tdate"  placeholder="To Date" required="" onchange="TDate()">
	</p>
					
	<p style="width: 350px;">
<b>Adult</b>  <input type="text" name="adult" class="form-control" id="adult"  placeholder="0" required="">
	</p> 
	<p style="width: 350px;">
<b>Childern</b>  <input type="text" name="child" class="form-control" id="child"  placeholder="0" required="">
	</p> 
												
			<p style="width: 350px;">
<button type="submit" name="submit1" class="btn-primary btn" >Submit</button>
			</p>
			</form>

		
	</div>
</div>
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

function myfun(datavalue)
{
	$.ajax({
		url:'class.php',
		type:'POST',
		data:{datapost:datavalue},
		success:function(result){
			$('#city').html(result);
		}
	});
}

</script>
<!--<script>

function TDate(){
	var userDate=document.getElementById("tdate").value;
	var ToDate=new Date();
	if (new Date(userDate).getDate()<=ToDate.getDate()){
		alert ("From date must be lesser to todate date");
		return false;
	}
	return true;
}

</script>-->


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