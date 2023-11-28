<?php
require './bo/cl_Agent.php';

$PARAM_hote='localhost';
$PARAM_port='3306';
$PARAM_nom_bd='basepdo';
$PARAM_utilisateur='root';
$PARAM_mdp='';

try
{
	$connexion= new PDO('mysql:host='.$PARAM_hote.'; port='.$PARAM_port.';
	dbname='.$PARAM_nom_bd,$PARAM_utilisateur, $PARAM_mdp);
	echo 'Connexion effectuée';
}
catch(Exception $e)
{
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
}
try{
	$query = ("SELECT nom,prenom FROM agents ");
	$result = $connexion->query($query);
	while ($ligne=$result->fetch(PDO::FETCH_OBJ))
	{
		echo 'utilisateur : '.$ligne->nom. '<br />';
	}
	$result->closeCursor();
}
catch (Exception $e){
		echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
}

echo '<br /> Essai avec fetch_class et into';

$a= $connexion->query("SELECT nom,prenom FROM agents");
//$a->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'Agent');
$a->setFetchMode(PDO::FETCH_CLASS,'Agent');

while($obj = $a->fetch()){
echo 'ceci est l objet : '.$obj->Getnom().'<br />';
}

?>
















