<?php
include_once("control/GestorUsuarios.php");
include_once("control/GestorHorarios.php");
include_once("control/GestorAreas.php");
include_once("entidad/Horario.php");
include_once("entidad/Usuario.php");
include_once("gui/contenidos/tablas/horariosAsignados/TablaHorariosAsignadosAgregados.php");
include_once("gui/contenidos/tablas/horariosAsignados/TablaHorariosAsignadosEditable.php");
include_once("gui/contenidos/tablas/horariosAsignados/TablaHorariosAsignadosEliminados.php");
include_once("gui/contenidos/tablas/horariosAsignados/TablaHorariosAsignadosMovidos.php");
include_once("gui/contenidos/tablas/horariosAsignados/TablaHorariosAsignadosSuperpuestos.php");

/**
 * {@inheritdoc }
 */
class ContenidoHorarioAsignado extends Contenido
{
    // Atributos obligatorios
    /**
     * Controlador
     * @var GestorHorarios
     */
    private $gestorHorarios;

    /**
     * Número de documento del usuario al que pertenecen los horarios.
     * Enviado por el usuario mediante request.
     * @var integer
     */
    private $numeroDocumentoIngresado;

    /**
     * Usuario al que pertenecen los horarios.
     * @var integer
     */
    private $usuario;

    /**
     * Fecha de inicio del período.
     * @var DateTime
     */
    private $fechaInicio;

    /**
     * Fecha de fin del período.
     * @var DateTime
     */
    private $fechaFin;

   // Atributos opcionales
    /**
     * Horario a modificar, agregar o eliminar. Se crea por demanda.
     * @var HorarioAsignado
     */
    private $horario;

    /**
     * {@inheritdoc }
     */
    function __construct()
    {
        parent::__construct();

        $this->gestorHorarios = new GestorHorarios();
    }

    /**
     * {@inheritdoc }
     */
    public function mostrarContenido()
    {
        imprimirTabulados(4);
        echo '<div id="contenido">';

        try
        {
            $this->imprimirTitulos();
        }
        // Captura las excepciones referidas al usuario, sin él no puede ejecutarse
        // ninguna acción sobre los horarios.
        catch(Exception $excepcion)
        {
            imprimirTabulados(7);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(7);
            echo '<h3>' . $excepcion->getMessage() . '</h3>';

            // Cierra Titulos
            imprimirTabulados(5);
            echo '</div>';

            // Cierra Contenido
            imprimirTabulados(5);
            echo '</div>';

            return;
        }

        try
        {
            $this->imprimirFormularioFechas();

            // Determina la accion a ejecutar
            // Nuevo horario agregado por formulario
            if(isset($_REQUEST['botonAgregarAceptar']))
                $this->agregarHorario();
            // Horario editado por formulario
            elseif(isset($_REQUEST['botonMoverAceptar']))
                $this->moverHorario();
            // Horario eliminado por formulario
            elseif(isset($_REQUEST['botonEliminar']))
                $this->eliminarHorario();

            // La tabla con los horarios se imprime siempre, haya o no
            $this->imprimirTablaHorarios();
        }
        // Captura las excepciones referidas a las fechas
        catch(Exception $excepcion)
        {
            imprimirTabulados(7);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(7);
            echo '<h3>' . $excepcion->getMessage() . '</h3>';
        }

        imprimirTabulados(4);
        echo '</div>';
    }

    /**
     * {@inheritdoc }
     */
    private function imprimirTitulos()
    {
        imprimirTabulados(5);
        echo '<div id="titulos">';

        imprimirTabulados(6);
        echo '<h1>Horario asignado</h1>';

        $this->obtenerUsuario();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Obtiene de la base da datos el usuario con el documento ingresado.
     */
    private function obtenerUsuario()
    {
        if(isset($_REQUEST['numeroDocumento']))
        {
            $this->numeroDocumentoIngresado = $_REQUEST['numeroDocumento'];
            $this->usuario = $this->gestorUsuarios->getUsuario($this->numeroDocumentoIngresado);

            imprimirTabulados(6);
            echo '<h2>' . $this->usuario->getNombre() . ' ' .
                $this->usuario->getApellido() . '</h2>';
        }
        else
            throw new Exception('No se especificó el número de documento');
    }

    /**
     * Agrega un nuevo horario asignado al usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function agregarHorario()
    {
        if(isset($_REQUEST['area']) && isset($_REQUEST['fecha']) &&
           isset($_REQUEST['ingreso']) && isset($_REQUEST['egreso']))
        {
            // Acciones ejecutadas
            $this->horario = new Horario();
            $this->horario->setUsuario($this->usuario);
            $this->horario->setFecha($_REQUEST['fecha']);
            $this->horario->setIngreso($_REQUEST['ingreso']);
            $this->horario->setEgreso($_REQUEST['egreso']);
            $this->horario->setArea($this->gestorAreas->getArea($_REQUEST['area']));

            $horariosSuperpuestos = $this->gestorHorarios->getHorariosSuperpuestos($this->horario);
            if(empty($horariosSuperpuestos))
            {
                $this->gestorHorarios->insertarHorarioExtraordinario($this->horario);

                imprimirTabulados(5);
                echo '<div class="tablaTituloBotones">';

                imprimirTabulados(6);
                echo '<h3>El horario:</h3>';

                $horarios = array();
                array_push($horarios, $this->horario);
                $tabla = new TablaHorariosAsignadosAgregados($horarios);
                $tabla->imprimir();

                imprimirTabulados(6);
                echo '<h3>Ha sido agregado exitosamente</h3>';

                imprimirTabulados(5);
                echo '</div>';
            }
            else
                $this->imprimirHorariosSuperpuestos($horariosSuperpuestos);

        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Mueve un horario asignado al usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function moverHorario()
    {
        if(isset($_REQUEST['idHorario']) && isset($_REQUEST['fecha']) &&
           isset($_REQUEST['ingreso']) && isset($_REQUEST['egreso']))
        {
            // Obtiene el horario para editar solo los campos necesarios
            $this->horario = $this->gestorHorarios->getHorario($_REQUEST['idHorario']);
            $horarioViejo = new Horario();
            $horarioViejo->copiar($this->horario);
            $this->horario->setUsuario($this->usuario);
            $this->horario->setFecha($_REQUEST['fecha']);
            $this->horario->setIngreso($_REQUEST['ingreso']);
            $this->horario->setEgreso($_REQUEST['egreso']);

            $horariosSuperpuestos = $this->gestorHorarios->getHorariosSuperpuestos($this->horario);
            if(empty($horariosSuperpuestos))
            {
                $this->gestorHorarios->modificarHorario($this->horario);

                imprimirTabulados(5);
                echo '<div class="tablaTituloBotones">';

                imprimirTabulados(6);
                echo '<h3>El horario:</h3>';

                $horarios = array();
                array_push($horarios, $horarioViejo);
                $tabla = new TablaHorariosAsignados($horarios);
                $tabla->imprimir();

                imprimirTabulados(6);
                echo '<br /><h3>Ha sido movido exitosamente al horario:</h3>';

                $horarios = array();
                array_push($horarios, $this->horario);
                $tabla = new TablaHorariosAsignadosMovidos($horarios);
                $tabla->imprimir();

                imprimirTabulados(5);
                echo '</div>';
            }
            else
                $this->imprimirHorariosSuperpuestos($horariosSuperpuestos);
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Elimina un horario asignado al usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function eliminarHorario()
    {
        if(isset($_REQUEST['idHorario']))
        {
            $this->horario = $this->gestorHorarios->getHorario($_REQUEST['idHorario']);
            $this->gestorHorarios->eliminarHorario($_REQUEST['idHorario']);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaHorariosAsignadosEliminados($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido eliminado exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';
        }
         else
            throw new Exception('No se especificó el horario');
    }

    /**
     * Muestra los horarios que se superponen con el que se está intentando cargar.
     * @param array $horariosSuperpuestos Horarios superpuestos.
     */
    private function imprimirHorariosSuperpuestos($horariosSuperpuestos)
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h3>El horario ingresado:</h3>';

        $horarios = array();
        array_push($horarios, $this->horario);
        $tabla = new TablaHorariosAsignados($horarios);
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br /><h3>Se superpone con:</h3>';

        $tabla = new TablaHorariosAsignadosSuperpuestos($horariosSuperpuestos);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra los horarios asignados al usuario entre las fechas dadas.
     */
    private function imprimirTablaHorarios()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        $horarios = $this->gestorHorarios->getHorarios($this->numeroDocumentoIngresado,
                $this->fechaInicio->format('d-m-Y'), $this->fechaFin->format('d-m-Y'));

        imprimirTabulados(6);
        echo '<hr /><br /><h3>Horarios asignados: </h3>';

        if(empty($horarios))
            echo '<p>No hay horarios asignados entre esas fechas</p>';

        $tabla = new TablaHorariosAsignadosEditable($horarios, $this->usuario,
                 $this->fechaInicio, $this->fechaFin);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra el formulario para ingresar las fechas de la consulta.
     */
    private function imprimirFormularioFechas()
    {
        // Inicialización de los campos de fechas
        // Si la fecha fue cargada, la mantiene entre pantalla y pantalla
        if(isset($_REQUEST['fechaInicio']) && isset($_REQUEST['fechaFin']))
        {
            validarIntervaloFechasFuturo($_REQUEST['fechaInicio'], $_REQUEST['fechaFin']);

            $this->fechaInicio = DateTime::createFromFormat('!d-m-Y', $_REQUEST['fechaInicio']);
            $this->fechaFin = DateTime::createFromFormat('!d-m-Y', $_REQUEST['fechaFin']);
        }
        // Sino la establece entre el día de la fecha y el viernes de esta semana
        else
        {
            $this->fechaInicio = new DateTime();
            $this->fechaFin = new DateTime('next Friday');
        }

        imprimirTabulados(5);
        echo '<form action="horarioasignado.php" method="get">';

        imprimirTabulados(5);
        echo '<fieldset>';

        imprimirTabulados(5);
        echo '<legend>Fechas</legend>';

        imprimirTabulados(6);
        echo '<input type="hidden" name="numeroDocumento"  value="' . $this->numeroDocumentoIngresado . '" />';

        imprimirTabulados(6);
        echo '<label for="fechaInicio">Del</label>';
        imprimirTabulados(6);
        echo '<input class="campoTexto" id="fechaInicioHorarioAsignado" type="text" name="fechaInicio" size="8" value="' . $this->fechaInicio->format('d-m-Y') . '" />';
        imprimirTabulados(6);
        echo '<input type="button" id="seleccionarFechaInicioHorarioAsignado" value="..." />';
        imprimirTabulados(6);
        echo '<label for="fechaFin">Hasta el</label>';
        imprimirTabulados(6);
        echo '<input class="campoTexto" id="fechaFinHorarioAsignado" type="text" name="fechaFin" size="8" value="' . $this->fechaFin->format('d-m-Y') . '" />';
        imprimirTabulados(6);
        echo '<input type="button" id="seleccionarFechaFinHorarioAsignado" value="..." />';

        imprimirTabulados(6);
        echo '<input type="submit" name="botonConsultarFechas"  value="Consultar" />';

        imprimirTabulados(5);
        echo '</fieldset>';

        imprimirTabulados(5);
        echo '</form>';
    }
}
?>
