<?php

include_once("gui/contenidos/tablas/cambiosHorario/TablaCambiosHorario.php");
include_once("control/GestorAreas.php");
include_once("entidad/DiaSemana.php");

/**
 * Representa una tabla con cambios de horario editable, con las acciones
 * correspondientes.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-04-2010
 * @version 0.5
 */
// TODO sacar los size de algunos campos
class TablaCambiosHorarioEditable extends TablaCambiosHorario
{
    /**
     * Usuario al que pertenece el horario.
     * @var Usuario
     */
    private $usuario;

    /**
     * Formulario que manejara las acciones del horarios.
     * @var string
     */
    private $formulario;

    function __construct($horarios, $usuario)
    {
        parent::__construct($horarios);
        $this->usuario = $usuario;
        $this->formulario = '<form action="horariohabitual.php" method="post">';
    }

    public function imprimir()
    {
        $this->imprimirCabecera();

        $index = 0;
        for($index = 0; $index < count($this->horarios); $index++)
        {
            $horario = $this->horarios[$index];
            $this->imprimirFilaTablaCambioHorario($horario, $index);
        }

        imprimirTabulados(6);
        echo $this->tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><hr />';
    }

    /**
     * Imprime una fila de tabla con un cambio de horario y coloca las acciones básicas.
     *
     * @param Horario $horario Horario a imprimir.
     * @param integer $fila Número de horario que se está imprimiendo
     */
    private function imprimirFilaTablaCambioHorario($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $horario->getHorarioHabitual()->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $horario->getHorarioHabitual()->getDia()->getNombre());
        $this->tabla->setCellContents($fila + 1, 2, $horario->getHorarioHabitual()->imprimirIngreso());
        $this->tabla->setCellContents($fila + 1, 3, $horario->getHorarioHabitual()->imprimirEgreso());
        $this->tabla->setCellContents($fila + 1, 4, $horario->getObservacionesUsuario());
        $this->tabla->setCellContents($fila + 1, 5, $this->formulario . '<textarea class="areaTexto" name="observacionesAdministrador" rows="2" cols="5"></textarea>');
        $this->tabla->setCellContents($fila + 1, 6, $this->accionesFilaTablaHorario($horario));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaCambioHorario
     *
     * @param integer $idHorario Horario sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaHorario($horario)
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idCambioHorario"  value="' . $horario->getIdCambioHorario() . '" />';
        $salida = $salida . '<input type="submit" name="botonAceptarCambioHorario" value="Aceptar" />&nbsp;';
        $salida = $salida . '<input type="submit" name="botonRechazarCambioHorario" value="Rechazar" />';
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
        $salida = '<input type="hidden" name="numeroDocumento"  value="' . $this->usuario->getNumeroDocumento() . '" />';

        return $salida;
    }
}
?>
