<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Intervalo de fechas dentro de un período dentro de las cuales no se aplican
 * los horarios habituales definidos para cada usuario, por ejemplo semanas de
 * consulta, semanas de exámenes, semanas del receso, etc.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Periodo
 */
class SemanaEspecial
{
    private $idSemanaEspecial;
    private $periodo;
    private $descripcion;
    private $inicio;
    private $fin;

    function __construct()
    {

    }

    public function getIdSemanaEspecial()
    {
        return $this->idSemanaEspecial;
    }

    public function setIdSemanaEspecial($idSemanaEspecial)
    {
        $this->idSemanaEspecial = $idSemanaEspecial;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
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

        if(!empty($fecha))
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

        if(!empty($fecha))
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

}
?>
