<?php
include_once("Utilidades.php");

/**
 * Sección inferior del sitio para usuarios autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class PiePagina
{
    function __construct()
    {
        
    }
    
    public function mostrarPiePagina()
    {
        imprimirTabulados(3);
        echo '<div id="piepagina">';

        imprimirTabulados(3);
        echo '<div id="logout">';

        imprimirTabulados(4);
        echo '<form method="post" action="index.php">';

        imprimirTabulados(4);
        $autenticacion = $GLOBALS['autenticacion'];
        echo 'Usuario: ' . $autenticacion->getAuthData('usuario');

        imprimirTabulados(4);
        echo '<input type="submit" name="botonCerrarSesion" value="Cerrar sesión" />';

        imprimirTabulados(4);
        echo '</form>';

        imprimirTabulados(3);
        echo '</div>';

        imprimirTabulados(4);
        echo '<p id="legal">Copyright &copy; 2009 - 2010</p>';
        imprimirTabulados(4);
        echo '<p id="links"><a href="http://www.frsf.utn.edu.ar">Universidad Tecnológica Nacional - Facultad Regional Santa Fe</a></p>';

        imprimirTabulados(3);
        echo '</div>';
    }
}
?>
