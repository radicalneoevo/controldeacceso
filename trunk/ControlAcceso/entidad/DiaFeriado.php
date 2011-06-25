<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Representa un día no laboral sea éste un feriado, paro, día festivo, etc.
 * Está asociado a un período.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Periodo
 */
class DiaFeriado
{
    private $idDiaFeriado;
    private $periodo;
    private $fecha;
    private $descripcion;

    function __construct()
    {

    }

    public function getIdDiaFeriado()
    {
        return $this->idDiaFeriado;
    }

    public function setIdDiaFeriado($idDiaFeriado)
    {
        $this->idDiaFeriado = $idDiaFeriado;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
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

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
}
?>
