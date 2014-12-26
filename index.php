<?php  
	require_once 'php/autoloads.php'; 
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Auto Experto</title>
	
	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/vendor/jquery.jscrollpane.css" />
	<link rel="stylesheet" href="css/main.css" />
	
	<!-- Scripts -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script src="js/vendor/gmap3.js"></script>
	<script src="js/vendor/jquery.mousewheel.js"></script>
	<script src="js/vendor/jquery.jscrollpane.min.js"></script>
</head>
<body>
	<div id="wrap">
		<div class="col-left">
			<div class="title">
				<img src="images/icos/instagram.jpg" alt="Instagram" />
				<h2>Espacio creado para la comunidad.</h2>
			</div>
			<div class="desc">
				<div class="img">
					<img src="images/icos/car.png" alt="AUTOEXPERTOTEAYUDA" />
				</div>
				<h2>#autoexpertoteayuda</h2>
				<span>Sube fotos a instagram lorem Ipsum is simply dummy text of the printing and typesetting industry</span>
			</div>
			<div class="thumbs">
				<div class="thumbs-inner">
				</div>
			</div>
		</div>
		<div class="col-right">
			<div id="gmap"></div>
		</div>
	</div>
	<!-- Scripts -->
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
