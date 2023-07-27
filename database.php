<?php 

try {
	$connection=new PDO("mysql:host=localhost;dbname=banque","root","");
} catch (Exception $e) {
	echo "Erreur:".$e->getMessage();
}

 ?>