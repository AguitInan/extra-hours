<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

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

		
		<?php
		
		// Fichier de mise à jour des agents liés à l'évènement
			
		$array_Where = array();
		$array_Where['ID_Evenement'] = $_GET["id_evenement"];
		
		// On efface les agent liés à l'évènement
		DELETE ('Agent_Evenement',$array_Where);
		
		// Récupération du tableau JS $tab_js contenant les ID des agents à lier à l'évènement
		$tab_js=explode(',',$_GET["tab_js"]);
		
		// Récupération du tableau JS $bool contenant les valeurs du booléen Payer
		$bool=explode(',',$_GET["bool"]);
		$taille = (count($tab_js));
		
		$array_Values = array();
			
		for ($i = 0 ; $i < $taille ; $i++) {
		
			$array_Values['ID_Agent'] = $tab_js[$i];
			$array_Values['ID_Evenement'] = $_GET["id_evenement"];
			$array_Values['Payer'] = $bool[$i];
			
			// On ajoute les données dans la table Agent_Evenement
			INSERT ('Agent_Evenement',$array_Values);
		
		}
		
		// Retour à la page de l'évènement que l'on vient de mettre à jour
		header('Location: evenement2.php?id_evenement='.$_GET["id_evenement"]);
		
		?>
		
	</body>
</html>