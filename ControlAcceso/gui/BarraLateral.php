<?php
include_once("control/GestorUsuarios.php");
include_once("Utilidades.php");

/**
 * Barra de opciones disponibles para modificar el contenido.
 * 
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class BarraLateral
{
    function __construct()
    {

    }

    public function mostrarBarraLateral()
    {
        imprimirTabulados(4);
        echo '<div id="barralateral">';

        imprimirTabulados(5);
        echo '<ul>';
        $this->mostrarSubmenu();
        $this->mostrarUpdates();
        imprimirTabulados(5);
        echo '</ul>';

        imprimirTabulados(4);
        echo '</div>';
    }

    public function mostrarSubmenu()
    {
        imprimirTabulados(6);
        echo '<li id="submenu">';

        $this->mostrarPanel();

        imprimirTabulados(6);
        echo '</li>';
    }

    public function mostrarPanel()
    {
        imprimirTabulados(7);
        echo '<h2>Panel</h2>';

        imprimirTabulados(7);
        echo '<ul>';

        imprimirTabulados(8);
        echo '<li><a href="index.php">Inicio</a></li>';
        imprimirTabulados(8);
        echo '<li><a href="presentes.php">Presentes</a></li>';
        imprimirTabulados(8);
        echo '<li><a href="usuario.php">Personal</a></li>';
        imprimirTabulados(8);
        echo '<li><a href="reportes.php">Reportes</a></li>';
        imprimirTabulados(8);
        echo '<li><a href="periodos.php">Periodos</a></li>';

        imprimirTabulados(7);
        echo '</ul>';
    }

    public function mostrarUpdates()
    {
        imprimirTabulados(6);
        echo '<li id="updates">';

        $this->mostrarNovedades();

        imprimirTabulados(6);
        echo '</li>';
    }

    public function mostrarNovedades()
    {
        imprimirTabulados(7);
        echo '<h2>Novedades</h2>';

        imprimirTabulados(7);
        echo '<ul>';

        imprimirTabulados(8);
        echo '<li>';

        imprimirTabulados(9);
        echo '<h3>Últimos ingresos</h3>';

        $gestorUsuarios = new GestorUsuarios();
        $usuarios = $gestorUsuarios->getUltimosIngresos();

        if(empty($usuarios))
        {
            imprimirTabulados(9);
            echo '<p></p>';
        }

        for($index = 0; $index < count($usuarios); $index++)
        {
            $usuario = $usuarios[$index];

            echo '<p>' . $usuario->getApellido() . ' ' . $usuario->getNombre() . '</p>';
        }

        imprimirTabulados(8);
        echo '</li>';

        imprimirTabulados(8);
        echo '<li>';

        imprimirTabulados(9);
        echo '<h3>Últimos egresos</h3>';

        $gestorUsuarios = new GestorUsuarios();
        $usuarios = $gestorUsuarios->getUltimosEgresos();

        if(empty($usuarios))
        {
            imprimirTabulados(9);
            echo '<p></p>';
        }

        for($index = 0; $index < count($usuarios); $index++)
        {
            $usuario = $usuarios[$index];

            echo '<p>' . $usuario->getApellido() . ' ' . $usuario->getNombre() . '</p>';
        }

        imprimirTabulados(8);
        echo '</li>';

        imprimirTabulados(7);
        echo '</ul>';
    }
}
?>
