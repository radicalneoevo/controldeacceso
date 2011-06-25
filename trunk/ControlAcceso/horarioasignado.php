<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoHorarioAsignado.php");
include_once("login.php");

/*
 * ABMC de Horarios asignados de un usuario particular.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Horario asignado');
    $pagina->getCuerpo()->setContenido(new ContenidoHorarioAsignado());
    $pagina->agregarScript("gui/calendario/calendar.js");
    $pagina->agregarScript("gui/calendario/lang/calendar-es.js");
    $pagina->agregarScript("gui/calendario/calendar-setup.js");
    $pagina->agregarScript("gui/calendario.js");
    $pagina->mostrarPagina();
}
?>
