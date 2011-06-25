<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Tipo de usuario presente en el sistema.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class Nivel
{
    private $idNivel;
    private $nombre;
    private $descripcion;

    function __construct()
    {

    }

    public function getIdNivel()
    {
        return $this->idNivel;
    }

    public function setIdNivel($idNivel)
    {
        $this->idNivel = $idNivel;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     *
     * @param Nivel $nivel
     * @return boolean
     */
    public function igual($nivel)
    {
        if($nivel->getIdNivel() == $this->idNivel)
            return true;
        else
            return false;
    }
}
?>
