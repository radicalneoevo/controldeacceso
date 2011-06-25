<?php
include_once("entidad/Horario.php");
include_once("gui/contenidos/tablas/TablaHorarios.php");

/**
 * Representa una tabla de horarios habituales genérica.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
class TablaHorariosHabituales extends TablaHorarios
{
    function __construct($horarios)
    {
        parent::__construct($horarios);
    }

    /**
     * Imprime la cabecera de la tabla.
     */
    protected function imprimirCabecera()
    {
        $this->tabla->setHeaderContents(0, 0, 'Área');
        $this->tabla->setHeaderContents(0, 1, 'Día');
        $this->tabla->setHeaderContents(0, 2, 'Ingreso');
        $this->tabla->setHeaderContents(0, 3, 'Egreso');
        $this->tabla->setHeaderContents(0, 4, 'Acción');
        $this->tabla->setRowAttributes(0, $this->clase, false);
    }

    /**
     * Imprime una fila individual de la tabla.
     *
     * @param Horario $horario Horario a imprimir.
     * @param integer $fila Número de horario que se está imprimiendo
     */
    protected function imprimirFila($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $horario->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $horario->getDia()->getNombre());
        $this->tabla->setCellContents($fila + 1, 2, $horario->imprimirIngreso());
        $this->tabla->setCellContents($fila + 1, 3, $horario->imprimirEgreso());
        $this->tabla->setCellContents($fila + 1, 4, $this->acciones($horario->getIdHorarioHabitual()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }
    
    /**
     * Acciones que pueden realizarse con la fila actual.
     *
     * @param integer $idHorario Horario sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function acciones($idHorario)
    {
        $salida = '';

        // Ninguna por ahora

        return $salida;
    }
}
?>
