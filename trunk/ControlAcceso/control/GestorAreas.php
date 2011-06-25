<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/Area.php");
include_once("dao/AreaDAO.php");

/**
 * Controla todas las operaciones pertinentes a las áreas.
 * Todos los accesos a la capa de datos deben ser solicitados a este gestor.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 06-11-2009
 * @version 0.5
 * @see Area
 */
class GestorAreas
{
    private $areaDAO;

    function __construct()
    {
        $this->areaDAO = new AreaDAO();
    }

    /**
     * Obtiene el objeto Area correspondiente para el ID dado.
     *
     * @param integer $idArea
     * @return Area
     * @throws Exception Si el área no existe o no se encuentra.
     */
    public function getArea($idArea)
    {
        return $this->areaDAO->getArea($idArea);
    }

    /**
     * Obtiene todas las áreas cargadas hasta el momento en el sistema.
     *
     * @return array Arreglo de objetos Area
     * @throws Exception Si no hay áreas cargadas o no se encuentran.
     */
    public function getAreas()
    {
        return $this->areaDAO->getAreas();
    }
}
?>
