<?php
include_once("gui/contenidos/tablas/reportes/TablaReportes.php");
include_once("control/GestorHorarios.php");

/**
 * {@inheritdoc }
 */
class ContenidoNovedades extends Contenido
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
        
        $this->imprimirCambiosHorarioActivos();

        $this->imprimirNuevosHorarioActivos();

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
        echo '<h1>Bienvenido al sistema de control de acceso de personal</h1>';

        imprimirTabulados(6);
        echo '<h2>Novedades</h2>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra una lista con las solicitudes de cambios de horario activos y los
     * nuevos horarios pendientes de confirmación.
     */
    private function imprimirCambiosHorarioActivos()
    {
        $gestorHorarios = new GestorHorarios();
        $cambiosHorario = $gestorHorarios->getCambiosHorarioActivos();

        if(empty($cambiosHorario))
            return;

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        for($fila = 0; $fila <= count($cambiosHorario) - 1; $fila++)
        {
            $cambioHorario = $cambiosHorario[$fila];

            imprimirTabulados(6);
            echo '<h4>El usuario <a href="usuario.php?numeroDocumento=' .
            $cambioHorario->getHorarioHabitual()->getUsuario()->getNumeroDocumento() .
            '">' . $cambioHorario->getHorarioHabitual()->getUsuario()->getNombreyApellido() .
            '</a> solicita confirmación de un <a href="horariohabitual.php?numeroDocumento=' .
            $cambioHorario->getHorarioHabitual()->getUsuario()->getNumeroDocumento() .
            '&botonAsignarHorario">cambio de horario</a></h4>';
        }

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra una lista con las solicitudes de confirmación de nuevo horario
     * activos y los nuevos horarios pendientes de confirmación.
     */
    private function imprimirNuevosHorarioActivos()
    {
        $gestorHorarios = new GestorHorarios();
        $nuevosHorario = $gestorHorarios->getNuevosHorariosActivos();

        if(empty($nuevosHorario))
            return;

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        for($fila = 0; $fila <= count($nuevosHorario) - 1; $fila++)
        {
            $nuevoHorario = $nuevosHorario[$fila];

            imprimirTabulados(6);
            echo '<h4>El usuario <a href="usuario.php?numeroDocumento=' .
            $nuevoHorario->getHorarioHabitual()->getUsuario()->getNumeroDocumento() .
            '">' . $nuevoHorario->getHorarioHabitual()->getUsuario()->getNombreyApellido() .
            '</a> solicita confirmación de un <a href="horariohabitual.php?numeroDocumento=' .
            $nuevoHorario->getHorarioHabitual()->getUsuario()->getNumeroDocumento() .
            '&botonAsignarHorario">nuevo horario</a></h4>';
        }

        imprimirTabulados(5);
        echo '</div>';
    }
}
?>
