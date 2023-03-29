<?php
class PokemonGeneration
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $generation_id;

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

  public function setGenerationId($content)
  {
    $this->generation_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getGenerationId()
  {
    return $this->generation_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Generation | Pokemon ID: {$this->getPokemonId()} - Generation ID: {$this->getGenerationId()}\n";
  }

  private function selectPokmonGeneration()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_generation
      WHERE pokemon_id = :pokemon_id AND generation_id = :generation_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':generation_id', $this->getGenerationId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonGeneration()
  {
    if ($this->selectPokmonGeneration()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_generation (pokemon_id, generation_id) 
      VALUES (:pokemon_id, :generation_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':generation_id', $this->getGenerationId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>