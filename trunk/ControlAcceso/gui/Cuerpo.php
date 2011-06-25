<?php
include_once("Contenido.php");
include_once("BarraLateral.php");

/**
 * Sección central del sitio para usuarios autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class Cuerpo
{
    /**
     * Contenido principal del cuerpo.
     * @var Contenido
     */
    protected $contenido;

    /**
     * Barra de menú lateral.
     * @var BarraLateral
     */
    protected $barraLateral;

    /**
     * Constructor por defecto.
     */
    function __construct()
    {
        $this->contenido = new Contenido();
        $this->barraLateral = new BarraLateral();
    }

    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }

    public function getContenido()
    {
        return $this->contenido;
    }

    public function setBarraLateral($barraLateral)
    {
        $this->barraLateral = $barraLateral;
    }

    public function mostrarCuerpo()
    {
        imprimirTabulados(3);
        echo '<div id="cuerpo">';

        $this->contenido->mostrarContenido();
        $this->barraLateral->mostrarBarraLateral();

        echo '<div style="clear: both; height: 1px"></div>';

        imprimirTabulados(3);
        echo '</div>';
    }
}
?>
