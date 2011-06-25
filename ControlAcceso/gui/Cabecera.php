<?php
include_once("Utilidades.php");

/**
 * Sección superior del sitio para usuarios autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class Cabecera
{
    function __construct()
    {

    }

    public function mostrarCabecera()
    {
        imprimirTabulados(3);
        echo '<div id="cabecera">';

        $this->mostrarLogo();
        $this->mostrarMenu();

        imprimirTabulados(3);
        echo '</div>';
    }

    protected function mostrarLogo()
    {
        imprimirTabulados(4);
        echo '<div id="logo">';

        imprimirTabulados(5);
        echo '<h1><a href="index.php">Control de acceso</a></h1>';
        imprimirTabulados(5);
        echo '<h2><a href="index.php">Laboratorio de sistemas</a></h2>';

        imprimirTabulados(4);
        echo '</div>';
    }

    protected function mostrarMenu()
    {
        imprimirTabulados(4);
        echo '<div id="menu">';

        imprimirTabulados(5);
        echo '<ul>';

        imprimirTabulados(6);
        echo '<li><a href="index.php">Inicio</a></li>';
        imprimirTabulados(6);
        echo '<li><a href="index.php" style="font-size: 8px;">Control de acceso</a></li>';
        imprimirTabulados(6);
        echo '<li><a href="index.php">Tareas</a></li>';

        imprimirTabulados(5);
        echo '</ul>';

        imprimirTabulados(4);
        echo '</div>';
    }
}
?>
