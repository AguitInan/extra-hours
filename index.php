<?php

require '/tools/helper.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Authentification DHS</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="bootstrap/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
		<style>
		input{height:15px};
		</style>
	</head>
	<body>
		<div class="container-fluid">
		  <div class="row-fluid">
			<div class="span10">
			
			<?php
			
			// Formulaire d'authentification
			HlpForm::Start(array('url' =>'accueil.php','action'=>'post','titre'=>'Authentification'));
			HlpForm::Input('Login');
			HlpForm::Inputpwd('Password');
			HlpForm::Submit();
			?>
			
			</div>
		  </div>
		</div>
		<div class="footer-content">
			<div class="footer-text">
				Mairie de Beauvais - communauté d'agglomération du Beauvaisis
			</div>	
		</div>
	</body>
</html>