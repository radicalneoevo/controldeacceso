<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("gui/contenidos/ContenidoPresentes.php");
include_once("login.php");

/*
 * Pantalla en la que se muestran los usuarios presentes en laboratorios y los
 * ausentes (considerando media hora de retraso o más).
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $pagina = new Pagina('Control de acceso - Presentes');
    $pagina->getCuerpo()->setContenido(new ContenidoPresentes());
    $pagina->mostrarPagina();
}
?>