<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoPeriodos.php");
include_once("login.php");

/*
 * ABMC de Periodos, Dias feriados y Semanas especiales.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Periodos');
    $pagina->getCuerpo()->setContenido(new ContenidoPeriodos());
    $pagina->agregarScript("gui/formularios.js");
    $pagina->agregarScript("gui/calendario/calendar.js");
    $pagina->agregarScript("gui/calendario/lang/calendar-es.js");
    $pagina->agregarScript("gui/calendario/calendar-setup.js");
    $pagina->agregarScript("gui/calendario.js");
    $pagina->mostrarPagina();
}
?>
