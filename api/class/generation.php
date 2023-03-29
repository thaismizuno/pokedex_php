<?php
class Generation
{
  private $auxiliaryFunctions;
  private $db;

  private $generation_id;
  private $generation_name;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setGenerationId($content)
  {
    $this->generation_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getGenerationId()
  {
    return $this->generation_id;
  }

  public function setGenerationName($content)
  {
    $aux = explode('-', $content->name);
    $this->generation_name = strtoupper($aux[1]);
  }

  private function getGenerationName()
  {
    return $this->generation_name;
  }

  private function auxiliaryMsg()
  {
    return " - Generation | Generation ID: {$this->getGenerationId()} - Generation Nome: {$this->getGenerationName()}\n";
  }

  private function selectGenerationById()
  {
    $this->db->setQuery("SELECT * FROM generation WHERE generation_id = :generation_id");

    $this->db->setParametersList([
      [':generation_id', $this->getGenerationId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateGeneration()
  {
    $this->db->setQuery(
      "UPDATE generation
      SET generation_name = :generation_name
      WHERE generation_id = :generation_id"
    );

    $this->db->setParametersList([
      [':generation_name', $this->getGenerationName(), PDO::PARAM_STR],
      [':generation_id', $this->getGenerationId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertGeneration()
  {
    if ($this->selectGenerationById()) {
      return $this->updateGeneration();
    }

    $this->db->setQuery(
      "INSERT generation (generation_id, generation_name) 
      VALUES (:generation_id, :generation_name)"
    );

    $this->db->setParametersList([
      [':generation_id', $this->getGenerationId(), PDO::PARAM_INT],
      [':generation_name', $this->getGenerationName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }

  public function selectAllGenerations()
  {
    $this->db->setQuery("SELECT * FROM generation ORDER BY generation_id ASC ");

    return $this->db->selectManyLinesQuery();
  }
}
?>