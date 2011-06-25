<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("entidad/Usuario.php");
include_once("dao/UsuarioDAO.php");
include_once("control/GestorAreas.php");
include_once("control/GestorNiveles.php");

/**
 * Controla todas las operaciones pertinentes a los usuarios.
 * Todos los accesos a la capa de datos deben ser solicitados a este gestor.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 06-11-2009
 * @version 0.5
 * @see Usuario
 */
class GestorUsuarios
{
    private $usuarioDAO;
    private $gestorAreas;
    private $gestorNiveles;

    function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
        $this->gestorAreas = new GestorAreas();
        $this->gestorNiveles = new GestorNiveles();
    }

    /**
     * Obtiene el objeto Usuario correspondiente para el numero de documento dado.
     *
     * @param integer $numeroDocumento
     * @return Usuario
     * @throws Exception Si el Usuario no existe o no se encuentra.
     */
    public function getUsuario($numeroDocumento)
    {
        return $this->usuarioDAO->getUsuario($numeroDocumento);
    }

    /**
     * Obtiene todas los usuarios cargados hasta el momento en el sistema.
     *
     * @return array Arreglo de objetos Usuario
     * @throws Exception Si no hay usuarios cargados o no se encuentran.
     */
    public function getUsuarios()
    {
        return $this->usuarioDAO->getUsuarios();
    }

    /**
     * Modifica los datos correspondientes a un usuario dado.
     *
     * @param Usuario $usuario
     */
    public function modificarUsuario($usuario)
    {
        $this->usuarioDAO->modificarUsuario($usuario);
    }

    /**
     * Verifica si existe algún usuario con el número de documento dado
     *
     * @param integer $numeroDocumento
     * @return boolean true: si existe un usuario con ese número de documento
     * false: cualquier otro caso
     */
    public function existeDNI($numeroDocumento)
    {
        return $this->usuarioDAO->existeDNI($numeroDocumento);
    }

    public function insertarUsuario($nuevoUsuario)
    {
        if(!$this->existeDNI($nuevoUsuario->getNumeroDocumento()))
            $this->usuarioDAO->insertarUsuario($nuevoUsuario);
        else
            throw new Exception('El número de documento ya existe');
    }

    public function getUsuariosPresentes()
    {
        return $this->usuarioDAO->getUsuariosPresentes();
    }

    public function getUsuariosAusentes()
    {
        return $this->usuarioDAO->getUsuariosAusentes();
    }

    public function getUltimosIngresos()
    {
        return $this->usuarioDAO->getUltimosIngresos();
    }

    public function getUltimosEgresos()
    {
        return $this->usuarioDAO->getUltimosEgresos();
    }

    public function reporteHorasAcumuladasDiario($area)
    {
        return $this->usuarioDAO->reporteHorasAcumuladasDiario($area);
    }

    public function reporteHorasAcumuladasSemanal($area)
    {
        return $this->usuarioDAO->reporteHorasAcumuladasSemanal($area);
    }

    public function reporteHorasAcumuladasDelDia($dia, $area)
    {
        return $this->usuarioDAO->reporteHorasAcumuladasDelDia($dia, $area);
    }

    public function reporteHorasAcumuladasDeLaSemana($dia, $area)
    {
        return $this->usuarioDAO->reporteHorasAcumuladasDeLaSemana($dia, $area);
    }

    public function reporteHorasAcumuladasEntreLosDias($fechaInicio, $fechaFin,$area)
    {
        return $this->usuarioDAO->reporteHorasAcumuladasEntreLosDias($fechaInicio, $fechaFin,$area);
    }

    public function reporteFaltasDiario($area)
    {
        return $this->usuarioDAO->reporteFaltasDiario($area);
    }

    public function reporteFaltasSemanal($area)
    {
        return $this->usuarioDAO->reporteFaltasSemanal($area);
    }

    public function reporteFaltasDelDia($dia, $area)
    {
        return $this->usuarioDAO->reporteFaltasDelDia($dia, $area);
    }

    public function reporteFaltasDeLaSemana($dia, $area)
    {
        return $this->usuarioDAO->reporteFaltasDeLaSemana($dia, $area);
    }
}
?>
