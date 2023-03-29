<?php
include 'include/db.php';
include 'include/createTables.php';
include 'include/auxiliaryFunctions.php';
include 'include/weaknesses.php';

include 'class/ability.php';
include 'class/color.php';
include 'class/eggGroup.php';
include 'class/gender.php';
include 'class/generation.php';
include 'class/habitat.php';
include 'class/pokemon.php';
include 'class/pokemonAbility.php';
include 'class/pokemonColor.php';
include 'class/pokemonEggGroup.php';
include 'class/pokemonEvolution.php';
include 'class/pokemonGender.php';
include 'class/pokemonGeneration.php';
include 'class/pokemonHabitat.php';
include 'class/pokemonShape.php';
include 'class/pokemonStats.php';
include 'class/pokemonType.php';
include 'class/shape.php';
include 'class/stat.php';
include 'class/type.php';
include 'class/weakness.php';

$db = new DB();
$createTables = new CreateTables();
$createTables->createTables();
$auxiliaryFunctions = new AuxiliaryFunctions();

$text = '';

for ($i = 0; $i <= 358; $i = $i + 20) {
  $content = json_decode(file_get_contents("https://pokeapi.co/api/v2/ability/?offset={$i}&limit=20"));

  foreach($content->results as $info) {
    $ability = new Ability();
    $ability->setAbilityId($info);
    $ability->setAbilityEnglishName($info);
    $ability->setAbilityPortugueseName($info);
    $result = $ability->insertAbility();
    echo "{$result}";
    $text .= "{$result}";
  }
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon-color/"));
foreach($content->results as $info) {
  $color = new Color();
  $color->setColorId($info);
  $color->setColorName($info);
  $result = $color->insertColor();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/egg-group/"));
foreach($content->results as $info) {
  $eggGroup = new EggGroup();
  $eggGroup->setEggGroupId($info);
  $eggGroup->setEggGroupEnglishName($info);
  $eggGroup->setEggGroupPortugueseName($info);
  $result = $eggGroup->insertEggGroup();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/gender/"));
foreach($content->results as $info) {
  var_dump($result);
  $gender = new Gender();
  $gender->setGenderId($info);
  $gender->setGenderEnglishName($info);
  $gender->setGenderPortugueseName($info);
  $result = $gender->insertGender();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/generation/"));
foreach($content->results as $info) {
  $generation = new Generation();
  $generation->setGenerationId($info);
  $generation->setGenerationName($info);
  $result = $generation->insertGeneration();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon-habitat/"));
foreach($content->results as $info) {
  $habitat = new Habitat();
  $habitat->setHabitatId($info);
  $habitat->setHabitatEnglishName($info);
  $habitat->setHabitatPortugueseName($info);
  $result = $habitat->insertHabitat();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon-shape/"));
foreach($content->results as $info) {
  $shape = new Shape();
  $shape->setShapeId($info);
  $shape->setShapeEnglishName($info);
  $shape->setShapePortugueseName($info);
  $result = $shape->insertShape();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/stat/"));
foreach($content->results as $info) {
  $stat = new Stat();
  $stat->setStatId($info);
  $stat->setStatEnglishName($info);
  $stat->setStatPortugueseName($info);
  $result = $stat->insertStat();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/type/"));
$listOfTypes = [];
foreach($content->results as $info) {
  $listOfTypes[$info->name] = $auxiliaryFunctions->formatId($info->url);

  $type = new Type();
  $type->setTypeId($info);
  $type->setTypeEnglishName($info);
  $type->setTypePortugueseName($info);
  $result = $type->insertType();
  echo "{$result}";
  $text .= "{$result}";
}

echo "\n";
$text .= "\n";

echo '<pre>';
$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/"));
$qtd = $content->count;
for ($i = 0; $i <= $qtd; $i = $i + 20) {
  $content = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/?offset={$i}&limit=20"));

  foreach($content->results as $info) {
    $content = json_decode(file_get_contents($info->url));

    $pokemon = new Pokemon();
    $pokemon->setPokemonId($content->id);
    $pokemon->setPokemonName($content);
    $pokemon->setPokemonImage($content);
    $pokemon->setPokemonHeight($content);
    $pokemon->setPokemonWeight($content);
    $result = $pokemon->insertPokemon();
    echo "{$result}\n";
    $text .= "{$result}\n";

    $pokemon_type = new PokemonType();
    $pokemon_type->setPokemonId($content->id);
    $pokemon_type->setTypeId($content->types[0]->type);
    $pokemon_type->setTypeOrder(1);
    $result = $pokemon_type->insertWithTypeId();
    echo "{$result}";
    $text .= "{$result}";

    $pokemon_type = new PokemonType();
    $pokemon_type->setPokemonId($content->id);
    $pokemon_type->setTypeOrder(2);

    if (count($content->types) == 1) {
      $result = $pokemon_type->insertWithoutTypeId();
    } elseif (count($content->types) == 2) {
      $pokemon_type->setTypeId($content->types[1]->type);
      $result = $pokemon_type->insertWithTypeId();
    }

    echo "{$result}";
    $text .= "{$result}";

    echo "\n";
    $text .= "\n";

    foreach($content->abilities as $ability) {
      $pokemon_ability = new pokemonAbility();
      $pokemon_ability->setPokemonId($content->id);
      $pokemon_ability->setAbilityId($ability);
      $result = $pokemon_ability->insertPokemonAbility();
      echo "{$result}";
      $text .= "{$result}";
    }

    echo "\n";
    $text .= "\n";

    foreach($content->stats as $stat) {
      $pokemon_stats = new PokemonStats();
      $pokemon_stats->setPokemonId($content->id);
      $pokemon_stats->setStatId($stat);
      $pokemon_stats->setStatBaseStat($stat);
      $pokemon_stats->setStatEffort($stat);
      $result = $pokemon_stats->insertPokemonStats();
      echo "{$result}";
      $text .= "{$result}";
    }

    echo "\n";
    $text .= "\n";

    $contentOtherInfos = json_decode(file_get_contents($content->species->url));

    $pokemon_color = new PokemonColor();
    $pokemon_color->setPokemonId($content->id);
    $pokemon_color->setColorId($contentOtherInfos->color);
    $result = $pokemon_color->insertPokemonColor();
    echo "{$result}";
    $text .= "{$result}";

    echo "\n";
    $text .= "\n";

    foreach($contentOtherInfos->egg_groups as $egg_group) {
      $pokemon_egg_group = new PokemonEggGroup();
      $pokemon_egg_group->setPokemonId($content->id);
      $pokemon_egg_group->setEggGroupId($egg_group);
      $result = $pokemon_egg_group->insertPokemonEggGroup();
      echo "{$result}";
      $text .= "{$result}";
    }

    echo "\n";
    $text .= "\n";

    $pokemon_generation = new PokemonGeneration();
    $pokemon_generation->setPokemonId($content->id);
    $pokemon_generation->setGenerationId($contentOtherInfos->generation);
    $result = $pokemon_generation->insertPokemonGeneration();
    echo "{$result}";
    $text .= "{$result}";

    echo "\n";
    $text .= "\n";

    if (!is_null($contentOtherInfos->habitat)) {
      $pokemon_habitat = new PokemonHabitat();
      $pokemon_habitat->setPokemonId($content->id);
      $pokemon_habitat->setHabitatId($contentOtherInfos->habitat);
      $result = $pokemon_habitat->insertPokemonHabitat();
      echo "{$result}";
      $text .= "{$result}";
    }

    echo "\n";
    $text .= "\n";

    if (!is_null($contentOtherInfos->shape)) {
      $pokemon_shape = new PokemonShape();
      $pokemon_shape->setPokemonId($content->id);
      $pokemon_shape->setShapeId($contentOtherInfos->shape);
      $result = $pokemon_shape->insertPokemonShape();
      echo "{$result}";
      $text .= "{$result}";
    }

    echo "\n";
    $text .= "\n";

    $contentEvolutionChain = json_decode(file_get_contents($contentOtherInfos->evolution_chain->url));

    if (count($contentEvolutionChain->chain->evolves_to) == 1) {
      $pokemonFirstEvolutionId = $contentEvolutionChain->chain->species;
      foreach ($contentEvolutionChain->chain->evolves_to as $envolve2) {
        $pokemonSecondEvolutionId = $envolve2->species;
        $pokemon_first_evolution = new PokemonEvolution();
        $pokemon_first_evolution->setPokemonIdFrom($pokemonFirstEvolutionId);
        $pokemon_first_evolution->setPokemonIdTo($pokemonSecondEvolutionId);
        $pokemon_first_evolution->setPokemonEvolution(1);
        $result = $pokemon_first_evolution->insertPokemonEvolution();
        echo "{$result}";
        $text .= "{$result}";

        if (count($envolve2->evolves_to) == 1) {
          foreach ($envolve2->evolves_to as $envolve3) {
            $pokemonThirdEvolutionId = $envolve3->species;
            $pokemon_second_evolution = new PokemonEvolution();
            $pokemon_second_evolution->setPokemonIdFrom($pokemonSecondEvolutionId);
            $pokemon_second_evolution->setPokemonIdTo($pokemonThirdEvolutionId);
            $pokemon_second_evolution->setPokemonEvolution(2);
            $result = $pokemon_second_evolution->insertPokemonEvolution();
            echo "{$result}";
            $text .= "{$result}";
          }
        }
      }
    }

    echo "\n";
    $text .= "\n";

    echo "\n-------------------------\n\n";
    $text .= "\n-------------------------\n\n";
  }
}

$content = json_decode(file_get_contents("https://pokeapi.co/api/v2/gender/"));
foreach($content->results as $info) {
  $gender = new Gender();
  $gender->setGenderId($info);
  $gender->setGenderEnglishName($info);
  $gender->setGenderPortugueseName($info);
  $result = $gender->insertGender();
  echo "{$result}";
  $text .= "{$result}";

  echo "\n";
  $text .= "\n";

  $contentPokemonGender = json_decode(file_get_contents($info->url));
  foreach($contentPokemonGender->pokemon_species_details as $pokemon) {
    $pokemon_gender = new PokemonGender();
    $pokemon_gender->setPokemonId($pokemon->pokemon_species);
    $pokemon_gender->setGenderId($info);
    $result = $pokemon_gender->insertPokemonGender();
    echo "{$result}";
    $text .= "{$result}";
  }
}

echo "\n";
$text .= "\n";

foreach(explode("\n",$listOfWeaknesses) as $weaknesses) {
  $auxWeaknesses = explode('|', $weaknesses);
  $auxTypes = explode(' ', $auxWeaknesses[0]);

  $primaryTypeName = strtolower($auxTypes[0]);
  $primaryTypeId = $listOfTypes[$primaryTypeName];

  $secondaryTypeName = strtolower($auxTypes[1]);
  $secondaryTypeId = is_null($listOfTypes[$secondaryTypeName]) ? null : $listOfTypes[$secondaryTypeName];

  for ($i = 1; $i < count($auxWeaknesses); $i++) {
    $listOfWeakenesses = explode(';', $auxWeaknesses[$i]);

    if ($listOfWeakenesses[1] == '2' || $listOfWeakenesses[1] == '4'){
      $weakness = new Weakness();
      $weakness->setPrimaryTypeId($primaryTypeId);
      $weakness->setSecondaryTypeId($secondaryTypeId);
      $weakness->setTypeId($listOfTypes[strtolower($listOfWeakenesses[0])]);
      $result = $weakness->insertWeakness();
      echo "{$result}";
      $text .= "{$result}";
    }
  }
}

$fileName = 'scripts/rodada_'.date('Ymd_His').'.txt';
$file = fopen($fileName, 'a');
fwrite($file, $text);
fclose($file);
?>