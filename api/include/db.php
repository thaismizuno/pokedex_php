<?php
class DB {
  private $DB_HOST;
  private $DB_NAME;
  private $DB_USER;
  private $DB_PASSWORD;

  private $mysql;
  private $query;
  private $parametersList;
  private $type;

  function __construct() {
    $this->type = ['INT' => PDO::PARAM_INT, 'STR' => PDO::PARAM_STR];
    $local = 'on';

    if ($local == 'on') {
      $this->setDBHost('localhost');
      $this->setDBName('pokedex');
      $this->setDBUser('root');
      $this->setDBPassword('1q2w3e4r');
    } else {
      $this->setDBHost('mysql.carteado.kinghost.net');
      $this->setDBName('carteado');
      $this->setDBUser('carteado_add1');
      $this->setDBPassword('JQBBwUmNMj6A');
    }

    $this->mysql = $this->connect();
  }

  private function setDBHost($info)
  {
    $this->DB_HOST = $info;
  }

  private function getDBHost()
  {
    return $this->DB_HOST;
  }

  private function setDBName($info)
  {
    $this->DB_NAME = $info;
  }

  private function getDBName()
  {
    return $this->DB_NAME;
  }

  private function setDBUser($info) {
    $this->DB_USER = $info;
  }

  private function getDBUser()
  {
    return $this->DB_USER;
  }

  private function setDBPassword($info) {
    $this->DB_PASSWORD = $info;
  }

  private function getDBPassword()
  {
    return $this->DB_PASSWORD;
  }

  public function connect()
  {
    return new PDO("mysql:host={$this->getDBHost()};dbname={$this->getDBName()};charset=utf8", $this->getDBUser(), $this->getDBPassword());
  }

  public function setQuery($query)
  {
    $this->query = $query;
  }

  private function getQuery()
  {
    return $this->query;
  }

  public function setParametersList($parametersList)
  {
    $this->parametersList = $parametersList;
  }

  private function getParametersList()
  {
    return $this->parametersList;
  }

  private function setParameters($db, $parameter)
  {
    $db->bindParam($parameter['column_name'], $parameter['value'], $parameter['type']);
  }

  private function mountQuery($stmt, $parameters)
  {
    foreach( $this->getParametersList() as $parameter ) {
      $this->setParameters($stmt, $parameter);
    }
  }

  public function insertOrUpdateExecuteQuery()
  {
    try {
      $db = $this->mysql->prepare($this->getQuery());

      foreach ( $this->getParametersList() as $parameter ) {
        $db->bindParam($parameter[0], $parameter[1], $parameter[2]);
      }

      $result = $db->execute();
      if (!$result) {
        echo("Error ao adicionar novo registro: ");
        print_r($db->errorInfo());
        return false;
      }

      return $result;
    } catch(Exception $e) {
      return array(
        'message' => $e->getMessage()
      );
    }
  }

  public function selectOneLineQuery()
  {
    try {
      $db = $this->mysql->prepare($this->getQuery());
      foreach ( $this->getParametersList() as $parameter ) {
        $db->bindParam($parameter[0], $parameter[1], $parameter[2]);
      }
      $db->execute();
      return $db->fetch();
    } catch(Exception $e) {
      return array(
        'message' => $e->getMessage()
      );
    }
  }

  public function selectManyLinesQuery()
  {
    try {
      $db = $this->mysql->prepare($this->getQuery());
      foreach( $this->getParametersList() as $parameter ) {
        $db->bindParam($parameter[0], $parameter[1], $parameter[2]);
      }
      $db->execute();
      return $db->fetchAll();
    } catch(Exception $e) {
      return array(
        'message' => $e->getMessage()
      );
    }
  }
}
?>