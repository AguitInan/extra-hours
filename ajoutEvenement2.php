<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

	
	// Fonction appelée par le formulaire formulaireEvenement2.php pour ajouter un évènement dans la base de données

	// On récupère les valeurs entrées dans le formulaire que l'on stocke dans le tableau $array_Values
	$array_Values = array();
	$array_Values['ID_Evenement'] = '';
	$array_Values['Date_Saisie'] = date("Y-m-d");
	$array_Values['Date'] = $_POST['Date'];
	$array_Values['Categorie_Evenement'] = $_POST['Categorie_Evenement'];
	$array_Values['No_Manifestation'] = $_POST['No_Manifestation'];
	$array_Values['Nom_Evenement'] = $_POST['Nom_Evenement'];
	$array_Values['Type_Evenement'] = $_POST['Type_Evenement'];
	$array_Values['Heure_Debut'] = $_POST['Heure_Debut'];
	$array_Values['Heure_Fin'] = $_POST['Heure_Fin'];

	// On copie $array_Values dans $array_Values_Insert qui nous servira pour vérifer si l'évènement existe déjà
	$array_Values_Insert = $array_Values;

	//On récupère l'index du premier élément du tableau
	list($id, ) = each($array_Values_Insert);
	//On efface le premier élément du tableau
	unset($array_Values_Insert[$id]);

	// Vérification de l'existance de l'évènement avant de l'ajouter pour éviter les doublons
	try
	{
		// Connexion à la base de données
		$connexion = Get_cnx();
		$chaine_Where = toString_WHERE($array_Values_Insert);
		$req = 'SELECT ID_Evenement FROM Evenement WHERE '.$chaine_Where;
		$st = $connexion->query($req);
		$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
		if($donnees == FALSE){
			
			// On n'a pas trouvé d'évènement avec les mêmes données donc on peut l'ajouter dans la base de données
			INSERT ('Evenement',$array_Values);
				
		}
		$st -> closeCursor();
		
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}

	// Retour à la page des évènements
	header('Location: evenement.php');
		
?>
