<?php
require_once("HTML/Table.php");
include_once("FilaTablaHorasAsignadas.php");

/**
 * Descripcion de TablasHorasAsignadas
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 21-12-2009
 */
class TablasHorasAsignadas
{
    /**
     * Lista de horas asignadas al usuario.
     * @var array
     */
    protected $listaHorasAsignadas;

    /**
     * Tabla HTML con los horarios
     * @var HTML_Table
     */
    protected $tabla;

    /**
     * Clase CSS que se asociará a los elementos de la tabla.
     * @var array
     */
    protected $clase;

    /**
     * Formulario que manejara las acciones del horarios.
     * @var string
     */
    private $formulario;

    
    private $numeroDocumentoIngresado;

    function __construct($listaHorasAsignadas, $numeroDocumentoIngresado)
    {
        $this->listaHorasAsignadas = $listaHorasAsignadas;
        $this->clase = array('class' => 'tablaReporte');
        $this->tabla = new HTML_Table($this->clase);
        $this->tabla->setAutoGrow(true);
        $this->formulario = '<form action="horariohabitual.php" method="post">';
        $this->numeroDocumentoIngresado = $numeroDocumentoIngresado;
    }


    public function imprimir()
    {
        // Implementada en la subclase
        $this->imprimirCabecera();

        for($index = 0; $index < count($this->listaHorasAsignadas); $index++)
        {
            $horasAsignadas = $this->listaHorasAsignadas[$index];
            // El usuario pidio editar este horario
            if(isset($_REQUEST['botonEditarHoras']))
                $this->filaTablaHorasAsignadasEditar($horasAsignadas, $index);
            else
                // Muestra una fila ordinaria
                $this->filaTablaHorasAsignadas($horasAsignadas, $index);
        }

        imprimirTabulados(6);
        echo $this->tabla->toHtml();
    }

    /**
     * Imprime la cabecera de la tabla.
     */
    private function imprimirCabecera()
    {
        $this->tabla->setHeaderContents(0, 0, 'Área');
        $this->tabla->setHeaderContents(0, 1, 'Horas asignadas');
        $this->tabla->setHeaderContents(0, 2, 'Horas asignadas actualmente');
        $this->tabla->setHeaderContents(0, 3, 'Acción');
        $this->tabla->setRowAttributes(0, $this->clase, false);
    }

    protected function filaTablaHorasAsignadas($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $horario->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $horario->getHorasAsignadas());
        $this->tabla->setCellContents($fila + 1, 2, $horario->getHorasActualmenteAsignadas());
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaHorasAsignadas($horario->getArea()->getIdArea()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    // Acciones posible para filaTablaHorasAsignadas
    private function accionesFilaTablaHorasAsignadas($idArea)
    {
        $salida = $this->formulario . $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idArea"  value="' . $idArea . '" />';
        $salida = $salida . '<input type="submit" name="botonEditarHoras" value="Editar" />';
        
        return $salida;
    }

    // Fila de tabla de horas asignadas que esta siendo editada
    private function filaTablaHorasAsignadasEditar($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . $horario->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, '<input class="campoTexto campoTextoChico" type="text" name="cantidadHoras" size="4" value="' . $horario->getHorasAsignadas() . '" />');
        $this->tabla->setCellContents($fila + 1, 2, $horario->getHorasActualmenteAsignadas());
        $this->tabla->setCellContents($fila + 1, 3, $this->accionesFilaTablaHorasAsignadasEditar($horario->getArea()->getIdArea()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    // Acciones posible para una FilaTablaHorasAsignadas que esta siendo editada
    private function accionesFilaTablaHorasAsignadasEditar($idArea)
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idArea"  value="' . $idArea . '" />';
        $salida = $salida . '<input type="submit" name="botonEditarHorasAceptar" value="Aceptar" />';
        return $salida;
    }

    /**
     * Parámetros comunes en los formularios de las acciones.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesComunes()
    {
        $salida = '<input type="hidden" name="numeroDocumento"  value="' . $this->numeroDocumentoIngresado . '" />';

        return $salida;
    }
}
?>
