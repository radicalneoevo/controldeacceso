<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("dao/HorarioDAO.php");
include_once("control/GestorPeriodos.php");

include_once("entidad/DiaSemana.php");
include_once("entidad/Horario.php");
include_once("entidad/HorarioHabitual.php");
include_once("entidad/Periodo.php");
include_once("entidad/CambioHorario.php");
include_once("entidad/NuevoHorario.php");

/**
 * Controla todas las operaciones pertinentes a los horarios asignados,
 * horarios habituales, cambios de horario y nuevos horarios.
 * Centraliza los reportes de notificaciones de faltas.
 * Todos los accesos a la capa de datos deben ser solicitados a este gestor.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 06-11-2009
 * @version 0.5
 * @see HorarioHabitual
 * @see HorarioAsignado
 */
class GestorHorarios
{
    private $horarioDAO;
    private $gestorPeriodos;

    function __construct()
    {
        $this->horarioDAO = new HorarioDAO();
        $this->gestorPeriodos = new GestorPeriodos();
    }

    /*************************** Horarios asignados ***************************/

    /**
     * Obtiene todos los horarios asignados de un usuario particular, entre las
     * dos fechas dadas, en todas las áreas a las que pertenezca.
     *
     * @param integer $numeroDocumento
     * @param string $fechaInicio Formato: DD-MM-AAAA
     * @param string $fechaFin Formato: DD-MM-AAAA
     * @return array Arreglo de objetos HorarioAsignado
     */
    public function getHorarios($numeroDocumento, $fechaInicio, $fechaFin)
    {
        return $this->horarioDAO->getHorarios($numeroDocumento, $fechaInicio, $fechaFin);
    }

    /**
     * Obtiene el objeto HorarioAsignado correspondiente para el ID dado.
     *
     * @param integer $idHorario
     * @return HorarioAsignado
     * @throws Exception Si el horario asignado no existe o no se encuentra.
     */
    public function getHorario($idHorario)
    {
        return $this->horarioDAO->getHorario($idHorario);
    }

    /**
     * Inserta un nuevo horario asignado.
     *
     * @param HorarioAsignado $horario
     * @throws Exception Si el horario no se pudo insertar.
     */
    public function insertarHorario($horario)
    {
        $this->horarioDAO->insertarHorario($horario);
    }

    /**
     * Modifica los datos correspondientes a un horario asignado.
     *
     * @param HorarioAsignado $horario
     * @throws Exception Si el horario asignado no existe o no se encuentra.
     */
    public function modificarHorario($horario)
    {
        $this->horarioDAO->modificarHorario($horario);
    }

    /**
     * Elimina el horario asignado dado.
     *
     * @param integer $idHorario
     * @throws Exception Si el horario asignado no existe o no se encuentra.
     */
    public function eliminarHorario($idHorario)
    {
        if($this->horarioDAO->existeHorario($idHorario))
            $this->horarioDAO->eliminarHorario($idHorario);
        else
            throw new Exception('No existe el horario');
    }

    /**
     * Inserta un horario extraordinario.
     * Un horario extraordinario es un horario no asignado a un horario habitual.
     *
     * @param HorarioAsignado $horario
     * @throws Exception Si el horario no se pudo insertar.
     */
    public function insertarHorarioExtraordinario($horario)
    {
        // Establece el período actual
        $periodoActual = $this->gestorPeriodos->getPeriodoActual($horario->getArea()->getIdArea());
        $horario->setPeriodo($periodoActual);

        $this->horarioDAO->insertarHorarioExtraordinario($horario);
    }

    /**
     * Obtiene todos los horarios asignados que se superponen con el dado.
     *
     * @param HorarioAsignado $horario
     * @return array Arreglo de HorarioAsignado
     */
    public function getHorariosSuperpuestos($horario)
    {
        return $this->horarioDAO->getHorariosSuperpuestos($horario);
    }

    /************************** Horarios habituales ***************************/

    /**
     * Obtiene todos los horarios habituales de un usuario particular, entre las
     * dos fechas dadas, en todas las áreas a las que pertenezca.
     *
     * @param integer $numeroDocumento
     * @param string $fechaInicio Formato: DD-MM-AAAA
     * @param string $fechaFin Formato: DD-MM-AAAA
     * @return array Arreglo de objetos HorarioHabitual
     */
    public function getHorariosHabituales($numeroDocumento)
    {
        return $this->horarioDAO->getHorariosHabituales($numeroDocumento);
    }

    /**
     * Obtiene el objeto HorarioHabitual correspondiente para el ID dado
     *
     * @param integer $idHorarioHabitual
     * @return HorarioHabitual
     * @throws Exception Si el horario habitual no existe o no se encuentra.
     */
    public function getHorarioHabitual($idHorarioHabitual)
    {
        return $this->horarioDAO->getHorarioHabitual($idHorarioHabitual);
    }

    /**
     * Inserta un nuevo horario habitual.
     *
     * @param HorarioHabitual $horarioHabitual
     * @throws Exception Si el horario no se pudo insertar.
     */
    public function insertarHorarioHabitual($horarioHabitual)
    {
        // Establece el período actual
        $periodoActual = $this->gestorPeriodos->getPeriodoActual($horarioHabitual->getArea()->getIdArea());
        $horarioHabitual->setPeriodo($periodoActual);

        // Inserta el nuevo período
        $idHorarioHabitual = $this->horarioDAO->insertarHorarioHabitual($horarioHabitual);

        $horarioHabitual = $this->horarioDAO->getHorarioHabitual($idHorarioHabitual);
        // Generacion de los horarios asignados
        $this->generarHorariosAsignados($horarioHabitual);
    }

    /**
     * Modifica los datos correspondientes a un horario habitual.
     *
     * @param HorarioHabitual $horarioHabitual
     * @throws Exception Si el horario asignado no existe o no se encuentra.
     */
    public function modificarHorarioHabitual($horarioHabitual)
    {
        $this->eliminarHorarioHabitual($horarioHabitual);
        $this->insertarHorarioHabitual($horarioHabitual);
    }    

    /**
     * Elimina el horario habitual dado. Elimina los HorarioAsignado futuros
     * correspondientes al HorarioHabitual.
     * 
     * @param HorarioHabitual $horarioHabitual
     * @throws Exception Si el horario habitual no existe o no se encuentra.
     */
    public function eliminarHorarioHabitual($horarioHabitual)
    {
        if($this->horarioDAO->existeHorarioHabitual($horarioHabitual->getIdHorariohabitual()))
        {
            // El horario habitual se marca como no activo
            $this->horarioDAO->eliminarHorarioHabitual($horarioHabitual->getIdHorariohabitual());
            // Se eliminan los futuros horarios asignados del horario habitual
            $fechaFinal = $horarioHabitual->getPeriodo()->imprimirFin();
            $this->horarioDAO->eliminarHorarios($horarioHabitual->getIdHorariohabitual(), $fechaFinal);
        }
        else
            throw new Exception('No existe el horario');
    }

    /**
     * Obtiene todos los horarios habituales que se superponen con el dado.
     *
     * @param HorarioHabitual $horario
     * @return array Arreglo de HorarioHabitual
     */
    public function getHorariosHabitualesSuperpuestos($horario)
    {
        return $this->horarioDAO->getHorariosHabitualesSuperpuestos($horario);
    }

    /************************ Operaciones con horarios ************************/

    /**
     * Genera objetos HorarioAsignado desde la fecha actual hasta que termina el
     * período al que corresponde el HorarioHabitual dado. Marca como no actvos
     * los horarios que caen en feriados o semanas especiales.
     *
     * @param HorarioHabitual $horarioHabitual
     */
    private function generarHorariosAsignados($horarioHabitual)
    {
        $periodoActual = $this->gestorPeriodos->getPeriodoActual($horarioHabitual->getArea()->getIdArea());
        $fechaFinal = $periodoActual->getFin();
        // Obtiene el primer horario que debe cumplir
        $fecha = new DateTime('next ' . $horarioHabitual->getDia()->getNombreIngles());
        while($fecha->getTimestamp() <= $fechaFinal->getTimestamp())
        {
            $horario = new Horario();
            $horario->setUsuario($horarioHabitual->getUsuario());
            $horario->setIdHorarioHabitual($horarioHabitual->getIdHorarioHabitual());
            $horario->setFecha($fecha->format('d-m-Y'));
            $horario->setIngreso($horarioHabitual->imprimirIngreso());
            $horario->setEgreso($horarioHabitual->imprimirEgreso());
            $horario->setArea($horarioHabitual->getArea());
            $horario->setPeriodo($horarioHabitual->getPeriodo());
            $this->insertarHorario($horario);
            $fecha->modify("+1 week");
        }

        $this->horarioDAO->eliminarHorariosEnFeriados();
        $this->horarioDAO->eliminarHorariosEnSemanasEspeciales();
    }

    /**
     * Reporte: Obtiene las horas que tiene asignadas el usuario en todas las
     * áreas a las que pertenece.
     * 
     * @param integer $numeroDocumento
     * @return array Arreglo de objetos FilaTablaHorasAsignadas
     */
    public function getHorasAsignadas($numeroDocumento)
    {
        return $this->horarioDAO->getHorasAsignadas($numeroDocumento);
    }

    /**
     * Asigna una cantidad de horas al área dada para un usuario particular.
     *
     * @param integer $numeroDocumento
     * @param integer $idArea
     * @param string $horas Formato: HH:MM
     */
    public function asignarHoras($numeroDocumento, $idArea, $horas)
    {
        $this->horarioDAO->asignarHoras($numeroDocumento, $idArea, $horas);
    }

    /**
     * Coloca como activos los horarios que hayan caído en el feriado dado, es
     * la operación opuesta a la realizada por eliminarHorariosEnFeriados().
     *
     * @param DiaFeriado $diaFeriado
     */
    private function habilitarHorariosDelFeriado($diaFeriado)
    {
        $this->horarioDAO->habilitarHorariosDelFeriado($diaFeriado);
    }

    /**
     * Coloca como activos los horarios que hayan caído en la semana especial
     * dada, es la operación opuesta a la realizada por
     * eliminarHorariosEnSemanasEspeciales().
     * 
     * @param SemanaEspecial $semanaEspecial
     */
    private function habilitarHorariosDeLaSemanaEspecial($semanaEspecial)
    {
        $this->horarioDAO->habilitarHorariosDeLaSemanaEspecial($semanaEspecial);
    }

    /*************************** Cambios de horario ***************************/

    /**
     * Recupera todos los cambios de horario que estan pendientes de confirmación.
     * 
     * @return array Arreglo de CambioHorario
     */
    public function getCambiosHorarioActivos()
    {
        return $this->horarioDAO->getCambiosHorarioActivos();
    }

    /**
     * Recupera un cambio de horario específico.
     *
     * @param integer $idCambioHorario
     * @return CambioHorario
     * @throws Exception Si el cambio de horario no existe o no se encuentra.
     */
    public function getCambioHorario($idCambioHorario)
    {
        return $this->horarioDAO->getCambioHorario($idCambioHorario);
    }

    /**
     * Recupera todos los cambios de horario del usuario dado que estan pendientes
     * de confirmación.
     * 
     * @param integer $numeroDocumento
     * @return array Arreglo de CambioHorario
     */
    public function getCambiosHorarioActivosUsuario($numeroDocumento)
    {
        return $this->horarioDAO->getCambiosHorarioActivosUsuario($numeroDocumento);
    }

    /**
     * Acepta el cambio de horario dado.
     * 
     * @param CambioHorario $cambioHorario
     * @throws Exception Si el cambio de horario no se pudo aceptar.
     */
    public function aceptarCambioHorario($cambioHorario)
    {
        $this->eliminarHorarioHabitual($cambioHorario->getHorarioHabitual());

        $this->horarioDAO->aceptarCambioHorario($cambioHorario);
    }

    /**
     * Rechaza el cambio de horario dado.
     * 
     * @param CambioHorario $cambioHorario
     * @throws Exception Si el cambio de horario no se pudo rechazar.
     */
    public function rechazarCambioHorario($cambioHorario)
    {
        $this->horarioDAO->rechazarCambioHorario($cambioHorario);
    }

    /***************************** Nuevos horarios ****************************/

    /**
     * Recupera todos los nuevos horarios que estan pendientes de confirmación.
     * 
     * @return array Arreglo de NuevoHorario
     */
    public function getNuevosHorariosActivos()
    {
        return $this->horarioDAO->getNuevosHorariosActivos();
    }

    /**
     * Recupera un nuevo horario específico.
     *
     * @param integer $idNuevoHorario
     * @return NuevoHorario
     * @throws Exception Si el nuevo horario no existe o no se encuentra.
     */
    public function getNuevoHorario($idNuevoHorario)
    {
        return $this->horarioDAO->getNuevoHorario($idNuevoHorario);
    }

    /**
     * Recupera todos los nuevos horarios del usuario dado que estan pendientes
     * de confirmación.
     * 
     * @param integer $numeroDocumento
     * @return array Arreglo de NuevoHorario
     */
    public function getNuevosHorariosActivosUsuario($numeroDocumento)
    {
        return $this->horarioDAO->getNuevosHorariosActivosUsuario($numeroDocumento);
    }

    /**
     * Acepta el nuevo horario dado.
     * 
     * @param NuevoHorario $nuevoHorario
     * @throws Exception Si el nuevo horario no se pudo aceptar.
     */
    public function aceptarNuevoHorario($nuevoHorario)
    {
        // Marca el horario habitual como confirmado
        $this->horarioDAO->confirmarHorarioHabitual($nuevoHorario->getHorarioHabitual()->getIdHorarioHabitual());

        $this->generarHorariosAsignados($nuevoHorario->getHorarioHabitual());

        // Establece el estado de la solicitud de nuevo horario
        $this->horarioDAO->aceptarNuevoHorario($nuevoHorario);
    }

    /**
     * Rechaza el nuevo horario dado.
     * 
     * @param NuevoHorario $nuevoHorario
     * @throws Exception Si el nuevo horario no se pudo rechazar.
     */
    public function rechazarNuevoHorario($nuevoHorario)
    {
        $this->eliminarHorarioHabitual($nuevoHorario->getHorarioHabitual());

        $this->horarioDAO->rechazarNuevoHorario($nuevoHorario);
    }

    /******************************** Reportes ********************************/

    /************************ Notificaciones de faltas ************************/

    /**
     * Reporte: Notificaciones de faltas sin reemplazo para una fecha y área dada.
     *
     * @param string $dia Formato: DD-MM-AAAA
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltas
     */
    public function reporteNotificacionesFaltasSinReemplazoDelDia($dia, $area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasSinReemplazoDelDia($dia, $area);
    }

    /**
     * Reporte: Notificaciones de faltas sin reemplazo para el día de la fecha.
     *
     * @param string $dia Formato: DD-MM-AAAA
     * @return array Arreglo de FilaReporteNotificacionesFaltas
     */
    public function reporteNotificacionesFaltasSinReemplazoDiario($area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasSinReemplazoDiario($area);
    }

    /**
     * Reporte: Notificaciones de faltas sin reemplazo para la semana actual.
     *
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltas
     */
    public function reporteNotificacionesFaltasSinReemplazoSemanal($area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasSinReemplazoSemanal($area);
    }

    /**
     * Reporte: Notificaciones de faltas sin reemplazo entre las fechas dadas.
     *
     * @param string $fechaInicio Formato: DD-MM-AAAA
     * @param string $fechaFin Formato: DD-MM-AAAA
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltas
     */
    public function reporteNotificacionesFaltasSinReemplazoEntreLosDias($fechaInicio, $fechaFin, $area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasSinReemplazoEntreLosDias($fechaInicio, $fechaFin, $area);
    }

    /**
     * Reporte: Notificaciones de faltas con reemplazo para una fecha y área dada.
     *
     * @param string $dia Formato: DD-MM-AAAA
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltasConReemplazo
     */
    public function reporteNotificacionesFaltasConReemplazoDelDia($dia, $area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasConReemplazoDelDia($dia, $area);
    }

    /**
     * Reporte: Notificaciones de faltas con reemplazo para el día de la fecha.
     *
     * @param string $dia Formato: DD-MM-AAAA
     * @return array Arreglo de FilaReporteNotificacionesFaltasConReemplazo
     */
    public function reporteNotificacionesFaltasConReemplazoDiario($area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasConReemplazoDiario($area);
    }

    /**
     * Reporte: Notificaciones de faltas con reemplazo para la semana actual.
     *
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltasConReemplazo
     */
    public function reporteNotificacionesFaltasConReemplazoSemanal($area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasConReemplazoSemanal($area);
    }

    /**
     * Reporte: Notificaciones de faltas con reemplazo entre las fechas dadas.
     *
     * @param string $fechaInicio Formato: DD-MM-AAAA
     * @param string $fechaFin Formato: DD-MM-AAAA
     * @param integer $area
     * @return array Arreglo de FilaReporteNotificacionesFaltasConReemplazo
     */
    public function reporteNotificacionesFaltasConReemplazoEntreLosDias($fechaInicio, $fechaFin, $area)
    {
        return $this->horarioDAO->reporteNotificacionesFaltasConReemplazoEntreLosDias($fechaInicio, $fechaFin, $area);
    }
}
?>
