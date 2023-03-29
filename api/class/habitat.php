<?php
class Habitat
{
  private $auxiliaryFunctions;
  private $db;
 
  private $habitat_id;
  private $habitat_english_name;
  private $habitat_portuguese_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setHabitatId($content)
  {
    $this->habitat_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getHabitatId()
  {
    return $this->habitat_id;
  }

  public function setHabitatEnglishName($content)
  {
    $this->habitat_english_name = $content->name;
  }

  private function getHabitatEnglishName()
  {
    return $this->habitat_english_name;
  }

  public function setHabitatPortugueseName($content)
  {
    $this->habitat_portuguese_name = $this->auxiliaryFunctions->formatName($this->auxiliaryFunctions->translateHabitatName($content->name));
  }

  private function getHabitatPortugueseName()
  {
    return $this->habitat_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Habitat | {$this->getHabitatId()} - {$this->getHabitatEnglishName()} - {$this->getHabitatPortugueseName()}\n";
  }

  private function selectHabitatById()
  {
    $this->db->setQuery("SELECT * FROM habitat WHERE habitat_id = :habitat_id");

    $this->db->setParametersList([
      [':habitat_id', $this->getHabitatId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateHabitat()
  {
    $this->db->setQuery(
      "UPDATE habitat
      SET habitat_english_name = :habitat_english_name, habitat_portuguese_name = :habitat_portuguese_name
      WHERE habitat_id = :habitat_id"
    );

    $this->db->setParametersList([
      [':habitat_english_name', $this->getHabitatEnglishName(), PDO::PARAM_STR],
      [':habitat_portuguese_name', $this->getHabitatPortugueseName(), PDO::PARAM_STR],
      [':habitat_id', $this->getHabitatId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertHabitat()
  {
    if ($this->selectHabitatById()) {
      return $this->updateHabitat();
    }

    $this->db->setQuery(
      "INSERT INTO habitat (habitat_id, habitat_english_name, habitat_portuguese_name) 
      VALUES (:habitat_id, :habitat_english_name, :habitat_portuguese_name)"
    );

    $this->db->setParametersList([
      [':habitat_id', $this->getHabitatId(), PDO::PARAM_INT],
      [':habitat_english_name', $this->getHabitatEnglishName(), PDO::PARAM_STR],
      [':habitat_portuguese_name', $this->getHabitatPortugueseName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }

  public function selectAllHabitats()
  {
    $this->db->setQuery("SELECT * FROM habitat ORDER BY habitat_id ASC ");
    return $this->db->selectManyLinesQuery();
  }
}
?>