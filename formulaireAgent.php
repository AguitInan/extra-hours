<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Ajout d'un Agent</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker-fr.js"></script>
		<style>
		input{height:15px};
		</style>
	</head>
	<body>


		<?php
		
		// Formulaire d'ajout d'un nouvel agent
		HlpForm::Start(array('url' =>'ajoutAgent.php','action'=>'post','titre'=>'Formulaire d\'ajout d\'agent'));
		HlpForm::MultiInput(array('Nom','Prenom','Fonction','Date_Entree_Collectivite','Matricule','Profil'));
		HlpForm::Select2(Listage_Tableau('Collectivite', 'ID_Collectivite', 'Collectivite'),'Collectivite','ID_Collectivite');
		HlpForm::Select2(Listage_Tableau('Service', 'ID_Service', 'Service'),'Service','ID_Service');
		HlpForm::Submit();
				
		?>


		<script>
		
		// Configuration du DatePicker
		jQuery.datepicker.setDefaults(jQuery.datepicker.regional['fr']);
		$(function() {
			$( "#Date_Entree_Collectivite" ).datepicker({
				showButtonPanel: true,
				changeMonth:true,
				changeYear:true,
				dateFormat: 'yy-mm-dd'
			});
		});

		</script>

	</body>
</html>