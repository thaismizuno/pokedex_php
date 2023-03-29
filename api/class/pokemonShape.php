<?php
class PokemonShape
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $shape_id;

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

  public function setShapeId($content)
  {
    $this->shape_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getShapeId()
  {
    return $this->shape_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Shape | Pokemon ID: {$this->getPokemonId()} - Shape ID: {$this->getShapeId()}\n";
  }

  private function selectPokmonShape()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_shape
      WHERE pokemon_id = :pokemon_id AND shape_id = :shape_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':shape_id', $this->getShapeId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonShape()
  {
    if ($this->selectPokmonShape()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_shape (pokemon_id, shape_id) 
      VALUES (:pokemon_id, :shape_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':shape_id', $this->getShapeId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>