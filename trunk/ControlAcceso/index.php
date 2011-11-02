<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoNovedades.php");
include_once("login.php");

/*
 * Punto de entrada al sistema. Si el usuario esta autenticado despliega un
 * resumen con las novedades del día, sino muestra la pantalla de login.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados

    // El usuario presionó el botón para cerrar sesión, ubicado en el PiePagina
    // Este (index.php) script es el único que puede procesar un cierre de sesión
    if(isset($_POST['botonCerrarSesion']))
        $autenticacion->logout();
    else
    {
        $pagina = new Pagina("Control de acceso - Inicio");
        $pagina->getCuerpo()->setContenido(new ContenidoNovedades());
        $pagina->mostrarPagina();
    }
}
?>
