<?php
include_once("dao/DAO.php");
include_once("entidad/Nivel.php");

class NivelDAO extends DAO
{
    function __construct()
    {
        parent::__construct();
    }

    public function getNiveles()
    {
        $connection = parent::initDB();
        $query = "SELECT idNivel, nombre, descripcion FROM nivel";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No hay niveles cargados en el sistema');

        $niveles = array();
        while($row = mysql_fetch_array($result))
        {
                $nivel = new Nivel();
                $nivel->setIdNivel($row['idNivel']);
                $nivel->setNombre($row['nombre']);
                $nivel->setDescripcion($row['descripcion']);

                array_push($niveles, $nivel);
        }
        
        parent::closeDB($connection);
        return $niveles;
    }

    public function getNivel($idNivel)
    {
        $connection = parent::initDB();
        $query = "SELECT idNivel, nombre, descripcion FROM nivel " .
                 "WHERE idNivel = " . $idNivel;

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No se pudo obtener el nivel');

        $row = mysql_fetch_array($result);
        $nivel = new Nivel();
        $nivel->setIdNivel($row['idNivel']);
        $nivel->setNombre($row['nombre']);
        $nivel->setDescripcion($row['descripcion']);

        parent::closeDB($connection);
        return $nivel;
    }
}
?>
