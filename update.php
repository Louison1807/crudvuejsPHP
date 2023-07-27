<?php 
	require "database.php";
	if (isset($_POST['edit_num']) && isset($_POST['edit_nom_cli']) && isset($_POST['edit_nom_banque']) && isset($_POST['edit_montant']) && isset($_POST['edit_date']) && isset($_POST['edit_taux']) && isset($_POST['numtemp']))
	{
		$num=$_POST['edit_num'];
		$nomcli=$_POST['edit_nom_cli'];
		$nombanque=$_POST['edit_nom_banque'];
		$montant=$_POST['edit_montant'];
		$date=$_POST['edit_date'];
		$taux=$_POST['edit_taux'];
		$numtemp=$_POST['numtemp'];

		$update=$connection->prepare("update pret_bancaire set Ncompte=?,nom_cli=?,nom_banque=?,montant=?,date_pret=?,taux_pret=? where Ncompte=?");
		$update->execute(array($num,$nomcli,$nombanque,$montant,$date,$taux,$numtemp));

		$data=array('res'=>'success');

		echo json_encode($data);
	}

 ?>