<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Representa un turno que debe cumplir un usuario en una fecha y horas
 * específicas. Está asociado a un período y área en particular.
 * Puede pertenecer a un horario habitual.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Periodo
 * @see Area
 * @see HorarioHabitual
 */
class Horario
{
    private $idHorario;
    private $idHorarioHabitual; // Horario semanal al que corresponde
    private $area;
    private $fecha;
    private $ingreso;
    private $egreso;
    private $usuario;
    private $periodo;
    
    function __construct()
    {

    }

    /**
     *
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     *
     * @param Area $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Establece la fecha desde un string con la forma 'd-m-Y'
     * @param string $fecha
     */
    public function setFecha($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!d-m-Y', $fecha);

        if(!empty($fecha))
            $this->fecha = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    /**
     * Establece la fecha desde un string con la forma 'Y-m-d'
     * @param string $fecha
     */
    public function setFechaISO($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!Y-m-d', $fecha);

        if(!empty($fecha))
            $this->fecha = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    public function imprimirFecha()
    {
        return $this->fecha->format('d-m-Y');
    }

    public function imprimirFechaISO()
    {
        return $this->fecha->format('Y-m-d');
    }

    /**
     * Retorna la hora de ingreso como objeto DateTime
     * @return DateTime
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Establece la hora de ingreso desde un string con la forma 'H:i'
     * @param string $ingreso
     */
    public function setIngreso($ingreso)
    {
        $ingreso = trim($ingreso);
        $ingreso = substr($ingreso, 0, 5);
        $ingreso = DateTime::createFromFormat('!H:i', $ingreso);

        if(!empty($ingreso))
            $this->ingreso = $ingreso;
        else
            throw new Exception('Hora de ingreso incorrecta');
    }

    /**
     * Retorna la hora de ingreso con formato 'H:i'
     * @return string
     */
    public function imprimirIngreso()
    {
        return $this->ingreso->format('H:i');
    }

    /**
     * Retorna la hora de egreso como objeto DateTime
     * @return DateTime
     */
    public function getEgreso()
    {
        return $this->egreso;
    }

    /**
     * Establece la hora de egreso desde un string con la forma 'H:i'
     * @param string $egreso
     */
    public function setEgreso($egreso)
    {
        $egreso = trim($egreso);
        $egreso = substr($egreso, 0, 5);
        $egreso = DateTime::createFromFormat('!H:i', $egreso);

        if(!empty($egreso))
            $this->egreso = $egreso;
        else
            throw new Exception('Hora de egreso incorrecta');
    }

    /**
     * Retorna la hora de egreso con formato 'H:i'
     * @return string
     */
    public function imprimirEgreso()
    {
        return $this->egreso->format('H:i');
    }

    /**
     *
     * @return integer
     */
    public function getIdHorario()
    {
        return $this->idHorario;
    }

    /**
     *
     * @param integer $idHorario
     */
    public function setIdHorario($idHorario)
    {
        $this->idHorario = $idHorario;
    }

    /**
     *
     * @return integer
     */
    public function getIdHorarioHabitual()
    {
        return $this->idHorarioHabitual;
    }

    /**
     *
     * @param integer $idHorario
     */
    public function setIdHorarioHabitual($idHorarioHabitual)
    {
        $this->idHorarioHabitual = $idHorarioHabitual;
    }

    /**
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     *
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }
    
    /**
     *
     * @param Horario $horario
     * @return boolean
     */
    public function igual($horario)
    {
        if($this->idHorario == $horario->getIdHorario() &&
           $this->idHorarioHabitual == $horario->getIdHorarioHabitual() &&
           $this->usuario->igual($horario->getUsuario()) &&
           $this->area->igual($horario->getArea()) &&
           strcmp($this->fecha->format('d-m-y'), $horario->getFecha()->format('d-m-y')) == 0 &&
           strcmp($this->ingreso->format('H:i'), $horario->getIngreso()->format('H:i')) == 0 &&
           strcmp($this->ingreso->format('H:i'), $horario->getIngreso()->format('H:i')) == 0)
            return true;
        else
            return false;
    }

    public function copiar($horario)
    {
        $this->idHorario = $horario->getIdHorario();
        $this->idHorarioHabitual = $horario->getIdHorarioHabitual();
        $this->usuario = $horario->getUsuario();
        $this->area = $horario->getArea();
        $this->fecha = $horario->getFecha();
        $this->ingreso = $horario->getIngreso();
        $this->egreso = $horario->getEgreso();
    }

    public function superponeCon($horario)
    {
        if($this->ingreso->getTimestamp() < $horario->getEgreso()->getTimestamp() &&
           $horario->getIngreso()->getTimestamp() < $this->egreso->getTimestamp())
           return true;
        else
            return false;
    }
}
?>
