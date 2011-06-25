<?php

include_once("gui/contenidos/tablas/semanasEspeciales/TablaSemanasEspeciales.php");

/**
 * Representa una tabla de semanas especiales editable.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaSemanasEspecialesEditable extends TablaSemanasEspeciales
{
    /**
     * Período al que pertenecen las semanas especiales.
     * @var Periodo
     */
    protected $periodo;

    /**
     * Formulario que manejara las acciones de los días feriados.
     * @var string
     */
    private $formulario;

    function __construct($semanasEspeciales, $periodo)
    {
        parent::__construct($semanasEspeciales);
        $this->periodo = $periodo;
        $this->formulario = '<form action="periodos.php" method="post">';
    }

    public function imprimir()
    {
        $this->imprimirCabecera();

        $index = 0;
        for($index = 0; $index < count($this->semanasEspeciales); $index++)
        {
            $semanaEspecial = $this->semanasEspeciales[$index];

            // El usuario pidio editar esta semana especial
            if(isset($_REQUEST['botonEditarSemanaEspecial']) && isset($_REQUEST['idSemanaEspecial']) &&
                    $semanaEspecial->getIdSemanaEspecial() == $_REQUEST['idSemanaEspecial'])
                $this->filaTablaEditar($semanaEspecial, $index);
            else
                // Muestra una fila ordinaria
                $this->imprimirFilaTablaSemanaEspecial($semanaEspecial, $index);
        }

        // El usuario pidio agregar una nueva semana especial, se agrega
        // al final de la tabla una nueva fila editable
        if(isset($_REQUEST['botonAgregarSemanaEspecial']))
            $this->filaTablaNuevaSemanaEspecial($index);
        else
            // Muestra una fila especial con un vínculo para agregar semanas especiales
            $this->filaTablaAgregar($index);

        imprimirTabulados(6);
        echo $this->tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><hr />';
    }

    /**
     * Imprime una fila de tabla con una semana especial y coloca las acciones básicas.
     *
     * @param SemanaEspecial $semanaEspecial Semana especial a imprimir.
     * @param integer $fila Número de semana especial que se está imprimiendo
     */
    private function imprimirFilaTablaSemanaEspecial($semanaEspecial, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $semanaEspecial->getDescripcion());
        $this->tabla->setCellContents($fila + 1, 1, $semanaEspecial->imprimirInicio());
        $this->tabla->setCellContents($fila + 1, 2, $semanaEspecial->imprimirFin());
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaSemanaEspecial($semanaEspecial->getIdSemanaEspecial()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaSemanaEspecial.
     *
     * @param integer $idSemanaEspecial Semana especial sobre la que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaSemanaEspecial($idSemanaEspecial)
    {
        // El formulario solo afecta a las acciones
        $salida = $this->formulario;
        $salida = $salida . $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idSemanaEspecial"  value="' . $idSemanaEspecial . '" />';
        $salida = $salida . '<input type="submit" name="botonEliminarSemanaEspecial" value="Eliminar" />&nbsp;';
        $salida = $salida . '<input type="submit" name="botonEditarSemanaEspecial" value="Editar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con una semana especial y coloca campos para editar el mismo.
     *
     * @param SemanaEspecial $semanaEspecial Semana especial a editar.
     * @param integer $fila Número de semana especial que se está imprimiendo.
     */
    private function filaTablaEditar($semanaEspecial, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . '<input class="campoTexto" type="text" name="descripcionSemanaEspecial" size="30" value="' . $semanaEspecial->getDescripcion() . '" />');
        $this->tabla->setCellContents($fila + 1, 1, $semanaEspecial->imprimirInicio());
        $this->tabla->setCellContents($fila + 1, 2, $semanaEspecial->imprimirFin());
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaEditar($semanaEspecial->getIdSemanaEspecial()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaEditar.
     *
     * @param integer $idSemanaEspecial Semana especial sobre la que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaEditar($idSemanaEspecial)
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idSemanaEspecial"  value="' . $idSemanaEspecial . '" />';
        $salida = $salida . '<input type="submit" name="botonEditarAceptarSemanaEspecial" value="Aceptar" />&nbsp;';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla especial vacía con un botón para agregar una nueva semana especial.
     *
     * @param integer $fila Última fila en la que se agregó una semana especial.
     */
    private function filaTablaAgregar($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, '');
        $this->tabla->setCellContents($fila + 1, 1, '');
        $this->tabla->setCellContents($fila + 1, 2, '');
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaAgregar());
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
        $salida = $salida . '<input type="submit" name="botonAgregarSemanaEspecial" value="Agregar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con campos para agregar una nueva semana especial.
     *
     * @param integer $fila Número de semana especial que se está imprimiendo.
     */
    private function filaTablaNuevaSemanaEspecial($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . '<input class="campoTexto" type="text" name="descripcionSemanaEspecial" size="30" value="" />');
        $this->tabla->setCellContents($fila + 1, 1, '<input class="campoTexto" type="text" name="fechaInicioSemanaEspecial" id="fechaInicioSemanaEspecial" size="11" value="DD-MM-AAAA" />' . '<input type="button" id="seleccionarFechaInicioSemanaEspecial" value="..." />');
        $this->tabla->setCellContents($fila + 1, 2, '<input class="campoTexto" type="text" name="fechaFinSemanaEspecial" id="fechaFinSemanaEspecial" size="11" value="DD-MM-AAAA" />' . '<input type="button" id="seleccionarFechaFinSemanaEspecial" value="..." />');
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaNuevaSemanaEspecial());
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaNuevaSemanaEspecial.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaNuevaSemanaEspecial()
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="submit" name="botonAgregarAceptarSemanaEspecial" value="Aceptar" />';
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
