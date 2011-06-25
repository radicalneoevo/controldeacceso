<?php

include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabituales.php");
include_once("control/GestorAreas.php");
include_once("entidad/DiaSemana.php");

/**
 * Representa una tabla con horarios habituales editables.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 20-12-2009
 * @version 0.5
 */
// TODO sacar los size de algunos campos
class TablaHorariosHabitualesEditable extends TablaHorariosHabituales
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

            // El usuario pidio editar este horario
            if(isset($_REQUEST['botonMover']) && isset($_REQUEST['idHorarioHabitual']) &&
                    $horario->getIdHorarioHabitual() == $_REQUEST['idHorarioHabitual'])
                $this->filaTablaEditar($horario, $index);
            else
                // Muestra una fila ordinaria
                $this->imprimirFilaTablaHorario($horario, $index);
        }

        // El usuario pidio agregar un nuevo horario, se agrega
        // al final de la tabla una nueva fila editable
        if(isset($_REQUEST['botonAgregar']))
            $this->filaTablaNuevoHorario($index);
        else
            // Sino se muestra una fila especial con un vínculo para agregar horarios
            $this->filaTablaAgregar($index);

        imprimirTabulados(6);
        echo $this->tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><hr />';
    }

    /**
     * Imprime una fila de tabla con un horario y coloca las acciones básicas.
     *
     * @param Horario $horario Horario a imprimir.
     * @param integer $fila Número de horario que se está imprimiendo
     */
    private function imprimirFilaTablaHorario($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, $horario->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $horario->getDia()->getNombre());
        $this->tabla->setCellContents($fila + 1, 2, $horario->imprimirIngreso());
        $this->tabla->setCellContents($fila + 1, 3, $horario->imprimirEgreso());
        $this->tabla->setCellContents($fila + 1, 4, $this->accionesFilaTablaHorario($horario));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaHorario.
     *
     * @param integer $idHorario Horario sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaHorario($horario)
    {
        // El formulario solo afecta a las acciones
        $salida = $this->formulario;
        $salida = $salida . $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idHorarioHabitual"  value="' . $horario->getIdHorarioHabitual() . '" />';
        $salida = $salida . '<input type="submit" name="botonEliminar" value="Eliminar" />&nbsp;';
        $salida = $salida . '<input type="submit" name="botonMover" value="Mover" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con un horario y coloca campos para editar el mismo.
     *
     * @param Horario $horario Horario a editar.
     * @param integer $fila Número de horario que se está imprimiendo.
     */
    private function filaTablaEditar($horario, $fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . $horario->getArea()->getNombreArea());
        $this->tabla->setCellContents($fila + 1, 1, $this->mostrarDias($horario->getDia()->getNombre()));
        $this->tabla->setCellContents($fila + 1, 2, '<input class="campoTexto campoTextoChico" type="text" name="ingreso" size="4" value="' . $horario->imprimirIngreso() . '" />');
        $this->tabla->setCellContents($fila + 1, 3, '<input class="campoTexto campoTextoChico" type="text" name="egreso" size="4" value="' . $horario->imprimirEgreso() . '" />');
        $this->tabla->setCellContents($fila + 1, 4, $this->accionesFilaTablaEditar($horario->getIdHorarioHabitual()));
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaEditar.
     *
     * @param integer $idHorario Horario sobre el que pueden ejecutarse las acciones.
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaEditar($idHorario)
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="hidden" name="idHorarioHabitual"  value="' . $idHorario . '" />';
        $salida = $salida . '<input type="submit" name="botonMoverAceptar" value="Aceptar" />&nbsp;';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla especial vacía con un botón para agregar un nuevo horario.
     *
     * @param integer $fila Última fila en la que se agregó un horario.
     */
    private function filaTablaAgregar($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        $this->tabla->setCellContents($fila + 1, 0, '');
        $this->tabla->setCellContents($fila + 1, 1, '');
        $this->tabla->setCellContents($fila + 1, 2, '');
        $this->tabla->setCellContents($fila + 1, 3, '');
        $this->tabla->setCellContents($fila + 1, 4, $this->accionesFilaTablaAgregar());
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
        $salida = $salida . '<input type="submit" name="botonAgregar" value="Agregar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Imprime una fila de tabla con campos para agregar un nuevo horario.
     *
     * @param integer $fila Número de horario que se está imprimiendo.
     */
    private function filaTablaNuevoHorario($fila)
    {
        // Debe sumarse uno a la fila porque la fila 0 es la cabecera
        // Se abre un formulario para editar los campos
        $this->tabla->setCellContents($fila + 1, 0, $this->formulario . $this->mostrarAreas());
        $this->tabla->setCellContents($fila + 1, 1, $this->mostrarDias());
        $this->tabla->setCellContents($fila + 1, 2, '<input class="campoTexto campoTextoChico" type="text" name="ingreso" size="4" value="HH:MM" />');
        $this->tabla->setCellContents($fila + 1, 3, '<input class="campoTexto campoTextoChico" type="text" name="egreso" size="4" value="HH:MM" />');
        $this->tabla->setCellContents($fila + 1, 4, $this->accionesFilaTablaNuevoHorario());
        $this->tabla->setRowAttributes($fila + 1, $this->clase, false);
    }

    /**
     * Acciones que pueden realizarse con una FilaTablaNuevoHorario.
     *
     * @return string Código HTML con las acciones.
     */
    private function accionesFilaTablaNuevoHorario()
    {
        $salida = $this->accionesComunes();
        $salida = $salida . '<input type="submit" name="botonAgregarAceptar" value="Aceptar" />';
        $salida = $salida . '</form>';

        return $salida;
    }

    /**
     * Muestra una lista desplegable de simple selección con las áreas a las que
     * pertenece el usuario.
     *
     * @return string Lista desplegable con las áreas a las que pertenece el usuario.
     */
    private function mostrarAreas()
    {
        $gestorAreas = new GestorAreas();
        $areas = $gestorAreas->getAreas();

        $salida = '<select name="area">';

        foreach ($areas as $value)
            if($this->usuario->perteneceAlArea($value))
                $salida = $salida . '<option value="' . $value->getIdArea() . '" >' .
                    $value->getNombreArea() . '</option>';

        $salida = $salida . '</select>';

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
    
    /**
     * Muestra un menu despleable con los dias de la semana y sus codigos.
     * Default: lunes
     *
     * @param string $diaSeleccionado Nombre del día seleccionado por defecto.
     *               Primera letra en mayúsculas.
     * @return string Menú de selección simple.
     */
    public function mostrarDias($diaSeleccionado)
    {
        if(empty($diaSeleccionado))
            $diaSeleccionado = 'Lunes';

        $salida = '<select name="dia" >';

        $salida = $salida . '<option value="1" '. (strcmp($diaSeleccionado, 'Domingo') == 0 ? 'selected' : '') . '>Domingo</option>';
        $salida = $salida . '<option value="2" '. (strcmp($diaSeleccionado, 'Lunes') == 0 ? 'selected' : '') . '>Lunes</option>';
        $salida = $salida . '<option value="3" '. (strcmp($diaSeleccionado, 'Martes') == 0 ? 'selected' : '') . '>Martes</option>';
        $salida = $salida . '<option value="4" '. (strcmp($diaSeleccionado, 'Miercoles') == 0 ? 'selected' : '') . '>Miercoles</option>';
        $salida = $salida . '<option value="5" '. (strcmp($diaSeleccionado, 'Jueves') == 0 ? 'selected' : '') . '>Jueves</option>';
        $salida = $salida . '<option value="6" '. (strcmp($diaSeleccionado, 'Viernes') == 0 ? 'selected' : '') . '>Viernes</option>';
        $salida = $salida . '<option value="7" '. (strcmp($diaSeleccionado, 'Sabado') == 0 ? 'selected' : '') . '>Sabado</option>';

        $salida = $salida . '</select>';

        return $salida;
    }
}
?>
