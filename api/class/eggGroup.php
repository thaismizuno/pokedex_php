<?php
class EggGroup
{
  private $auxiliaryFunctions;
  private $db;

  private $egg_group_id;
  private $egg_group_english_name;
  private $egg_group_portuguese_name;

  public function __construct() {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setEggGroupId($content)
  {
    $this->egg_group_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getEggGroupId()
  {
    return $this->egg_group_id;
  }

  public function setEggGroupEnglishName($content)
  {
    $this->egg_group_english_name = $content->name;
  }

  private function getEggGroupEnglishName()
  {
    return $this->egg_group_english_name;
  }

  public function setEggGroupPortugueseName($content)
  {
    $this->egg_group_portuguese_name = $this->auxiliaryFunctions->translateEggGroupName($content->name);
  }

  private function getEggGroupPortugueseName()
  {
    return $this->egg_group_portuguese_name;
  }

  private function auxiliaryMsg() {
    return " - EggGroup | {$this->getEggGroupId()} - {$this->getEggGroupEnglishName()} - {$this->getEggGroupPortugueseName()}\n";
  }

  private function selectEggGroupById()
  {
    $this->db->setQuery("SELECT * FROM egg_group WHERE egg_group_id = :egg_group_id");

    $this->db->setParametersList([
      [':egg_group_id', $this->getEggGroupId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateEggGroup() {
    $this->db->setQuery(
      "UPDATE egg_group
      SET egg_group_english_name = :egg_group_english_name, egg_group_portuguese_name = :egg_group_portuguese_name
      WHERE egg_group_id = :egg_group_id"
    );

    $this->db->setParametersList([
      [':egg_group_english_name', $this->getEggGroupEnglishName(), PDO::PARAM_STR],
      [':egg_group_portuguese_name', $this->getEggGroupPortugueseName(), PDO::PARAM_STR],
      [':egg_group_id', $this->getEggGroupId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertEggGroup() {
    if ($this->selectEggGroupById()) {
      return $this->updateEggGroup();
    }

    $this->db->setQuery(
      "INSERT INTO egg_group (egg_group_id, egg_group_english_name, egg_group_portuguese_name) 
      VALUES (:egg_group_id, :egg_group_english_name, :egg_group_portuguese_name)"
    );

    $this->db->setParametersList([
      [':egg_group_id', $this->getEggGroupId(), PDO::PARAM_INT],
      [':egg_group_english_name', $this->getEggGroupEnglishName(), PDO::PARAM_STR],
      [':egg_group_portuguese_name', $this->getEggGroupPortugueseName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>