<?php

require '/tools/helper.php';
require 'fonctions_mySQL.php';

		
	// Fonction appelée par le formulaire formulaireAgent.php pour ajouter un agent dans la base de données

	$array_Values2 = array();
	$array_Values2['ID_Login'] = '';
	$array_Values2['Login'] = $_POST['Nom'];  // par défaut le login de l'agent créé sera son Nom
	$array_Values2['Password'] = md5('PASSWORD');  // génération du mot de passe, par défaut le mot de passe sera "PASSWORD"
	$array_Values2['Profil'] = "Utilisateur";  // par défaut le profil de l'agent créé sera "Utilisateur"

	// On ajoute une nouvelle entrée dans la table Login
	INSERT ('Login',$array_Values2);

	$array_Values['Nom'] = $_POST['Nom'];
	try
	{
		// Connexion à la base de données
		$connexion = Get_cnx();
		$req = 'SELECT ID_Login FROM Login WHERE Login = "'.$array_Values2['Login'].'"';
		$st = $connexion->query($req);
		$donnees = $st -> fetch( PDO::FETCH_ASSOC);

		$var = "";
		foreach($donnees as $key => $val)
		{
			// On stocke dans la variable $var l'ID_Login de l'agent pour donner le même dans la table Agent
			$var = $val;
		
		}

		$st -> closeCursor();
		$connexion = null;
		
	}	
	catch(Exception $f)
	{
		echo 'err : '.$f->getMessage().'<br />';
	}

	echo '<br/>';

	// On récupère les valeurs entrées dans le formulaire que l'on stocke dans le tableau $array_Values
	$array_Values = array();

	// L'ID_Agent du nouvel agent sera le même que son ID_Login
	$array_Values['ID_Agent'] = $var;
	$array_Values['Nom'] = $_POST['Nom'];
	$array_Values['Prenom'] = $_POST['Prenom'];
	$array_Values['Fonction'] = $_POST['Fonction'];
	$array_Values['Date_Entree_Collectivite'] = $_POST['Date_Entree_Collectivite'];
	$array_Values['Matricule'] = $_POST['Matricule'];
	$array_Values['ID_Collectivite'] = $_POST['ID_Collectivite'];
	$array_Values['ID_Service'] = $_POST['ID_Service'];
	$array_Values['ID_Login'] = $var;

	// On ajoute une nouvelle entrée dans la table Agent
	INSERT ('Agent',$array_Values);

	// Retour à la page d'accueil
	header('Location: accueil.php');

?>