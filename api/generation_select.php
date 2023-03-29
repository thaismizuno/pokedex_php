<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/generation.php';

$generation = new Generation();
echo json_encode(['data' => $generation->selectAllGenerations()]);
?>