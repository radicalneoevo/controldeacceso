<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoHorarioHabitual.php");
include_once("login.php");

/*
 * ABMC de Horarios habituales de un usuario particular.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Horario habitual');
    $pagina->getCuerpo()->setContenido(new ContenidoHorarioHabitual());
    $pagina->mostrarPagina();
}
?>
