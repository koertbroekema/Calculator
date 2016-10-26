<?php
$amount="";
$interest="";
$periods="";
$op ="";
$out="";
$outlabel="";

function calculate_interest($amount,$interest,$periods)
{//start function calculate_interest

$amount="";
$interest="";
$periods="";
$out=$op="";	
$outlabel="";

	if (isset($_POST['amount'])) $amount = sanitizeString($_POST['amount']);
	if (isset($_POST['interest'])) $interest = sanitizeString($_POST['interest']);
	if (isset($_POST['periods'])) $periods = sanitizeString($_POST['periods']);
	if (isset($_POST['op'])) $op = sanitizeString($_POST['op']);
	

	if ($op == 'pv')
	{
		$answer = $amount/pow((1+$interest/100),$periods);
		$out = "$answer";
		$outlabel='present value';
	}

	elseif ($op == 'fv')
	{
		$answer = $amount*pow((1+$interest/100),$periods);
		$out = "$answer";
		$outlabel='future value';
	}
	elseif($op == 'ann')
	{
		$answer = $amount*($interest/100)/(1-pow((1+$interest/100),-$periods))*1/(1+$interest/100);
		$out = $answer;
		$outlabel='annuity, payments begin period';
	}

	elseif($op == 'pv_ann')
	{
		$answer =$amount+$amount* ((1-pow((1+$interest/100),-($periods-1)))/($interest/100));
		$out = $answer;
		$outlabel='present value annuity';
	}
	elseif($op == 'fv_ann')
	{
		$answer = (1+$interest/100)*$amount*((pow((1+$interest/100),$periods)-1)/($interest/100));
		$out = $answer;
		$outlabel='future value annuity';
	}

	else $out = "";

	$out= number_format($out*1.,2,".",",");

	return array($out,$outlabel,$amount,$interest,$periods);
}//end function calculate_interest



function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}


list($x,$y,$a,$b,$c)=calculate_interest($amount,$interest,$periods);
$out=$x;
$outlabel=$y;
$amount=$a;
$interest=$b;
$periods=$c;

echo <<<_END
<!DOCTYPE html>
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

   
    <form method="post" action="kb_interest.php">
          
          
        <table>
        <tr>
        <td>
        <input type = "radio"
                 name = "op"
                 id = "pv"
                 value = "pv"
                 />
          <label for = "pv">PV</label> 
          </td>
          <td>
         <input type = "radio"
                 name = "op"
                 id = "fv"
                 value='fv'
                />                
          <label for = "fv">FV</label>
          </td>
          <td>
          </td>
         </tr>
         
          <tr>
          <td> 
          <input type = "radio"
                 name = "op"
                 id = "ann"
                 value = "ann" 
              	
                 />
          <label for = "ann">ANN</label> 
          </td>
          <td>
           <input type = "radio"
                 name = "op"
                 id = "pv_ann"
                 value = "pv_ann" 
                
                 />
          <label for = "pv_ann">PV ANN</label> 
          </td>
          <td>
           <input type = "radio"
                 name = "op"
                 id = "fv_ann"
                 value = "fv_ann" 
               
                 />
          <label for = "fv_ann">FV ANN</label>
          </td></tr>
          </table><br>
       
        
      
        <input type="text" name="amount" size="7" value= $amount>amount<br>
        <input type="text" name="interest" size="7" value=$interest>interest %<br>
        <input type="text" name="periods" size="7" value=$periods>periods<br><br>
        <input type="submit" value="Calculate"><hr>
     
             
       </form>
       <em>$outlabel</em>
       <h1>$out</h1><br>
       </div>   
</body>
</html>

_END

?>