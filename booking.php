<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit2']))
{
$pid=intval($_GET['pkgid']);
$useremail=$_SESSION['login'];
$subject = $_POST['subject'];
$chil = $_POST['chil'];
$pay=$_POST['pay'];
$status=0;
$sql="INSERT INTO tblbooking(PackageId,UserEmail,subject,chil,pay,status) VALUES(:pid,:useremail,:subject,:chil,:pay,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':subject', $subject, PDO::PARAM_STR);
$query->bindParam(':chil', $chil, PDO::PARAM_STR);
$query->bindParam(':pay', $pay, PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Booked Successfully";
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
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->




<style>
    * {
    margin-top: 0;
    padding: 0;
}

body {
    overflow-x: hidden;
    background: #000000;
}

#bg-div {
    margin: 0;
    margin-top: 100px;
    margin-bottom: 100px
}

#border-btm {
    padding-bottom: 20px;
    margin-bottom: 0px;
    box-shadow: 0px 35px 2px -35px lightgray
}

#test {
    margin-top: 0px;
    margin-bottom: 40px;
    border: 1px solid #FFE082;
    border-radius: 0.25rem;
    width: 60px;
    height: 30px;
    background-color: #FFECB3
}

.active1 {
    color: #00C853 !important;
    font-weight: bold
}

.bar4 {
    width: 35px;
    height: 5px;
    background-color: #ffffff;
    margin: 6px 0
}

.list-group .tabs {
    color: #000000
}

#menu-toggle {
    height: 50px
}

#new-label {
    padding: 2px;
    font-size: 10px;
    font-weight: bold;
    background-color: red;
    color: #ffffff;
    border-radius: 5px;
    margin-left: 5px
}

#sidebar-wrapper {
    min-height: 100vh;
    margin-left: -15rem;
    -webkit-transition: margin .25s ease-out;
    -moz-transition: margin .25s ease-out;
    -o-transition: margin .25s ease-out;
    transition: margin .25s ease-out
}

#sidebar-wrapper .sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem
}

#sidebar-wrapper .list-group {
    width: 15rem
}

#page-content-wrapper {
    min-width: 100vw;
    padding-left: 20px;
    padding-right: 20px
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: 0
}

.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #fff !important;
    border-color: #fff !important
}

@media (min-width: 768px) {
    #sidebar-wrapper {
        margin-left: 0
    }

    #page-content-wrapper {
        min-width: 0;
        width: 100%
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: -15rem;
        display: none
    }
}

.card0 {
    margin-top: 10px;
    margin-bottom: 10px
}

.top-highlight {
    color: #00C853;
    font-weight: bold;
    font-size: 20px
}

.form-card input,
.form-card textarea {
    padding: 10px 15px 5px 15px;
    border: none;
    border: 1px solid lightgrey;
    border-radius: 6px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: arial;
    color: #2C3E50;
    font-size: 14px;
    letter-spacing: 1px
}

.form-card input:focus,
.form-card textarea:focus {
    -moz-box-shadow: 0px 0px 0px 1.5px skyblue !important;
    -webkit-box-shadow: 0px 0px 0px 1.5px skyblue !important;
    box-shadow: 0px 0px 0px 1.5px skyblue !important;
    font-weight: bold;
    border: 1px solid skyblue;
    outline-width: 0
}

input.btn-success {
    height: 50px;
    color: #ffffff;
    opacity: 0.9
}

#below-btn a {
    font-weight: bold;
    color: #000000
}

.input-group {
    position: relative;
    width: 100%;
    overflow: hidden
}

.input-group input {
    position: relative;
    height: 90px;
    margin-left: 1px;
    margin-right: 1px;
    border-radius: 6px;
    padding-top: 30px;
    padding-left: 25px
}

.input-group label {
    position: absolute;
    height: 24px;
    background: none;
    border-radius: 6px;
    line-height: 48px;
    font-size: 15px;
    color: gray;
    width: 100%;
    font-weight: 100;
    padding-left: 25px
}

input:focus+label {
    color: #1E88E5
}

#qr {
    margin-bottom: 150px;
    margin-top: 50px
}
</style>

<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		  <?php if($error){?><div class="errorWrap"><strong style="color: white;"> ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong style="color: white;">SUCCESS :    <?php echo htmlentities($msg); ?></strong> </div><?php }?>
<?php 
$pid=intval($_GET['pkgid']);
$sql = "SELECT * from tbltourpackages where PackageId=:pid";
$query = $dbh->prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
	# print_r($results);
foreach($results as $result)
{	?>

<form name="book" method="post">




<!--- /banner ---->
<!--- rooms ---->
<div class="rooms">
	<div class="container">
		
		<div class="room-bottom">
      
        <div class="container-fluid px-0" id="bg-div">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-12">
            <div class="card card0">
                <div class="d-flex" id="wrapper">
                    <!-- Sidebar -->
    

                   


                    <!-- Page Content -->
                    
                    <div id="page-content-wrapper">
                        <div class="row pt-3" id="border-btm">
                        <h2>Booking form</h2>
                            <div class="col-8">
                                <div class="row justify-content-right">
                                    <div class="col-12">
                                        <p class="mb-0 mr-4 mt-4 text-right"><?php echo htmlentities($_SESSION['login']);?></p>
                                    </div>
                                </div>
                                <div class="row justify-content-right">
                                    <div class="col-12">
                                        
                                        <p class="mb-0 mr-4 text-right" name="pay">Price :- <?php echo htmlentities($_SESSION['tour_price']);?> <span class="top-highlight"></span> </p>
                                    </div>
                                    
                                </div>

                         
                            </div>
                        </div>
                        
                       
                                                <div class="ban-bottom">
                                                    							
				<!--<div class="bnr-right">
				<label class="inputLabel">From</label>
				<input  type="date" placeholder="dd-mm-yyyy"  name="fromdate" required="">
			</div>
			<div class="bnr-right">
				<label class="inputLabel">To</label>
				<input  type="date" placeholder="dd-mm-yyyy" name="todate" required="">
			</div>-->
            <div class="form-group">
													<span class="form-label">Adult</span>
													<input class="form-control" type="text" name="subject" id="subject" value="0" required="">

												</div>
												<div class="form-group">
													<span class="form-label">Children</span>
													<input class="form-control" type="text" name="chil" id="chil" value="0" required="">
												</div>
			</div> 


            <?php
												$pack_price =  htmlentities($result->PackagePrice);


												$num1 = $_POST['subject'];
												$num2 = $_POST['chil'];
												$sum = $num1 + $num2;
												$final_price =  $sum * $pack_price;
                                               
												?>



            <div class="form-group">
													<span class="form-label">Total people in Your Group:</span>
													<input readonly class="form-control" value="0" name="totalPeople" id="totalPeople" type="text">
												</div>
                                                <div class="form-group">
													<span class="form-label">Offer:</span>
													<input readonly class="form-control" type="text" name="Offer" id="Offer" value="<?php echo htmlentities($result->Offer);?>%">
												</div>
                                                <div class="form-group">
													<span class="form-label">Payment:</span>
													<input readonly class="form-control" type="text" name="pay" id="pay" value="<?php echo htmlentities($result->PackagePrice);?>">
												</div>



                         
                                                <?php 
					if(!$msg){
					if($_SESSION['login'])
					{
						$_SESSION['tour_price'] = $results[0]->PackagePrice;
                        
						?>
						<p class="spe" align="center">
							
					<button type="submit" name="submit2" class="btn-primary btn">Pay</button></a>
                    </p>
						<?php } else {?>
							<p class="sigi" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn" > Book</a></p>
							<?php } }?>
                            <div class="clearfix"></div>
                                            </form>
                                            <?php }}?>
                            
                                            

                                                <!--<div class="row">
                                                    <div class="col-md-12"> <input type="submit" name="submit2" value="Pay :<?php echo htmlentities($_SESSION['tour_price']);?> " class="btn btn-success placeicon"> </div>
                                                </div>-->
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <p class="text-center mb-5" id="below-btn"><a href="index.php">BACK TO HOME</a></p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




			
		
		
		</div>
	</div>
</div>


<!--- /rooms ---->

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
<!-- //write us -->

    <script>
			let child = document.getElementById('chil');
			let adult = document.getElementById('subject');
			let total = document.getElementById('totalPeople');
            let Offer = document.getElementById('Offer');
            let pay = document.getElementById('pay');
			console.log(total)

			child.addEventListener('change', (e) => {
				total.value = parseInt(child.value) + parseInt(adult.value);
				document.cookie=`total=${total.value}`;
			})
			/*adult.addEventListener('change', (e) => {
				total.value = parseInt(child.value) * parseInt(adult.value);
				document.cookie=`total=${total.value}`;
			})*/

			child.addEventListener('change', (e) => {
				pay.value = parseInt(total.value) * parseInt(pay.value);
				document.cookie=`pay=${pay.value}`;
			})

            child.addEventListener('change', (e) => {
				pay.value = pay.value - ((parseInt(Offer.value.replace("%",""))/100)*pay.value) ;
				document.cookie=`pay=${pay.value}`;
			})
		
		</script>
</body>
</html>