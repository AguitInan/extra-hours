<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>Ajout d'un Evènement</title>
		<meta name="" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="images/x-icon" href="" />
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery.ui.datepicker-fr.js"></script>
		<script type="text/javascript" src="bootstrap/js/ui/jquery-ui-timepicker-addon.js"></script>
		<style>
		input{height:15px};
		</style>
	</head>
	<body>

		<?php

		// Formulaire d'ajout d'un évènement
		HlpForm::Start(array('url' =>'ajoutEvenement2.php','action'=>'post','titre'=>'Formulaire d\'ajout d\'évènement'));
		HlpForm::MultiInput(array('Date'));
		HlpForm::Select2(Listage_Tableau('Categorie_Evenement', 'Categorie_Evenement', 'Categorie_Evenement'),'Catégories d\'Evènements','Categorie_Evenement');
		HlpForm::MultiInput(array('No_Manifestation','Nom_Evenement','Type_Evenement','Heure_Debut','Heure_Fin'));
		HlpForm::Submit();
				
		?>


		<script>

		// Configuration du DatePicker
		jQuery.datepicker.setDefaults(jQuery.datepicker.regional['fr']);
		$(function() {
			$( "#Date" ).datepicker({
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
		});

		// Configuration des TimePicker
		jQuery(function(){
			$( "#Heure_Debut, #Heure_Fin" ).timepicker({
				timeOnlyTitle: 'Choisir Heure',
				timeText: 'Heure',
				hourText: 'Heures',
				minuteText: 'Minutes',
				secondText: 'Secondes',
				currentText: 'Maintenant',
				closeText: 'Fermer'

			});
		});


		</script>

	</body>
	
</html>