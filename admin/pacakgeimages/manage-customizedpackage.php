<?php
session_start();
error_reporting(0);
$server = "localhost";
$username = "root";
$password = "";
$dbname = "tms";
$conn = mysqli_connect($server , $username , $password , $dbname);


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Shyaam Holidays | Admin manage customized package</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
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
    });
</script>
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
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Customized Package</li>
            </ol>

            <div class="agile-grids">	
				<!-- tables -->
				<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Manage Customize Package</h2>
					    <table id="table">
						<thead>
						  <tr>
                <th>id</th>
						  <th>Package Name</th>
							<th>Package Type</th>
							<th>Price</th>
							<th>Location</th>
							<th>From Date</th>
              <th>To Date</th>
              <th>Posting date </th>
							<th>Action </th>
						  </tr>
            </thead>
              <?php
              $query = "select * from tblcustomizedpackage";
              $connect = mysqli_query($conn,$query);
              

                
                          while($data = mysqli_fetch_array($connect))
                          {
                            ?>
                    
                              <tr>
                              <td><?php echo $data['pid'];?></td>
                              <td><?php echo $data['pname'];?></td>
                              <td><?php echo $data['ptype'];?></td>
                              <td><?php echo $data['pprice'];?></td>
                              <td><?php echo $data['plocation'];?></td>
                              <td><?php echo $data['pfdate'];?></td>
                              <td><?php echo $data['ptdate'];?></td>
                              <td><?php echo $data['postingdate'];?></td>
                              <td>
                              <?php 
                              if($data['status']==NULL)
                              {
                                echo '<p><a href ="manage-customizedpackage.php?pid='.$data['pid'].'&status=1">Read</a></p>';
                                
                              }
                              else
                              {
                                echo '<p><a href ="manage-customizedpackage.php?pid='.$data['pid'].'&status=0">cancle</a></p>';
                              }
                              ?>
      
                            
                          
              
      <?php }?>
              
						</thead>
						</table>
						</div>
			

						
<!-- /script-for sticky-nav -->




  <!--//content-inner-->
<!--/sidebar-menu-->
<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							  </div>
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
   <!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here--> 
   </body>
</html>
 
