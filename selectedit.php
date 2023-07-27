<?php 
	require "database.php";
	if (isset($_POST['num'])) {
		$num=$_POST['num'];
		$select=$connection->prepare("select * from pret_bancaire where Ncompte=?");
		$select->execute(array($num));
		$rows=$select->fetch();

		$data=array('res'=>'success','row'=>$rows);

		echo json_encode($data);
	}
 ?>