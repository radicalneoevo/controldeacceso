<?php
include_once("dao/DAO.php");
include_once("entidad/Periodo.php");
include_once("entidad/DiaFeriado.php");
include_once("entidad/SemanaEspecial.php");

/**
 * Descripcion de PeriodoDAO
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 22-12-2009
 */
class PeriodoDAO extends DAO
{
    private $areaDAO;

    function __construct()
    {
        parent::__construct();
        $this->areaDAO = new AreaDAO();
    }

    public function getPeriodos()
    {
        $connection = parent::initDB();
        $query = "SELECT idPeriodo, nombre, area, inicio, fin, observaciones " .
                 "FROM periodo ";

        $result = mysql_query($query);

        $periodos = array();
        while($row = mysql_fetch_array($result))
        {
            $periodo = new Periodo();
            $periodo->setIdPeriodo($row['idPeriodo']);
            $periodo->setNombre($row['nombre']);
            $periodo->setArea($this->areaDAO->getArea($row['area']));
            $periodo->setInicioISO($row['inicio']);
            $periodo->setFinISO($row['fin']);
            $periodo->setObservaciones($row['observaciones']);

            array_push($periodos, $periodo);
        }

        parent::closeDB($connection);
        return $periodos;
    }

    public function getPeriodo($idPeriodo)
    {
        $connection = parent::initDB();
        $query = "SELECT idPeriodo, nombre, area, inicio, fin, observaciones " .
                 "FROM periodo " .
                 "WHERE idPeriodo = $idPeriodo";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el periodo');

        $row = mysql_fetch_array($result);
        $periodo = new Periodo();
        $periodo->setIdPeriodo($row['idPeriodo']);
        $periodo->setNombre($row['nombre']);
        $periodo->setArea($this->areaDAO->getArea($row['area']));
        $periodo->setInicioISO($row['inicio']);
        $periodo->setFinISO($row['fin']);
        $periodo->setObservaciones($row['observaciones']);

        parent::closeDB($connection);
        return $periodo;
    }

    public function insertarPeriodo($periodo)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO periodo (nombre, area, inicio, fin, observaciones) " .
                "VALUES ('" . $periodo->getNombre() . "', " .
                              $periodo->getArea()->getIdArea() . ", " .
                             "str_to_date('" . $periodo->imprimirInicio() . "', '%d-%m-%Y'), " .
                             "str_to_date('" . $periodo->imprimirFin() . "', '%d-%m-%Y'), '" .
                              $periodo->getObservaciones() . "')";
       
        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar el periodo');

        parent::closeDB($connection);
    }

    public function hayPeriodosSuperpuestos($periodo)
    {
        $connection = parent::initDB();
        $query = "SELECT * " .
                 "FROM periodo " .
                 "WHERE str_to_date('" . $periodo->imprimirInicio() . "', '%d-%m-%Y') < fin AND " .
                 "      inicio < str_to_date('" . $periodo->imprimirFin() . "', '%d-%m-%Y') AND " .
                 "      area = " . $periodo->getArea()->getIdArea();

        $result = mysql_query($query);

        if(mysql_num_rows($result) == 0)
        {
            parent::closeDB($connection);
            return false;
        }
        else
        {
            parent::closeDB($connection);
            return true;
        }
    }

    public function editarPeriodo($periodo)
    {
        $connection = parent::initDB();
        $query = "UPDATE periodo SET " .
                 "nombre = '" . $periodo->getNombre() . "', " .
                 "observaciones = '" . $periodo->getObservaciones() . "' " .
                 "WHERE idPeriodo = " . $periodo->getIdPeriodo();

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function getPeriodoActual($idArea)
    {
        $connection = parent::initDB();
        $query = "SELECT idPeriodo, nombre, area, inicio, fin, observaciones " .
                 "FROM periodo " .
                 "WHERE inicio < curdate() AND curdate() < fin AND area = $idArea ";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No hay periodos activos para esa área');


        $row = mysql_fetch_array($result);
        $periodo = new Periodo();
        $periodo->setIdPeriodo($row['idPeriodo']);
        $periodo->setNombre($row['nombre']);
        $periodo->setArea($this->areaDAO->getArea($row['area']));
        $periodo->setInicioISO($row['inicio']);
        $periodo->setFinISO($row['fin']);
        $periodo->setObservaciones($row['observaciones']);

        parent::closeDB($connection);
        return $periodo;
    }

    public function getDiasFeriados($idPeriodo)
    {
        $connection = parent::initDB();
        $query = "SELECT idDiaFeriado, periodo, fecha, descripcion " .
                 "FROM dia_feriado " .
                 "WHERE periodo = $idPeriodo " .
                 "ORDER BY fecha";

        $result = mysql_query($query);

        $diasFeriados = array();
        while($row = mysql_fetch_array($result))
        {
            $diaFeriado = new DiaFeriado();
            $diaFeriado->setIdDiaFeriado($row['idDiaFeriado']);
            $diaFeriado->setPeriodo($this->getPeriodo($row['periodo']));
            $diaFeriado->setFechaISO($row['fecha']);
            $diaFeriado->setDescripcion($row['descripcion']);

            array_push($diasFeriados, $diaFeriado);
        }

        parent::closeDB($connection);
        return $diasFeriados;
    }

    public function getDiaFeriado($idDiaFeriado)
    {
        $connection = parent::initDB();
        $query = "SELECT idDiaFeriado, periodo, fecha, descripcion " .
                 "FROM dia_feriado " .
                 "WHERE idDiaFeriado = $idDiaFeriado ";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el dia feriado');

        $row = mysql_fetch_array($result);

        $diaFeriado = new DiaFeriado();
        $diaFeriado->setIdDiaFeriado($row['idDiaFeriado']);
        $diaFeriado->setPeriodo($this->getPeriodo($row['periodo']));
        $diaFeriado->setFechaISO($row['fecha']);
        $diaFeriado->setDescripcion($row['descripcion']);

        parent::closeDB($connection);
        return $diaFeriado;
    }

    public function insertarDiaFeriado($diaFeriado)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO dia_feriado (periodo, fecha, descripcion) " .
                "VALUES (" . $diaFeriado->getPeriodo()->getIdPeriodo() . ", " .
                             "str_to_date('" . $diaFeriado->imprimirFecha() . "', '%d-%m-%Y'), '" .
                              $diaFeriado->getDescripcion() . "')";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar el dia feriado');

        parent::closeDB($connection);
    }

    public function editarDiaFeriado($diaFeriado)
    {
        $connection = parent::initDB();
        $query = "UPDATE dia_feriado SET " .
                 "descripcion = '" . $diaFeriado->getDescripcion() . "' " .
                 "WHERE idDiaFeriado = " . $diaFeriado->getIdDiaFeriado();

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function eliminarDiaFeriado($diaFeriado)
    {
        $connection = parent::initDB();
        $query = "DELETE FROM dia_feriado " .
                 "WHERE idDiaFeriado = " . $diaFeriado->getIdDiaFeriado();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo eliminar el dia feriado');

        parent::closeDB($connection);
    }

    public function existeDiaFeriado($diaFeriado)
    {
        $connection = parent::initDB();
        $query = "SELECT * " .
                 "FROM dia_feriado " .
                 "WHERE fecha = str_to_date('" . $diaFeriado->imprimirFecha() . "', '%d-%m-%Y') AND " .
                 "      periodo = " . $diaFeriado->getPeriodo()->getIdPeriodo();

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
        {
            parent::closeDB($connection);
            return false;
        }
        else
        {
            parent::closeDB($connection);
            return true;
        }
    }

    public function getSemanasEspeciales($idPeriodo)
    {
        $connection = parent::initDB();
        $query = "SELECT idSemanaEspecial, periodo, descripcion, inicio, fin " .
                 "FROM semana_especial " .
                 "WHERE periodo = $idPeriodo " .
                 "ORDER BY inicio";

        $result = mysql_query($query);

        $semanasEspeciales = array();
        while($row = mysql_fetch_array($result))
        {
            $semanaEspecial = new SemanaEspecial();
            $semanaEspecial->setIdSemanaEspecial($row['idSemanaEspecial']);
            $semanaEspecial->setPeriodo($this->getPeriodo($row['periodo']));
            $semanaEspecial->setDescripcion($row['descripcion']);
            $semanaEspecial->setInicioISO($row['inicio']);
            $semanaEspecial->setFinISO($row['fin']);

            array_push($semanasEspeciales, $semanaEspecial);
        }

        parent::closeDB($connection);
        return $semanasEspeciales;
    }

    public function getSemanaEspecial($idSemanaEspecial)
    {
        $connection = parent::initDB();
        $query = "SELECT idSemanaEspecial, periodo, descripcion, inicio, fin " .
                 "FROM semana_especial " .
                 "WHERE idSemanaEspecial = $idSemanaEspecial ";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener la semana especial');

        $row = mysql_fetch_array($result);

        $semanaEspecial = new SemanaEspecial();
        $semanaEspecial->setIdSemanaEspecial($row['idSemanaEspecial']);
        $semanaEspecial->setPeriodo($this->getPeriodo($row['periodo']));
        $semanaEspecial->setDescripcion($row['descripcion']);
        $semanaEspecial->setInicioISO($row['inicio']);
        $semanaEspecial->setFinISO($row['fin']);

        parent::closeDB($connection);
        return $semanaEspecial;
    }

    public function insertarSemanaEspecial($semanaEspecial)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO semana_especial (periodo, descripcion, inicio, fin) " .
                "VALUES (" . $semanaEspecial->getPeriodo()->getIdPeriodo() . ", '" .
                             $semanaEspecial->getDescripcion() . "', " .
                             "str_to_date('" . $semanaEspecial->imprimirInicio() . "', '%d-%m-%Y'), " .
                             "str_to_date('" . $semanaEspecial->imprimirFin() . "', '%d-%m-%Y'))";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar la semana especial');

        parent::closeDB($connection);
    }

    public function editarSemanaEspecial($semanaEspecial)
    {
        $connection = parent::initDB();
        $query = "UPDATE semana_especial SET " .
                 "descripcion = '" . $semanaEspecial->getDescripcion() . "', " .
                 "inicio = str_to_date('" . $semanaEspecial->imprimirInicio() . "', '%d-%m-%Y'), " .
                 "fin = str_to_date('" . $semanaEspecial->imprimirFin() . "', '%d-%m-%Y') " .
                 "WHERE idSemanaEspecial = " . $semanaEspecial->getIdSemanaEspecial();

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function eliminarSemanaEspecial($semanaEspecial)
    {
        $connection = parent::initDB();
        $query = "DELETE FROM semana_especial " .
                 "WHERE idSemanaEspecial = " . $semanaEspecial->getIdSemanaEspecial();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo eliminar el dia feriado');

        parent::closeDB($connection);
    }

    public function existeSuperposicion($semanaEspecial)
    {
        $connection = parent::initDB();
        $query = "SELECT * " .
                 "FROM semana_especial " .
                 "WHERE str_to_date('" . $semanaEspecial->imprimirInicio() . "', '%d-%m-%Y') < fin AND " .
                 "      inicio < str_to_date('" . $semanaEspecial->imprimirFin() . "', '%d-%m-%Y') AND " .
                 "      periodo = " . $semanaEspecial->getPeriodo()->getIdPeriodo();


        $result = mysql_query($query);

        if(mysql_num_rows($result) == 0)
        {
            parent::closeDB($connection);
            return false;
        }
        else
        {
            parent::closeDB($connection);
            return true;
        }
    }
}
?>
