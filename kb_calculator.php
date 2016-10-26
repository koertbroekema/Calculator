<?php

echo <<<_END

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Financial Calculator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>

<div class="container">
  <h2>Financial Calculator</h2>
	<em>Very basic calculator, not for professional use</em><br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#interest">Interest</a></li>
    <li><a data-toggle="tab" href="#options">Options</a></li>
    <li><a data-toggle="tab" href="#loans">Loans</a></li>
    
  </ul>

  <div class="tab-content">

    <div id="interest" class="tab-pane fade in active">
      	<iframe 
			src=kb_interest.php height="800""width="800" 			style="border:none;">
	 	</iframe>    
    </div>

    <div id="options" class="tab-pane fade">      
    		<iframe 
			src=kb_options.php height="800""width="800" 			style="border:none;">
		</iframe>
	</div>

 
 	<div id="loans" class="tab-pane fade">      
    		<iframe 
			src=kb_loans.php height="800" width="800" 				style="border:none;">
		</iframe>
	</div>		 		

</body>
</html>

_END

?>
