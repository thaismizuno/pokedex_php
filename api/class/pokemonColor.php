<?php
class PokemonColor
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $color_id;

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

  public function setColorId($content)
  {
    $this->color_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getColorId()
  {
    return $this->color_id;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Color | Pokemon ID: {$this->getPokemonId()} - Color ID: {$this->getColorId()}\n";
  }

  public function selectPokmonColor()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_color
      WHERE pokemon_id = :pokemon_id AND color_id = :color_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':color_id', $this->getColorId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonColor()
  {
    if ($this->selectPokmonColor()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_color (pokemon_id, color_id) 
      VALUES (:pokemon_id, :color_id)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':color_id', $this->getColorId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>