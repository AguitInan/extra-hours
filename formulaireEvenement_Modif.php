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

		try
		{
			
			// Connexion à la base de données
			$connexion = Get_cnx();
			$req = 'SELECT * FROM Evenement WHERE ID_Evenement = "'.$_GET['ID_Evenement'].'"';
			$st = $connexion->query($req);
			$donnees = $st->fetch( PDO::FETCH_OBJ);
			
			// Formulaire de modification de l'évènement
			HlpForm::Start(array('url' =>'modifEvenement.php','action'=>'post','titre'=>'Formulaire de modification d\'évènement'));
			echo '<input type="hidden" name="ID_Evenement" value="'.$_GET['ID_Evenement'].'" />';
			HlpForm::MultiInput2(array('Date'=>$donnees->Date));
			HlpForm::Select3(Listage_Tableau('Categorie_Evenement', 'Categorie_Evenement', 'Categorie_Evenement'),'Catégories d\'Evènements','Categorie_Evenement', $donnees->Categorie_Evenement);
			HlpForm::MultiInput2(array('No_Manifestation'=>$donnees->No_Manifestation,'Nom_Evenement'=>$donnees->Nom_Evenement,'Type_Evenement'=>$donnees->Type_Evenement,'Heure_Debut'=>$donnees->Heure_Debut,'Heure_Fin'=>$donnees->Heure_Fin));
			HlpForm::Submit();
		
		}
		catch(Exception $f)
		{
			echo 'err : '.$f->getMessage().'<br />';
		}

						
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