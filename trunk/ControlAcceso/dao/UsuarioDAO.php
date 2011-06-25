<?php
include_once("dao/DAO.php");
include_once("dao/AreaDAO.php");
include_once("dao/NivelDAO.php");
include_once("entidad/Usuario.php");
include_once("entidad/Nivel.php");
include_once("gui/contenidos/tablas/reportes/FilaReportePresentes.php");
include_once("gui/contenidos/tablas/reportes/FilaReporteAusentes.php");
include_once("gui/contenidos/tablas/reportes/FilaReporteHorasAcumuladas.php");

class UsuarioDAO extends DAO
{
    private $areaDAO;

    function __construct()
    {
        parent::__construct();
        $this->areaDAO = new AreaDAO();
    }

    public function getUsuarios()
    {
        $connection = parent::initDB();
        $query = "SELECT apellido, nombre, numeroDocumento FROM usuario ORDER BY apellido";

        $result = mysql_query($query);
        if(mysql_num_rows($result) == 0)
            throw new Exception('No hay usuarios cargados en el sistema');

        $usuarios = array();
        while($row = mysql_fetch_array($result))
        {
                $usuario = new Usuario();
                $usuario->setApellido($row['apellido']);
                $usuario->setNombre($row['nombre']);
                $usuario->setNumeroDocumento($row['numeroDocumento']);
                $usuario->setArea($this->areaDAO->getAreasDelUsuario($row['numeroDocumento']));

                array_push($usuarios, $usuario);
        }

        parent::closeDB($connection);
        return $usuarios;
    }

    public function getUsuario($numeroDocumentoIngresado)
    {
        $connection = parent::initDB();
        $query = "SELECT tipoDocumento, numeroDocumento, nombre, segundoNombre, " .
                 "       apellido, date_format(fechaNacimiento, '%d-%m-%Y') AS fecha, " .
                 "       direccion, telefonoFijo, telefonoCelular, email, legajo, nivel, " .
                 "       notas, activo " .
                 "FROM usuario " .
                 "WHERE numeroDocumento = '$numeroDocumentoIngresado'";

        $result = mysql_query($query);
        if(mysql_num_rows($result) != 1)
            throw new Exception('No se pudo obtener el usuario');

        $row = mysql_fetch_array($result);

        $usuario = new Usuario();
        $usuario->setTipoDocumento($row['tipoDocumento']);
        $usuario->setNumeroDocumento($row['numeroDocumento']);
        $usuario->setNombre($row['nombre']);
        if(!empty($row['segundoNombre']))
            $usuario->setSegundoNombre($row['segundoNombre']);
        $usuario->setApellido($row['apellido']);
        $usuario->setFechaNacimiento($row['fecha']);
        $usuario->setDireccion($row['direccion']);
        if(!empty($row['telefonoFijo']))
            $usuario->setTelefonoFijo($row['telefonoFijo']);
        if(!empty($row['telefonoCelular']))
            $usuario->setTelefonoCelular($row['telefonoCelular']);
        $usuario->setEmail($row['email']);
        $usuario->setLegajo($row['legajo']);
        if(!empty($row['notas']))
            $usuario->setNotas($row['notas']);
        $usuario->setActivo($row['activo']);

        // Claves foraneas
        $nivelDAO = new NivelDAO();
        $nivel = $nivelDAO->getNivel($row['nivel']);
        $usuario->setNivel($nivel);
        
        $usuario->setArea($this->areaDAO->getAreasDelUsuario($row['numeroDocumento']));

        parent::closeDB($connection);
        return $usuario;
    }

    public function existeDNI($numeroDocumento)
    {
        $connection = parent::initDB();
        $query =
        "SELECT * FROM usuario WHERE numeroDocumento = '$numeroDocumento'";

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

    public function insertarUsuario($nuevoUsuario)
    {
        $connection = parent::initDB();
        $query = "INSERT INTO usuario (tipoDocumento, numeroDocumento, nombre, " .
                 "segundoNombre, apellido, fechaNacimiento, direccion, " .
                 "telefonoFijo, telefonoCelular, email, legajo, password, nivel, notas, activo) " .
                 "VALUES ('" . $nuevoUsuario->getTipoDocumento() . "', '" .
                               $nuevoUsuario->getNumeroDocumento() . "', '" . 
                               $nuevoUsuario->getNombre() . "', '" .
                               $nuevoUsuario->getSegundoNombre() . "', '" .
                               $nuevoUsuario->getApellido() . "', " .
                               " str_to_date('" . $nuevoUsuario->getFechaNacimiento() . "', '%d-%m-%Y'), '" .
                               $nuevoUsuario->getDireccion() . "', '" .
                               $nuevoUsuario->getTelefonoFijo() . "', '" . 
                               $nuevoUsuario->getTelefonoCelular(). "', '" .
                               $nuevoUsuario->getEmail() . "', " .
                               $nuevoUsuario->getLegajo() . ", " .
                               " sha1('12345678'), '" .
                               $nuevoUsuario->getNivel()->getIdNivel() . "', '" .
                               $nuevoUsuario->getNotas() . "', '" .
                               $nuevoUsuario->getActivo() . "')";

        mysql_query($query);
        if(mysql_affected_rows() == 0)
            throw new Exception('No se pudo agregar el usuario');

        $this->areaDAO->insertarUsuarioArea($nuevoUsuario->getNumeroDocumento(),
                $nuevoUsuario->getArea());

        parent::closeDB($connection);
    }

    public function modificarUsuario($usuarioModificado)
    {
        $connection = parent::initDB();
        $query = "UPDATE usuario SET " . 
                 "tipoDocumento = '" . $usuarioModificado->getTipoDocumento() . "', " .
                 "nombre = '" . $usuarioModificado->getNombre() . "', " .
                 "segundoNombre = '" . $usuarioModificado->getSegundoNombre(). "', " .
                 "apellido = '" . $usuarioModificado->getApellido()."', " .
                 "fechaNacimiento = str_to_date('" . $usuarioModificado->getFechaNacimiento() . "', '%d-%m-%Y'), " .
                 "direccion = '" . $usuarioModificado->getDireccion() . "', " .
                 "telefonoFijo = '" . $usuarioModificado->getTelefonoFijo() . "', " .
                 "telefonoCelular = '" . $usuarioModificado->getTelefonoCelular(). "', " .
                 "email = '" . $usuarioModificado->getEmail() . "', " .
                 "legajo = " . $usuarioModificado->getLegajo() . ", " .
                 "nivel = '" . $usuarioModificado->getNivel()->getIdNivel() . "', " .
                 "notas = '" . $usuarioModificado->getNotas() . "', " .
                 "activo = '" . $usuarioModificado->getActivo() . "' " .
                 "WHERE numeroDocumento = '" . $usuarioModificado->getNumeroDocumento() . "' ";

        mysql_query($query);

        $this->areaDAO->eliminarAreas($usuarioModificado->getNumeroDocumento());
        $this->areaDAO->insertarUsuarioArea($usuarioModificado->getNumeroDocumento(),
                $usuarioModificado->getArea());
        
        parent::closeDB($connection);
    }

    public function getUsuariosPresentes()
    {
        $connection = parent::initDB();
        $query =
        "SELECT numeroDocumento, nombre, apellido, area, ingreso, egresoOficial, tiempoAcumulado
        FROM (SELECT turno_usuario_area.usuario, turno_usuario_area.area,
                                 turno_usuario_area.ingreso AS ingreso,
                     horario_asignado.egreso AS egresoOficial,
                     timediff(CURRENT_TIME (), turno_usuario_area.ingreso) AS tiempoAcumulado
                 FROM turno_usuario_area LEFT OUTER JOIN horario_asignado ON
                          turno_usuario_area.horario = horario_asignado.idHorario
                 WHERE turno_usuario_area.egreso IS NULL) AS horarios, usuario
        WHERE horarios.usuario = usuario.numeroDocumento";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $filaReportePresentes = new FilaReportePresentes();
                $filaReportePresentes->setNumeroDocumento($row['numeroDocumento']);
                $filaReportePresentes->setNombre($row['nombre']);
                $filaReportePresentes->setApellido($row['apellido']);
                $filaReportePresentes->setArea($this->areaDAO->getArea($row['area']));
                $filaReportePresentes->setIngreso($row['ingreso']);
                if(!empty($row['egresoOficial']))
                    $filaReportePresentes->setEgresoOficial($row['egresoOficial']);
                $filaReportePresentes->setTiempoAcumulado($row['tiempoAcumulado']);

                array_push($filas, $filaReportePresentes);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function getUltimosIngresos()
    {
        $connection = parent::initDB();
        $query =
        "SELECT apellido, nombre, numeroDocumento
        FROM turno_usuario_area, usuario
        WHERE turno_usuario_area.usuario = usuario.numeroDocumento AND
              fecha = curdate() AND egreso IS NULL
        ORDER BY ingreso DESC
        LIMIT 10";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $usuario = new Usuario();
                $usuario->setNumeroDocumento($row['numeroDocumento']);
                $usuario->setNombre($row['nombre']);
                $usuario->setApellido($row['apellido']);

                array_push($filas, $usuario);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function getUltimosEgresos()
    {
        $connection = parent::initDB();
        $query =
        "SELECT apellido, nombre, numeroDocumento
        FROM turno_usuario_area, usuario
        WHERE turno_usuario_area.usuario = usuario.numeroDocumento AND
              fecha = curdate() AND egreso IS NOT NULL
        ORDER BY egreso DESC
        LIMIT 10";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $usuario = new Usuario();
                $usuario->setNumeroDocumento($row['numeroDocumento']);
                $usuario->setNombre($row['nombre']);
                $usuario->setApellido($row['apellido']);

                array_push($filas, $usuario);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function getUsuariosAusentes()
    {
        $connection = parent::initDB();
        $query =
        "SELECT  apellido, nombre, numeroDocumento, telefonoCelular,
               email, ingresoOficial, egresoOficial, idNotificacion AS notificacion
        FROM (SELECT date_format(ingresoOficial, '%H:%i') AS ingresoOficial,
                                 date_format(egresoOficial, '%H:%i') AS egresoOficial,
                     horariosDelDia.horario, usuario
              FROM (SELECT idHorario AS horario, ingreso AS ingresoOficial, egreso AS egresoOficial,
                           usuario
                    FROM horario_asignado
                    WHERE fecha = curdate() AND activo = 1) AS horariosDelDia
                    LEFT OUTER JOIN
                   (SELECT idTurno AS turno, horario,
                           ingreso AS ingresoRegistrado, fecha
                    FROM turno_usuario_area
                    WHERE fecha = curdate()) AS turnosDelDia
                    ON horariosDelDia.horario = turnosDelDia.horario
              WHERE turno IS NULL AND
                    timediff(curtime(), ingresoOficial) >= maketime(00, 30, 00)) AS personalFaltante
              LEFT OUTER JOIN
              notificacion_falta_usuarios ON
              (personalFaltante.horario = notificacion_falta_usuarios.horarioFalta), usuario
        WHERE personalFaltante.usuario = usuario.numeroDocumento";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $filaReporteAusentes = new FilaReporteAusentes();
                $filaReporteAusentes->setNombre($row['nombre']);
                $filaReporteAusentes->setApellido($row['apellido']);
                $filaReporteAusentes->setNumeroDocumento($row['numeroDocumento']);
                $filaReporteAusentes->setTelefonoCelular($row['telefonoCelular']);
                $filaReporteAusentes->setEmail($row['email']);
                $filaReporteAusentes->setIngresoOficial($row['ingresoOficial']);
                $filaReporteAusentes->setEgresoOficial($row['egresoOficial']);
                $filaReporteAusentes->setNotificoFalta($row['notificacion']);

                array_push($filas, $filaReporteAusentes);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteHorasAcumuladasDiario($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT apellido, nombre, numeroDocumento, area, fecha, horasHabitualesAsignadas, " .
        "horasHabitualesCumplidas, horasCompensadasPorOtroUsuario, " .
        "horasCompensadasPorUsuario, horasCompensadasAOtroUsuario, horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha = curdate() AND temp5.usuario = usuario.numeroDocumento ";
        else
        $query =
        "SELECT apellido, nombre, numeroDocumento, area, fecha, horasHabitualesAsignadas, " .
        "horasHabitualesCumplidas, horasCompensadasPorOtroUsuario, " .
        "horasCompensadasPorUsuario, horasCompensadasAOtroUsuario, horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha = curdate() AND temp5.usuario = usuario.numeroDocumento " .
        " AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteHorasAcumuladas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['horasHabitualesAsignadas']))
                    $fila->setHorasHabitualesAsignadas($row['horasHabitualesAsignadas']);

                if(!empty($row['horasHabitualesCumplidas']))
                    $fila->setHorasHabitualesCumplidas($row['horasHabitualesCumplidas']);

                if(!empty($row['horasCompensadasPorOtroUsuario']))
                    $fila->setHorasCompensadasPorOtroUsuario($row['horasCompensadasPorOtroUsuario']);

                if(!empty($row['horasCompensadasPorUsuario']))
                    $fila->setHorasCompensadasPorUsuario($row['horasCompensadasPorUsuario']);

                if(!empty($row['horasCompensadasAOtroUsuario']))
                    $fila->setHorasCompensadasAOtroUsuario($row['horasCompensadasAOtroUsuario']);

                if(!empty($row['horasExtras']))
                    $fila->setHorasExtras($row['horasExtras']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteHorasAcumuladasSemanal($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuario, area, semana, apellido, nombre, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE semana = week(curdate()) AND temp5.usuario = usuario.numeroDocumento " .
        "GROUP BY usuario, area, semana ";
        else
        $query =
        "SELECT usuario, area, semana, apellido, nombre, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE semana = week(curdate()) AND temp5.usuario = usuario.numeroDocumento " .
        " AND area = $area " .
        "GROUP BY usuario, area, semana ";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteHorasAcumuladas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['usuario']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['horasHabitualesAsignadas']))
                    $fila->setHorasHabitualesAsignadas($row['horasHabitualesAsignadas']);

                if(!empty($row['horasHabitualesCumplidas']))
                    $fila->setHorasHabitualesCumplidas($row['horasHabitualesCumplidas']);

                if(!empty($row['horasCompensadasPorOtroUsuario']))
                    $fila->setHorasCompensadasPorOtroUsuario($row['horasCompensadasPorOtroUsuario']);

                if(!empty($row['horasCompensadasPorUsuario']))
                    $fila->setHorasCompensadasPorUsuario($row['horasCompensadasPorUsuario']);

                if(!empty($row['horasCompensadasAOtroUsuario']))
                    $fila->setHorasCompensadasAOtroUsuario($row['horasCompensadasAOtroUsuario']);

                if(!empty($row['horasExtras']))
                    $fila->setHorasExtras($row['horasExtras']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteHorasAcumuladasDelDia($dia, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT apellido, nombre, numeroDocumento, area, fecha, horasHabitualesAsignadas, " .
        "horasHabitualesCumplidas, horasCompensadasPorOtroUsuario, " .
        "horasCompensadasPorUsuario, horasCompensadasAOtroUsuario, horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha = str_to_date('$dia', '%d-%m-%Y') AND temp5.usuario = usuario.numeroDocumento ";
        else
        $query =
        "SELECT apellido, nombre, numeroDocumento, area, fecha, horasHabitualesAsignadas, " .
        "horasHabitualesCumplidas, horasCompensadasPorOtroUsuario, " .
        "horasCompensadasPorUsuario, horasCompensadasAOtroUsuario, horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha = str_to_date('$dia', '%d-%m-%Y') AND temp5.usuario = usuario.numeroDocumento " .
        " AND area = $area";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteHorasAcumuladas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['horasHabitualesAsignadas']))
                    $fila->setHorasHabitualesAsignadas($row['horasHabitualesAsignadas']);

                if(!empty($row['horasHabitualesCumplidas']))
                    $fila->setHorasHabitualesCumplidas($row['horasHabitualesCumplidas']);

                if(!empty($row['horasCompensadasPorOtroUsuario']))
                    $fila->setHorasCompensadasPorOtroUsuario($row['horasCompensadasPorOtroUsuario']);

                if(!empty($row['horasCompensadasPorUsuario']))
                    $fila->setHorasCompensadasPorUsuario($row['horasCompensadasPorUsuario']);

                if(!empty($row['horasCompensadasAOtroUsuario']))
                    $fila->setHorasCompensadasAOtroUsuario($row['horasCompensadasAOtroUsuario']);

                if(!empty($row['horasExtras']))
                    $fila->setHorasExtras($row['horasExtras']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteHorasAcumuladasDeLaSemana($dia, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT usuario, area, semana, apellido, nombre, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE semana = week(str_to_date('$dia', '%d-%m-%Y')) AND temp5.usuario = usuario.numeroDocumento " .
        "GROUP BY usuario, area, semana ";
        else
        $query =
        "SELECT usuario, area, semana, apellido, nombre, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE semana = week(str_to_date('$dia', '%d-%m-%Y')) AND temp5.usuario = usuario.numeroDocumento " .
        " AND area = $area " .
        "GROUP BY usuario, area, semana ";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteHorasAcumuladas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['usuario']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['horasHabitualesAsignadas']))
                    $fila->setHorasHabitualesAsignadas($row['horasHabitualesAsignadas']);

                if(!empty($row['horasHabitualesCumplidas']))
                    $fila->setHorasHabitualesCumplidas($row['horasHabitualesCumplidas']);

                if(!empty($row['horasCompensadasPorOtroUsuario']))
                    $fila->setHorasCompensadasPorOtroUsuario($row['horasCompensadasPorOtroUsuario']);

                if(!empty($row['horasCompensadasPorUsuario']))
                    $fila->setHorasCompensadasPorUsuario($row['horasCompensadasPorUsuario']);

                if(!empty($row['horasCompensadasAOtroUsuario']))
                    $fila->setHorasCompensadasAOtroUsuario($row['horasCompensadasAOtroUsuario']);

                if(!empty($row['horasExtras']))
                    $fila->setHorasExtras($row['horasExtras']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteHorasAcumuladasEntreLosDias($fechaInicio, $fechaFin,$area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT apellido, nombre, usuario, area, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y') " .
        "AND temp5.usuario = usuario.numeroDocumento " .
        "GROUP BY usuario, area ";
        else
        $query =
        "SELECT apellido, nombre, usuario, area, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesAsignadas))) AS horasHabitualesAsignadas, " .
        "sec_to_time(sum(time_to_sec(horasHabitualesCumplidas))) AS horasHabitualesCumplidas, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorOtroUsuario))) AS horasCompensadasPorOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasPorUsuario))) AS horasCompensadasPorUsuario, " .
        "sec_to_time(sum(time_to_sec(horasCompensadasAOtroUsuario))) AS horasCompensadasAOtroUsuario, " .
        "sec_to_time(sum(time_to_sec(horasExtras))) AS horasExtras " .
        "FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM (SELECT * FROM " .
        "(SELECT usuario, area, fecha, semana " .
        "FROM turno_usuario_area " .
        "UNION " .
        "SELECT usuario, area, fecha, semana " .
        "FROM horario_asignado_duracion) AS fechas " .
        "NATURAL LEFT JOIN horas_habituales_asignadas) AS " .
        "temp1 NATURAL LEFT JOIN horas_habituales_cumplidas) AS " .
        "temp2 NATURAL LEFT JOIN horas_compensadas_por_otro_usuario) AS " .
        "temp3 NATURAL LEFT JOIN horas_compensadas_por_usuario) AS " .
        "temp4 NATURAL LEFT JOIN horas_compensadas_a_otro_usuario) AS " .
        "temp5 NATURAL LEFT JOIN horas_extras, usuario " .
        "WHERE fecha BETWEEN str_to_date('$fechaInicio', '%d-%m-%Y') AND str_to_date('$fechaFin', '%d-%m-%Y') " .
        "AND temp5.usuario = usuario.numeroDocumento AND area = $area " .
        "GROUP BY usuario, area ";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteHorasAcumuladas();
                $fila->setApellido($row['apellido']);
                $fila->setNombre($row['nombre']);
                $fila->setNumeroDocumento($row['usuario']);
                $fila->setArea($this->areaDAO->getArea($row['area']));

                if(!empty($row['horasHabitualesAsignadas']))
                    $fila->setHorasHabitualesAsignadas($row['horasHabitualesAsignadas']);

                if(!empty($row['horasHabitualesCumplidas']))
                    $fila->setHorasHabitualesCumplidas($row['horasHabitualesCumplidas']);

                if(!empty($row['horasCompensadasPorOtroUsuario']))
                    $fila->setHorasCompensadasPorOtroUsuario($row['horasCompensadasPorOtroUsuario']);

                if(!empty($row['horasCompensadasPorUsuario']))
                    $fila->setHorasCompensadasPorUsuario($row['horasCompensadasPorUsuario']);

                if(!empty($row['horasCompensadasAOtroUsuario']))
                    $fila->setHorasCompensadasAOtroUsuario($row['horasCompensadasAOtroUsuario']);

                if(!empty($row['horasExtras']))
                    $fila->setHorasExtras($row['horasExtras']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteFaltasDiario($area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT nombre, apellido, numeroDocumento, area, ingreso, egreso " .
        "FROM (SELECT idHorario AS horario, usuario, area, ingreso, egreso " .
        "      FROM horario_asignado " .
        "      WHERE dia = dayofweek(curdate())) AS horariosDelDia " .
        "      LEFT OUTER JOIN " .
        "      (SELECT idTurno AS turno, horario, fecha " .
        "      FROM turno_usuario_area " .
        "      WHERE fecha = curdate()) AS turnosDelDia " .
        "      ON horariosDelDia.horario = turnosDelDia.horario, usuario " .
        "WHERE turno IS NULL AND " .
        "      timediff(curtime(), ingreso) >= maketime(00, 30, 00) AND " .
        "      usuario.numeroDocumento =  horariosDelDia.usuario ";
        else
        $query =
        "SELECT nombre, apellido, numeroDocumento, area, ingreso, egreso " .
        "FROM (SELECT idHorario AS horario, usuario, area, ingreso, egreso " .
        "      FROM horario_asignado " .
        "      WHERE dia = dayofweek(curdate())) AS horariosDelDia " .
        "      LEFT OUTER JOIN " .
        "      (SELECT idTurno AS turno, horario, fecha " .
        "      FROM turno_usuario_area " .
        "      WHERE fecha = curdate()) AS turnosDelDia " .
        "      ON horariosDelDia.horario = turnosDelDia.horario, usuario " .
        "WHERE turno IS NULL AND " .
        "      timediff(curtime(), ingreso) >= maketime(00, 30, 00) AND " .
        "      usuario.numeroDocumento =  horariosDelDia.usuario AND " .
        "      area = $area ";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteFaltas();
                $fila->setNombre($row['nombre']);
                $fila->setApellido($row['apellido']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));
                $fila->setIngreso($row['ingreso']);
                $fila->setEgreso($row['egreso']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }

    public function reporteFaltasDelDia($dia, $area)
    {
        $connection = parent::initDB();
        if($area == 0)
        $query =
        "SELECT nombre, apellido, numeroDocumento, area, ingreso, egreso " .
        "FROM (SELECT idHorario AS horario, usuario, area, ingreso, egreso " .
        "      FROM horario_asignado " .
        "      WHERE dia = dayofweek(str_to_date('$dia', '%d-%m-%Y'))) AS horariosDelDia " .
        "      LEFT OUTER JOIN " .
        "      (SELECT idTurno AS turno, horario, fecha " .
        "      FROM turno_usuario_area " .
        "      WHERE fecha = str_to_date('$dia', '%d-%m-%Y')) AS turnosDelDia " .
        "      ON horariosDelDia.horario = turnosDelDia.horario, usuario " .
        "WHERE turno IS NULL AND " .
        "      usuario.numeroDocumento =  horariosDelDia.usuario ";
        else
        $query =
        "SELECT nombre, apellido, numeroDocumento, area, ingreso, egreso " .
        "FROM (SELECT idHorario AS horario, usuario, area, ingreso, egreso " .
        "      FROM horario_asignado " .
        "      WHERE dia = dayofweek(str_to_date('$dia', '%d-%m-%Y'))) AS horariosDelDia " .
        "      LEFT OUTER JOIN " .
        "      (SELECT idTurno AS turno, horario, fecha " .
        "      FROM turno_usuario_area " .
        "      WHERE fecha = str_to_date('$dia', '%d-%m-%Y')) AS turnosDelDia " .
        "      ON horariosDelDia.horario = turnosDelDia.horario, usuario " .
        "WHERE turno IS NULL AND " .
        "      usuario.numeroDocumento =  horariosDelDia.usuario AND " .
        "      area = $area ";

        $result = mysql_query($query);

        $filas = array();
        while($row = mysql_fetch_array($result))
        {
                $fila = new FilaReporteFaltas();
                $fila->setNombre($row['nombre']);
                $fila->setApellido($row['apellido']);
                $fila->setNumeroDocumento($row['numeroDocumento']);
                $fila->setArea($this->areaDAO->getArea($row['area']));
                $fila->setIngreso($row['ingreso']);
                $fila->setEgreso($row['egreso']);

                array_push($filas, $fila);
        }

        parent::closeDB($connection);
        return $filas;
    }
}
?>
