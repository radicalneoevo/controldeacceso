<?php

include_once("gui/contenidos/tablas/diasFeriados/TablaDiasFeriados.php");

/**
 * Representa una tabla de días feriados editable.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaDiasFeriadosEditable extends TablaDiasFeriados
{
    /**
     * Período al que pertenecen los días feriados.
     * @var Periodo
     */
    protected $periodo;

    /**
     * Formulario que manejara las acciones de los días feriados.
     * @var string
     */
    private $formulario;

    function __construct($diasFeriados, $periodo)
    {
        parent::__construct($diasFeriados);
        $this->periodo = $periodo;
        $this->formulario = '<form action="periodos.php" method="post">';
    }

    public function imprimir()
    {
        $this->imprimirCabecera();

        $index = 0;
        for($index = 0; $index < count($this->diasFeriados); $index++)
        {
            $diaFeriado = $this->diasFeriados[$index];

            // El usuario pidio editar este dia feriado
            if(isset($_REQUEST['botonEditarDiaFeriado']) && isset($_REQUEST['idDiaFeriado']) &&
                    $diaFeriado->getIdDiaFeriado() == $_REQUEST['idDiaFeriado'])
                $this->filaTablaEditar($diaFeriado, $index);
            else
                // Muestra una fila ordinaria
                $this->imprimirFilaTablaDiaFeriado($diaFeriado, $index);
        }

        // El usuario pidio agregar un nuevo dia feriado, se agrega
        // al final de la tabla una nueva fila editable
        if(isset($_REQUEST['botonAgregarDiaFeriado']))
            $this->filaTablaNuevoDiaFeriado($index);
        else
            // Muestra una fila especial con un vínculo para agregar dias feriados
            $this->filaTablaAgregar($index);

        imprimirTabulados(6);
        echo $this->tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><hr />';
    }

    /**
     * Imprime una fila de tabla con un día feriado y coloca las acciones básicas.
     *
     * @param DiaFeriado $diaFeriado Dia feriado a imprimir.
     * @param integer $fila Número de día feriado que se está imprimiendo
     */
    private function imprimirFilaTablaDiaFeriado($diaFeriado, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $diaFeriado->imprimirFecha());
        $this->tabla->setCellContents($fila + 1, 1, $diaFeriado->getDescripcion());
        $this->tabla->setCellContents($fila + 1, 2, $this->accionesFilaTablaDiaFeriado($diaFeriado->getIdDiaFeriado()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaDiaFeriado.
     *
     * @param integer $idDiaFeriado Día feriado sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaDiaFeriado($idDiaFeriado)
    {
        // El formulario solo afecta a las acciones
        $salida = $this->formulario;
        $salida = $salida . $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idDiaFeriado"  value="' . $idDiaFeriado . '" />';
        $salida = $salida . '<input type="submit" name="botonEliminarDiaFeriado" value="Eliminar" />&nbsp;';
        $salida = $salida . '<input type="submit" name="botonEditarDiaFeriado" value="Editar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con un día feriado y coloca campos para editar el mismo.
     *
     * @param DiaFeriado $diaFeriado DiaFeriado a editar.
     * @param integer $fila Número de día feriado que se está imprimiendo.
     */
    private function filaTablaEditar($diaFeriado, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . $diaFeriado->imprimirFecha());
        $this->tabla->setCellContents($fila + 1, 1, '<input class="campoTexto" type="text" name="descripcionDiaFeriado" size="30" value="' . $diaFeriado->getDescripcion() . '" />');
        $this->tabla->setCellContents($fila + 1, 2, $this->accionesFilaTablaEditar($diaFeriado->getIdDiaFeriado()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaEditar.
     *
     * @param integer $idDiaFeriado DiaFeriado sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaEditar($idDiaFeriado)
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idDiaFeriado"  value="' . $idDiaFeriado . '" />';
        $salida = $salida . '<input type="submit" name="botonEditarAceptarDiaFeriado" value="Aceptar" />&nbsp;';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla especial vacía con un botón para agregar un nuevo dia feriado.
     *
     * @param integer $fila Última fila en la que se agregó un dia feriado.
     */
    private function filaTablaAgregar($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, '');
        $this->tabla->setCellContents($fila + 1, 1, '');
        $this->tabla->setCellContents($fila + 1, 2, $this->accionesFilaTablaAgregar());
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaAgregar.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaAgregar()
    {
        $salida = $this->formulario;
        $salida = $salida . $this->accionesComunes();
        $salida = $salida . '<input type="submit" name="botonAgregarDiaFeriado" value="Agregar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con campos para agregar un nuevo día feriado.
     *
     * @param integer $fila Número de día feriado que se está imprimiendo.
     */
    private function filaTablaNuevoDiaFeriado($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . '<input class="campoTexto" type="text" name="fechaDiaFeriado" id="fechaDiaFeriado" size="11" value="DD-MM-AAAA" />' . '<input type="button" id="seleccionarFechaDiaFeriado" value="..." />');
        $this->tabla->setCellContents($fila + 1, 1, '<input class="campoTexto" type="text" name="descripcionDiaFeriado" size="30" value="" />');
        $this->tabla->setCellContents($fila + 1, 2, $this->accionesFilaTablaNuevoDiaFeriado());
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaNuevoDiaFeriado.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaNuevoDiaFeriado()
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="submit" name="botonAgregarAceptarDiaFeriado" value="Aceptar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Parámetros comunes en los formularios de las acciones.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesComunes()
    {
        $salida = '<input type="hidden" name="idPeriodo"  value="' . $this->periodo->getIdPeriodo() . '" />';

        return $salida;
    }
}
?>
