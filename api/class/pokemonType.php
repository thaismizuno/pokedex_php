<?php
class PokemonType
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $type_id;
  private $type_order;

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

  public function setTypeId($content)
  {
    $this->type_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getTypeId()
  {
    return $this->type_id;
  }

  public function setTypeOrder($content)
  {
    $this->type_order = $content;
  }

  private function getTypeOrder()
  {
    return $this->type_order;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Type | Pokemon ID: {$this->getPokemonId()} - Type ID: {$this->getTypeId()} - Type Order: {$this->getTypeOrder()}\n";
  }

  private function selectTypeIdNull()
  {
    $this->db->setQuery(
      "SELECT *
        FROM pokemon_type
        WHERE pokemon_id = :pokemon_id AND `type_id` IS NULL AND type_order = :type_order");

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':type_order', $this->getTypeOrder(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertWithoutTypeId()
  {
    if ($this->selectTypeIdNull()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_type (pokemon_id, type_order) 
      VALUES (:pokemon_id, :type_order)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':type_order', $this->getTypeOrder(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }

  private function selectTypeIdNotNull()
  {
    $this->db->setQuery(
      "SELECT *
        FROM pokemon_type
        WHERE pokemon_id = :pokemon_id AND `type_id` = :type_id AND type_order = :type_order"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':type_id', $this->getTypeId(), PDO::PARAM_INT],
      [':type_order', $this->getTypeOrder(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertWithTypeId()
  {
    if ($this->selectTypeIdNotNull()) {
      return "Já cadastrado {$this->auxiliaryMsg()}";
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_type (pokemon_id, `type_id`, type_order) 
      VALUES (:pokemon_id, :type_id, :type_order)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':type_id', $this->getTypeId(), PDO::PARAM_INT],
      [':type_order', $this->getTypeOrder(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>