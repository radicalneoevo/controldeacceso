<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoReportes.php");
include_once("login.php");

/*
 * Pantalla de generación de reportes a nivel de personal.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Reportes');
    $pagina->getCuerpo()->setContenido(new ContenidoReportes());
    $pagina->agregarScript("gui/calendario/calendar.js");
    $pagina->agregarScript("gui/calendario/lang/calendar-es.js");
    $pagina->agregarScript("gui/calendario/calendar-setup.js");
    $pagina->agregarScript("gui/calendario.js");
    $pagina->mostrarPagina();
}
?>