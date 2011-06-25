<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Representa un día de la semana.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class DiaSemana
{
    private $idDiaSemana;
    private $nombre;

    function __construct($idDiaSemana)
    {
        $this->setIdDiaSemana($idDiaSemana);
    }

    public function getIdDiaSemana()
    {
        return $this->idDiaSemana;
    }

    public function setIdDiaSemana($idDiaSemana)
    {
        if($idDiaSemana == 1)
        {
            $this->idDiaSemana = 1;
            $this->nombre = 'Domingo';
        }
        elseif($idDiaSemana == 2)
        {
            $this->idDiaSemana = 2;
            $this->nombre = 'Lunes';
        }
        elseif($idDiaSemana == 3)
        {
            $this->idDiaSemana = 3;
            $this->nombre = 'Martes';
        }
        elseif($idDiaSemana == 4)
        {
            $this->idDiaSemana = 4;
            $this->nombre = 'Miercoles';
        }
        elseif($idDiaSemana == 5)
        {
            $this->idDiaSemana = 5;
            $this->nombre = 'Jueves';
        }
        elseif($idDiaSemana == 6)
        {
            $this->idDiaSemana = 6;
            $this->nombre = 'Viernes';
        }
        elseif($idDiaSemana == 7)
        {
            $this->idDiaSemana = 7;
            $this->nombre = 'Sabado';
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getNombreIngles()
    {
        if($this->idDiaSemana == 1)
            return 'Sunday';
        elseif($this->idDiaSemana == 2)
            return 'Monday';
        elseif($this->idDiaSemana == 3)
            return 'Tuesday';
        elseif($this->idDiaSemana == 4)
            return 'Wednesday';
        elseif($this->idDiaSemana == 5)
            return 'Thursday';
        elseif($this->idDiaSemana == 6)
            return 'Friday';
        elseif($this->idDiaSemana == 7)
            return 'Saturday';
    }

    public function setNombre($nombre)
    {
        if(strcmp($nombre, 'Domingo') == 0)
        {
            $this->idDiaSemana = 1;
            $this->nombre = 'Domingo';
        }
        if(strcmp($nombre, 'Lunes') == 0)
        {
            $this->idDiaSemana = 2;
            $this->nombre = 'Lunes';
        }
        if(strcmp($nombre, 'Martes') == 0)
        {
            $this->idDiaSemana = 3;
            $this->nombre = 'Martes';
        }
        if(strcmp($nombre, 'Miercoles') == 0)
        {
            $this->idDiaSemana = 4;
            $this->nombre = 'Miercoles';
        }
        if(strcmp($nombre, 'Jueves') == 0)
        {
            $this->idDiaSemana = 5;
            $this->nombre = 'Jueves';
        }
        if(strcmp($nombre, 'Viernes') == 0)
        {
            $this->idDiaSemana = 6;
            $this->nombre = 'Viernes';
        }
        if(strcmp($nombre, 'Sabado') == 0)
        {
            $this->idDiaSemana = 7;
            $this->nombre = 'Sabado';
        }

    }

    /**
     *
     * @param DiaSemana $diaSemana
     * @return boolean
     */
    public function igual($diaSemana)
    {
        if($this->idDiaSemana === $diaSemana->getIdDiaSemana() &&
           strcmp($this->nombre, $diaSemana->getNombre()) == 0)
            return true;
        else
            return false;
    }

    public function imprimir()
    {
        return $this->nombre . '';
    }
}
?>
