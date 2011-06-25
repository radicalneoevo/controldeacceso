<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoUsuario.php");
include_once("login.php");

/*
 * ABMC de usuarios.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Ficha de usuario');
    $pagina->getCuerpo()->setContenido(new ContenidoUsuario());
    $pagina->agregarScript("gui/formularios.js");
    $pagina->mostrarPagina();
}
?>
