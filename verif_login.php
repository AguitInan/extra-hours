<?php
 
session_name('hsup');
session_start();

if ( isset($_SESSION['Profil']) ){

	
}else{

	header('Location: index.php');
	
}
 
?>