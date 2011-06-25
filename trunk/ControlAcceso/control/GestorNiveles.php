<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/Nivel.php");
include_once("dao/NivelDAO.php");

/**
 * Controla todas las operaciones pertinentes a los niveles.
 * Todos los accesos a la capa de datos deben ser solicitados a este gestor.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 06-11-2009
 * @version 0.5
 * @see Nivel
 */
class GestorNiveles
{
    private $nivelDAO;

    function __construct()
    {
        $this->nivelDAO = new NivelDAO();
    }

    /**
     * Obtiene el objeto Nivel correspondiente para el ID dado.
     *
     * @param Nivel $idNivel
     * @return Nivel
     * @throws Exception Si el nivel no existe o no se encuentra.
     */
    public function getNivel($idNivel)
    {
        return $this->nivelDAO->getNivel($idNivel);
    }

    /**
     * Obtiene todas los niveles cargados hasta el momento en el sistema.
     *
     * @return array Arreglo de objetos Nivel
     * @throws Exception Si no hay niveles cargados o no se encuentran.
     */
    public function getNiveles()
    {
        return $this->nivelDAO->getNiveles();
    }
}
?>
