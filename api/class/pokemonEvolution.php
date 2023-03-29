<?php
class PokemonEvolution {
  private $auxiliaryFunctions;
  private $db;

  private $pokemon_id_from;
  private $pokemon_id_to;
  private $pokemon_evolution;

  public function __construct()
  {
    $this->auxiliaryFunctions = new AuxiliaryFunctions();
    $this->db = new DB();
  }

  public function setPokemonIdFrom($content)
  {
    $this->pokemon_id_from = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getPokemonIdFrom()
  {
    return $this->pokemon_id_from;
  }

  public function setPokemonIdTo($content)
  {
    $this->pokemon_id_to = $this->auxiliaryFunctions->formatId($content->url);
  }

  private function getPokemonIdTo()
  {
    return $this->pokemon_id_to;
  }

  public function setPokemonEvolution($content)
  {
    $this->pokemon_evolution = $content;
  }

  private function getPokemonEvolution()
  {
    return $this->pokemon_evolution;
  }

  private function auxiliaryMsg()
  {
    return " - Pokemon Evolution Chain | Pokemon ID From: {$this->getPokemonIdFrom()} - Pokemon Id To: {$this->getPokemonIdTo()} - Pokemon Evolution: {$this->getPokemonEvolution()}\n";
  }

  private function selectNextPokemon()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon
      WHERE pokemon_id = :pokemon_id"
    );

    $this->db->setParametersList([
      [':pokemon_id', $this->getPokemonIdTo(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  private function selectPokemonEvolution()
  {
    $this->db->setQuery(
      "SELECT *
      FROM pokemon_evolution_chain
      WHERE pokemon_id_from = :pokemon_id_from AND pokemon_id_to = :pokemon_id_to AND  	pokemon_evolution = :pokemon_evolution");

    $this->db->setParametersList([
      [':pokemon_id_from', $this->getPokemonIdFrom(), PDO::PARAM_INT],
      [':pokemon_id_to', $this->getPokemonIdTo(), PDO::PARAM_INT],
      [':pokemon_evolution', $this->getPokemonEvolution(), PDO::PARAM_INT]
    ]);

    return $this->db->selectOneLineQuery();
  }

  public function insertPokemonEvolution()
  {
    if (!$this->selectNextPokemon()) {
      return "Próximo Pokemon não está cadastrado " . $this->auxiliaryMsg();
    }

    if ($this->selectPokemonEvolution()) {
      return "Já cadastrado " . $this->auxiliaryMsg();
    }

    $this->db->setQuery(
      "INSERT INTO pokemon_evolution_chain (pokemon_id_from, pokemon_id_to, pokemon_evolution) 
      VALUES (:pokemon_id_from, :pokemon_id_to, :pokemon_evolution)"
    );

    $this->db->setParametersList([
      [':pokemon_id_from', $this->getPokemonIdFrom(), PDO::PARAM_INT],
      [':pokemon_id_to', $this->getPokemonIdTo(), PDO::PARAM_INT],
      [':pokemon_evolution', $this->getPokemonEvolution(), PDO::PARAM_INT]
    ]);

    return ($this->db->insertOrUpdateExecuteQuery() ? "Cadastrado" : "Erro ao cadastrar") . $this->auxiliaryMsg();
  }
}
?>