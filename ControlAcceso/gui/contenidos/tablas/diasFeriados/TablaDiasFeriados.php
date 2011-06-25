<?php
include_once("entidad/DiaFeriado.php");

/**
 * Representa una tabla de días feriados genérica.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaDiasFeriados
{
    /**
     * Lista de días feriados a imprimir.
     * @var array
     */
    protected $diasFeriados;

    /**
     * Tabla HTML con los dias feriados
     * @param HTML_Table
     */
    protected $tabla;

    function __construct($diasFeriados)
    {
        $this->diasFeriados = $diasFeriados;
        $this->clase = array('class' => 'tablaReporte');
        $this->tabla = new HTML_Table($this->clase);
        $this->tabla->setAutoGrow(true);
    }

    public function imprimir()
    {
        // Implementada en la subclase
        $this->imprimirCabecera();

        for($index = 0; $index < count($this->diasFeriados); $index++)
        {
            $diaFeriado = $this->diasFeriados[$index];
            // Implementada en la subclase
            $this->imprimirFila($diaFeriado, $index);
        }

        imprimirTabulados(6);
        echo $this->tabla->toHtml();
    }

    /**
     * Imprime la cabecera de la tabla.
     */
    protected function imprimirCabecera()
    {
        $this->tabla->setHeaderContents(0, 0, 'Fecha');
        $this->tabla->setHeaderContents(0, 1, 'Descripción');
        $this->tabla->setHeaderContents(0, 2, 'Acción');
        $this->tabla->setRowAttributes(0, $this->clase, false);
    }
    
    /**
     * Imprime una fila individual de la tabla.
     *
     * @param DiaFeriado $diaFeriado Dia feriado a imprimir.
     * @param integer $fila Número de dia feriado que se está imprimiendo
     */
    protected function imprimirFila($diaFeriado, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $diaFeriado->imprimirFecha());
        $this->tabla->setCellContents($fila + 1, 1, $diaFeriado->getDescripcion());
        $this->tabla->setCellContents($fila + 1, 2, $this->acciones($diaFeriado->getIdDiaFeriado()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con la fila actual.
     *
     * @param integer $idDiaFeriado Dia feriado sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function acciones($idDiaFeriado)
    {
        $salida = '';

        // Ninguna por ahora

        return $salida;
    }
}
?>
