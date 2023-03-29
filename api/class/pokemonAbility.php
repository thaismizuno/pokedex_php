<?php
class PokemonAbility
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $ability_id;

  public function __construct()
  {
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

  public function setAbilityId($content)
  {
    $this->ability_id = $this->auxiliaryFunctions->formatId($content->ability->url);
  }

  private function getAbilityId()
  {
    return $this->ability_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Ability | Pokemon ID: {$this->getPokemonId()} - Ability Id: {$this->getAbilityId()}\n";
  }

  private function selectPokemonAbility()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_ability
      WHERE pokemon_id = :pokemon_id AND ability_id = :ability_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':ability_id', $this->getAbilityId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonAbility()
  {
    if ($this->selectPokemonAbility()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_ability (pokemon_id, ability_id) 
      VALUES (:pokemon_id, :ability_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':ability_id', $this->getAbilityId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>