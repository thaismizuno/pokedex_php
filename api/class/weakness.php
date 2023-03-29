<?php
class Weakness {
  private $auxiliaryFunctions;
  private $db;

  private $primary_type_id;
  private $secondary_type_id;
  private $type_id;

  public function __construct() {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setPrimaryTypeId($content)
  {
    $this->primary_type_id = $content;
  }

  private function getPrimaryTypeId()
  {
    return $this->primary_type_id;
  }

  public function setSecondaryTypeId($content)
  {
    $this->secondary_type_id = $content;
  }

  private function getSecondaryTypeId()
  {
    return $this->secondary_type_id;
  }

  public function setTypeId($content)
  {
    $this->type_id = $content;
  }

  private function getTypeId()
  {
    return $this->type_id;
  }

  private function auxiliaryMsg()
  {
    return " - Weakness | {$this->getPrimaryTypeId()} - {$this->getSecondaryTypeId()} - {$this->getTypeId()}\n";
  }

  private function selectWeakness()
  {
    if (is_null($this->getSecondaryTypeId())) {
      $this->db->setQuery(
        "SELECT * FROM `weakness`
        WHERE `primary_type_id` = :primary_type_id
          AND `secondary_type_id` IS NULL
          AND `type_id` = :type_id");

      $this->db->setParametersList([
        [':primary_type_id', $this->getPrimaryTypeId(), PDO::PARAM_INT],
        [':type_id', $this->getTypeId(), PDO::PARAM_INT]
      ]);
    } else {
      $this->db->setQuery(
        "SELECT * FROM `weakness`
        WHERE `primary_type_id` = :primary_type_id
          AND `secondary_type_id` = :secondary_type_id
          AND `type_id` = :type_id");

      $this->db->setParametersList([
        [':primary_type_id', $this->getPrimaryTypeId(), PDO::PARAM_INT],
        [':secondary_type_id', $this->getSecondaryTypeId(), PDO::PARAM_INT],
        [':type_id', $this->getTypeId(), PDO::PARAM_INT]
      ]);
    }

    return $this->db->selectOneLineQuery();
  }

  public function insertWeakness()
  {
    if ($this->selectWeakness()) {
      return 'Já cadastrado' . $this->auxiliaryMsg();
    }

    $this->db->setQuery(
      "INSERT INTO `weakness` (`primary_type_id`, `secondary_type_id`, `type_id`) 
      VALUES (:primary_type_id, :secondary_type_id, :type_id)"
    );

    $this->db->setParametersList([
      [':primary_type_id', $this->getPrimaryTypeId(), PDO::PARAM_INT],
      [':secondary_type_id', $this->getSecondaryTypeId(), PDO::PARAM_INT],
      [':type_id', $this->getTypeId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
    return false;
  }
}
?>