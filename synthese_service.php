<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<?php

require 'verif_login.php';
require '/fonctions_heures.php';
require '/tools/helper.php';

?>


<style>
.tableau th, .tableau td{
	text-align: center;
	vertical-align:middle;
}
.table tbody tr td .recup{
	background-color : grey;
}
#recupjour1, #recupjour2, #recupdim, #recupnuit{
	background-color: #B4AF91;
}
</style>


<?php

// Synthèse du service
echo '</br><h2><em>SYNTHESE DU SERVICE</em>
		<a href="accueil.php" class="btn btn-large">Retour à l\'accueil</a></h2>
		<br/>';

$tab_mois = array ("01"=>'Janvier', "02"=>'Février', "03"=>'Mars', "04"=>'Avril', "05"=>'Mai', "06"=>'Juin', "07"=>'Juillet', "08"=>'Août', "09"=>'Septembre', "10"=>'Octobre', "11"=>'Novembre', "12"=>'Décembre');

for($i=2012 ; $i <= 2100 ; $i++){

	$tab_annee [$i] = $i;
}

// Formulaire de sélection de la Période		
HlpForm::Start(array('url' =>'synthese_service.php','action'=>'get','titre'=>'Choisir Période'));


// Si une Période est sélectionné alors on affiche la synthèse du mois correspondant sinon...
if(isset($_GET['Mois'])){

	HlpForm::Select3($tab_mois,'Mois','Mois', $_GET['Mois']);
	HlpForm::Select3($tab_annee,'Annee','Annee', $_GET['Annee']);

// ... on affiche la synthèse du mois en cours
}else{

	HlpForm::Select3($tab_mois,'Mois','Mois', substr(date("Y-m-d"), 5, -3));
	HlpForm::Select3($tab_annee,'Annee','Annee', substr(date("Y-m-d"), 0, 4));
	
}

HlpForm::Submit();


try
{	
	$connexion = Get_cnx();	
	$req = 'SELECT Service FROM Service WHERE ID_Service = (SELECT ID_Service FROM Agent WHERE ID_Agent = '.$_SESSION["ID_Login"].')';
	$st = $connexion->query($req);
	while($obj = $st->fetch(PDO::FETCH_OBJ)){
	
		$_SESSION["Service"] = $obj->Service;
	
	}

	$st -> closeCursor();

}	
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}

// On affiche le service
echo 'Service : '.$_SESSION["Service"];

// On affiche la Période
if (isset ($_GET['Mois'])){

	echo '<div align="right"><b>'.$tab_mois[$_GET['Mois']].' '.$_GET['Annee'].'</b></div><br/><br/>';
	
}else{			

	echo '<div align="right"><b>'.$tab_mois[substr(date("Y-m-d"), 5, -3)].' '.substr(date("Y-m-d"), 0, 4).'</b></div><br/><br/>';
	
}


if(isset($_GET['Mois'])){
		
	$mois = $_GET['Mois'];
	$annee = $_GET['Annee'];
		
}else{

	$mois = substr(date("Y-m-d"), 5, -3);
	$annee = substr(date("Y-m-d"), 0, 4);
	
}


try
{
	// On récupère la liste des ID des agents du service qui ont au moins un évènement dans le mois sélectionné que l'on stocke dans le tableau $id	
	$req = 'SELECT DISTINCT ID_Agent FROM Agent_Evenement WHERE ID_Evenement IN (SELECT ID_Evenement FROM Evenement WHERE Date LIKE "'.$annee.'-'.$mois.'%") AND ID_Agent IN (SELECT ID_Agent FROM Agent WHERE ID_Service IN (SELECT ID_Service FROM Agent WHERE ID_Agent = "'.$_SESSION['ID_Login'].'")) ORDER BY ID_Agent';
	$st = $connexion->query($req);
	$id = array();
	while($obj = $st->fetch(PDO::FETCH_OBJ)){
	
		$id[] = $obj->ID_Agent;
		
	}

	$st -> closeCursor();

}	
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}


try
{
	
	if (isset ($_GET['Mois'])){
	
		$periode = $_GET['Annee'].'-'.$_GET['Mois'];
		
	}else{
	
		$periode = substr(date("Y-m-d"), 0, 7);
		
	}
	
	// On vérifie s'il existe des évènements sur le mois sélectionné...
	$req = 'SELECT * FROM Evenement A, Agent_Evenement B WHERE A.ID_Evenement=B.ID_Evenement AND Date LIKE "'.$periode.'%" AND ID_Agent IN (SELECT ID_Agent FROM Agent WHERE ID_Service IN (SELECT ID_Service FROM Agent WHERE ID_Agent = "'.$_SESSION['ID_Login'].'"))';
	$st = $connexion->query($req);

	$donnees = $st -> fetchAll( PDO::FETCH_ASSOC);
	if($donnees == FALSE){
		
		// ... si on n'en trouve pas on affiche "Aucun évènement ce mois-ci"...
		echo "Aucun évènement ce mois-ci";
		
	}else{
			// ... sinon on passe au traitement des données des agents du service par la fonction Tableau (définie dans le fichiers fonctions_heures.php)
			Tableau ($id);
			
	}
	
	$connexion = null;
}
catch(Exception $f)
{
	echo 'err : '.$f->getMessage().'<br />';
}

	
?>

<div class="footer-content">
	<div class="footer-text">
		Mairie de Beauvais - communauté d'agglomération du Beauvaisis
	</div>	
</div>
