<?php
class PokemonHabitat
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $habitat_id;

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

  public function setHabitatId($content)
  {
    $this->habitat_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getHabitatId()
  {
    return $this->habitat_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Habitat | Pokemon ID: {$this->getPokemonId()} - Habitat ID: {$this->getHabitatId()}\n";
  }

  private function selectPokmonHabitat()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_habitat
      WHERE pokemon_id = :pokemon_id AND habitat_id = :habitat_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':habitat_id', $this->getHabitatId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonHabitat()
  {
    if ($this->selectPokmonHabitat()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_habitat (pokemon_id, habitat_id) 
      VALUES (:pokemon_id, :habitat_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':habitat_id', $this->getHabitatId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>