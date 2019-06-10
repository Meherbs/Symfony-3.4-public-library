<?php
$id = $POST["id"];
try {
    $bdd = new PDO('mysql:host=localhost;dbname=projetsymfony', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$query = "SELECT * FROM `acteur` WHERE `id_acteur`= $id ;";
$result = $bdd->query($query);
$STH = $bdd->query($query);
$data = array();
foreach ($STH as $row){
    $data[] = $row;
}
$result->closeCursor();
$d= json_encode($data);
$don = '{"success": true,"data": '.$d.'}';
print $don;
?>