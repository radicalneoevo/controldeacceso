<?php
include_once("gui/PiePagina.php");

/**
 * Sección inferior del sitio para usuarios no autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class PiePaginaLogin extends PiePagina
{
   
    public function mostrarPiePagina()
    {
        imprimirTabulados(3);
        echo '<div id="piepagina">';

        imprimirTabulados(4);
        echo '<p id="legal">Copyright &copy; 2009 - 2010</p>';
        imprimirTabulados(4);
        echo '<p id="links"><a href="http://www.frsf.utn.edu.ar">Universidad Tecnológica Nacional - Facultad Regional Santa Fe</a></p>';

        imprimirTabulados(3);
        echo '</div>';
    }
}
?>
