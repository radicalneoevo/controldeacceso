<?php
include_once("Cabecera.php");

/**
 * Sección superior del sitio para usuarios no autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class CabeceraLogin extends Cabecera
{
    function __construct()
    {

    }

    public function mostrarCabecera()
    {
        imprimirTabulados(3);
        echo '<div id="cabecera">';

        $this->mostrarLogo();

        imprimirTabulados(3);
        echo '</div>';
    }
}
?>
