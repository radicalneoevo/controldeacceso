<?php
/**
 * Descripcion de TablaReportes
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-12-2009
 */
class TablaReportes
{
    protected $filas;
    protected $mensajeVacio;

    function __construct($filas)
    {
        $this->filas = $filas;
    }

    public function getMensajeVacio()
    {
        return $this->mensajeVacio;
    }

    public function setMensajeVacio($mensajeVacio)
    {
        $this->mensajeVacio = $mensajeVacio;
    }

    public function imprimir()
    {
        if(empty($this->filas))
            echo '<p>' . $this->mensajeVacio . '</p>';
        else
        {
            imprimirTabulados(6);
            echo '<table class="tablaReporte">';

            for($index = 0; $index < count($this->filas); $index++)
            {
                $fila = $this->filas[$index];

                if($index == 0)
                    $fila->imprimirCabecera();

                $fila->imprimir();
            }

            imprimirTabulados(6);
            echo '</table>';

            $this->imprimirNotas();
        }
    }

    public function imprimirNotas()
    {
        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>Click sobre el apellido para mayor información</p>';

        imprimirTabulados(6);
        echo '</div>';
    }
}
?>
