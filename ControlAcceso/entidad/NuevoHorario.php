<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/MovimientoHorario.php");

/**
 * Representa la asignación de un nuevo horario habitual por parte de un usuario
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 05-04-2010
 * @version 0.5
 */
class NuevoHorario extends MovimientoHorario
{
    /**
     * ID único del nuevo horario.
     * @var integer
     */
    private $idNuevoHorario;

    /**
     *
     * @return integer
     */
    public function getIdNuevoHorario()
    {
        return $this->idNuevoHorario;
    }

    /**
     *
     * @param integer $idNuevoHorario
     */
    public function setIdNuevoHorario($idNuevoHorario)
    {
        $this->idNuevoHorario = $idNuevoHorario;
    }
}
?>
