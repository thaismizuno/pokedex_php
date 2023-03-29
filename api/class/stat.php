<?php
class Stat
{
  private $auxiliaryFunctions;
  private $db;

  private $stat_id;
  private $stat_english_name;
  private $stat_portuguese_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setStatId($content)
  {
    $this->stat_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getStatId()
  {
    return $this->stat_id;
  }

  public function setStatEnglishName($content)
  {
    $this->stat_english_name = $content->name;
  }

  private function getStatEnglishName()
  {
    return $this->stat_english_name;
  }

  public function setStatPortugueseName($content)
  {
    $this->stat_portuguese_name = $this->auxiliaryFunctions->translateStatName($content->name);
  }

  private function getStatPortugueseName()
  {
    return $this->stat_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Stat | {$this->getStatId()} - {$this->getStatEnglishName()} - {$this->getStatPortugueseName()}\n";
  }

  private function selectStat()
  {
    $this->db->setQuery("SELECT * FROM stat WHERE stat_id = :stat_id");

    $this->db->setParametersList([
      [':stat_id', $this->getStatId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  private function updateStat()
  {
    $this->db->setQuery(
      "UPDATE stat
      SET stat_english_name = :stat_english_name, stat_portuguese_name = :stat_portuguese_name
      WHERE stat_id = :stat_id"
    );

    $this->db->setParametersList([
      [':stat_english_name', $this->getStatEnglishName(), PDO::PARAM_STR],
      [':stat_portuguese_name', $this->getStatPortugueseName(), PDO::PARAM_STR],
      [':stat_id', $this->getStatId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertStat()
  {
    if ($this->selectStat()) {
      return $this->updateStat();
    }

    $this->db->setQuery(
      "INSERT INTO stat (stat_id, stat_english_name, stat_portuguese_name) 
      VALUES (:stat_id, :stat_english_name, :stat_portuguese_name)"
    );

    $this->db->setParametersList([
      [':stat_id', $this->getStatId(), PDO::PARAM_INT],
      [':stat_english_name', $this->getStatEnglishName(), PDO::PARAM_STR],
      [':stat_portuguese_name', $this->getStatPortugueseName(), PDO::PARAM_STR],
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>