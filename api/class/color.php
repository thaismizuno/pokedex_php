<?php
class Color
{
  private $auxiliaryFunctions;
  private $db;

  private $color_id;
  private $color_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setColorId($content)
  {
    $this->color_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getColorId()
  {
    return $this->color_id;
  }

  public function setColorName($content)
  {
    $this->color_name = $content->name;
  }

  private function getColorName()
  {
    return $this->color_name;
  }

  private function auxiliaryMsg() {
    return " - Color | {$this->getColorId()} - {$this->getColorName()}\n";
  }

  private function selectColorById()
  {
    $this->db->setQuery("SELECT * FROM color WHERE color_id = :color_id");

    $this->db->setParametersList([
      [':color_id', $this->getColorId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateColor()
  {
    $this->db->setQuery(
      "UPDATE color
      SET color_name = :color_name
      WHERE color_id = :color_id"
    );

    $this->db->setParametersList([
      [':color_name', $this->getColorName(), PDO::PARAM_STR],
      [':color_id', $this->getColorId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertColor()
  {
    if ($this->selectColorById()) {
      return $this->updateColor();
    }

    $this->db->setQuery(
      "INSERT INTO color (color_id, color_name) 
      VALUES (:color_id, :color_name)"
    );

    $this->db->setParametersList([
      [':color_id', $this->getColorId(), PDO::PARAM_INT],
      [':color_name', $this->getColorName(), PDO::PARAM_STR],
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>