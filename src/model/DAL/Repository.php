<?php
  namespace DAL;

  require_once("Settings.php");

  abstract class Repository {
    protected $dbConnection;
    protected $dbTable;

    /**
      * Connect to the db
      *
      * @return connection - a db-connection to use
      */
    protected function connection() {
      if ($this->dbConnection == NULL)
        $this->dbConnection = new \PDO(\Settings::$DB_CONNECTION, \Settings::$DB_USERNAME, \Settings::$DB_PASSWORD);

      $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      return $this->dbConnection;
    }
  }
