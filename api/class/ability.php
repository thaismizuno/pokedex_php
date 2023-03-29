<?php
class Ability
{
  private $auxiliaryFunctions;
  private $db;

  private $ability_id;
  private $ability_english_name;
  private $ability_portuguese_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setAbilityId($content)
  {
    $this->ability_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getAbilityId()
  {
    return $this->ability_id;
  }

  public function setAbilityEnglishName($content)
  {
    $this->ability_english_name = $this->auxiliaryFunctions->formatName($content->name);
  }

  private function getAbilityEnglishName()
  {
    return $this->ability_english_name;
  }

  public function setAbilityPortugueseName($content)
  {
    $this->ability_portuguese_name = $this->auxiliaryFunctions->formatName($this->auxiliaryFunctions->translateAbilityName($content->name));
  }

  private function getAbilityPortugueseName()
  {
    return $this->ability_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Ability | {$this->getAbilityId()} - {$this->getAbilityEnglishName()} - {$this->getAbilityPortugueseName()}\n";
  }

  private function selectAbilityById()
  {
    $this->db->setQuery("SELECT * FROM ability WHERE ability_id = :ability_id");

    $this->db->setParametersList([
      [':ability_id', $this->getAbilityId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateAbility()
  {
    $this->db->setQuery(
      "UPDATE ability
      SET ability_english_name = :ability_english_name, ability_portuguese_name = :ability_portuguese_name
      WHERE ability_id = :ability_id"
    );

    $this->db->setParametersList([
      [':ability_english_name', $this->getAbilityEnglishName(), PDO::PARAM_STR],
      [':ability_portuguese_name', $this->getAbilityPortugueseName(), PDO::PARAM_STR],
      [':ability_id', $this->getAbilityId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertAbility()
  {
    if ($this->selectAbilityById()) {
      return $this->updateAbility();
    }

    $this->db->setQuery(
      "INSERT INTO ability (ability_id, ability_english_name, ability_portuguese_name) 
      VALUES (:ability_id, :ability_english_name, :ability_portuguese_name)"
    );

    $this->db->setParametersList([
      [':ability_english_name', $this->getAbilityEnglishName(), PDO::PARAM_STR],
      [':ability_portuguese_name', $this->getAbilityPortugueseName(), PDO::PARAM_STR],
      [':ability_id', $this->getAbilityId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>