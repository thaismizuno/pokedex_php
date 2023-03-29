<?php
include 'include/db.php';
include 'include/auxiliaryFunctions.php';
include 'class/pokemon.php';

if ($_GET['pokemon_id'] == '1') {
  $previousPokemon = new Pokemon();
  $previousPokemonInfo = $previousPokemon->selectPokemonLastId();

  $nextPokemon = new Pokemon();
  $nextPokemon->setPokemonId($_GET['pokemon_id'] + 1);
  $nextPokemonInfo = $nextPokemon->selectPokemonPreviousOrNextId();
} else {
  $previousPokemon = new Pokemon();
  $previousPokemon->setPokemonId($_GET['pokemon_id'] - 1);
  $previousPokemonInfo = $previousPokemon->selectPokemonPreviousOrNextId();

  $nextPokemon = new Pokemon();
  $nextPokemon->setPokemonId($_GET['pokemon_id'] + 1);
  $nextPokemonInfo = $nextPokemon->selectPokemonPreviousOrNextId();
}

$pokemon = new Pokemon();
$pokemon->setPokemonId($_GET['pokemon_id']);

echo json_encode([
  'previous_pokemon'=> $previousPokemonInfo,
  'next_pokemon' => $nextPokemonInfo,
  'info' => $pokemon->selectPokemonInfoById(),
  'ability' => $pokemon->selectPokemonAbilityById(),
  'habitat' => $pokemon->selectPokemonHabitat(),
  'egg_group' => $pokemon->selectPokemonEggGroup(),
  'gender' => $pokemon->selectPokemonGender(),
  'shape' => $pokemon->selectPokemonShape(),
  'stat' => $pokemon->selectPokemonStat(),
  //'weakness' => $pokemon->selectPokemonWeakness()
]);
?>