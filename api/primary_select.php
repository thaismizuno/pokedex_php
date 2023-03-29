<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/pokemon.php';

$pokemon = new Pokemon();
if (isset($_GET['generation_id']) && (!empty($_GET['generation_id']) || !is_null($_GET['generation_id']) ) ) {
  $pokemon->setFilterGenerationId($_GET['generation_id']);
}

if (isset($_GET['secondary_type_id']) && (!empty($_GET['secondary_type_id']) || !is_null($_GET['secondary_type_id']) ) ) {
  $pokemon->setFilterSecondaryTypeId($_GET['secondary_type_id']);
}

$lista = [];
foreach($pokemon->selectPrimaryType() as $info) {
  if (!array_key_exists($info['type_id'], $lista)) {
    $lista[$info['type_id']] = [
      'id'              => $info['type_id'],
      'portuguese_name' => $info['type_portuguese_name'],
      'qtd'             => 1
    ];
  } else {
    $lista[$info['type_id']]['qtd']++;
  }
}

echo json_encode(['data' => $lista]);
?>