<?php
require './tools/cnx_param.php';
require './bo/cl_Agent.php';

 

function Get_Agent_By_Nom ($nom)
	{		
		try
		{
			$connexion = Get_cnx();
			if($nom=='all'){
			$st = $connexion->prepare('SELECT * FROM AGENTS');
			}else{
			$st = $connexion->prepare('SELECT * FROM AGENTS WHERE nom=:nom');
			$st->bindParam(':nom',$nom, PDO::PARAM_STR);
			}			
			$st->execute();
			displaytable_agent($st);
		}		
		catch(Exception $z)
		{
			echo 'err : '.$f->getMessage().'<br />';
		}
	}
	
function pre_Add_Agent($nom,$prenom)
{
	$Ag = new Agent();
	$Ag->SetNom($nom);
	$Ag->SetPrenom($prenom);
	Add_agent($Ag);

}

function Add_agent($obj_ag)
{
	try
	{
		$connexion = Get_cnx();
		$count = $connexion->exec("INSERT INTO agents (id,nom,prenom) VALUES (null,'Test','nTiers')");
		
	}
	catch(Exception $f)
	{ 
		echo 'err : '.$f->getMessage().'<br />';
	}

}
	
function displaytable_agent ($st)
{
	echo "<table border=0 >"; 
	echo "<tr>"; 
	echo "<th><b>Id</b></th>"; 
	echo "<th><b>Nom</b></th>"; 
	echo "<th><b>Prenom</b></th>";
	echo "</tr>"; 

	while($obj = $st->fetch(PDO::FETCH_OBJ))
			{	
				echo "<tr>";  
				echo "<td class=\"tablo\" valign='top'>" . $obj->id. "</td>";  
				echo "<td class=\"tablo\" valign='top'>" . $obj->nom . "</td>";  
				echo "<td class=\"tablo\" valign='top'>" .$obj->prenom . "</td>";  
				echo "<td class=\"tablo\" valign='top'><a href=edit.php?id={$obj->id}>Edit</a></td><td><a href=delete.php?id={$obj->id}>Delete</a></td> "; 
				echo "</tr>"; 
				
			}
	echo "</table>"; 
	echo "<a href=new.php>New Row</a>"; 
}
?>