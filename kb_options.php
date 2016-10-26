<?php
$share="";
$excercise="";
$rf_interest="";
$volatility ="";
$time="";
$O_out="";
$O_outlabel="";
$f="";
function calculate_option()
{//begin function calculate_option
$op=$O_out="";
$share=$excercise=$rf_interest=$volatility=$time="";
$O_outlabel="";

if (isset($_POST['share'])) $share = sanitizeString($_POST['share']);
if (isset($_POST['excercise'])) $excercise = sanitizeString($_POST['excercise']);
if (isset($_POST['rf_interest'])) $rf_interest = sanitizeString($_POST['rf_interest']);
if (isset($_POST['volatility'])) $volatility = sanitizeString($_POST['volatility']);
if (isset($_POST['time'])) $time = sanitizeString($_POST['time']);
if (isset($_POST['op'])) $op = sanitizeString($_POST['op']);


$d1=(log($share/($excercise+.00001))+($rf_interest/100+$volatility/100*$volatility/100/2)*$time)/(($volatility+.00001)/100*pow(($time+.00001),.5));
$d2= $d1-$volatility/100*pow($time,.5);

if($op == 'call')

{
	$answer = $share*cumnormdist($d1)-$excercise*cumnormdist($d2)*exp(-$rf_interest/100*$time);
	$O_out = $answer;
	$O_outlabel='price call option';
}

elseif($op == 'put')
{
	$answer = $excercise*cumnormdist(-$d2)*exp(-$rf_interest/100*$time)-$share*cumnormdist(-$d1);
	$O_out = $answer;
	$O_outlabel='price put option';
}


else $O_out = "";

return array($O_out,$O_outlabel,$share,$excercise,$rf_interest,$volatility,$time,$d1);



}//end function calculate_option


function sanitizeString($var)
{
	$var = stripslashes($var);
	$var = strip_tags($var);
	$var = htmlentities($var);
	return $var;
}

function cumnormdist($x)
{
	$b1 =  0.319381530;
	$b2 = -0.356563782;
	$b3 =  1.781477937;
	$b4 = -1.821255978;
	$b5 =  1.330274429;
	$p  =  0.2316419;
	$c  =  0.39894228;

	if($x >= 0.0) {
		$t = 1.0 / ( 1.0 + $p * $x );
		return (1.0 - $c * exp( -$x * $x / 2.0 ) * $t *
				( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
	}
	else {
		$t = 1.0 / ( 1.0 - $p * $x );
		return ( $c * exp( -$x * $x / 2.0 ) * $t *
				( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
	}
}



list($x,$y,$a,$b,$c,$d,$e,$f)=calculate_option($O_out,$O_outlabel,$share,$excercise,$rf_interest,$volatility,$time,$f);
$O_out=$x;
$O_outlabel=$y;
$share=$a;
$excercise=$b;
$rf_interest=$c;
$volatility=$d;
$time=$e;
$O_out= number_format($O_out*1.,2,".",",");

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

 	
   
    <form method="post" action="kb_options.php">
          
          
        <table>
        <tr>
        <td>
        <input type = "radio"
                 name = "op"
                 id = "put"
                 value = "put"
                 />
          <label for = "put">Put Option</label></td>
        </tr>
        <tr>
          <td>
         <input type = "radio"
                 name = "op"
                 id = "call"
                 value=call
                />                
          <label for = "call">Call Option</label>
          </td>
          <td>
          </td>
         </tr>
         
         </table><br>
       
        
      
        <input type="text" name="share" size="7" value=$share>share price<br>
        <input type="text" name="excercise" size="7" value=$excercise>excercise price<br>
        <input type="text" name="rf_interest" size="7" value=$rf_interest>risk free interest rate %<br>
        <input type="text" name="volatility" size="7" value=$volatility>volatility %<br>
        <input type="text" name="time" size="7" value=$time>years to maturity<br><br><br>
        
        
        <input type="submit" value="Calculate"><hr>
     
        
       </form>
       <em>$O_outlabel</em>
    	<h1>$O_out</h1></b>  	
        		
</div>

 

</body>
</html>

_END

?>