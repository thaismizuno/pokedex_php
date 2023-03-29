<?php
class Shape
{
  private $auxiliaryFunctions;
  private $db;

  private $shape_id;
  private $shape_english_name;
  private $shape_portuguese_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setShapeId($content)
  {
    $this->shape_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getShapeId()
  {
    return $this->shape_id;
  }

  public function setShapeEnglishName($content)
  {
    $this->shape_english_name = $content->name;
  }

  private function getShapeEnglishName()
  {
    return $this->shape_english_name;
  }

  public function setShapePortugueseName($content)
  {
    $this->shape_portuguese_name = $this->auxiliaryFunctions->formatName($this->auxiliaryFunctions->translateShapeName($content->name));
  }

  private function getShapePortugueseName()
  {
    return $this->shape_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Shape | {$this->getShapeId()} - {$this->getShapeEnglishName()} - {$this->getShapePortugueseName()}\n";
  }

  private function selectShape()
  {
    $this->db->setQuery("SELECT * FROM shape WHERE shape_id = :shape_id");

    $this->db->setParametersList([
      [':shape_id', $this->getShapeId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateShape()
  {
    $this->db->setQuery(
      "UPDATE shape
      SET shape_english_name = :shape_english_name, shape_portuguese_name = :shape_portuguese_name
      WHERE shape_id = :shape_id"
    );

    $this->db->setParametersList([
      [':shape_english_name', $this->getShapeEnglishName(), PDO::PARAM_STR],
      [':shape_portuguese_name', $this->getShapePortugueseName(), PDO::PARAM_STR],
      [':shape_id', $this->getShapeId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertShape()
  {
    if ($this->selectShape()) {
      return $this->updateShape();
    }

    $this->db->setQuery(
      "INSERT INTO shape (shape_id, shape_english_name, shape_portuguese_name) 
      VALUES (:shape_id, :shape_english_name, :shape_portuguese_name)"
    );

    $this->db->setParametersList([
      [':shape_id', $this->getShapeId(), PDO::PARAM_INT],
      [':shape_english_name', $this->getShapeEnglishName(), PDO::PARAM_STR],
      [':shape_portuguese_name', $this->getShapePortugueseName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>