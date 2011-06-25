<?php
include_once("entidad/NuevoHorario.php");
include_once("gui/contenidos/tablas/TablaHorarios.php");

/**
 * Representa una tabla de nuevos horarios genérica, simple, sin acciones,
 * utilizada solo para imprimir.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-04-2010
 * @version 0.5
 */
class TablaNuevoHorario extends TablaHorarios
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
        $this->tabla->setHeaderContents(0, 4, 'Observaciones usuario');
        $this->tabla->setHeaderContents(0, 5, 'Observaciones administrador');
        $this->tabla->setHeaderContents(0, 6, 'Acción');
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
        $this->tabla->setCellContents($fila + 1, 0, $horario->getHorarioHabitual()->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $horario->getHorarioHabitual()->getDia()->getNombre());
        $this->tabla->setCellContents($fila + 1, 2, $horario->getHorarioHabitual()->imprimirIngreso());
        $this->tabla->setCellContents($fila + 1, 3, $horario->getHorarioHabitual()->imprimirEgreso());
        $this->tabla->setCellContents($fila + 1, 4, $horario->getObservacionesUsuario());
        $this->tabla->setCellContents($fila + 1, 5, $horario->getObservacionesAdministrador());
        $this->tabla->setCellContents($fila + 1, 6, $this->acciones($horario->getHorarioHabitual()->getIdHorarioHabitual()));
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
