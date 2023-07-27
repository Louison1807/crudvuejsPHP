<?php 
	require "database.php";
	if (isset($_POST['num']) && isset($_POST['nom_cli']) && isset($_POST['nom_banque']) && isset($_POST['montant']) && isset($_POST['date']) && isset($_POST['taux'])) {
		$num=$_POST['num'];
		$nomcli=$_POST['nom_cli'];
		$nombanque=$_POST['nom_banque'];
		$montant=$_POST['montant'];
		$date=$_POST['date'];
		$taux=$_POST['taux'];

		$insert=$connection->prepare("INSERT into pret_bancaire values(?,?,?,?,?,?)");
		$insert->execute(array($num,$nomcli,$nombanque,$montant,$date,$taux));
		$data=array('res'=>'success');

		echo json_encode($data);
	}

 ?>