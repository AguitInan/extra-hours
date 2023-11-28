<?php
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
try
{
	$count = $connexion->exec("INSERT INTO agent (Id,Nom,Prenom) VALUES (null,'Glppo','Paulette')");
	echo 'insert ok valeur du count = '.$count;
}
catch(Exception $f)
{ echo 'err : '.$f->getMessage().'<br />';}

echo '<br /> lecture classique <br />';
$selAg = 'SELECT Nom,Prenom FROM agent';
try
{
	foreach($connexion->query($selAg) as $row)
		{
			echo $row['Nom'].' = '.$row['Prenom'].'<br />';
		}
}
catch(Exception $z){echo 'err : '.$f->getMessage().'<br />';}

echo '<br /> Fetch_assoc <br />';
 $sql = "SELECT * FROM agent";
    $stmt = $connexion->query($sql);
    while($result = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		foreach($result as $key=>$val)
		{
		echo $key.' - '.$val.'<br />';
		}
	}

$sql = "SELECT * FROM agent";
    $stmt = $connexion->query($sql);
    displaytable($stmt);
	
// test de requete avec bind des variables


echo "<br />"; 
echo " Test de requete avec bind var";
$nom='Berleux';
$prenom='testBInd';
$numid=3;
//$sth = $connexion->prepare('INSERT INTO (Id,Nom, prenom) values (null,:nom,:prenom');
$sth = $connexion->prepare('SELECT * FROM AGENT WHERE Nom=:nom');
$sth->bindParam(':nom',$nom, PDO::PARAM_STR);
//$sth->bindParam(':prenom',$prenom, PDO::PARAM_STR);
$sth->execute();
$tr=displaytable($sth);
//echo $



function displaytable ($sth)
{
echo "<table border=1 >"; 
echo "<tr>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Nom</b></td>"; 
echo "<td><b>Prenom</b></td>"; 
echo "</tr>"; 

while($obj = $sth->fetch(PDO::FETCH_OBJ))
		{	
			echo "<tr>";  
			echo "<td valign='top'>" . $obj->Id. "</td>";  
			echo "<td valign='top'>" . $obj->Nom . "</td>";  
			echo "<td valign='top'>" .$obj->Prenom . "</td>";  
			echo "<td valign='top'><a href=edit.php?id={$obj->Id}>Edit</a></td><td><a href=delete.php?id={$obj->Id}>Delete</a></td> "; 
			echo "</tr>"; 
			//echo $obj->Id.'<br />';
			//echo $obj->Nom.'<br />';
			//echo $obj->Prenom.'<br />';
		}
echo "</table>"; 
echo "<a href=new.php>New Row</a>"; 
}
?>
















