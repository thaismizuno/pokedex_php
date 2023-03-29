<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/ability.php';

$ability = new Ability();
echo json_encode(['data' => $ability->selectAllAbilities()]);
?>