<?php
require_once("HTML/Table.php");

/**
 * Representa una lista genérica de horarios (asignados o habituales).
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-12-2009
 * @version 0.5
 */
class TablaHorarios
{
    /**
     * Lista de horarios a imprimir.
     * @var array
     */
    protected $horarios;

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

    function __construct($horarios)
    {
        $this->horarios = $horarios;
        $this->clase = array('class' => 'tablaReporte');
        $this->tabla = new HTML_Table($this->clase);
        $this->tabla->setAutoGrow(true);
    }

    public function imprimir()
    {
        // Implementada en la subclase
        $this->imprimirCabecera();

        for($index = 0; $index < count($this->horarios); $index++)
        {
            $horario = $this->horarios[$index];
            // Implementada en la subclase
            $this->imprimirFila($horario, $index);
        }

        imprimirTabulados(6);
        echo $this->tabla->toHtml();
    }
}
?>
