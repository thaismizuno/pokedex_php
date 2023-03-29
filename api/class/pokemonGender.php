<?php
class PokemonGender
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $gender_id;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setPokemonId($content)
  {
    $this->pokemon_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getPokemonId()
  {
    return $this->pokemon_id;
  }

  public function setGenderId($content)
  {
    $this->gender_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getGenderId()
  {
    return $this->gender_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Gender | Pokemon ID: {$this->getPokemonId()} - Gender ID: {$this->getGenderId()}\n";
  }

  private function selectPokmonGender()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_gender
      WHERE pokemon_id = :pokemon_id AND gender_id = :gender_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':gender_id', $this->getGenderId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonGender()
  {
    if ($this->selectPokmonGender()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_gender (pokemon_id, gender_id) 
      VALUES (:pokemon_id, :gender_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':gender_id', $this->getGenderId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>