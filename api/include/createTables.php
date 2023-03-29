
<?php
class CreateTables {
  private $db;
  private $mysql;

  function __construct() {
    $db = new DB();
    $this->mysql = $db->connect();
  }

  private function createTablePokemon()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS `pokemon` (
        `pokemon_id` int PRIMARY KEY AUTO_INCREMENT,
        `pokemon_name` varchar(50),
        `pokemon_image` varchar(256),
        `pokemon_height` int(11),
        `pokemon_weight` int(11)
      );
    ");
  }

  private function createTableAbility()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`ability` (
        `ability_id` int PRIMARY KEY AUTO_INCREMENT,
        `ability_english_name` varchar(256),
        `ability_portuguese_name` varchar(256)
      );
    ");
  }

  private function createTablePokemonAbility()
  {
    $this->mysql->exec(
        "CREATE TABLE IF NOT EXISTS`pokemon_ability` (
        `pokemon_id` int(11),
        `ability_id` int(11)
      );
    ");

    $this->mysql->exec("ALTER TABLE `pokemon_abilities` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon_abilities` ADD FOREIGN KEY (`ability_id`) REFERENCES `ability` (`ability_id`)");
  }

  private function createTableColor()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`color` (
        `color_id` int PRIMARY KEY AUTO_INCREMENT,
        `color_name` varchar(20)
      );"
    );
  }

  private function createTablePokemonColor()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_color` (
        `pokemon_id` int(11),
        `color_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_color` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon_color` ADD FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`)");
  }

  private function createTableEggGroup()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`egg_group` (
        `egg_group_id` int PRIMARY KEY AUTO_INCREMENT,
        `egg_group_english_name` varchar(20),
        `egg_group_portuguese_name` varchar(20)
      );"
    );
  }
  
  private function createTablePokemonEggGroup()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_egg_group` (
        `pokemon_id` int(11),
        `egg_group_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_egg_group` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`);");
    $this->mysql->exec("ALTER TABLE `pokemon_egg_group` ADD FOREIGN KEY (`egg_group_id`) REFERENCES `egg_group` (`egg_group_id`);");
  }

  private function createTableGender()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`gender` (
        `gender_id` int PRIMARY KEY AUTO_INCREMENT,
        `gender_english_name` varchar(20),
        `gender_portuguese_name` varchar(20)
      );"
    );
  }

  private function createTablePokemonGender()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_gender` (
        `pokemon_id` int(11),
        `gender_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_gender` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`);");

    $this->mysql->exec("ALTER TABLE `pokemon_gender` ADD FOREIGN KEY (`gender_id`) REFERENCES `gender` (`gender_id`);");
  }

  private function createTableGeneration()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`generation` (
        `generation_id` int PRIMARY KEY AUTO_INCREMENT,
        `generation_name` varchar(20)
      );
      "
    );
  }

  private function createTablePokemonGeneration()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_generation` (
        `pokemon_id` int(11),
        `generation_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_generation` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`);");
    $this->mysql->exec("ALTER TABLE `pokemon_generation` ADD FOREIGN KEY (`generation_id`) REFERENCES `generation` (`generation_id`);");
  }

  private function createTableHabitat()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`habitat` (
        `habitat_id` int PRIMARY KEY AUTO_INCREMENT,
        `habitat_english_name` varchar(20),
        `habitat_portuguese_name` varchar(20)
      );"
    );
  }

  private function createTablePokemonHabitat()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_habitat` (
        `pokemon_id` int(11),
        `habitat_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_habitat` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon_habitat` ADD FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`habitat_id`)");
  }

  private function createTableShape()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`shape` (
        `shape_id` int PRIMARY KEY AUTO_INCREMENT,
        `shape_english_name` varchar(20),
        `shape_portuguese_name` varchar(20)
      );"
    );
  }

  private function createTablePokemonShape()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_shape` (
        `pokemon_id` int(11),
        `shape_id` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_stat` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`);");
    $this->mysql->exec("ALTER TABLE `pokemon_stat` ADD FOREIGN KEY (`stat_id`) REFERENCES `stat` (`stat_id`);");

  }

  private function createTableStat()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`stat` (
        `stat_id` int PRIMARY KEY AUTO_INCREMENT,
        `stat_english_name` varchar(20),
        `stat_portuguese_name` varchar(20)
      );"
    );
  }

  private function createTablePokemonStat()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_stat` (
        `pokemon_id` int(11),
        `stat_id` int(11),
        `stat_base_stat` int(11),
        `stat_effort` int(11)
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_stat` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon_stat` ADD FOREIGN KEY (`stat_id`) REFERENCES `stat` (`stat_id`)");
  }

  private function createTableType()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`type` (
        `type_id` int PRIMARY KEY AUTO_INCREMENT,
        `type_english_name` varchar(20),
        `type_portuguese_name` varchar(20)
      );
    ");

    $this->mysql->exec("ALTER TABLE `pokemon` ADD FOREIGN KEY (`pokemon_primary_type_id`) REFERENCES `type` (`type_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon` ADD FOREIGN KEY (`pokemon_secondary_type_id`) REFERENCES `type` (`type_id`)");
  }

  private function createTablePokemonType()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_type` (
        `pokemon_id` int(11),
        `type_id` int(11),
        `type_order` tinyint(1) COMMENT '1=Primary / 2=Secondary'
      );
    ");

    $this->mysql->exec("ALTER TABLE `pokemon_type` ADD FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`pokemon_id`)");
    $this->mysql->exec("ALTER TABLE `pokemon_type` ADD FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`)");
  }

  private function createTableWeakness()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`weakness` (
        `primary_type_id` int(11),
        `secondary_type_id` int(11),
        `type_id` int(11)
      );
    ");

    $this->mysql->exec("ALTER TABLE `weakness` ADD FOREIGN KEY (`primary_type_id`) REFERENCES `pokemon_type` (`primary_type_id`)");
    $this->mysql->exec("ALTER TABLE `weakness` ADD FOREIGN KEY (`secondary_type_id`) REFERENCES `pokemon_type` (`secondary_type_id`)");
    $this->mysql->exec("ALTER TABLE `weakness` ADD FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`)");
  }

  private function createTableEvolutionChain()
  {
    $this->mysql->exec(
      "CREATE TABLE IF NOT EXISTS`pokemon_evolution_chain` (
        `pokemon_id_from` int(11),
        `pokemon_id_to` int(11),
        `pokemon_evolution` tinyint(1) COMMENT '1=Primeira Evolução / 2=Segunda Evolução / 3=Terceira Evolução / 4 = Quarta Evolução'
      );"
    );

    $this->mysql->exec("ALTER TABLE `pokemon_evolution_chain` ADD FOREIGN KEY (`pokemon_id_from`) REFERENCES `pokemon` (`pokemon_id`);");
    $this->mysql->exec("ALTER TABLE `pokemon_evolution_chain` ADD FOREIGN KEY (`pokemon_id_to`) REFERENCES `pokemon` (`pokemon_id`);");
  }

  public function createTables() {
    $this->mysql->beginTransaction();

    $this->createTablePokemon();

    $this->createTableAbility();
    $this->createTablePokemonAbility();

    $this->createTableColor();
    $this->createTablePokemonColor();

    $this->createTableEggGroup();
    $this->createTablePokemonEggGroup();

    $this->createTableEvolutionChain();

    $this->createTableGender();
    $this->createTablePokemonGender();

    $this->createTableGeneration();
    $this->createTablePokemonGeneration();

    $this->createTableHabitat();
    $this->createTablePokemonHabitat();

    $this->createTableShape();
    $this->createTablePokemonShape();

    $this->createTableStat();
    $this->createTablePokemonStat();

    $this->createTableType();
    $this->createTablePokemonType();

    $this->createTableWeakness();

    $this->mysql->commit();
  }
}
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