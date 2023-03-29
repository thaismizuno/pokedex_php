<?php
class Gender
{
  private $auxiliaryFunctions;
  private $db;

  private $gender_id;
  private $gender_english_name;
  private $gender_portuguese_name;

  public function __construct() {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setGenderId($content)
  {
    $this->gender_id = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getGenderId()
  {
    return $this->gender_id;
  }

  public function setGenderEnglishName($content)
  {
    $this->gender_english_name = $content->name;
  }

  private function getGenderEnglishName()
  {
    return $this->gender_english_name;
  }

  public function setGenderPortugueseName($content)
  {
    $this->gender_portuguese_name = $this->auxiliaryFunctions->translateGenderName($content->name);
  }

  private function getGenderPortugueseName()
  {
    return $this->gender_portuguese_name;
  }

  private function auxiliaryMsg()
  {
    return " - Gender | Id: {$this->getGenderId()} - {$this->getGenderEnglishName()} - {$this->getGenderPortugueseName()}\n";
  }

  private function selectGenderById()
  {
    $this->db->setQuery("SELECT * FROM gender WHERE gender_id = :gender_id");

    $this->db->setParametersList([
      [':gender_id', $this->getGenderId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function updateGender()
  {
    $this->db->setQuery(
      "UPDATE gender
      SET gender_english_name = :gender_english_name, gender_portuguese_name = :gender_portuguese_name
      WHERE gender_id = :gender_id"
    );

    $this->db->setParametersList([
      [':gender_english_name', $this->getGenderEnglishName(), PDO::PARAM_STR],
      [':gender_portuguese_name', $this->getGenderPortugueseName(), PDO::PARAM_STR],
      [':gender_id', $this->getGenderId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertGender()
  {
    if ($this->selectGenderById()) {
      return $this->updateGender();
    }

    $this->db->setQuery(
      "INSERT INTO gender (gender_id, gender_english_name, gender_portuguese_name) 
      VALUES (:gender_id, :gender_english_name, :gender_portuguese_name)"
    );

    $this->db->setParametersList([
      [':gender_id', $this->getGenderId(), PDO::PARAM_INT],
      [':gender_english_name', $this->getGenderEnglishName(), PDO::PARAM_STR],
      [':gender_portuguese_name', $this->getGenderPortugueseName(), PDO::PARAM_STR]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>