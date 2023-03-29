<?php
class Pokemon
{
  private $auxiliaryFunctions;
  private $db;
  private $mysql;

  private $whereParameters;
  private $parametersList;
  private $orderBy;
  private $page;

  private $pokemon_id;
  private $pokemon_name;
  private $pokemon_image;
  private $pokemon_height;
  private $pokemon_weight;

  private $generation_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setWhereParameters($content)
  {
    $this->whereParameters[] = $content;
  }

  public function getWhereParameters()
  {
    return (count($this->whereParameters) >= 1) ? "WHERE ".implode(" AND ", $this->whereParameters) : '';
  }

  private function setParametersList($content)
  {
    $this->parametersList[] = $content;
  }

  private function getParametersList()
  {
    return $this->parametersList;
  }

  public function setOrderBy($content)
  {
    $this->orderBy = $content;
  }

  private function getOrderBy()
  {
    switch($this->orderBy) {
      case '1-9';
        return 'ORDER BY pokemon.pokemon_id ASC';
        break;
      case '9-1':
        return 'ORDER BY pokemon.pokemon_id DESC';
        break;
      case 'A-Z':
        return 'ORDER BY pokemon.pokemon_name ASC';
        break;
      case 'Z-A':
        return 'ORDER BY pokemon.pokemon_name DESC';
        break;
    }
  }

  public function setPage($content)
  {
    $this->page = $content;
  }

  private function getPage()
  {
    return $this->page == 1 ? '' : 'OFFSET '.($this->page * 30);
  }

  public function setFilterPokemonId($content)
  {
    $this->setWhereParameters('pokemon.pokemon_id = :pokemon_id');
    $this->setParametersList([':pokemon_id', $content, PDO::PARAM_INT]);
  }

  public function setFilterGenerationId($content)
  {
    $this->setWhereParameters('generation.generation_id = :generation_id');
    $this->setParametersList([':generation_id', $content, PDO::PARAM_INT]);
  }

  public function setFilterPrimaryTypeId($content)
  {
    $this->setWhereParameters('pokemon_type1.type_id = :primary_type_id');
    $this->setParametersList([':primary_type_id', $content, PDO::PARAM_INT]);
  }

  public function setFilterSecondaryTypeId($content)
  {
    if ($content === 'null') {
      $this->setWhereParameters('pokemon_type2.type_id IS NULL');
    } else {
      $this->setWhereParameters('pokemon_type2.type_id = :secondary_type_id');
      $this->setParametersList([':secondary_type_id', $content, PDO::PARAM_INT]);
    }
  }

  public function setFilterHabitatId($content)
  {
    $this->setWhereParameters('habitat.habitat_id = :habitat_id');
    $this->setParametersList([':habitat_id', $content, PDO::PARAM_INT]);
  }

  public function setFilterAbilityId($content)
  {
    $this->setWhereParameters('ability.habitat_id = :habitat_id');
    $this->setParametersList([':habitat_id', $content, PDO::PARAM_INT]);
  }

  public function setFilterRangePokemonId($pokemonIdList)
  {
    $whereParameters = [];
    foreach($pokemonIdList AS $index => $id) {
      $whereParameters[] = ":pokemon_id_$index";
      $this->setParametersList([":pokemon_id_$index", $id, PDO::PARAM_INT]);
    }

    $this->setWhereParameters("pokemon_ability.pokemon_id IN (".implode(',', $whereParameters).")");
  }

  public function setPokemonId($content)
  {
    $this->pokemon_id = $content;
  }

  private function getPokemonId()
  {
    return $this->pokemon_id;
  }

  public function setPokemonName($content)
  {
    $this->pokemon_name = $this->auxiliaryFunctions->formatName($content->name);
  }

  private function getPokemonName()
  {
    return $this->pokemon_name;
  }

  public function setPokemonImage($content)
  {
    $this->pokemon_image = is_null($content->sprites->other->dream_world->front_default) ? $content->sprites->front_default : $content->sprites->other->dream_world->front_default;
  }

  private function getPokemonImage()
  {
    return $this->pokemon_image;
  }

  public function setPokemonHeight($content)
  {
    $this->pokemon_height = $content->height;
    $this->db->setParametersList('pokemon_height', $this->pokemon_height, PDO::PARAM_STR);
  }

  private function getPokemonHeight()
  {
    return $this->pokemon_height;
  }

  public function setPokemonWeight($content)
  {
    $this->pokemon_weight = $content->weight;
  }

  private function getPokemonWeight()
  {
    return $this->pokemon_weight;
  }

  public function setGenerationName($content)
  {
    $this->generation_name = $content;
  }

  private function getGenerationName()
  {
    return $this->generation_name;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon | {$this->getPokemonId()} - {$this->getPokemonName()}\n";
  }

  private function selectPokemonById()
  {
    $this->db->setQuery("SELECT * FROM pokemon WHERE pokemon_id = :pokemon_id");

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectManyLinesQuery();
  }

  public function updatePokemon()
  {
    $this->db->setQuery(
      "UPDATE pokemon
      SET pokemon_name = :pokemon_name, pokemon_image = :pokemon_image, pokemon_height = :pokemon_height, pokemon_weight = :pokemon_weight
      WHERE pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_name', $this->getPokemonName(), PDO::PARAM_STR],
      [':pokemon_image', $this->getPokemonImage(), PDO::PARAM_STR],
      [':pokemon_height', $this->getPokemonHeight(), PDO::PARAM_INT],
      [':pokemon_weight', $this->getPokemonWeight(), PDO::PARAM_INT],
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertPokemon()
  {
    if ($this->selectPokemonById()) {
      return $this->updatePokemon();
    }

    $this->db->setQuery(
      "INSERT INTO pokemon (pokemon_id, pokemon_name, pokemon_image, pokemon_height, pokemon_weight)
      VALUES (:pokemon_id, :pokemon_name, :pokemon_image, :pokemon_height, :pokemon_weight)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':pokemon_name', $this->getPokemonName(), PDO::PARAM_STR],
      [':pokemon_image', $this->getPokemonImage(), PDO::PARAM_STR],
      [':pokemon_height', $this->getPokemonHeight(), PDO::PARAM_INT],
      [':pokemon_weight', $this->getPokemonWeight(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "CadAStrado" : "Erro ao cadAStrar") . $this->auxiliaryMsg();
  }

  public function selectPrimaryType()
  {
    $this->db->setQuery(
      "SELECT type1.type_id, type1.type_portuguese_name
      FROM pokemon
        INNER JOIN pokemon_type AS pokemon_type1 ON (pokemon.pokemon_id = pokemon_type1.pokemon_id AND pokemon_type1.type_order = 1)
        INNER JOIN `type` AS type1 ON type1.type_id = pokemon_type1.type_id
        LEFT JOIN pokemon_type AS pokemon_type2 ON (pokemon_type2.pokemon_id = pokemon.pokemon_id AND pokemon_type2.type_order = 2)
        LEFT JOIN `type` AS type2 ON type2.type_id = pokemon_type2.type_id
        INNER JOIN pokemon_generation ON pokemon.pokemon_id = pokemon_generation.pokemon_id
        INNER JOIN generation ON pokemon_generation.generation_id = generation.generation_id
      {$this->getWhereParameters()}
      ORDER BY pokemon.pokemon_id ASC"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectManyLinesQuery();
  }

  public function selectSecondaryType()
  {
    $this->db->setQuery(
      "SELECT type2.type_id, type2.type_portuguese_name
      FROM pokemon
        INNER JOIN pokemon_type AS pokemon_type1 ON (pokemon.pokemon_id = pokemon_type1.pokemon_id AND pokemon_type1.type_order = 1)
        INNER JOIN `type` AS type1 ON type1.type_id = pokemon_type1.type_id
        LEFT JOIN pokemon_type AS pokemon_type2 ON (pokemon_type2.pokemon_id = pokemon.pokemon_id AND pokemon_type2.type_order = 2)
        LEFT JOIN `type` AS type2 ON type2.type_id = pokemon_type2.type_id
        INNER JOIN pokemon_generation ON pokemon.pokemon_id = pokemon_generation.pokemon_id
        INNER JOIN generation ON pokemon_generation.generation_id = generation.generation_id
      {$this->getWhereParameters()}
      ORDER BY type2.type_portuguese_name ASC"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonLimit()
  {
    $this->db->setQuery("SELECT CEILING(count(*)/15) AS qtd FROM pokemon");
  }

  public function selectAllPokemonsList()
  {
    $this->db->setQuery(
      "SELECT pokemon.*, color.color_name, generation.generation_name, habitat.habitat_portuguese_name AS habitat_portuguese_name,
        type1.type_id AS primary_type_id, LOWER(type1.type_english_name) AS primary_type_english_name, type1.type_portuguese_name AS primary_type_portuguese_name,
        type2.type_id AS secondary_type_id, LOWER(type2.type_english_name) AS secondary_type_english_name, type2.type_portuguese_name AS secondary_type_portuguese_name
      FROM pokemon
        INNER JOIN pokemon_type AS pokemon_type1 ON (pokemon.pokemon_id = pokemon_type1.pokemon_id AND pokemon_type1.type_order = 1)
        INNER JOIN `type` AS type1 ON type1.type_id = pokemon_type1.type_id
        LEFT JOIN pokemon_type AS pokemon_type2 ON pokemon_type2.pokemon_id = pokemon.pokemon_id AND pokemon_type2.type_order = 2
        LEFT JOIN `type` AS type2 ON type2.type_id = pokemon_type2.type_id
        INNER JOIN pokemon_color ON pokemon.pokemon_id = pokemon_color.pokemon_id
        INNER JOIN color ON pokemon_color.color_id = color.color_id
        LEFT JOIN pokemon_habitat ON pokemon.pokemon_id = pokemon_habitat.pokemon_id
        LEFT JOIN habitat ON habitat.habitat_id = pokemon_habitat.habitat_id
        INNER JOIN pokemon_generation ON pokemon.pokemon_id = pokemon_generation.pokemon_id
        INNER JOIN generation ON pokemon_generation.generation_id = generation.generation_id
        {$this->getWhereParameters()}
        {$this->getOrderBy()}
      LIMIT 30 {$this->getPage()}"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectManyLinesQuery();
  }

  public function selectAllPokemonsQtd()
  {
    $this->db->setQuery(
      "SELECT COUNT(*) as total
      FROM pokemon
        INNER JOIN pokemon_type AS pokemon_type1 ON (pokemon.pokemon_id = pokemon_type1.pokemon_id AND pokemon_type1.type_order = 1)
        INNER JOIN `type` AS type1 ON type1.type_id = pokemon_type1.type_id
        LEFT JOIN pokemon_type AS pokemon_type2 ON pokemon_type2.pokemon_id = pokemon.pokemon_id AND pokemon_type2.type_order = 2
        LEFT JOIN `type` AS type2 ON type2.type_id = pokemon_type2.type_id
        INNER JOIN pokemon_color ON pokemon.pokemon_id = pokemon_color.pokemon_id
        INNER JOIN color ON pokemon_color.color_id = color.color_id
        LEFT JOIN pokemon_habitat ON pokemon.pokemon_id = pokemon_habitat.pokemon_id
        LEFT JOIN habitat ON habitat.habitat_id = pokemon_habitat.habitat_id
        INNER JOIN pokemon_generation ON pokemon.pokemon_id = pokemon_generation.pokemon_id
        INNER JOIN generation ON pokemon_generation.generation_id = generation.generation_id
        {$this->getWhereParameters()}"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectOneLineQuery();
  }
  
  public function selectAllPokemonaAbilitiesList()
  {
    $this->db->setQuery(
      "SELECT pokemon_ability.pokemon_id, ability.ability_portuguese_name
      FROM pokemon_ability INNER JOIN ability ON pokemon_ability.ability_id = ability.ability_id
      {$this->getWhereParameters()}
      ORDER BY ability.ability_portuguese_name ASC"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonInfoById()
  {
    $this->db->setQuery(
      "SELECT pokemon.*, color.color_name, generation.generation_name, habitat.habitat_portuguese_name AS habitat_portuguese_name,
      type1.type_id AS primary_type_id, LOWER(type1.type_english_name) AS primary_type_english_name, type1.type_portuguese_name AS primary_type_portuguese_name,
      type2.type_id AS secondary_type_id, LOWER(type2.type_english_name) AS secondary_type_english_name, type2.type_portuguese_name AS secondary_type_portuguese_name
      FROM pokemon
        INNER JOIN pokemon_type AS pokemon_type1 ON (pokemon.pokemon_id = pokemon_type1.pokemon_id AND pokemon_type1.type_order = 1)
        INNER JOIN `type` AS type1 ON type1.type_id = pokemon_type1.type_id
        LEFT JOIN pokemon_type AS pokemon_type2 ON pokemon_type2.pokemon_id = pokemon.pokemon_id AND pokemon_type2.type_order = 2
        LEFT JOIN `type` AS type2 ON type2.type_id = pokemon_type2.type_id
        INNER JOIN pokemon_color ON pokemon.pokemon_id = pokemon_color.pokemon_id
        INNER JOIN color ON pokemon_color.color_id = color.color_id
        LEFT JOIN pokemon_habitat ON pokemon.pokemon_id = pokemon_habitat.pokemon_id
        LEFT JOIN habitat ON habitat.habitat_id = pokemon_habitat.habitat_id
        INNER JOIN pokemon_generation ON pokemon.pokemon_id = pokemon_generation.pokemon_id
        INNER JOIN generation ON pokemon_generation.generation_id = generation.generation_id
      WHERE pokemon.pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function selectPokemonLAStId()
  {
    $this->db->setQuery(
      "SELECT pokemon_id, pokemon_name FROM pokemon ORDER BY pokemon_id DESC LIMIT 1"
    );

    return $this->db->selectOneLineQuery();
  }

  public function selectPokemonPreviousOrNextId()
  {
    $this->db->setQuery(
      "SELECT pokemon_id, pokemon_name FROM pokemon WHERE pokemon_id = :pokemon_id;"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function selectPokemonAbilityById()
  {
    $this->db->setQuery(
      "SELECT ability.ability_portuguese_name AS portuguese_name
      FROM pokemon_ability INNER JOIN ability ON pokemon_ability.ability_id = ability.ability_id
      WHERE pokemon_ability.pokemon_id = :pokemon_id
      ORDER BY ability.ability_portuguese_name ASC"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonHabitat()
  {
    $this->db->setQuery(
      "SELECT habitat.habitat_portuguese_name AS portuguese_name
      FROM pokemon_habitat INNER JOIN habitat ON pokemon_habitat.habitat_id = habitat.habitat_id
       WHERE pokemon_habitat.pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function selectPokemonEggGroup()
  {
    $this->db->setQuery(
      "SELECT egg_group.egg_group_portuguese_name AS portuguese_name
      FROM pokemon_egg_group INNER JOIN egg_group ON egg_group.egg_group_id = pokemon_egg_group.egg_group_id
      WHERE pokemon_egg_group.pokemon_id = :pokemon_id
      ORDER BY egg_group.egg_group_portuguese_name ASC"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonGender()
  {
    $this->db->setQuery(
      "SELECT gender.gender_portuguese_name AS portuguese_name, gender.gender_english_name AS english_name
      FROM pokemon_gender INNER JOIN gender ON gender.gender_id = pokemon_gender.gender_id
      WHERE pokemon_gender.pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonStat()
  {
    $this->db->setQuery(
      "SELECT pokemon_stat.*, stat.stat_portuguese_name AS portuguese_name
      FROM pokemon_stat INNER JOIN stat ON stat.stat_id = pokemon_stat.stat_id
      WHERE pokemon_stat.pokemon_id = :pokemon_id
      ORDER BY stat.stat_portuguese_name ASC"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectManyLinesQuery();
  }

  public function selectPokemonShape()
  {
    $this->db->setQuery(
      "SELECT shape.shape_portuguese_name AS portuguese_name
      FROM pokemon_shape INNER JOIN shape ON pokemon_shape.shape_id = shape.shape_id
      WHERE pokemon_shape.pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function selectPokemonWeakness()
  {
    $this->db->setQuery(
      "SELECT LOWER(type.type_english_name) AS english_name, type.type_portuguese_name AS portuguese_name
      FROM pokemon
        LEFT JOIN weakness ON pokemon.pokemon_primary_type_id = weakness.pokemon_primary_type_id AND 
      ((pokemon.pokemon_secondary_type_id = weakness.pokemon_secondary_type_id) OR (pokemon.pokemon_secondary_type_id IS NULL AND weakness.pokemon_secondary_type_id IS NULL))
        INNER JOIN `type` ON type.`type_id` = weakness.type_id
      WHERE pokemon.pokemon_id = :pokemon_id
      ORDER BY type.type_portuguese_name ASC"
    );

    $this->db->setParametersList($this->getParametersList());

    return $this->db->selectManyLinesQuery();
  }
}
?>