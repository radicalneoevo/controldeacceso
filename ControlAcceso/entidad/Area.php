<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Área perteneciente a un departamento.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class Area
{
    private $idArea;
    private $nombreArea;
    private $departamento;

    function __construct()
    {

    }

    public function getIdArea()
    {
        return $this->idArea;
    }

    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }

    public function getNombreArea()
    {
        return $this->nombreArea;
    }

    public function setNombreArea($nombreArea)
    {
        $this->nombreArea = $nombreArea;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     *
     * @param Ares $area
     * @return boolean
     */
    public function igual($area)
    {
        if($area->getIdArea() == $this->idArea)
            return true;
        else
            return false;
    }

    public function imprimir()
    {
        return $this->nombreArea;
    }
}
?>
