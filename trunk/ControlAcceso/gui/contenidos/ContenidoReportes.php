<?php
include_once("gui/contenidos/tablas/reportes/TablaReportes.php");
include_once("control/GestorHorarios.php");

/**
 * {@inheritdoc }
 */
class ContenidoReportes extends Contenido
{
    private $gestorHorarios;

    /**
     * {@inheritdoc }
     */
    function __construct()
    {
        parent::__construct();
        $this->gestorHorarios = new GestorHorarios();
    }

    /**
     * {@inheritdoc }
     */
    public function mostrarContenido()
    {
        imprimirTabulados(4);
        echo '<div id="contenido">';

        $this->imprimirTitulos();

        try
        {
            if(isset($_REQUEST["enviarHorasAcumuladas"]))
                $this->reporteHorasAcumuladas();
            elseif(isset($_REQUEST["enviarTardanzas"]))
                $this->reporteTardanzas();
            elseif(isset($_REQUEST["enviarFaltas"]))
                $this->reporteFaltas();
            elseif(isset($_REQUEST["enviarNotificacionesFaltas"]))
                $this->reporteNotificacionesFaltas();
            else
                $this->mostrarFormularios();
        }
        catch(Exception $excepcion)
        {
            imprimirTabulados(7);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(7);
            echo '<h3>' . $excepcion->getMessage() . '</h3>';
        }

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
        echo '<h1>Reportes</h1>';

        imprimirTabulados(5);
        echo '</div>';

    }

    /**
     * Procesa las opciones del reporte de horas acumuladas.
     */
    private function reporteHorasAcumuladas()
    {
        if(isset($_REQUEST["radioGroupHorasAcumuladas"]) && isset($_REQUEST["area"]))
        {
            switch($_REQUEST["radioGroupHorasAcumuladas"])
            {
                case 0:
                    $this->imprimirReporteHorasAcumuladasDiario($_REQUEST["area"]);
                    break;
                case 1:
                    $this->imprimirReporteHorasAcumuladasSemanal($_REQUEST["area"]);
                    break;
                case 2:
                    $this->imprimirReporteHorasAcumuladasDelDia($_REQUEST["campoFechaEspecifica"], $_REQUEST["area"]);
                    break;
                case 3:
                    $this->imprimirReporteHorasAcumuladasEntreLosDias($_REQUEST["fechaInicio"], $_REQUEST["fechaFin"], $_REQUEST["area"]);
                    break;
                default:
                    throw new Exception('Intervalo incorrecto');
            }
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Procesa las opciones del reporte de notificaciones de faltas.
     */
    private function reporteNotificacionesFaltas()
    {
        if(isset($_REQUEST["radioGroupNotificacionesFaltas"]) && isset($_REQUEST["area"]))
        {
            switch($_REQUEST["radioGroupNotificacionesFaltas"])
            {
                case 0:
                    $this->imprimirReporteNotificacionesFaltasDiario($_REQUEST["area"]);
                    break;
                case 1:
                    $this->imprimirReporteNotificacionesFaltasSemanal($_REQUEST["area"]);
                    break;
                case 2:
                    $this->imprimirReporteNotificacionesFaltasDelDia($_REQUEST["campoFechaEspecifica"], $_REQUEST["area"]);
                    break;
                case 3:
                    $this->imprimirReporteNotificacionesFaltasEntreLosDias($_REQUEST["fechaInicio"], $_REQUEST["fechaFin"], $_REQUEST["area"]);
                    break;
                default:
                    throw new Exception('Intervalo incorrecto');
            }
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    // TODO terminar
    private function reporteFaltas()
    {
        if(isset($_REQUEST["radioGroupFaltas"]) && isset($_REQUEST["area"]))
        {
            switch($_REQUEST["radioGroupFaltas"])
            {
                case 0:
                    $this->imprimirReporteFaltasDiario($_REQUEST["area"]);
                    break;
                case 1:
                    $this->imprimirReporteFaltasSemanal($_REQUEST["area"]);
                    break;
                case 2:
                    $this->imprimirReporteFaltasDelDia($_REQUEST["campoFechaEspecifica"], $_REQUEST["area"]);
                    break;
                case 3:
                    $this->imprimirReporteFaltasDeLaSemana($_REQUEST["campoSemanaEspecifica"], $_REQUEST["area"]);
                    break;
                default:
                    throw new Exception('Intervalo incorrecto');
            }
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Muestra los formularios con los datos necesarios para generar los reportes.
     */
    private function mostrarFormularios()
    {
        $this->mostrarFormularioReporteHorasAcumuladas();

        $this->mostrarFormularioReporteNotificacionesFaltas();

        imprimirTabulados(6);
        echo '<br />';
    }

    /**
     * Formulario con los datos necesarios para generar el reporte de horas acumuladas.
     */
    private function mostrarFormularioReporteHorasAcumuladas()
    {
        imprimirTabulados(6);
        echo '<fieldset class="ancho">';

        imprimirTabulados(6);
        echo '<legend>Reporte de horas acumuladas</legend>';

        imprimirTabulados(7);
        echo '<form action="reportes.php" method="post">';

        imprimirTabulados(8);
        echo '<label for="radioGroupHorasAcumuladas_0">Diario</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupHorasAcumuladas" value="0" id="radioGroupHorasAcumuladas_0" checked="checked" />';

        imprimirTabulados(8);
        echo '<label for="radioGroupHorasAcumuladas_1">Semanal</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupHorasAcumuladas" value="1" id="radioGroupHorasAcumuladas_1" />';

        imprimirTabulados(8);
        echo '<label for="radioGroupHorasAcumuladas_2">Del dia</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupHorasAcumuladas" value="2" id="radioGroupHorasAcumuladas_2" />';
        echo '<input class="campoTexto" type="text" name="campoFechaEspecifica" id="campoFechaEspecificaHorasAcumuladas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaEspecificaHorasAcumuladas" value="..." /><br />';

        imprimirTabulados(8);
        echo '<label for="radioGroupHorasAcumuladas_3">Entre las fechas:</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupHorasAcumuladas" value="3" id="radioGroupHorasAcumuladas_3" />';

        echo '<label for="fechaInicio">Desde el</label>';
        echo '<input class="campoTexto" type="text" name="fechaInicio" id="fechaInicioHorasAcumuladas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaInicioHorasAcumuladas" value="..." />';
        echo '<label for="fechaFin">Hasta el</label>';
        echo '<input class="campoTexto" type="text" name="fechaFin" id="fechaFinHorasAcumuladas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaFinHorasAcumuladas" value="..." /><br />';

        imprimirTabulados(8);
        echo '<label for="area">Área</label>';
        echo $this->mostrarAreasSimpleSeleccionTodas();

        imprimirTabulados(8);
        echo '<input type="submit" name="enviarHorasAcumuladas" id="button" value="Enviar"/>';

        imprimirTabulados(7);
        echo '</form><br />';

        imprimirTabulados(6);
        echo '</fieldset>';
    }

    /**
     * Formulario con los datos necesarios para generar el reporte de notificaciones de faltas.
     */
    private function mostrarFormularioReporteNotificacionesFaltas()
    {
        imprimirTabulados(6);
        echo '<fieldset class="ancho">';

        imprimirTabulados(6);
        echo '<legend>Reporte de notificaciones de faltas</legend>';

        imprimirTabulados(7);
        echo '<form action="reportes.php" method="post">';

        imprimirTabulados(8);
        echo '<label for="radioGroupNotificacionesFaltas_0">Diario</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupNotificacionesFaltas" value="0" id="radioGroupNotificacionesFaltas_0" checked="checked" />';

        imprimirTabulados(8);
        echo '<label for="radioGroupNotificacionesFaltas_1">Semanal</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupNotificacionesFaltas" value="1" id="radioGroupNotificacionesFaltas_1" />';

        imprimirTabulados(8);
        echo '<label for="radioGroupNotificacionesFaltas_2">Del dia</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupNotificacionesFaltas" value="2" id="radioGroupNotificacionesFaltas_2" />';
        echo '<input class="campoTexto" type="text" name="campoFechaEspecifica" id="campoFechaEspecificaNotificacionesFaltas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaEspecificaNotificacionesFaltas" value="..." /><br />';

        imprimirTabulados(8);
        echo '<label for="radioGroupNotificacionesFaltas_3">Entre las fechas:</label>';
        echo '<input class="radioButton" type="radio" name="radioGroupNotificacionesFaltas" value="3" id="radioGroupNotificacionesFaltas_3" />';

        echo '<label for="fechaInicio">Desde el</label>';
        echo '<input class="campoTexto" type="text" name="fechaInicio" id="fechaInicioNotificacionesFaltas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaInicioNotificacionesFaltas" value="..." />';
        echo '<label for="fechaFin">Hasta el</label>';
        echo '<input class="campoTexto" type="text" name="fechaFin" id="fechaFinNotificacionesFaltas" value="DD-MM-AAAA" size="11" />';
        echo '<input type="button" id="seleccionarFechaFinNotificacionesFaltas" value="..." /><br />';

        imprimirTabulados(8);
        echo '<label for="area">Área</label>';
        echo $this->mostrarAreasSimpleSeleccionTodas();

        imprimirTabulados(8);
        echo '<input type="submit" name="enviarNotificacionesFaltas" id="button" value="Enviar"/>';

        imprimirTabulados(7);
        echo '</form><br />';

        imprimirTabulados(6);
        echo '</fieldset>';
    }

    /**
     * Reporte de horas acumuladas del día de la fecha.
     * @param Area $area Área de interes
     */
    private function imprimirReporteHorasAcumuladasDiario($area)
    {
        $reporte = $this->gestorUsuarios->reporteHorasAcumuladasDiario($area);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de horas acumuladas del día</h2>';

        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de horas acumuladas de la semana actual.
     * @param Area $area Área de interes
     */
    private function imprimirReporteHorasAcumuladasSemanal($area)
    {
        $reporte = $this->gestorUsuarios->reporteHorasAcumuladasSemanal($area);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de horas acumuladas de la semana</h2>';

        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en la semana');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de horas acumuladas de un día específico.
     * @param string $dia Fecha a validar
     * @param Area $area
     */
    private function imprimirReporteHorasAcumuladasDelDia($dia, $area)
    {
        validarFecha($dia);
        $reporte = $this->gestorUsuarios->reporteHorasAcumuladasDelDia($dia, $area);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de horas acumuladas del día ' . $dia . '</h2>';

        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de horas acumuladas entre dos fechas especificas.
     * @param string $fechaInicio Fecha a validar
     * @param string $fechaFin Fecha a validar
     * @param Area $area
     */
    private function imprimirReporteHorasAcumuladasEntreLosDias($fechaInicio, $fechaFin,$area)
    {
        validarIntervaloFechas($fechaInicio, $fechaFin);
        $reporte = $this->gestorUsuarios->reporteHorasAcumuladasEntreLosDias($fechaInicio, $fechaFin,$area);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de horas acumuladas entre los dias ' . $fechaInicio . ' y ' . $fechaFin .'</h2>';

        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros entre esas fechas');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de notificaciones de faltas del día de la fecha.
     * @param Area $area Área de interes
     */
    private function imprimirReporteNotificacionesFaltasDiario($area)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de notificaciones de falta del día</h2>';

        imprimirTabulados(6);
        echo '<h3>Faltas sin reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasSinReemplazoDiario($area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br><br><h3>Faltas con reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasConReemplazoDiario($area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de notificaciones de faltas de la semana actual.
     * @param Area $area Área de interes
     */
    private function imprimirReporteNotificacionesFaltasSemanal($area)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de notificaciones de falta semanal</h2>';

        imprimirTabulados(6);
        echo '<h3>Faltas sin reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasSinReemplazoSemanal($area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en la semana');
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br><br><h3>Faltas con reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasConReemplazoSemanal($area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en la semana');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de notificaciones de faltas de un día específico.
     * @param string $dia Fecha a validar
     * @param Area $area
     */
    private function imprimirReporteNotificacionesFaltasDelDia($dia, $area)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de notificaciones de falta del día ' . $dia . '</h2>';

        imprimirTabulados(6);
        echo '<h3>Faltas sin reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasSinReemplazoDelDia($dia, $area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br><br><h3>Faltas con reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasConReemplazoDelDia($dia, $area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros en el día');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Reporte de notificaciones de faltas entre dos fechas especificas.
     * @param string $fechaInicio Fecha a validar
     * @param string $fechaFin Fecha a validar
     * @param Area $area
     */
    private function imprimirReporteNotificacionesFaltasEntreLosDias($fechaInicio, $fechaFin,$area)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Reporte de notificaciones de faltas entre los dias ' . $fechaInicio . ' y ' . $fechaFin .'</h2>';

        imprimirTabulados(6);
        echo '<h3>Faltas sin reemplazo</h3>'; 

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasSinReemplazoEntreLosDias($fechaInicio, $fechaFin,$area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros entre esas fechas');
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br><br><h3>Faltas con reemplazo</h3>';

        $reporte = $this->gestorHorarios->reporteNotificacionesFaltasConReemplazoEntreLosDias($fechaInicio, $fechaFin,$area);
        $tabla = new TablaReportes($reporte);
        $tabla->setMensajeVacio('No hay registros entre esas fechas');
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }
}
?>
