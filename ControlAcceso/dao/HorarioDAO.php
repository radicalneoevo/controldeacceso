<?php
include_once("dao/DAO.php");
include_once("dao/AreaDAO.php");
include_once("dao/PeriodoDAO.php");
include_once("entidad/Area.php");
include_once("entidad/Horario.php");
include_once("entidad/DiaSemana.php");
include_once("entidad/Periodo.php");
include_once("entidad/CambioHorario.php");
include_once("gui/contenidos/tablas/reportes/FilaReporteNotificacionesFaltas.php");
include_once("gui/contenidos/tablas/reportes/FilaReporteNotificacionesFaltasConReemplazo.php");
include_once("gui/contenidos/tablas/horasAsignadas/FilaTablaHorasAsignadas.php");

class HorarioDAO extends DAO
{
    private $areaDAO;
    private $periodoDAO;

    function __construct()
    {
        parent::__construct();
        $this->areaDAO = new AreaDAO();
        $this->periodoDAO = new PeriodoDAO();
    }

    public function getHorarios($numeroDocumento, $fechaInicio, $fechaFin)
    {
        $connection = parent::initDB();
        $query = "SELECT idHorario, area, periodo, fecha, ingreso, egreso " .
                 "FROM horario_asignado " .
                 "WHERE activo = 1 AND usuario = '$numeroDocumento' AND " .
                 "      fecha BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND " .
                 "                    str_to_date('$fechaFin', '%d-%m-%Y') " .
                 "ORDER BY area, fecha, ingreso ";

        $result = mysql_query($query);

        $horarios = array();
        while($row = mysql_fetch_array($result))
        {
            $horario = new Horario();
            $horario->setIdHorario($row['idHorario']);
            $horario->setFechaISO($row['fecha']);
            $horario->setIngreso($row['ingreso']);
            $horario->setEgreso($row['egreso']);
            $horario->setArea($this->areaDAO->getArea($row['area']));
            $horario->setPeriodo($this->periodoDAO->getPeriodo($row['periodo']));

            array_push($horarios, $horario);
        }

        parent::closeDB($connection);
        return $horarios;
    }

    public function getHorariosHabituales($numeroDocumento)
    {
        $connection = parent::initDB();
        $query = "SELECT idHorarioHabitual, area, periodo, dia, ingreso, egreso, confirmado " .
                 "FROM horario_asignado_habitual " .
                 "WHERE activo = 1 AND usuario = '$numeroDocumento' AND confirmado = 1 " .
                 "ORDER BY area, dia, ingreso";

        $result = mysql_query($query);

        $horarios = array();
        while($row = mysql_fetch_array($result))
        {
            $horario = new HorarioHabitual();
            $horario->setIdHorarioHabitual($row['idHorarioHabitual']);
            $horario->setDia(new DiaSemana($row['dia']));
            $horario->setIngreso($row['ingreso']);
            $horario->setEgreso($row['egreso']);
            $horario->setArea($this->areaDAO->getArea($row['area']));
            $horario->setConfirmado($row['confirmado']);
            $horario->setPeriodo($this->periodoDAO->getPeriodo($row['periodo']));

            array_push($horarios, $horario);
        }

        parent::closeDB($connection);
        return $horarios;
    }


    public function getHorario($idHorario)
    {
        $connection = parent::initDB();
        $query = "SELECT idHorario, area, periodo, fecha, ingreso, egreso " .
                 "FROM horario_asignado " .
                 "WHERE idHorario = $idHorario";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el horario');

        $row = mysql_fetch_array($result);
        $horario = new Horario();
        $horario->setIdHorario($row['idHorario']);
        $horario->setFechaISO($row['fecha']);
        $horario->setIngreso($row['ingreso']);
        $horario->setEgreso($row['egreso']);
        $horario->setArea($this->areaDAO->getArea($row['area']));
        $horario->setPeriodo($this->periodoDAO->getPeriodo($row['periodo']));

        parent::closeDB($connection);
        return $horario;
    }

    public function getHorarioHabitual($idHorarioHabitual)
    {
        $connection = parent::initDB();
        $query = "SELECT idHorarioHabitual, area, periodo, dia, ingreso, egreso, usuario " .
                 "FROM horario_asignado_habitual " .
                 "WHERE idHorarioHabitual = $idHorarioHabitual";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el horario');

        $row = mysql_fetch_array($result);
        $horario = new HorarioHabitual();
        $horario->setIdHorarioHabitual($row['idHorarioHabitual']);
        $horario->setDia(new DiaSemana($row['dia']));
        $horario->setIngreso($row['ingreso']);
        $horario->setEgreso($row['egreso']);
        $horario->setArea($this->areaDAO->getArea($row['area']));
        $horario->setPeriodo($this->periodoDAO->getPeriodo($row['periodo']));
        $gestorUsuarios = new GestorUsuarios();
        $horario->setUsuario($gestorUsuarios->getUsuario($row['usuario']));

        parent::closeDB($connection);
        return $horario;
    }

    public function existeHorario($idHorario)
    {
        $connection = parent::initDB();
        $query =
        "SELECT * FROM horario_asignado WHERE idHorario = $idHorario";

        $result = mysql_query($query);

        if(mysql_num_rows($result) == 1)
        {
            parent::closeDB($connection);
            return true;
        }
        else
        {
            parent::closeDB($connection);
            return false;
        }
    }

    public function existeHorarioHabitual($idHorarioHabitual)
    {
        $connection = parent::initDB();
        $query =
        "SELECT * FROM horario_asignado_habitual WHERE idHorarioHabitual = $idHorarioHabitual";

        $result = mysql_query($query);

        if(mysql_num_rows($result) == 1)
        {
            parent::closeDB($connection);
            return true;
        }
        else
        {
            parent::closeDB($connection);
            return false;
        }
    }


    public function eliminarHorarios($idHorarioHabitual, $fechaFin)
    {
        $connection = parent::initDB();
        $query = "DELETE FROM horario_asignado " .
                 "WHERE horarioHabitual = $idHorarioHabitual AND fecha " .
                 "      BETWEEN curdate() AND str_to_date('$fechaFin', '%d-%m-%Y') ";

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function eliminarHorario($idHorario)
    {
        $connection = parent::initDB();
        $query = "DELETE FROM horario_asignado " .
                 "WHERE idHorario = $idHorario ";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo eliminar el horario');

        parent::closeDB($connection);
    }

    public function eliminarHorarioHabitual($idHorarioHabitual)
    {
        $connection = parent::initDB();
        $query = "UPDATE horario_asignado_habitual SET activo = 0 " .
                 "WHERE idHorarioHabitual = $idHorarioHabitual";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo eliminar el horario');

        parent::closeDB($connection);
    }

    public function modificarHorario($horario)
    {
        $connection = parent::initDB();
        $query = "UPDATE horario_asignado SET " .
                 "fecha = str_to_date('" . $horario->imprimirFecha() . "', '%d-%m-%Y'), " .
                 "ingreso = '" . $horario->imprimirIngreso() . "', " .
                 "egreso = '" . $horario->imprimirEgreso() . "', " .
                 "horarioHabitual = NULL " .
                 "WHERE idHorario = " . $horario->getIdHorario();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo modificar el horario');

        parent::closeDB($connection);
    }

    public function modificarHorarioHabitual($horario)
    {
        $connection = parent::initDB();
        $query = "UPDATE horario_asignado_habitual SET " .
                 "dia = " . $horario->getDia()->getIdDiaSemana() . ", " .
                 "ingreso = '" . $horario->imprimirIngreso() . "', " .
                 "egreso = '" . $horario->imprimirEgreso() . "' " .
                 "WHERE idHorarioHabitual = " . $horario->getIdHorarioHabitual();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo modificar el horario');

        parent::closeDB($connection);
    }

    public function insertarHorario($horario)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO horario_asignado (usuario, horarioHabitual, fecha, ingreso, egreso, area, periodo, " .
                "confirmado, activo) " .
                "VALUES ('" . $horario->getUsuario()->getNumeroDocumento() . "', " .
                              $horario->getIdHorarioHabitual() . ", " .
                             "str_to_date('" . $horario->imprimirFecha() . "', '%d-%m-%Y'), '" .
                              $horario->imprimirIngreso() . "', '" .
                              $horario->imprimirEgreso() . "', " .
                              $horario->getArea()->getIdArea() . ", " .
                              $horario->getPeriodo()->getIdPeriodo() . ", " .
                              "1, 1)";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar el horario');

        parent::closeDB($connection);
    }

    public function insertarHorarioExtraordinario($horario)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO horario_asignado (usuario, fecha, ingreso, egreso, area, periodo, " .
                "confirmado, activo) " .
                "VALUES ('" . $horario->getUsuario()->getNumeroDocumento() . "', " .
                             "str_to_date('" . $horario->imprimirFecha() . "', '%d-%m-%Y'), '" .
                              $horario->imprimirIngreso() . "', '" .
                              $horario->imprimirEgreso() . "', " .
                              $horario->getArea()->getIdArea() . ", " .
                              $horario->getPeriodo()->getIdPeriodo() . ", " .
                              "1, 1)";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar el horario');

        parent::closeDB($connection);
    }

    public function insertarHorarioHabitual($horario)
    {
       $connection = parent::initDB();
       $query = "INSERT INTO horario_asignado_habitual (usuario, dia, ingreso, egreso, area, periodo, " .
                "confirmado, activo) " .
                "VALUES ('" . $horario->getUsuario()->getNumeroDocumento() . "', " .
                              $horario->getDia()->getIdDiaSemana() . ", '" .
                              $horario->imprimirIngreso() . "', '" .
                              $horario->imprimirEgreso() . "', " .
                              $horario->getArea()->getIdArea() . ", " .
                              $horario->getPeriodo()->getIdPeriodo() . ", " .
                              "1, 1)";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo insertar el horario');

        $idHorarioHabitual = mysql_insert_id();
        parent::closeDB($connection);
        return $idHorarioHabitual;
    }

    public function getHorasAsignadas($numeroDocumento)
    {
        $connection = parent::initDB();
        $query = "SELECT usuario_area.usuario, usuario_area.idArea, 
                  time_format(horasAsignadas, '%H:%i') AS horasAsignadas,
                  time_format(horasSemanalesAsignadas, '%H:%i') AS horasSemanalesAsignadas
                  FROM usuario_area
                  LEFT OUTER JOIN
                  (SELECT usuario, area, sec_to_time(sum(time_to_sec(timediff(egreso, ingreso)))) AS horasSemanalesAsignadas
                  FROM horario_asignado_habitual
                  WHERE confirmado = 1 AND activo = 1
                  GROUP BY usuario, area) AS horasAsignadas ON
                  (usuario_area.usuario = horasAsignadas.usuario AND
                  usuario_area.idArea = horasAsignadas.area)
                  WHERE usuario_area.usuario = $numeroDocumento";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaTablaHorasAsignadas();
                $fila->setArea($this->areaDAO->getArea($row['idArea']));
                $fila->setHorasAsignadas($row['horasAsignadas']);
                
                if(!empty($row['horasSemanalesAsignadas']))
                    $fila->setHorasActualmenteAsignadas($row['horasSemanalesAsignadas']);
                else
                    $fila->setHorasActualmenteAsignadas('00:00');
                
                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function asignarHoras($numeroDocumento, $idArea, $horas)
    {
        $connection = parent::initDB();
        $query = "UPDATE usuario_area SET " .
                 "horasAsignadas = '$horas' " .
                 "WHERE usuario = '$numeroDocumento' AND idArea = $idArea";

        $result = mysql_query($query);

        // TODO Controlar aca
        /*
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo asignar las horas');
         *
         */

        parent::closeDB($connection);
    }

    public function getHorariosSuperpuestos($horario)
    {
        $connection = parent::initDB();
        // Nuevo horario
        if(is_null($horario->getIdHorario()))
        $query = "SELECT idHorario, area, fecha, ingreso, egreso " .
                 "FROM horario_asignado " .
                 "WHERE str_to_date('" . $horario->imprimirIngreso() . "', '%H:%i') < egreso AND " .
                 "      ingreso < str_to_date('" . $horario->imprimirEgreso() . "', '%H:%i') AND " .
                 "      fecha = str_to_date('" . $horario->imprimirFecha() . "', '%d-%m-%Y') AND " .
                 "      usuario = '" . $horario->getUsuario()->getNumeroDocumento() . "' AND " .
                 "      activo = 1";
        else
        // Horario existente
        $query = "SELECT idHorario, area, fecha, ingreso, egreso " .
                 "FROM horario_asignado " .
                 "WHERE str_to_date('" . $horario->imprimirIngreso() . "', '%H:%i') < egreso AND " .
                 "      ingreso < str_to_date('" . $horario->imprimirEgreso() . "', '%H:%i') AND " .
                 "      fecha = str_to_date('" . $horario->imprimirFecha() . "', '%d-%m-%Y') AND " .
                 "      usuario = '" . $horario->getUsuario()->getNumeroDocumento() . "' AND " .
                 "      idHorario != " . $horario->getIdHorario() . " AND " .
                 "      activo = 1";

        $result = mysql_query($query);
        
        $horarios = array();
        while($row = mysql_fetch_array($result))
        {
            $horario = new Horario();
            $horario->setIdHorario($row['idHorario']);
            $horario->setArea($this->areaDAO->getArea($row['area']));
            $horario->setFechaISO($row['fecha']);
            $horario->setIngreso($row['ingreso']);
            $horario->setEgreso($row['egreso']);

            array_push($horarios, $horario);
        }

        parent::closeDB($connection);
        return $horarios;
    }

    public function getHorariosHabitualesSuperpuestos($horario)
    {
        $connection = parent::initDB();
        // Nuevo horario
        if(is_null($horario->getIdHorarioHabitual()))
        $query = "SELECT idHorarioHabitual, area, dia, ingreso, egreso " .
                 "FROM horario_asignado_habitual " .
                 "WHERE str_to_date('" . $horario->imprimirIngreso() . "', '%H:%i') < egreso AND " .
                 "      ingreso < str_to_date('" . $horario->imprimirEgreso() . "', '%H:%i') AND " .
                 "      dia = " . $horario->getDia()->getIdDiaSemana() . " AND " .
                 "      usuario = '" . $horario->getUsuario()->getNumeroDocumento() . "' AND " .
                 "      activo = 1";
        else
        // Horario existente
        $query = "SELECT idHorarioHabitual, area, dia, ingreso, egreso " .
                 "FROM horario_asignado_habitual " .
                 "WHERE str_to_date('" . $horario->imprimirIngreso() . "', '%H:%i') < egreso AND " .
                 "      ingreso < str_to_date('" . $horario->imprimirEgreso() . "', '%H:%i') AND " .
                 "      dia = " . $horario->getDia()->getIdDiaSemana() . " AND " .
                 "      usuario = '" . $horario->getUsuario()->getNumeroDocumento() . "' AND " .
                 "      idHorarioHabitual != " . $horario->getIdHorarioHabitual() . " AND " .
                 "      activo = 1";

        $result = mysql_query($query);

        $horarios = array();
        while($row = mysql_fetch_array($result))
        {
            $horario = new HorarioHabitual();
            $horario->setIdHorarioHabitual($row['idHorarioHabitual']);
            $horario->setArea($this->areaDAO->getArea($row['area']));
            $horario->setDia(new DiaSemana($row['dia']));
            $horario->setIngreso($row['ingreso']);
            $horario->setEgreso($row['egreso']);

            array_push($horarios, $horario);
        }

        parent::closeDB($connection);
        return $horarios;
    }

    public function eliminarHorariosEnFeriados()
    {
        $connection = parent::initDB();
        $query =
        "UPDATE horario_asignado " .
        "SET activo = 0 " .
        "WHERE idHorario IN (SELECT idHorario " .
        "                    FROM dia_feriado " .
        "                    WHERE horario_asignado.periodo = dia_feriado.periodo AND " .
        "                          horario_asignado.fecha = dia_feriado.fecha)";

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function habilitarHorariosDelFeriado($diaFeriado)
    {
        $connection = parent::initDB();
        $query =
        "UPDATE horario_asignado " .
        "SET activo = 1 " .
        "WHERE idHorario IN (SELECT idHorario " .
        "                    FROM dia_feriado " .
        "                    WHERE horario_asignado.periodo = dia_feriado.periodo AND " .
        "                          horario_asignado.fecha = dia_feriado.fecha AND " .
        "                          dia_feriado.idDiaFeriado = " . $diaFeriado->getIdDiaFeriado() . ")";

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function eliminarHorariosEnSemanasEspeciales()
    {
        $connection = parent::initDB();
        $query =
        "UPDATE horario_asignado " .
        "SET activo = 0 " .
        "WHERE idHorario IN (SELECT idHorario " .
        "                    FROM semana_especial " .
        "                    WHERE horario_asignado.periodo = semana_especial.periodo AND " .
        "                          fecha BETWEEN inicio AND fin)";

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function habilitarHorariosDeLaSemanaEspecial($semanaEspecial)
    {
        $connection = parent::initDB();
        $query =
        "UPDATE horario_asignado " .
        "SET activo = 1 " .
        "WHERE idHorario IN (SELECT idHorario " .
        "                    FROM semana_especial " .
        "                    WHERE horario_asignado.periodo = semana_especial.periodo AND " .
        "                          fecha BETWEEN inicio AND fin AND " .
        "                          semana_especial.idSemanaEspecial = " . $semanaEspecial->getIdSemanaEspecial() . ")";

        $result = mysql_query($query);

        parent::closeDB($connection);
    }

    public function confirmarHorarioHabitual($idHorarioHabitual)
    {
        $connection = parent::initDB();
        $query = "UPDATE horario_asignado_habitual SET " .
                 "confirmado = 1 " .
                 "WHERE idHorarioHabitual = $idHorarioHabitual";

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo confirmar el horario');

        parent::closeDB($connection);
    }

    public function getCambiosHorarioActivos()
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM cambio_horario_habitual
                  WHERE aceptado IS NULL";

        $result = mysql_query($query);

        $cambiosHorario = array();
        while($row = mysql_fetch_array($result))
        {
                $cambioHorario = new CambioHorario();
                $cambioHorario->setIdCambioHorario($row['idCambioHorario']);
                $cambioHorario->setHorarioHabitual($this->getHorarioHabitual($row['horarioHabitual']));
                $cambioHorario->setObservacionesUsuario($row['observacionesUsuario']);
                $cambioHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

                array_push($cambiosHorario, $cambioHorario);
        }

        parent::closeDB($connection);
        return $cambiosHorario;
    }

    public function getCambiosHorarioActivosUsuario($numeroDocumento)
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM cambio_horario_usuario
                  WHERE usuario = $numeroDocumento AND aceptado IS NULL";

        $result = mysql_query($query);

        $cambiosHorario = array();
        while($row = mysql_fetch_array($result))
        {
                $cambioHorario = new CambioHorario();
                $cambioHorario->setIdCambioHorario($row['idCambioHorario']);
                $cambioHorario->setHorarioHabitual($this->getHorarioHabitual($row['idHorarioHabitual']));
                $cambioHorario->setObservacionesUsuario($row['observacionesUsuario']);
                $cambioHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

                array_push($cambiosHorario, $cambioHorario);
        }

        parent::closeDB($connection);
        return $cambiosHorario;
    }

    public function getCambioHorario($idCambioHorario)
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM cambio_horario_habitual
                  WHERE idCambioHorario = $idCambioHorario";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el cambio de horario');

        $row = mysql_fetch_array($result);

        $cambioHorario = new CambioHorario();
        $cambioHorario->setIdCambioHorario($row['idCambioHorario']);
        $cambioHorario->setHorarioHabitual($this->getHorarioHabitual($row['horarioHabitual']));
        $cambioHorario->setObservacionesUsuario($row['observacionesUsuario']);
        $cambioHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

        parent::closeDB($connection);
        return $cambioHorario;
    }

    public function aceptarCambioHorario($cambioHorario)
    {
        $connection = parent::initDB();
        $query = "UPDATE cambio_horario_habitual SET aceptado = 1, " .
                 "observacionesAdministrador = '" . $cambioHorario->getObservacionesAdministrador() . "' " .
                 "WHERE idCambioHorario = " . $cambioHorario->getIdCambioHorario();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo aceptar el cambio de horario');

        parent::closeDB($connection);
    }

    public function rechazarCambioHorario($cambioHorario)
    {
        $connection = parent::initDB();
        $query = "UPDATE cambio_horario_habitual SET aceptado = 0, " .
                 "observacionesAdministrador = '" . $cambioHorario->getObservacionesAdministrador() . "' " .
                 "WHERE idCambioHorario = " . $cambioHorario->getIdCambioHorario();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo rechazar el cambio de horario');

        parent::closeDB($connection);
    }

    /**************************** Nuevos horarios *****************************/

    public function getNuevosHorariosActivos()
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM nuevo_horario_habitual
                  WHERE aceptado IS NULL";

        $result = mysql_query($query);

        $nuevosHorarios = array();
        while($row = mysql_fetch_array($result))
        {
                $nuevoHorario = new NuevoHorario();
                $nuevoHorario->setIdNuevoHorario($row['idNuevoHorario']);
                $nuevoHorario->setHorarioHabitual($this->getHorarioHabitual($row['horarioHabitual']));
                $nuevoHorario->setObservacionesUsuario($row['observacionesUsuario']);
                $nuevoHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

                array_push($nuevosHorarios, $nuevoHorario);
        }

        parent::closeDB($connection);
        return $nuevosHorarios;
    }

    public function getNuevosHorariosActivosUsuario($numeroDocumento)
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM nuevo_horario_usuario
                  WHERE usuario = $numeroDocumento AND aceptado IS NULL";

        $result = mysql_query($query);

        $nuevosHorarios = array();
        while($row = mysql_fetch_array($result))
        {
                $nuevoHorario = new NuevoHorario();
                $nuevoHorario->setIdNuevoHorario($row['idNuevoHorario']);
                $nuevoHorario->setHorarioHabitual($this->getHorarioHabitual($row['idHorarioHabitual']));
                $nuevoHorario->setObservacionesUsuario($row['observacionesUsuario']);
                $nuevoHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

                array_push($nuevosHorarios, $nuevoHorario);
        }

        parent::closeDB($connection);
        return $nuevosHorarios;
    }

    public function getNuevoHorario($idNuevoHorario)
    {
        $connection = parent::initDB();
        $query = "SELECT *
                  FROM nuevo_horario_habitual 
                  WHERE idNuevoHorario = $idNuevoHorario";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el nuevo horario');

        $row = mysql_fetch_array($result);

        $nuevoHorario = new NuevoHorario();
        $nuevoHorario->setIdNuevoHorario($row['idNuevoHorario']);
        $nuevoHorario->setHorarioHabitual($this->getHorarioHabitual($row['horarioHabitual']));
        $nuevoHorario->setObservacionesUsuario($row['observacionesUsuario']);
        $nuevoHorario->setObservacionesAdministrador($row['observacionesAdministrador']);

        parent::closeDB($connection);
        return $nuevoHorario;
    }

    public function aceptarNuevoHorario($nuevoHorario)
    {
        $connection = parent::initDB();
        $query = "UPDATE nuevo_horario_habitual SET aceptado = 1, " .
                 "observacionesAdministrador = '" . $nuevoHorario->getObservacionesAdministrador() . "' " .
                 "WHERE idNuevoHorario = " . $nuevoHorario->getIdNuevoHorario();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo aceptar el nuevo horario');

        parent::closeDB($connection);
    }

    public function rechazarNuevoHorario($nuevoHorario)
    {
        $connection = parent::initDB();
        $query = "UPDATE nuevo_horario_habitual SET aceptado = 0, " .
                 "observacionesAdministrador = '" . $nuevoHorario->getObservacionesAdministrador() . "' " .
                 "WHERE idNuevoHorario = " . $nuevoHorario->getIdNuevoHorario();

        $result = mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo rechazar el nuevo horario');

        parent::closeDB($connection);
    }

    /******************************** REPORTES ********************************/

    /*********** Reportes de notificaciones de faltas sin reemplazo ***********/

    public function reporteNotificacionesFaltasSinReemplazoDelDia($fecha, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta = str_to_date('$fecha', '%d-%m-%Y')";
        else
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta = str_to_date('$fecha', '%d-%m-%Y') AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteNotificacionesFaltasSinReemplazoDiario($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta = curdate()";
        else
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta = curdate() AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteNotificacionesFaltasSinReemplazoSemanal($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              week(fechaFalta) = week(curdate())";
        else
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              week(fechaFalta) = week(curdate()) AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

   public function reporteNotificacionesFaltasSinReemplazoEntreLosDias($fechaInicio, $fechaFin, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y')";
        else
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, fechaFalta, horaFalta,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM notificacion_falta_usuarios, usuario
        WHERE notificacion_falta_usuarios.usuarioFalta = usuario.numeroDocumento AND
              (usuarioRecupera IS NULL OR usuarioRecupera = usuarioFalta) AND
              fechaFalta BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y') AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }


    /*********** Reportes de notificaciones de faltas con reemplazo ***********/

    public function reporteNotificacionesFaltasConReemplazoDelDia($fecha, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta = str_to_date('$fecha', '%d-%m-%Y')";
        else
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta = str_to_date('$fecha', '%d-%m-%Y') AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltasConReemplazo();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['nombreRecupera']))
                    $fila->setNombreRecupera($row['nombreRecupera']);

                if(!empty($row['apellidoRecupera']))
                    $fila->setApellidoRecupera($row['apellidoRecupera']);

                if(!empty($row['numeroDocumentoRecupera']))
                    $fila->setNumeroDocumentoRecupera($row['numeroDocumentoRecupera']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteNotificacionesFaltasConReemplazoDiario($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta = curdate()";
        else
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta = curdate() AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltasConReemplazo();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['nombreRecupera']))
                    $fila->setNombreRecupera($row['nombreRecupera']);

                if(!empty($row['apellidoRecupera']))
                    $fila->setApellidoRecupera($row['apellidoRecupera']);

                if(!empty($row['numeroDocumentoRecupera']))
                    $fila->setNumeroDocumentoRecupera($row['numeroDocumentoRecupera']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteNotificacionesFaltasConReemplazoSemanal($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  week(fechaFalta) = week(curdate())";
        else
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  week(fechaFalta) = week(curdate()) AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltasConReemplazo();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['nombreRecupera']))
                    $fila->setNombreRecupera($row['nombreRecupera']);

                if(!empty($row['apellidoRecupera']))
                    $fila->setApellidoRecupera($row['apellidoRecupera']);

                if(!empty($row['numeroDocumentoRecupera']))
                    $fila->setNumeroDocumentoRecupera($row['numeroDocumentoRecupera']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

   public function reporteNotificacionesFaltasConReemplazoEntreLosDias($fechaInicio, $fechaFin, $area)
   {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y')";
        else
        $query =
        "SELECT usuarioFalta.numeroDocumento AS numeroDocumento, usuarioFalta.nombre AS nombre,
                   usuarioFalta.apellido AS apellido, area, fechaFalta, horaFalta,
                   usuarioRecupera.numeroDocumento AS numeroDocumentoRecupera,
                   usuarioRecupera.nombre AS nombreRecupera,
                   usuarioRecupera.apellido AS apellidoRecupera,
                   fechaRecupera, horaRecupera, fechaRegistro
        FROM usuario AS usuarioFalta, notificacion_falta_usuarios, usuario AS usuarioRecupera
        WHERE usuarioRecupera != usuarioFalta AND
                  notificacion_falta_usuarios.usuarioFalta = usuarioFalta.numeroDocumento AND
                  notificacion_falta_usuarios.usuarioRecupera = usuarioRecupera.numeroDocumento AND
                  fechaFalta BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y') AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteNotificacionesFaltasConReemplazo();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['fechaFalta']))
                    $fila->setFechaFaltaISO($row['fechaFalta']);

                if(!empty($row['horaFalta']))
                    $fila->setHoraFalta($row['horaFalta']);

                if(!empty($row['nombreRecupera']))
                    $fila->setNombreRecupera($row['nombreRecupera']);

                if(!empty($row['apellidoRecupera']))
                    $fila->setApellidoRecupera($row['apellidoRecupera']);

                if(!empty($row['numeroDocumentoRecupera']))
                    $fila->setNumeroDocumentoRecupera($row['numeroDocumentoRecupera']);

                if(!empty($row['fechaRecupera']))
                    $fila->setFechaRecuperaISO($row['fechaRecupera']);

                if(!empty($row['horaRecupera']))
                    $fila->setHoraRecupera($row['horaRecupera']);

                if(!empty($row['fechaRegistro']))
                    $fila->setFechaRegistro($row['fechaRegistro']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }
}
?>
