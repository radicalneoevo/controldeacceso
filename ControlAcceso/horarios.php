<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Pagina.php");
include_once("login.php");

/*
 * Muestra los horarios asignados de todos los usuarios de forma gráfica
 * NO IMPLEMENTADA: propuesta, hacerlo con los servicios de Google Calendar.
 */

// Chequea si el usuario está autorizado
if($autenticacion->checkAuth())
{
    // Contenido para usuarios autenticados
    $prueba = new Pagina();
    $prueba->mostrarPagina();
}
?>
