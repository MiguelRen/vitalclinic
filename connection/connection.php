<?php

  class Connection {

  private static $instance = null;
  private $connection;
 
  
  // Constructor privado para evitar instanciación externa
  private function __construct() {
      $this->connection = new mysqli('localhost', 'root', '', 'vitalclinic');

      // Comprobar la conexión
      if ($this->connection->connect_error) {
          die("Conexión fallida: " . $this->connection->connect_error);
      }
  }

  // Método para obtener la instancia de la conexión
  public static function getInstance() {
      if (self::$instance == null) {
          self::$instance = new Connection();
      }
      return self::$instance;
  }

  // Método para obtener la conexión
  public function getConnection() {
      return $this->connection;
  }
}
