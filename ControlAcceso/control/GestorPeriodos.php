<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("dao/PeriodoDAO.php");
include_once("control/GestorHorarios.php");

include_once("entidad/Periodo.php");
include_once("entidad/DiaFeriado.php");
include_once("entidad/SemanaEspecial.php");


/**
 * Controla todas las operaciones pertinentes a los periodos.
 * Todos los accesos a la capa de datos deben ser solicitados a este gestor.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 22-12-2009
 * @version 0.5
 * @see Periodo
 */
class GestorPeriodos
{
    private $periodoDAO;
    private $gestorHorarios;

    function __construct()
    {
        $this->periodoDAO = new PeriodoDAO();
        $this->gestorHorarios = new HorarioDAO();
    }

    /******************************** Periodos ********************************/

    /**
     * Obtiene todos los períodos cargados hasta el momento en el sistema.
     *
     * @return array Arreglo de Periodo
     */
    public function getPeriodos()
    {
        return $this->periodoDAO->getPeriodos();
    }

    /**
     * Obtiene el objeto Periodo correspondiente para el ID dado.
     *
     * @param integer $idPeriodo
     * @return Periodo
     * @throws Exception Si el periodo no existe o no se encuentra.
     */
    public function getPeriodo($idPeriodo)
    {
        return $this->periodoDAO->getPeriodo($idPeriodo);
    }

    /**
     * Obtiene el período actual para el área dada.
     *
     * @param integer $idArea
     * @return Periodo
     * @throws Exception Si no hay un período activo para el área dada.
     */
    public function getPeriodoActual($idArea)
    {
        return $this->periodoDAO->getPeriodoActual($idArea);
    }

    /**
     * Inserta un nuevo período en el sistema.
     *
     * @param Periodo $periodo
     * @throws Exception Si el periodo no se pudo insertar.
     */
    public function insertarPeriodo($periodo)
    {
        if($this->periodoDAO->hayPeriodosSuperpuestos($periodo))
            throw new Exception("El período se superpone con uno existente");

        $this->periodoDAO->insertarPeriodo($periodo);
    }

    /**
     * Modifica los datos correspondientes a un período dado.
     *
     * @param Periodo $periodo
     */
    public function editarPeriodo($periodo)
    {
        $this->periodoDAO->editarPeriodo($periodo);
    }

    /**
     * Verifica si existen períodos que se superponen con el dado.
     *
     * @param Periodo $periodo
     * @return boolean true: hay periodos superpuestos false: cualquier otro caso
     */
    public function hayPeriodosSuperpuestos($periodo)
    {
        return $this->periodoDAO->hayPeriodosSuperpuestos($periodo);
    }

    /***************************** Dias feriados ******************************/

    /**
     * Obtiene todos los días feriados asignados hasta el momento al período dado.
     *
     * @param integer $idPeriodo
     * @return array Arreglo de DiaFeriado
     */
    public function getDiasFeriados($idPeriodo)
    {
        return $this->periodoDAO->getDiasFeriados($idPeriodo);
    }

    /**
     * Obtiene el objeto DiaFeriado correspondiente para el ID dado.
     *
     * @param integer $idDiaFeriado
     * @return DiaFeriado
     * @throws Exception Si el dia feriado no existe o no se encuentra.
     */
    public function getDiaFeriado($idDiaFeriado)
    {
        return $this->periodoDAO->getDiaFeriado($idDiaFeriado);
    }

    /**
     * Inserta un nuevo dia feriado en el sistema.
     *
     * @param DiaFeriado $diaFeriado
     * @throws Exception Si el dia feriado no se pudo insertar.
     */
    public function insertarDiaFeriado($diaFeriado)
    {
        if($this->periodoDAO->existeDiaFeriado($diaFeriado))
            throw new Exception("Ya existe un feriado definido para esa fecha");

        if(!$diaFeriado->getPeriodo()->incluyeElFeriado($diaFeriado))
            throw new Exception("El dia feriado especificado no está incluido dentro del período");

        $this->periodoDAO->insertarDiaFeriado($diaFeriado);
        $this->gestorHorarios->eliminarHorariosEnFeriados();
    }

    /**
     * Modifica los datos correspondientes a un dia feriado dado.
     *
     * @param DiaFeriado $diaFeriado
     */
    public function editarDiaFeriado($diaFeriado)
    {
        $this->periodoDAO->editarDiaFeriado($diaFeriado);
    }

    /**
     * Elimina el dia feriado dado, reactivando los horarios asignados que pudieron
     * haberse desactivado previamente por caer en esa fecha.
     *
     * @param DiaFeriado $diaFeriado
     * @throws Exception Si el dia feriado no se pudo eliminar.
     */
    public function eliminarDiaFeriado($diaFeriado)
    {
        $this->gestorHorarios->habilitarHorariosDelFeriado($diaFeriado);
        // Por si el feriado estaba en una semana especial
        $this->gestorHorarios->eliminarHorariosEnSemanasEspeciales();
        $this->periodoDAO->eliminarDiaFeriado($diaFeriado);
    }

    /**
     * Verifica si ya existe un día feriado definido en la misma fecha que el dado.
     * 
     * @param DiaFeriado $diaFeriado
     * @return boolean true: si ya existe un feriado en esa fecha false: cualquier otro caso
     */
    public function existeDiaFeriado($diaFeriado)
    {
        return $this->periodoDAO->existeDiaFeriado($diaFeriado);
    }

    /*************************** Semanas especiales ***************************/

    /**
     * Obtiene todas las semanas especiales asignadas hasta el momento al período dado.
     *
     * @param Periodo $idPeriodo
     * @return array Arreglo de SemanaEspecial
     */
    public function getSemanasEspeciales($idPeriodo)
    {
        return $this->periodoDAO->getSemanasEspeciales($idPeriodo);
    }

    /**
     * Obtiene el objeto SemanaEspecial correspondiente para el ID dado.
     *
     * @param integer $idSemanaEspecial
     * @return SemanaEspecial
     * @throws Exception Si la semana especial no existe o no se encuentra.
     */
    public function getSemanaEspecial($idSemanaEspecial)
    {
        return $this->periodoDAO->getSemanaEspecial($idSemanaEspecial);
    }

    /**
     * Inserta una nueva semana especial en el sistema.
     *
     * @param SemanaEspecial $semanaEspecial
     * @throws Exception Si la semana especial no se pudo insertar.
     */
    public function insertarSemanaEspecial($semanaEspecial)
    {
        if($this->periodoDAO->existeSuperposicion($semanaEspecial))
            throw new Exception("Existe superposición con una semana existente");

        if(!$semanaEspecial->getPeriodo()->incluyeLaSemana($semanaEspecial))
            throw new Exception("La semana especificada no esta incluida dentro del período");

        $this->periodoDAO->insertarSemanaEspecial($semanaEspecial);
        $this->gestorHorarios->eliminarHorariosEnSemanasEspeciales();
    }

    /**
     * Modifica los datos correspondientes a la semana especial dada.
     *
     * @param SemanaEspecial $semanaEspecial
     */
    public function editarSemanaEspecial($semanaEspecial)
    {
        $this->periodoDAO->editarSemanaEspecial($semanaEspecial);
    }

    /**
     * Elimina la semana especial dada, reactivando los horarios asignados que
     * pudieron haberse desactivado previamente por caer entre esas fechas.
     *
     * @param SemanaEspecial $semanaEspecial
     * @throws Exception Si la semana especial no se pudo eliminar.
     */
    public function eliminarSemanaEspecial($semanaEspecial)
    {
        $this->gestorHorarios->habilitarHorariosDeLaSemanaEspecial($semanaEspecial);
        // Por si la semana tenia un feriado definido
        $this->gestorHorarios->eliminarHorariosEnFeriados();
        $this->periodoDAO->eliminarSemanaEspecial($semanaEspecial);
    }
}
?>
