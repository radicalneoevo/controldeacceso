<?php
include_once("gui/contenidos/tablas/reportes/TablaReportes.php");

/**
 * {@inheritdoc }
 */
// TODO Colocar foto
class ContenidoPresentes extends Contenido
{
    /**
     * {@inheritdoc }
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc }
     */
    public function mostrarContenido()
    {
        imprimirTabulados(4);
        echo '<div id="contenido">';
        
        $this->imprimirTitulos();
        $this->imprimirListaPresentes();
        $this->imprimirListaAusentes();

        imprimirTabulados(4);
        echo '</div>';
    }

    /**
     * {@inheritdoc }
     */
    private function imprimirTitulos()
    {
        imprimirTabulados(5);
        echo '<div id="titulos">';

        imprimirTabulados(6);
        echo '<h1>Personal presente</h1>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra una lista con los usuarios presentes.
     */
    private function imprimirListaPresentes()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>En laboratorios</h1>';

        $usuarios = $this->gestorUsuarios->getUsuariosPresentes();

        $tabla = new TablaReportes($usuarios);
        $tabla->setMensajeVacio('No hay personal presente');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra una lista con los usuarios ausentes.
     */
    // TODO agregar area
    private function imprimirListaAusentes()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Ausentes</h1>';

        $usuarios = $this->gestorUsuarios->getUsuariosAusentes();

        $tabla = new TablaReportes($usuarios);
        $tabla->setMensajeVacio('No hay personal ausente');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }
}
?>
