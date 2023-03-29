
<?php
include 'db.php';

class DropTables {
  private $db;
  private $mysql;

  public function __construct() {
    $db = new DB();
    $this->mysql = $db->connect();
  }

  private function dropTablePokemonAbility()
  {
    $this->mysql->exec("DROP TABLE `pokemon_ability`;");
  }
  
  private function dropTableAbility()
  {
    $this->mysql->exec("DROP TABLE `ability`;");
  }

  private function dropTablePokemonColor()
  {
    $this->mysql->exec("DROP TABLE `pokemon_color`;");
  }

  private function dropTableColor()
  {
    $this->mysql->exec("DROP TABLE `color`;");
  }

  private function dropTablePokemonEggGroup()
  {
    $this->mysql->exec("DROP TABLE `pokemon_egg_group`;");
  }

  private function dropTableEggGroup()
  {
    $this->mysql->exec("DROP TABLE `egg_group`");
  }

  private function dropTablePokemonGender()
  {
    $this->mysql->exec("DROP TABLE `pokemon_gender`;");
  }

  private function dropTableGender()
  {
    $this->mysql->exec("DROP TABLE `gender`;");
  }

  private function dropTablePokemonGeneration()
  {
    $this->mysql->exec("DROP TABLE `pokemon_generation`;");
  }

  private function dropTableGeneration()
  {
    $this->mysql->exec("DROP TABLE `generation`;");
  }

  private function dropTablePokemonHabitat()
  {
    $this->mysql->exec("DROP TABLE `pokemon_habitat`;");
  }

  private function dropTableHabitat()
  {
    $this->mysql->exec("DROP TABLE `habitat`;");
  }

  private function dropTablePokemonShape()
  {
    $this->mysql->exec("DROP TABLE `pokemon_shape`;");
  }

  private function dropTableShape()
  {
    $this->mysql->exec("DROP TABLE `shape`;");
  }

  private function dropTablePokemonStat()
  {
    $this->mysql->exec("DROP TABLE `pokemon_stat`;");
  }

  private function dropTableStat()
  {
    $this->mysql->exec("DROP TABLE `stat`;");
  }

  private function dropTableEvolutionChain()
  {
    $this->mysql->exec("DROP TABLE `pokemon_evolution_chain`;");
  }

  private function dropTableWeakness()
  {
    $this->mysql->exec("DROP TABLE `weakness`;");
  }

  private function dropTablePokemonType()
  {
    $this->mysql->exec("DROP TABLE `pokemon_type`;");
  }

  private function dropTableType()
  {
    $this->mysql->exec("DROP TABLE `type`;");
  }

  private function dropTablePokemon()
  {
    $this->mysql->exec("DROP TABLE `pokemon`;");
  }

  public function dropTables() {
    var_dump('dropTables');
    $this->mysql->beginTransaction();

    $this->dropTablePokemonAbility();
    $this->dropTableAbility();

    $this->dropTablePokemonColor();
    $this->dropTableColor();

    $this->dropTablePokemonEggGroup();
    $this->dropTableEggGroup();

    $this->dropTablePokemonGender();
    $this->dropTableGender();

    $this->dropTablePokemonGeneration();
    $this->dropTableGeneration();

    $this->dropTablePokemonHabitat();
    $this->dropTableHabitat();

    $this->dropTablePokemonShape();
    $this->dropTableShape();

    $this->dropTablePokemonStat();
    $this->dropTableStat();

    $this->dropTableEvolutionChain();

    $this->dropTableWeakness();

    $this->dropTablePokemonType();

    $this->dropTableType();

    $this->dropTablePokemon();

    $this->mysql->commit();
  }
}

$x = new DropTables();
$x->dropTables();
/*DROP TABLE pokemon_ability;
DROP TABLE ability;

DROP TABLE pokemon_color;
DROP TABLE color;

DROP TABLE pokemon_egg_group;
DROP TABLE egg_group;

DROP TABLE pokemon_gender;
DROP TABLE gender;

DROP TABLE pokemon_generation;
DROP TABLE generation;

DROP TABLE pokemon_habitat;
DROP TABLE habitat;

DROP TABLE pokemon_shape;
DROP TABLE shape;

DROP TABLE pokemon_stat;
DROP TABLE stat;

DROP TABLE pokemon_evolution_chain;
drop table weakness;

DROP TABLE pokemon_type;
DROP TABLE pokemon;
drop table type;
*/
?>