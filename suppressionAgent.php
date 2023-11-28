<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Suppression d'un Agent</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="images/x-icon" href="" />

		<style>
		input{height:15px};
		</style>
	</head>
	<body>

	
	<?php

	// Demande de confirmation de la suppression de l'agent
	echo '<fieldset>
					<legend>
						Voulez-vous vraiment supprimer cet agent ?
					</legend>
		
					<div class="bottom-space25"></div>
					<div class="form-horizontal">
					 <a href="supprAgent.php?ID_Agent='.$_GET['ID_Agent'].'" id="bouton3" class="btn btn-danger btn-large">Oui</a>
					 <a href="accueil.php" id="bouton3" class="btn btn-large">Non</a>
					</div>
			
		  </fieldset>';
		  
	?>

	</body>
</html>