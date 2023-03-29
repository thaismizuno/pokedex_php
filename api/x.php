<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'include/weaknesses.php';
include 'class/type.php';
include 'class/weakness.php';

echo '<pre>';

$type = new Type();
$listOfTypes = [];
foreach ($type->selectAllTypes() as $info){
  $listOfTypes[strtolower($info['type_english_name'])] = $info['type_id'];
}

foreach(explode("\n",$listOfWeaknesses) as $weaknesses) {
  $auxWeaknesses = explode('|', $weaknesses);
  $auxTypes = explode(' ', $auxWeaknesses[0]);

  $primaryTypeName = strtolower($auxTypes[0]);
  $primaryTypeId = $listOfTypes[$primaryTypeName];

  $secondaryTypeName = strtolower($auxTypes[1]);
  $secondaryTypeId = is_null($listOfTypes[$secondaryTypeName]) ? null : $listOfTypes[$secondaryTypeName];

  for ($i = 1; $i <= count($auxWeaknesses); $i++) {
    $weakenesses = explode(';', $auxWeaknesses[$i]);

    if ($weakenesses[1] == '2' || $weakenesses[1] == '4'){
      $weakness = new Weakness();
      $weakness->setPrimaryTypeId($primaryTypeId);
      $weakness->setSecondaryTypeId($secondaryTypeId);
      $weakness->setTypeId($listOfTypes[strtolower($aux2[0])]);
      $result = $weakness->insertWeakness();
    }
  }
}
?>