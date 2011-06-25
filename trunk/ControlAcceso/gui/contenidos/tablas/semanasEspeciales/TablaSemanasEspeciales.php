<?php
include_once("entidad/SemanaEspecial.php");

/**
 * Representa una tabla con las semanas especiales genérica.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaSemanasEspeciales
{
    /**
     * Lista de semanas especiales a imprimir.
     * @var array
     */
    protected $semanasEspeciales;

    /**
     * Tabla HTML con las semanas especiales.
     * @param HTML_Table
     */
    protected $tabla;

    function __construct($semanasEspeciales)
    {
        $this->semanasEspeciales = $semanasEspeciales;
        $this->clase = array('class' => 'tablaReporte');
        $this->tabla = new HTML_Table($this->clase);
        $this->tabla->setAutoGrow(true);
    }

    public function imprimir()
    {
        // Implementada en la subclase
        $this->imprimirCabecera();

        for($index = 0; $index < count($this->semanasEspeciales); $index++)
        {
            $semanaEspecial = $this->semanasEspeciales[$index];
            // Implementada en la subclase
            $this->imprimirFila($semanaEspecial, $index);
        }

        imprimirTabulados(6);
        echo $this->tabla->toHtml();
    }

    /**
     * Imprime la cabecera de la tabla.
     */
    protected function imprimirCabecera()
    {
        $this->tabla->setHeaderContents(0, 0, 'Descripción');
        $this->tabla->setHeaderContents(0, 1, 'Inicio');
        $this->tabla->setHeaderContents(0, 2, 'Fin');
        $this->tabla->setHeaderContents(0, 3, 'Acción');
        $this->tabla->setRowAttributes(0, $this->clase, false);
    }

    /**
     * Imprime una fila individual de la tabla.
     *
     * @param SemanaEspecial $semanaEspecial Semana especial a imprimir.
     * @param integer $fila Número de semana especial que se está imprimiendo
     */
    protected function imprimirFila($semanaEspecial, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $semanaEspecial->getDescripcion());
        $this->tabla->setCellContents($fila + 1, 1, $semanaEspecial->imprimirInicio());
        $this->tabla->setCellContents($fila + 1, 2, $semanaEspecial->imprimirFin());
        $this->tabla->setCellContents($fila + 1, 3, $this->acciones($semanaEspecial->getIdSemanaEspecial()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con la fila actual.
     *
     * @param integer $idDiaSemanaEspecial Semana especial sobre la que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function acciones($idDiaSemanaEspecial)
    {
        $salida = '';

        // Ninguna por ahora

        return $salida;
    }
}
?>
