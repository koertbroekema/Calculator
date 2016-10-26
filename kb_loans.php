<?php
$principal="";
$interest="";
$periods="";
$op="";
$tot_interest=0;
$tot_payback=0;
$tot_tot=0;
$outlabel="";


if (isset($_POST['principal'])) $principal = sanitizeString($_POST['principal']);
if (isset($_POST['interest'])) $interest = sanitizeString($_POST['interest']);
if (isset($_POST['periods'])) $periods = sanitizeString($_POST['periods']);
if (isset($_POST['op'])) $op = sanitizeString($_POST['op']);

$payback=$principal/($periods+.000001);

function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}




echo'<!DOCTYPE html>
<html lang="en">
<head>
  <title>Financial Calculators</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
';

echo "
<form method='post' action='kb_loans.php'>

		

<table>
<tr>
<td>
<input type = 'radio'
		name = 'op'
		id = 'linear'
		value = 'linear'
		/>
		<label for = 'lineart'>Linear payback</label></td>
		</tr>
		<tr>
		<td>
		<input type = 'radio'
		name = 'op'
		id = 'annuity'
		value=annuity
		/>
		<label for = 'annuity'>Annuity payback</label>
		</td>
		<td>
		</td>
		</tr>														 
		</table><br>
";
echo "<input type='text' name='principal' size='7' value=$principal>Principal<br>
	<input type='text' name='interest' size='7' value=$interest>Interest<br>
	<input type='text' name='periods' size='7' value=$periods>periods<br>
	<br>
	<input type='submit' value='Calculate'><hr>						 

	</form>
		";

//LINEAR______________________________________________
if($op =='linear'){
	$outlabel="linear payback";
	for ($x = 0; $x <= $periods; $x++) {
	
		$loan[$x]=array($x,$principal-$x*$payback,($principal-($x-1)*$payback)*$interest/100,$payback,($principal-($x-1)*$payback)*$interest/100+$payback);
	
	}
$i=0;
echo "<em>".$outlabel."</em><br>";	
echo "<table>";
if($principal!=""||$interest!=""||$periods!=""){
echo 	"<tr>
		<td><h3>Period</h3></td>
		<td><h3>Principal</h3></td>
		<td><h3>Interest</h3></td>
		<td><h3>Payback</h3></td>
		<td><h3>Total</h3></td>
		</tr>";
echo "<tr><td>0</td><td>$principal</td></tr>";
}

foreach($loan as $row)
{
	echo "<tr>";
	foreach($row as $piece)
	{
		$piece= number_format($piece*1.,0,".",",");
		if($i>0){
		echo "<td width='120'>";
		echo $piece;
		echo "</td>";		
		}
	}
 	echo "</tr>";
	$i=$i+1;
	if($i>=2){$tot_interest=$tot_interest+$row[2];}
	if($i>=2){$tot_payback=$tot_payback+$row[3];}
	if($i>=2){$tot_tot=$tot_tot+$row[4];}
}
$tot_interest= number_format($tot_interest*1.,0,".",",");
$tot_payback= number_format($tot_payback*1.,0,".",",");
$tot_tot= number_format($tot_tot*1.,0,".",",");

if($principal!=""||$interest!=""||$periods!=""){
echo 	"<tr></tr><tr>
		<td><h3>Total</h3></td>
		<td><h3></h3></td>
		<td ><h3>$tot_interest</h3></td>
		<td ><h3>$tot_payback</h3></td>
		<td ><h3>$tot_tot</h3></td>
		</tr>";
echo "</table>";
}
}
//ANNUITY_______________________________________________
if($op =='annuity'){
	$outlabel="annuity payback, payments end of period";
	

	$ann=$principal*($interest/100)/(1-pow((1+$interest/100),-$periods))*1/(1+$interest/100);
	$ann=$ann*(1+$interest/100);
	$principal_r=$principal;
	$interest_r=0;
	$payback=0;
			
	for ($x = 0; $x <= $periods	; $x++) {
				
		if($x==0)
		{
			$interest_r=0;
			$payback=0;
			
		}
		if($x==1)
		{
			$interest_r=$principal*$interest/100;
			$payback=($ann-$interest_r);
			$principal_r=$principal-$payback;
		}
		
		if($x>1)
		{	
			$interest_r=$principal_r*$interest/100;
			$payback=($ann-$interest_r);
			$principal_r=$principal_r-$payback;
			
			
		}
		
		//echo $x."________ ".$payback."________ ".$interest_r."<br>";
		
		$loan[$x]=array(
			$x,
			$principal_r,
			$interest_r,
			$payback,
			$ann				
	);
				
}
$i=0;	
	echo "<em>".$outlabel."</em><br>";
	echo "<table>";
	if($principal!=""||$interest!=""||$periods!=""){
		echo 	"<tr>
		<td><h3>Period</h3></td>
		<td><h3>Principal</h3></td>
		<td><h3>Interest</h3></td>
		<td><h3>Payback</h3></td>
		<td><h3>Total</h3></td>
		</tr>";
		echo "<tr><td>0</td><td>$principal</td></tr>";
	}

	foreach($loan as $row)
	{
		echo "<tr>";
		foreach($row as $piece)
		{
			$piece= number_format($piece*1.,0,".",",");
			if($i>0){
				echo "<td width='120'>";
				echo $piece;
				echo "</td>";
			}
		}
		echo "</tr>";
		$i=$i+1;
		if($i>=2){$tot_interest=$tot_interest+$row[2];}
		if($i>=2){$tot_payback=$tot_payback+$row[3];}
		if($i>=2){$tot_tot=$tot_tot+$row[4];}
	}
	$tot_interest= number_format($tot_interest*1.,0,".",",");
	$tot_payback= number_format($tot_payback*1.,0,".",",");
	$tot_tot= number_format($tot_tot*1.,0,".",",");

	if($principal!=""||$interest!=""||$periods!=""){
		echo 	"<tr></tr><tr>
		<td><h3>Total</h3></td>
		<td><h3></h3></td>
		<td ><h3>$tot_interest</h3></td>
		<td ><h3>$tot_payback</h3></td>
		<td ><h3>$tot_tot</h3></td>
		</tr>";
		echo "</table>";
	}
}

echo "</body></html>";
?>