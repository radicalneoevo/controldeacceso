<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/MovimientoHorario.php");

/**
 * Representa la solicitud de cambio de horario habitual por parte de un usuario
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 05-04-2010
 * @version 0.5
 */
class CambioHorario extends MovimientoHorario
{
    /**
     * ID único del cambio de horario.
     * @var integer
     */
    private $idCambioHorario;

    /**
     *
     * @return integer
     */
    public function getIdCambioHorario()
    {
        return $this->idCambioHorario;
    }

    /**
     *
     * @param integer $idCambioHorario
     */
    public function setIdCambioHorario($idCambioHorario)
    {
        $this->idCambioHorario = $idCambioHorario;
    }
}
?>
