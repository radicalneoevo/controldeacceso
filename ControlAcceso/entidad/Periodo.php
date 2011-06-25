<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/DiaFeriado.php");
include_once("entidad/SemanaEspecial.php");

/**
 * Intervalo de fechas que definen un período de interés dentro del sistema, por
 * ejemplo un cuatrimestre, un semestre, un año lectivo, etc. Está asociado a
 * un área.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Area
 */
class Periodo
{
    private $idPeriodo;
    private $nombre;
    private $area;
    private $inicio;
    private $fin;
    private $observaciones;

    function __construct()
    {

    }

    public function getIdPeriodo()
    {
        return $this->idPeriodo;
    }

    public function setIdPeriodo($idPeriodo)
    {
        $this->idPeriodo = $idPeriodo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getArea()
    {
        return $this->area;
    }

    public function setArea($area)
    {
        $this->area = $area;
    }

    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Establece la fecha desde un string con la forma 'd-m-Y'
     * @param string $fecha
     */
    public function setInicio($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!d-m-Y', $fecha);

        // Error al parsear la fecha
        if(!empty($fecha))
            // La fecha de inicio es mayor a la de fin
            if(!is_null($this->fin) && $this->fin->getTimeStamp() < $fecha->getTimeStamp())
                throw new Exception('La fecha de inicio es mayor a la de fin');
            else
                $this->inicio = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    /**
     * Establece la fecha desde un string con la forma 'Y-m-d'
     * @param string $fecha
     */
    public function setInicioISO($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!Y-m-d', $fecha);

        if(!empty($fecha))
            $this->inicio = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    public function imprimirInicio()
    {
        return $this->inicio->format('d-m-Y');
    }

    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Establece la fecha desde un string con la forma 'd-m-Y'
     * @param string $fecha
     */
    public function setFin($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!d-m-Y', $fecha);

        // Error al parsear la fecha
        if(!empty($fecha))
            // La fecha de fin es menor a la de fin
            if(!is_null($this->inicio) && $this->inicio->getTimeStamp() > $fecha->getTimeStamp())
                throw new Exception('La fecha de fin es menor a la de inicio');
            else
                $this->fin = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    /**
     * Establece la fecha desde un string con la forma 'Y-m-d'
     * @param string $fecha
     */
    public function setFinISO($fecha)
    {
        $fecha = trim($fecha);
        $fecha = substr($fecha, 0, 10);
        $fecha = DateTime::createFromFormat('!Y-m-d', $fecha);

        if(!empty($fecha))
            $this->fin = $fecha;
        else
            throw new Exception('Fecha incorrecta');
    }

    public function imprimirFin()
    {
        return $this->fin->format('d-m-Y');
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function incluyeLaSemana($semanaEspecial)
    {
        if($this->inicio->getTimeStamp() <= $semanaEspecial->getInicio()->getTimeStamp() &&
           $semanaEspecial->getFin()->getTimeStamp() <= $this->fin->getTimeStamp())
            return true;
        else
            return false;
    }

    public function incluyeElFeriado($diaFeriado)
    {
        if($this->inicio->getTimeStamp() <= $diaFeriado->getFecha()->getTimeStamp() &&
           $diaFeriado->getFecha()->getTimeStamp() <= $this->fin->getTimeStamp())
            return true;
        else
            return false;
    }
}
?>
