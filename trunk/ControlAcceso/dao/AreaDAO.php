<?php
include_once("dao/DAO.php");
include_once("entidad/Area.php");

class AreaDAO extends DAO
{
    function __construct()
    {
        parent::__construct();
    }

    public function getAreas()
    {
        $connection = parent::initDB();
        $query = "SELECT idArea, nombreArea, departamento FROM area";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No hay areas cargadas en el sistema');

        $areas = array();
        while($row = mysql_fetch_array($result))
        {
                $area = new Area();
                $area->setIdArea($row['idArea']);
                $area->setNombreArea($row['nombreArea']);
                $area->setDepartamento($row['departamento']);

                array_push($areas, $area);
        }

        parent::closeDB($connection);
        return $areas;
    }

    public function getArea($idArea)
    {
        $connection = parent::initDB();
        $query = "SELECT idArea, nombreArea, departamento FROM area " . 
                 "WHERE idArea = $idArea";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No se pudo obtener el área');

        $row = mysql_fetch_array($result);
        
        $area = new Area();
        $area->setIdArea($row['idArea']);
        $area->setNombreArea($row['nombreArea']);
        $area->setDepartamento($row['departamento']);

        parent::closeDB($connection);
        return $area;
    }

    public function getAreasDelUsuario($numeroDocumento)
    {
        $connection = parent::initDB();
        $query =
        "SELECT idArea FROM usuario_area WHERE usuario = '$numeroDocumento'";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No se pudo obtener las areas del usuario');

        $areas = array();
        while($row = mysql_fetch_array($result))
        {
            $area = $this->getArea($row['idArea']);
            array_push($areas, $area);
        }

        parent::closeDB($connection);
        return $areas;
    }

    public function insertarUsuarioArea($numeroDocumento, $areas)
    {
        $connection = parent::initDB();

        foreach($areas as $value)
        {
            $query = "INSERT INTO usuario_area (usuario, idArea) VALUES ('" .
                     $numeroDocumento . "', '" . $value->getIdArea() . "')";

            mysql_query($query);
            if(mysql_affected_rows() == 0)
                throw new Exception('No se pudo insertar la asociación usuario/area');
        }
        
        parent::closeDB($connection);
    }

    public function modificarUsuarioArea($numeroDocumentoOriginal, $numeroDocumentoNuevo, $idArea)
    {
        $connection = parent::initDB();
        $query = "UPDATE usuario_area SET " .
                 "usuario = '" . $numeroDocumentoNuevo . "', " .
                 "idArea = '" . $idArea . "' " .
                 "WHERE usuario = " . $numeroDocumentoOriginal;

        mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo actualizar la asociación usuario/area');

        parent::closeDB($connection);
    }

    public function eliminarAreas($numeroDocumento)
    {
        $connection = parent::initDB();
        $query =
        "DELETE FROM usuario_area WHERE usuario = '$numeroDocumento'";

        mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo eliminar el area');

        parent::closeDB($connection);
    }
}
?>
