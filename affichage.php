<?php 
require 'database.php';

$select=$connection->prepare("select * from pret_bancaire");
$select->execute();
$rows=$select->fetchAll();

$somme=$connection->prepare("select SUM(montant*(1+(taux_pret/100))) as totalsomme from pret_bancaire");
$somme->execute();
$donne=$somme->fetch()['totalsomme'];


$min=$connection->prepare("select MIN(montant*(1+(taux_pret/100))) as min from pret_bancaire");
$min->execute();
$donne_min=$min->fetch()['min'];

$max=$connection->prepare("select MAX(montant*(1+(taux_pret/100))) as max from pret_bancaire");
$max->execute();
$donne_max=$max->fetch()['max'];

$data = array('rows' => $rows,'somme'=>$donne,'min'=>$donne_min,'max'=>$donne_max);

echo json_encode($data);
 ?>