<?php
require '/dal/Dal_Agent.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<title>test pdo</title>
	<meta name="" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" type="images/x-icon" href="" />
	<link rel="stylesheet" href="style.css" type="text/css" media="all" />
	<script type="text/javascript" src=""></script>
	
	<style type="text/css">
              
		table{
				border-collapse: collapse;
				color:#000;
				font-familly:	"Lucida Bright", "Times New Roman", serif;
				font-size:1.15em;		  
				}
					  
		tbody th, tbody td {
			border-bottom: 1px solid #ccc;
			padding: 2px 10px;
			text-align: left;
			vertical-align: top;
				}

    </style>
	
</head>
<body>
<?php
echo'<p> <a href="allag.php">Voir tous les agents</a> </p>';
	echo '<br /> lecture  de tous les agents <br />';
	Get_Agent_By_Nom ('all');
	
?>
</body>
</html>















