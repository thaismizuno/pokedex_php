<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/pokemon.php';

$pokemon = new Pokemon();
if ($_POST['generation_id']) {
  $pokemon->setFilterGenerationId($_POST['generation_id']);
}

if ($_POST['primary_type_id']) {
  $pokemon->setFilterPrimaryTypeId($_POST['primary_type_id']);
}

if ($_POST['secondary_type_id']) {
  $pokemon->setFilterSecondaryTypeId($_POST['secondary_type_id']);
}

if ($_POST['habitat_id']) {
  $pokemon->setFilterHabitatId($_POST['habitat_id']);
}

if ($_POST['ability_id']) {
  $pokemon->setFilterAbilityId($_POST['ability_id']);
}

$pokemon->setOrderBy($_POST['order_by']);
$pokemon->setPage($_POST['page']);

$pokemonList = $pokemon->selectAllPokemonsList();

$result = [
  'data' => [],
  'qtd'  => $pokemon->selectAllPokemonsQtd()
];

$pokemonIdList = [];
foreach($pokemonList as $info) {
  $pokemonIdList[] = $info['pokemon_id'];
  $result['data'][$info['pokemon_id']] = [
    'generation'   => $info['generation_name'],
    'id'           => $info['pokemon_id'],
    'name'         => $info['pokemon_name'],
    'image'        => $info['pokemon_image'],
    'height'       => $info['pokemon_height'],
    'weight'       => $info['pokemon_weight'],
    'color'        => $info['color_name'],
    'habitat'      => $info['habitat_portuguese_name'],
    'ability'      => [],
    'primary_type' => [
      'id'   => $info['primary_type_id'],
      'name' => [
        'english'    => $info['primary_type_english_name'],
        'portuguese' => $info['primary_type_portuguese_name']
      ]
    ],
    'secondary_type' => [
      'id'   => $info['secondary_type_id'],
      'name' => [
        'english'    => $info['secondary_type_english_name'],
        'portuguese' => $info['secondary_type_portuguese_name']
      ]
    ]
  ];
}

$pokemon = new Pokemon();
$pokemon->setFilterRangePokemonId($pokemonIdList);
$lista = [];
foreach($pokemon->selectAllPokemonaAbilitiesList() as $ability) {
  $result['data'][$ability['pokemon_id']]['ability'][] = $ability['ability_portuguese_name'];
}
echo json_encode($result);
?>