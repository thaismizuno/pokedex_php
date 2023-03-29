<?php
class PokemonStats
{
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id;
  private $stat_id;
  private $stat_base_stat;
  private $stat_effort;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setPokemonId($content)
  {
    $this->pokemon_id = $content;
  }

  private function getPokemonId()
  {
    return $this->pokemon_id;
  }

  public function setStatId($content)
  {
    $this->stat_id = $this->auxiliaryFunctions->formatId($content->stat->url);
  }

  private function getStatId()
  {
    return $this->stat_id;
  }

  public function setStatBaseStat($content)
  {
    $this->stat_base_stat = $content->base_stat;
  }

  private function getStatBaseStat()
  {
    return $this->stat_base_stat;
  }

  public function setStatEffort($content)
  {
    $this->stat_effort = $content->effort;
  }

  private function getStatEffort()
  {
    return $this->stat_effort;
  }

  private function selectPokemonStat()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_stat
      WHERE pokemon_id = :pokemon_id AND stat_id = :stat_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':stat_id', $this->getStatId(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Stat | Pokemon ID: {$this->getPokemonId()} - Stat ID: {$this->getStatId()} - Base Stat: {$this->getStatBaseStat()} - Effort: {$this->getStatEffort()}\n";
  }

  private function updatePokemonStat()
  {
    $this->db->setQuery(
      "UPDATE pokemon_stat
      SET stat_base_stat = :stat_base_stat, stat_effort = :stat_effort
      WHERE pokemon_id = :pokemon_id AND stat_id = :stat_id"
    );

    $this->db->setParametersList([
      [':stat_base_stat', $this->getStatBaseStat(), PDO::PARAM_INT],
      [':stat_effort', $this->getStatEffort(), PDO::PARAM_INT],
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':stat_id', $this->getStatId(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Atualizado" : "Erro ao atulizar") . $this->auxiliaryMsg();
  }

  public function insertPokemonStats()
  {
    if ($this->selectPokemonStat()) {
      return $this->updatePokemonStat();
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_stat (pokemon_id, stat_id, stat_base_stat, stat_effort) 
      VALUES (:pokemon_id, :stat_id, :stat_base_stat, :stat_effort)"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonId(), PDO::PARAM_INT],
      [':stat_id', $this->getStatId(), PDO::PARAM_INT],
      [':stat_base_stat', $this->getStatBaseStat(), PDO::PARAM_INT],
      [':stat_effort', $this->getStatEffort(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>