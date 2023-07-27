<?php 
require "database.php";
if (isset($_POST['num'])) {
	$num=$_POST['num'];

	$delete=$connection->prepare("delete from pret_bancaire where Ncompte=?");
	$delete->execute(array($num));

	$data=array('res'=>'success');

	echo json_encode($data);
}

 ?>