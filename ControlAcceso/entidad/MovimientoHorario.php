<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/HorarioHabitual.php");

/**
 * Representa un movimiento de un horario habitual del usuario.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 05-04-2010
 * @version 0.5
 */
class MovimientoHorario
{
    /**
     * Horario habitual al que corresponde. En el se encuentran el usuario, área
     * y horas de entrada/salida.
     * @var HorarioHabitual
     */
    protected $horarioHabitual;

    /**
     * Motivo por el cual el usuario desea realizar el movimiento de horario, opcional.
     * @var string
     */
    protected $observacionesUsuario;

    /**
     * Observación del administrador al aceptar/rechazar el movimiento de horario, opcional.
     * @var string
     */
    protected $observacionesAdministrador;

    /**
     * Estado en el que se encuentra el movimiento de horario:
     * null: no revisado por un administrador
     * false: rechazado
     * true: aceptado
     * @var boolean
     */
    protected $aceptado;

    /**
     * Determina si el movimiento de horario está activo o no.
     * @var boolean
     */
    protected $activo;

    function __construct()
    {

    }

    /**
     *
     * @return HorarioHabitual
     */
    public function getHorarioHabitual()
    {
        return $this->horarioHabitual;
    }

    /**
     *
     * @param HorarioHabitual $horarioHabitual
     */
    public function setHorarioHabitual($horarioHabitual)
    {
        $this->horarioHabitual = $horarioHabitual;
    }

    /**
     *
     * @return string
     */
    public function getObservacionesUsuario()
    {
        return $this->observacionesUsuario;
    }

    /**
     *
     * @param string $observacionesUsuario
     */
    public function setObservacionesUsuario($observacionesUsuario)
    {
        $this->observacionesUsuario = $observacionesUsuario;
    }

    /**
     *
     * @return string
     */
    public function getObservacionesAdministrador()
    {
        return $this->observacionesAdministrador;
    }

    /**
     *
     * @param string $observacionesAdministrador
     */
    public function setObservacionesAdministrador($observacionesAdministrador)
    {
        $this->observacionesAdministrador = $observacionesAdministrador;
    }

    /**
     *
     * @return boolean
     */
    public function getAceptado()
    {
        return $this->aceptado;
    }

    /**
     *
     * @param boolean $aceptado
     */
    public function setAceptado($aceptado)
    {
        $this->aceptado = $aceptado;
    }

    /**
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     *
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
?>
