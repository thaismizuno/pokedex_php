<?php
class Type
{
  private $auxiliaryFunctions;
  private $db;

  private $type_id;
  private $type_english_name;
  private $type_portuguese_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setTypeId($content)
  {
    $this->type_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getTypeId()
  {
    return $this->type_id;
  }

  public function setTypeEnglishName($content)
  {
    $this->type_english_name = $content->name;
  }

  private function getTypeEnglishName()
  {
    return $this->type_english_name;
  }

  public function setTypePortugueseName($content)
  {
    $this->type_portuguese_name = $this->auxiliaryFunctions->translateTypeName($content->name);
  }

  private function getTypePortugueseName()
  {
    return $this->type_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Type | {$this->getTypeId()} - {$this->getTypeEnglishName()} - {$this->getTypePortugueseName()}\n";
  }

  private function selectType()
  {
    $this->db->setQuery("SELECT * FROM `type` WHERE `type_id` = :type_id");

    $this->db->setParametersList([
      [':type_id', $this->getTypeId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  private function updateType()
  {
    $this->db->setQuery(
      "UPDATE type
      SET type_english_name = :type_english_name, type_portuguese_name = :type_portuguese_name
      WHERE type_id = :type_id"
    );

    $this->db->setParametersList([
      [':type_english_name', $this->getTypeEnglishName(), PDO::PARAM_STR],
      [':type_portuguese_name', $this->getTypePortugueseName(), PDO::PARAM_STR],
      [':type_id', $this->getTypeId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertType()
  {
    if ($this->selectType()) {
      return $this->updateType();
    }

    $this->db->setQuery(
      "INSERT INTO `type` (`type_id`, `type_english_name`, `type_portuguese_name`) 
      VALUES (:type_id, :type_english_name, :type_portuguese_name)"
    );

    $this->db->setParametersList([
      [':type_id', $this->getTypeId(), PDO::PARAM_INT],
      [':type_english_name', $this->getTypeEnglishName(), PDO::PARAM_STR],
      [':type_portuguese_name', $this->getTypePortugueseName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>