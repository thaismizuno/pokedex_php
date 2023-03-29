<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/habitat.php';

$habitat = new Habitat();
echo json_encode(['data' => $habitat->selectAllHabitats()]);
?>