<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
	
		<title>Modification d'un Agent</title>
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

		try
		{
		
			// Connexion à la base de données
			$connexion = Get_cnx();
			$req = 'SELECT * FROM Agent WHERE ID_Agent = "'.$_GET['ID_Agent'].'"';
			$st = $connexion->query($req);
			$donnees = $st->fetch( PDO::FETCH_OBJ);
			$login2 = $donnees->ID_Login;
			
			// Formulaire de modification de l'agent
			HlpForm::Start(array('url' =>'modifAgent.php','action'=>'post','titre'=>'Formulaire de modification d\'agent'));
			echo '<input type="hidden" name="ID_Agent" value="'.$_GET['ID_Agent'].'" />';
			HlpForm::MultiInput2(array('Nom' =>$donnees->Nom,'Prenom' =>$donnees->Prenom,'Fonction' =>$donnees->Fonction,'Date_Entree_Collectivite' =>$donnees->Date_Entree_Collectivite,'Matricule' =>$donnees->Matricule));
			HlpForm::Select3(Listage_Tableau('Collectivite', 'ID_Collectivite', 'Collectivite'),'Collectivite','ID_Collectivite',$donnees->ID_Collectivite);
			HlpForm::Select3(Listage_Tableau('Service', 'ID_Service', 'Service'),'Service','ID_Service',$donnees->ID_Service);
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
			$( "#Date_Entree_Collectivite" ).datepicker({
				showButtonPanel: true,
				dateFormat: 'yy-mm-dd'
			});
		});
		
		</script>

	</body>	
</html>