<?php
include_once("control/GestorPeriodos.php");
include_once("entidad/Periodo.php");
include_once("entidad/DiaFeriado.php");
include_once("entidad/SemanaEspecial.php");
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriadosEditable.php");
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriadosAgregados.php");
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriadosEditados.php");
include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriadosEliminados.php");
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspecialesEditable.php");
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspecialesAgregadas.php");
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspecialesEditadas.php");
include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspecialesEliminadas.php");
require_once("HTML/Table.php");

/**
 * {@inheritdoc }
 */
// PROPUESTA permitir importar feriados de otro periodo
class ContenidoPeriodos extends Contenido
{
    /**
     * Controlador
     * @var GestorPeriodos
     */
    private $gestorPeriodos;

    /**
     * {@inheritdoc }
     */
    function __construct()
    {
        parent::__construct();
        $this->gestorPeriodos = new GestorPeriodos();
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
            /* Acciones para los periodos */
            // Muestra el formulario para dar de alta un nuevo período
            if(isset($_REQUEST['nuevoPeriodo']))
                $this->imprimirFormularioNuevoPeriodo();
            // Muestra el formulario para editar un período
            elseif(isset($_REQUEST['editarPeriodo']))
                $this->imprimirFormularioEditarPeriodo();
            // Procesa el alta de un nuevo período
            elseif(isset($_REQUEST['enviarNuevoPeriodo']))
                $this->agregarPeriodo();
            // Procesa la edición de un periodo
            elseif(isset($_REQUEST['enviarEditarPeriodo']))
                $this->editarPeriodo();
            /* Acciones para los periodos */

            /* Acciones para los dias feriados */
            // Procesa el alta de un nuevo dia feriado
            elseif(isset($_REQUEST['botonAgregarAceptarDiaFeriado']))
                $this->agregarDiaFeriado();
            // Procesa la edición de un nuevo dia feriado
            elseif(isset($_REQUEST['botonEditarAceptarDiaFeriado']))
                $this->editarDiaFeriado();
            // Procesa la eliminación de un dia feriado
            elseif(isset($_REQUEST['botonEliminarDiaFeriado']))
                $this->eliminarDiaFeriado();
            /* Acciones para los dias feriados */

            /* Acciones para las semanas especiales */
            // Procesa el alta de un nuevo dia feriado
            elseif(isset($_REQUEST['botonAgregarAceptarSemanaEspecial']))
                $this->agregarSemanaEspecial();
            // Procesa la edición de un nuevo dia feriado
            elseif(isset($_REQUEST['botonEditarAceptarSemanaEspecial']))
                $this->editarSemanaEspecial();
            // Procesa la eliminación de un dia feriado
            elseif(isset($_REQUEST['botonEliminarSemanaEspecial']))
                $this->eliminarSemanaEspecial();
            /* Acciones para las semanas especiales */

            /* Impresion */
            // Muestra los detalles de un período
            elseif(isset($_REQUEST['idPeriodo']))
                $this->imprimirPeriodo($_REQUEST['idPeriodo']);
            // Muestra los períodos actualmente activos
            else
                $this->imprimirListaPeriodos();
            /* Impresion */
        }
        catch(Exception $excepcion)
        {
            imprimirTabulados(5);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(5);
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
        echo '<h1>Periodos</h1>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra los períodos cargados en el sistema.
     */
    // TODO mostrar cual está activo
    private function imprimirListaPeriodos()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Periodos cargados</h1>';

        $periodos = $this->gestorPeriodos->getPeriodos();

        if(empty($periodos))
        {
            imprimirTabulados(6);
            echo '<p>No hay periodos cargados</p>';
        }
        else
            $this->imprimirTablaPeriodos($periodos);

        $this->imprimirBotonesDetallePeriodo();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra la tabla con los períodos cargados en el sistema.
     * @param array Períodos cargados en el sistema.
     */
    private function imprimirTablaPeriodos($periodos)
    {
        imprimirTabulados(6);
        $clase = array('class' => 'tablaReporte');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        // Encabezado
        $tabla->setHeaderContents(0, 0, 'Nombre');
        $tabla->setHeaderContents(0, 1, 'Area');
        $tabla->setHeaderContents(0, 2, 'Inicio');
        $tabla->setHeaderContents(0, 3, 'Fin');
        $tabla->setRowAttributes(0, $clase, false);

        // Contenido
        for($fila = 0; $fila <= count($periodos) - 1; $fila++)
        {
            $periodo = $periodos[$fila];
            $tabla->setCellContents($fila + 1, 0, '<a class="data" href="periodos.php?idPeriodo='. $periodo->getIdPeriodo() . '">' . $periodo->getNombre() . '</a>');
            $tabla->setCellContents($fila + 1, 1, $periodo->getArea()->getNombreArea());
            $tabla->setCellContents($fila + 1, 2, $periodo->imprimirInicio());
            $tabla->setCellContents($fila + 1, 3, $periodo->imprimirFin());
            $tabla->setRowAttributes($fila + 1, $clase, false);
        }

        echo $tabla->toHtml();

        // Notas
        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>Click sobre el nombre para mayor información</p>';

        imprimirTabulados(6);
        echo '</div>';
        // Notas
    }

    /**
     * Formulario simple con un solo botón para dar de alta un nuevo período.
     */
    private function imprimirBotonesDetallePeriodo()
    {
        imprimirTabulados(6);
        echo '<div class="contenedorBotones">';

        imprimirTabulados(6);
        echo '<form action="periodos.php" method="get">';

        imprimirTabulados(7);
        echo '<input type="submit" name="nuevoPeriodo"  value="Nuevo periodo" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '</div>';
    }

    /**
     * Muestra el período especificado por el usuario de forma detallada.
     * @param integer $idPeriodo
     */
    private function imprimirPeriodo($idPeriodo)
    {
        $periodo = $this->gestorPeriodos->getPeriodo($idPeriodo);

        $this->imprimirDetallePeriodo($periodo);

        $this->imprimirListaDiasFeriados($periodo);

        $this->imprimirListaSemanasEspeciales($periodo);

    }

    /**
     * Muestra la información general del período.
     * @param Periodo $periodo
     */
    private function imprimirDetallePeriodo($periodo)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Detalle del periodo</h1>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Nombre');
        $tabla->setCellContents(0, 1, $periodo->getNombre());

        $tabla->setHeaderContents(1, 0, 'Área');
        $tabla->setCellContents(1, 1, $periodo->getArea()->getNombreArea());

        $tabla->setHeaderContents(2, 0, 'Fecha de inicio');
        $tabla->setCellContents(2, 1, $periodo->imprimirInicio());

        $tabla->setHeaderContents(3, 0, 'Fecha de fin');
        $tabla->setCellContents(3, 1, $periodo->imprimirFin());

        $tabla->setHeaderContents(4, 0, 'Observaciones');
        $tabla->setCellContents(4, 1, $periodo->getObservaciones());

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, array('class' => 'tablaReporte'));

        echo $tabla->toHtml();

        $this->imprimirBotonesPeriodo($periodo);

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra el formulario con las acciones que pueden ejecutarse sobre un período.
     * @param Periodo $periodo
     */
    private function imprimirBotonesPeriodo($periodo)
    {
        imprimirTabulados(6);
        echo '<div class="contenedorBotones">';

        imprimirTabulados(6);
        echo '<form action="periodos.php" method="get">';

        imprimirTabulados(7);
        echo '<input type="hidden" name="idPeriodoEditar"  value="' . $periodo->getIdPeriodo() . '" />';

        imprimirTabulados(7);
        echo '<input type="submit" name="editarPeriodo"  value="Editar periodo" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '</div>';
    }

    /**
     * Muestra el formulario para dar de alta un nuevo período.
     */
    private function imprimirFormularioNuevoPeriodo()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Nuevo período</h1>';

        imprimirTabulados(6);
        echo '<form action="periodos.php" method="post">';

        imprimirTabulados(6);
        echo '<fieldset>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Nombre');
        $tabla->setCellContents(0, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="nombre" value="" />');

        $tabla->setHeaderContents(1, 0, 'Fecha de inicio');
        $tabla->setCellContents(1, 1, '<input class="campoTexto campoTextoAlineadoFecha" type="text" name="fechaInicio" id="fechaInicioPeriodo" value="DD-MM-AAAA" />' . '<input type="button" id="seleccionarFechaInicioPeriodo" value="..." />');

        $tabla->setHeaderContents(2, 0, 'Fecha de fin');
        $tabla->setCellContents(2, 1, '<input class="campoTexto campoTextoAlineadoFecha" type="text" name="fechaFin" id="fechaFinPeriodo" value="DD-MM-AAAA" />' . '<input type="button" id="seleccionarFechaFinPeriodo" value="..." />');

        $tabla->setHeaderContents(3, 0, 'Área');
        $tabla->setCellContents(3, 1, $this->mostrarAreasSimpleSeleccion());

        $tabla->setHeaderContents(4, 0, 'Observaciones');
        $tabla->setCellContents(4, 1, '<textarea name="observaciones" rows="4" cols="20"></textarea>');

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, $clase);

        echo $tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><input type="submit" name="enviarNuevoPeriodo"  value="Enviar" >';

        imprimirTabulados(6);
        echo '</fieldset>';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra el formulario para editar un período existente.
     */
    private function imprimirFormularioEditarPeriodo()
    {
        $periodo = $this->gestorPeriodos->getPeriodo($_REQUEST['idPeriodoEditar']);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Editar</h1>';

        imprimirTabulados(6);
        echo '<form action="periodos.php" method="post">';

        imprimirTabulados(6);
        echo '<fieldset>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Nombre');
        $tabla->setCellContents(0, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="nombre" value="' . $periodo->getNombre() . '" />');

        $tabla->setHeaderContents(1, 0, 'Fecha de inicio');
        $tabla->setCellContents(1, 1, $periodo->imprimirInicio());

        $tabla->setHeaderContents(2, 0, 'Fecha de fin');
        $tabla->setCellContents(2, 1, $periodo->imprimirFin());

        $tabla->setHeaderContents(3, 0, 'Área');
        $tabla->setCellContents(3, 1, $periodo->getArea()->getNombreArea());

        $tabla->setHeaderContents(4, 0, 'Observaciones');
        $tabla->setCellContents(4, 1, '<textarea name="observaciones" rows="4" cols="20">' . $periodo->getObservaciones() . '</textarea>');

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, $clase);

        echo $tabla->toHtml();

        imprimirTabulados(6);
        echo '<input type="hidden" name="idPeriodoEditar"  value="' . $periodo->getIdPeriodo() . '" />';

        imprimirTabulados(6);
        echo '<br /><input type="submit" name="enviarEditarPeriodo"  value="Enviar" >';

        imprimirTabulados(6);
        echo '</fieldset>';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Realiza las validaciones necesarias y agrega un nuevo período al sistema.
     * Informa errores mediante excepciones.
     */
    private function agregarPeriodo()
    {
        if(isset($_REQUEST['nombre']) && isset($_REQUEST['area']) &&
           isset($_REQUEST['fechaInicio']) && isset($_REQUEST['fechaFin']) &&
           isset($_REQUEST['observaciones']))
        {
            // Acciones ejecutadas
            $periodo = new Periodo();
            $periodo->setNombre($_REQUEST['nombre']);
            $periodo->setArea($this->gestorAreas->getArea($_REQUEST['area']));
            $periodo->setInicio($_REQUEST['fechaInicio']);
            $periodo->setFin($_REQUEST['fechaFin']);
            $periodo->setObservaciones($_REQUEST['observaciones']);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            try
            {
                $this->gestorPeriodos->insertarPeriodo($periodo);

                imprimirTabulados(6);
                echo '<h3>El período ha sido agregado exitosamente</h3>';
            }
            catch(Exception $excepcion)
            {
                imprimirTabulados(5);
                echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

                imprimirTabulados(5);
                echo '<h3>' . $excepcion->getMessage() . '</h3>';
            }

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirListaPeriodos();
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Realiza las validaciones necesarias y un período existente en el sistema.
     * Informa errores mediante excepciones.
     */
    private function editarPeriodo()
    {
        if(isset($_REQUEST['idPeriodoEditar']) && isset($_REQUEST['nombre']) &&
           isset($_REQUEST['observaciones']))
        {
            // Acciones ejecutadas
            $periodo = $this->gestorPeriodos->getPeriodo($_REQUEST['idPeriodoEditar']);
            $periodo->setNombre($_REQUEST['nombre']);
            $periodo->setObservaciones($_REQUEST['observaciones']);
            $this->gestorPeriodos->editarPeriodo($periodo);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El período ha sido actualizado exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirListaPeriodos();
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Muestra los días feriados cargados en el período actual.
     * @param Periodo $periodo
     */
    private function imprimirListaDiasFeriados($periodo)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        // Acciones ejecutadas
        $diasFeriados = $this->gestorPeriodos->getDiasFeriados($periodo->getIdPeriodo());

        // Impresion
        imprimirTabulados(6);
        echo '<hr /><br /><h2>Dias feriados: </h2>';

        if(empty($diasFeriados))
            echo '<p>No hay feriados asignados a este período</p>';

        $tabla = new TablaDiasFeriadosEditable($diasFeriados, $periodo);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Realiza las validaciones necesarias y agrega un feriado al período actual.
     * Informa errores mediante excepciones.
     */
    private function agregarDiaFeriado()
    {
        if(isset($_REQUEST['idPeriodo']) && isset($_REQUEST['fechaDiaFeriado']) &&
           isset($_REQUEST['descripcionDiaFeriado']))
        {
            // Acciones ejecutadas
            $diaFeriado = new DiaFeriado();
            $diaFeriado->setPeriodo($this->gestorPeriodos->getPeriodo($_REQUEST['idPeriodo']));
            $diaFeriado->setFecha($_REQUEST['fechaDiaFeriado']);
            $diaFeriado->setDescripcion($_REQUEST['descripcionDiaFeriado']);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            try
            {
                $this->gestorPeriodos->insertarDiaFeriado($diaFeriado);

                imprimirTabulados(6);
                echo '<h3>El feriado:</h3>';

                $diasFeriados = array();
                array_push($diasFeriados, $diaFeriado);
                $tabla = new TablaDiasFeriadosAgregados($diasFeriados);
                $tabla->imprimir();

                imprimirTabulados(6);
                echo '<h3>Ha sido agregado exitosamente</h3>';

            }
            catch(Exception $excepcion)
            {
                imprimirTabulados(5);
                echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

                imprimirTabulados(5);
                echo '<h3>' . $excepcion->getMessage() . '</h3>';
            }

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Realiza las validaciones necesarias y edita un feriado existente en el
     * período actual. Informa errores mediante excepciones.
     */
    private function editarDiaFeriado()
    {
        if(isset($_REQUEST['idDiaFeriado']) && isset($_REQUEST['descripcionDiaFeriado']))
        {
            // Acciones ejecutadas
            $diaFeriado = $this->gestorPeriodos->getDiaFeriado($_REQUEST['idDiaFeriado']);
            $diaFeriado->setDescripcion($_REQUEST['descripcionDiaFeriado']);

            $this->gestorPeriodos->editarDiaFeriado($diaFeriado);

            // Impresion  
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El feriado:</h3>';

            $diasFeriados = array();
            array_push($diasFeriados, $diaFeriado);
            $tabla = new TablaDiasFeriadosEditados($diasFeriados);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<br /><h3>Ha sido editado exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Realiza las validaciones necesarias y elimina un feriado existente en el
     * período actual. Informa errores mediante excepciones.
     */
    private function eliminarDiaFeriado()
    {
        if(isset($_REQUEST['idDiaFeriado']))
        {
            // Acciones ejecutadas
            $diaFeriado = $this->gestorPeriodos->getDiaFeriado($_REQUEST['idDiaFeriado']);
            $this->gestorPeriodos->eliminarDiaFeriado($diaFeriado);

            // Impresion  
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El feriado:</h3>';

            $diasFeriados = array();
            array_push($diasFeriados, $diaFeriado);
            $tabla = new TablaDiasFeriadosEliminados($diasFeriados);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido eliminado exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
         else
            throw new Exception('No se especificó el horario');
    }

    /**
     * Muestra las semanas especiales cargadas en el período actual.
     * @param Periodo $periodo
     */
    private function imprimirListaSemanasEspeciales($periodo)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        // Acciones ejecutadas
        $semanasEspeciales = $this->gestorPeriodos->getSemanasEspeciales($periodo->getIdPeriodo());

        // Impresion
        imprimirTabulados(6);
        echo '<h2>Semanas especiales: </h2>';

        if(empty($semanasEspeciales))
            echo '<p>No hay semanas especiales asignadas a este período</p>';

        $tabla = new TablaSemanasEspecialesEditable($semanasEspeciales, $periodo);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Realiza las validaciones necesarias y agrega una semana especial al período actual.
     * Informa errores mediante excepciones.
     */
    private function agregarSemanaEspecial()
    {
        if(isset($_REQUEST['idPeriodo']) && isset($_REQUEST['fechaInicioSemanaEspecial']) &&
           isset($_REQUEST['fechaFinSemanaEspecial']) && isset($_REQUEST['descripcionSemanaEspecial']))
        {
            // Acciones ejecutadas
            $semanaEspecial = new SemanaEspecial();
            $semanaEspecial->setPeriodo($this->gestorPeriodos->getPeriodo($_REQUEST['idPeriodo']));
            $semanaEspecial->setDescripcion($_REQUEST['descripcionSemanaEspecial']);
            $semanaEspecial->setInicio($_REQUEST['fechaInicioSemanaEspecial']);
            $semanaEspecial->setFin($_REQUEST['fechaFinSemanaEspecial']);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            try
            {
                $this->gestorPeriodos->insertarSemanaEspecial($semanaEspecial);

                imprimirTabulados(6);
                echo '<h3>La semana especial:</h3>';

                $semanasEspeciales = array();
                array_push($semanasEspeciales, $semanaEspecial);
                $tabla = new TablaSemanasEspecialesAgregadas($semanasEspeciales);
                $tabla->imprimir();

                imprimirTabulados(6);
                echo '<h3>Ha sido agregada exitosamente</h3>';
            }
            catch(Exception $excepcion)
            {
                imprimirTabulados(5);
                echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

                imprimirTabulados(5);
                echo '<h3>' . $excepcion->getMessage() . '</h3>';
            }

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Realiza las validaciones necesarias y edita una semana especial existente en el
     * período actual. Informa errores mediante excepciones.
     */
    private function editarSemanaEspecial()
    {
        if(isset($_REQUEST['idSemanaEspecial']) && isset($_REQUEST['descripcionSemanaEspecial']))
        {
            // Acciones ejecutadas
            $semanaEspecial = $this->gestorPeriodos->getSemanaEspecial($_REQUEST['idSemanaEspecial']);
            $semanaEspecial->setDescripcion($_REQUEST['descripcionSemanaEspecial']);

            $this->gestorPeriodos->editarSemanaEspecial($semanaEspecial);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>La semana especial:</h3>';

            $semanasEspeciales = array();
            array_push($semanasEspeciales, $semanaEspecial);
            $tabla = new TablaSemanasEspecialesEditadas($semanasEspeciales);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<br /><h3>Ha sido editada exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Realiza las validaciones necesarias y elimina una semana especial existente en el
     * período actual. Informa errores mediante excepciones.
     */
    private function eliminarSemanaEspecial()
    {
        if(isset($_REQUEST['idSemanaEspecial']))
        {
            // Acciones ejecutadas
            $semanaEspecial = $this->gestorPeriodos->getSemanaEspecial($_REQUEST['idSemanaEspecial']);
            $this->gestorPeriodos->eliminarSemanaEspecial($semanaEspecial);

            // Impresion
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>La semana especial:</h3>';

            $semanasEspeciales = array();
            array_push($semanasEspeciales, $semanaEspecial);
            $tabla = new TablaSemanasEspecialesEliminadas($semanasEspeciales);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido eliminada exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';

            $this->imprimirPeriodo($_REQUEST['idPeriodo']);
        }
         else
            throw new Exception('No se especificó la semana');
    }
}
?>