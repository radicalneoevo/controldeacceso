<?php
class DAO
{
    protected $databaseURL = "localhost";
    protected $databaseUName = "root";
    protected $databasePWord = "labsis";
    protected $databaseName = "controlacceso";

    function __construct()
    {
        
    }

    public function getDatabaseURL()
    {
        return $this->databaseURL;
    }

    public function setDatabaseURL($databaseURL)
    {
        $this->databaseURL = $databaseURL;
    }

    public function getDatabaseUName()
    {
        return $this->databaseUName;
    }

    public function setDatabaseUName($databaseUName)
    {
        $this->databaseUName = $databaseUName;
    }

    public function getDatabasePWord()
    {
        return $this->databasePWord;
    }

    public function setDatabasePWord($databasePWord)
    {
        $this->databasePWord = $databasePWord;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    protected function initDB()
    {
        // TODO Agregar controles de errores
        // TODO Usar variables de sesion
        $connection = mysql_connect($this->databaseURL, $this->databaseUName, $this->databasePWord);

        $db = mysql_select_db($this->databaseName,$connection);

        return $connection;
    }

    protected function closeDB($connection)
    {
        //echo 'mysql_error($connection): ' . mysql_error($connection);
        mysql_close($connection);
    }
}
?>
