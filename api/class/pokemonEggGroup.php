<?php
class PokemonEggGroup
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $eggGroup_id;

  public function __construct() {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setPokemonId($content)
  {
    $this->pokemon_id = $content;
  }

  private function getPokemonId()
  {
    return $this->pokemon_id;
  }

  public function setEggGroupId($content)
  {
    $this->eggGroup_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getEggGroupId()
  {
    return $this->eggGroup_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Egg Groups | Pokemon ID: {$this->getPokemonId()} - Egg Group ID: {$this->getEggGroupId()}\n";
  }

  private function selectPokmonEggGroup()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_egg_group
      WHERE pokemon_id = :pokemon_id AND egg_group_id = :egg_group_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':egg_group_id', $this->getEggGroupId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonEggGroup()
  {
    if ($this->selectPokmonEggGroup()) {
      return "Já cadastrado " . $this->auxiliaryMsg();;
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_egg_group (pokemon_id, egg_group_id) 
      VALUES (:pokemon_id, :egg_group_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':egg_group_id', $this->getEggGroupId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>