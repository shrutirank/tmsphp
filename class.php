<?php

$conn=mysqli_connect("localhost","root","");
mysqli_select_db($conn,"tms");
$nameid=$_POST['datapost'];
$q="select * from city where state_id='$nameid'";
$result=mysqli_query($conn,$q);
while ($row=mysqli_fetch_array($result))
{
?>

	<option><?php echo $row['cname']; ?></option>
	<?php 	
}
?>



