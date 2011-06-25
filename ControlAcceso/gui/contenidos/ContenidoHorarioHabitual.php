<?php
include_once("control/GestorUsuarios.php");
include_once("control/GestorHorarios.php");
include_once("control/GestorAreas.php");
include_once("entidad/HorarioHabitual.php");
include_once("entidad/Usuario.php");
include_once("entidad/DiaSemana.php");
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabitualesAgregados.php");
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabitualesEditable.php");
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabitualesEliminados.php");
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabitualesMovidos.php");
include_once("gui/contenidos/tablas/horariosHabituales/TablaHorariosHabitualesSuperpuestos.php");
include_once("gui/contenidos/tablas/cambiosHorario/TablaCambiosHorarioEditable.php");
include_once("gui/contenidos/tablas/nuevoHorario/TablaNuevoHorarioEditable.php");
include_once("gui/contenidos/tablas/horasAsignadas/TablasHorasAsignadas.php");

/**
 * {@inheritdoc }
 */
class ContenidoHorarioHabitual extends Contenido
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
            // Determina la accion a ejecutar

            /* Acciones para los horarios habituales */
            // Nuevo horario agregado por formulario
            if(isset($_REQUEST['botonAgregarAceptar']))
                $this->agregarHorarioHabitual();
            // Horario editado por formulario
            elseif(isset($_REQUEST['botonMoverAceptar']))
                $this->editarHorarioHabitual();
            // Horario eliminado por hipervínculo
            elseif(isset($_REQUEST['botonEliminar']))
                $this->eliminarHorarioHabitual();
            elseif(isset($_REQUEST['botonConfirmar']))
                $this->confirmarHorarioHabitual();
            /* Acciones para los horarios habituales */

            /* Acciones para los cambios de horario */
            if(isset($_REQUEST['botonAceptarCambioHorario']))
                $this->aceptarCambioHorario();
            elseif(isset($_REQUEST['botonRechazarCambioHorario']))
                $this->rechazarCambioHorario();
            /* Acciones para los cambios de horario */

            /* Acciones para los nuevos horarios */
            if(isset($_REQUEST['botonAceptarNuevoHorario']))
                $this->aceptarNuevoHorario();
            elseif(isset($_REQUEST['botonRechazarNuevoHorario']))
                $this->rechazarNuevoHorario();
            /* Acciones para los nuevos horarios */

            /* Acciones para las horas asignadas */
            if(isset($_REQUEST['botonEditarHorasAceptar']))
                $this->asignarHoras();
            /* Acciones para las horas asignadas */

        }
        // Captura las excepciones referidas a las acciones
        catch(Exception $excepcion)
        {
            imprimirTabulados(7);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(7);
            echo '<h3>' . $excepcion->getMessage() . '</h3>';
        }

        // Muestra, si existen, los cambios de horario activos del usuario
        $this->imprimirTablaCambiosHorario();

        // Muestra, si existen, los nuevos horario activos del usuario
        $this->imprimirTablaNuevoHorario();

        $this->imprimirTablaHorasAsignadas();

        // La tabla con los horarios se imprime siempre, haya o no
        $this->imprimirTablaHorarios();

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
        echo '<h1>Horario habitual</h1>';

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
     * Agrega un nuevo horario habitual al usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function agregarHorarioHabitual()
    {
        if(isset($_REQUEST['area']) && isset($_REQUEST['dia']) &&
           isset($_REQUEST['ingreso']) && isset($_REQUEST['egreso']))
        {
            // Acciones ejecutadas
            $this->horario = new HorarioHabitual();
            $this->horario->setUsuario($this->usuario);
            $this->horario->setDia(new DiaSemana($_REQUEST['dia']));
            $this->horario->setIngreso($_REQUEST['ingreso']);
            $this->horario->setEgreso($_REQUEST['egreso']);
            $this->horario->setArea($this->gestorAreas->getArea($_REQUEST['area']));

            $horariosSuperpuestos = $this->gestorHorarios->getHorariosHabitualesSuperpuestos($this->horario);
            if(empty($horariosSuperpuestos))
            {
                $this->gestorHorarios->insertarHorarioHabitual($this->horario);

                imprimirTabulados(5);
                echo '<div class="tablaTituloBotones">';

                imprimirTabulados(6);
                echo '<h3>El horario:</h3>';

                $horarios = array();
                array_push($horarios, $this->horario);
                $tabla = new TablaHorariosHabitualesAgregados($horarios);
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
     * Edita un horario habitual del usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function editarHorarioHabitual()
    {
        if(isset($_REQUEST['idHorarioHabitual']) && isset($_REQUEST['dia']) &&
           isset($_REQUEST['ingreso']) && isset($_REQUEST['egreso']))
        {
            // Obtiene el horario para editar solo los campos necesarios
            $this->horario = $this->gestorHorarios->getHorarioHabitual($_REQUEST['idHorarioHabitual']);
            $this->horario->setUsuario($this->usuario);
            $this->horario->setDia(new DiaSemana($_REQUEST['dia']));
            $this->horario->setIngreso($_REQUEST['ingreso']);
            $this->horario->setEgreso($_REQUEST['egreso']);

            $horariosSuperpuestos = $this->gestorHorarios->getHorariosHabitualesSuperpuestos($this->horario);
            if(empty($horariosSuperpuestos))
            {
                $this->gestorHorarios->modificarHorarioHabitual($this->horario);

                imprimirTabulados(5);
                echo '<div class="tablaTituloBotones">';

                imprimirTabulados(6);
                echo '<h3>El horario:</h3>';

                $horarios = array();
                array_push($horarios, $this->horario);
                $tabla = new TablaHorariosHabitualesMovidos($horarios);
                $tabla->imprimir();

                imprimirTabulados(6);
                echo '<h3>Ha sido editado exitosamente</h3>';

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
     * Elimina un horario habitual del usuario. Verifica que estén presente
     * todos los campos y sean correctos. Controla que no haya superposición de
     * horarios. Imprime los resultados.
     */
    private function eliminarHorarioHabitual()
    {
        if(isset($_REQUEST['idHorarioHabitual']))
        {
            $this->horario = $this->gestorHorarios->getHorarioHabitual($_REQUEST['idHorarioHabitual']);
            $this->gestorHorarios->eliminarHorarioHabitual($this->horario);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaHorariosHabitualesEliminados($horarios);
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
     * Acepta un cambio de horario del usuario, marca el horario habitual como
     * no activo y elimina los horarios asignados futuros. Imprime los resultados.
     */
    private function aceptarCambioHorario()
    {
        if(isset($_REQUEST['idCambioHorario']))
        {
            // Recupera el cambio de horario para poder imprimirlo
            $this->horario = $this->gestorHorarios->getCambioHorario($_REQUEST['idCambioHorario']);

            if(isset($_REQUEST['observacionesAdministrador']))
                $this->horario->setObservacionesAdministrador($_REQUEST['observacionesAdministrador']);
            else
                $this->horario->setObservacionesAdministrador('');

            $this->gestorHorarios->aceptarCambioHorario($this->horario);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El cambio de horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaCambiosHorario($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido aceptado exitosamente</h3>';
            echo '<h4>Se le informará al usuario la próxima vez que se autentique en el cliente</h4>';

            imprimirTabulados(5);
            echo '</div>';
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Rechaza un cambio de horario del usuario. Imprime los resultados.
     */
    private function rechazarCambioHorario()
    {
        if(isset($_REQUEST['idCambioHorario']))
        {
            // Recupera el cambio de horario para poder imprimirlo
            $this->horario = $this->gestorHorarios->getCambioHorario($_REQUEST['idCambioHorario']);

            if(isset($_REQUEST['observacionesAdministrador']))
                $this->horario->setObservacionesAdministrador($_REQUEST['observacionesAdministrador']);
            else
                $this->horario->setObservacionesAdministrador('');

            $this->gestorHorarios->rechazarCambioHorario($this->horario);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El cambio de horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaCambiosHorario($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido rechazado exitosamente</h3>';
            echo '<h4>Se le informará al usuario la próxima vez que se autentique en el cliente</h4>';

            imprimirTabulados(5);
            echo '</div>';
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Acepta un nuevo horario del usuario y genera los horario asignados futuros
     * hasta el final del período actual. Imprime los resultados.
     */
    private function aceptarNuevoHorario()
    {
        if(isset($_REQUEST['idNuevoHorario']))
        {
             // Recupera el nuevo horario para poder imprimirlo
            $this->horario = $this->gestorHorarios->getNuevoHorario($_REQUEST['idNuevoHorario']);

            if(isset($_REQUEST['observacionesAdministrador']))
                $this->horario->setObservacionesAdministrador($_REQUEST['observacionesAdministrador']);
            else
                $this->horario->setObservacionesAdministrador('');

            $this->gestorHorarios->aceptarNuevoHorario($this->horario);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El nuevo horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaNuevoHorario($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido aceptado exitosamente</h3>';
            echo '<h4>Se le informará al usuario la próxima vez que se autentique en el cliente</h4>';

            imprimirTabulados(5);
            echo '</div>';
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Rechaza un nuevo horario del usuario. Imprime los resultados.
     */
    private function rechazarNuevoHorario()
    {
        if(isset($_REQUEST['idNuevoHorario']))
        {
            // Recupera el nuevo horario para poder imprimirlo
            $this->horario = $this->gestorHorarios->getNuevoHorario($_REQUEST['idNuevoHorario']);

            if(isset($_REQUEST['observacionesAdministrador']))
                $this->horario->setObservacionesAdministrador($_REQUEST['observacionesAdministrador']);
            else
                $this->horario->setObservacionesAdministrador('');

            $this->gestorHorarios->rechazarNuevoHorario($this->horario);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El nuevo horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaNuevoHorario($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido rechazado exitosamente</h3>';
            echo '<h4>Se le informará al usuario la próxima vez que se autentique en el cliente</h4>';

            imprimirTabulados(5);
            echo '</div>';
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    /**
     * Confirma un horario habitual del usuario y genera los horario asignado
     * hasta el final del período. Imprime los resultados.
     */
    private function confirmarHorarioHabitual()
    {
        if(isset($_REQUEST['idHorarioHabitual']))
        {
            $this->horario = $this->gestorHorarios->getHorarioHabitual($_REQUEST['idHorarioHabitual']);
            $this->gestorHorarios->confirmarHorarioHabitual($_REQUEST['idHorarioHabitual']);

            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<h3>El horario:</h3>';

            $horarios = array();
            array_push($horarios, $this->horario);
            $tabla = new TablaHorariosHabituales($horarios);
            $tabla->imprimir();

            imprimirTabulados(6);
            echo '<h3>Ha sido confirmado exitosamente</h3>';

            imprimirTabulados(5);
            echo '</div>';
        }
        else
            throw new Exception('No se especificó un parámetro');
    }

    private function asignarHoras()
    {
        if(isset($_REQUEST['idArea']) && isset($_REQUEST['cantidadHoras']))
        {
            $this->gestorHorarios->asignarHoras($_REQUEST['numeroDocumento'],
                    $_REQUEST['idArea'], $_REQUEST['cantidadHoras']);

            imprimirTabulados(6);
            echo '<br /><h3>Las horas han sido asignadas exitosamente</h3>';
        }
         else
            throw new Exception('No se especificó un parámetro');
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
        $tabla = new TablaHorariosHabituales($horarios);
        $tabla->imprimir();

        imprimirTabulados(6);
        echo '<br /><h3>Se superpone con:</h3>';

        $tabla = new TablaHorariosHabitualesSuperpuestos($horariosSuperpuestos);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra los horarios habituales del usuario.
     */
    private function imprimirTablaHorarios()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<hr /><br /><h3>Horarios asignados</h3>';

        $horarios = $this->gestorHorarios->getHorariosHabituales($this->numeroDocumentoIngresado);

        if(empty($horarios))
            echo '<p>No hay horarios asignados</p>';

        $tabla = new TablaHorariosHabitualesEditable($horarios, $this->usuario);
        $tabla->imprimir();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra los horarios habituales del usuario.
     */
    private function imprimirTablaCambiosHorario()
    {
        $horarios = $this->gestorHorarios->getCambiosHorarioActivosUsuario($this->numeroDocumentoIngresado);

        if(!empty($horarios))
        {
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<hr /><br /><h3>Cambios de horario:</h3>';

            $tabla = new TablaCambiosHorarioEditable($horarios, $this->usuario);
            $tabla->imprimir();

            imprimirTabulados(5);
            echo '</div>';
        }
    }

    /**
     * Muestra los horarios habituales del usuario.
     */
    private function imprimirTablaNuevoHorario()
    {
        $horarios = $this->gestorHorarios->getNuevosHorariosActivosUsuario($this->numeroDocumentoIngresado);

        if(!empty($horarios))
        {
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<hr /><br /><h3>Nuevos horarios:</h3>';

            $tabla = new TablaNuevoHorarioEditable($horarios, $this->usuario);
            $tabla->imprimir();

            imprimirTabulados(5);
            echo '</div>';
        }
    }

    private function imprimirTablaHorasAsignadas()
    {
        $reporte = $this->gestorHorarios->getHorasAsignadas($this->numeroDocumentoIngresado);

        if(empty($reporte))
            echo '<p>El usuario no está asociado a ningún área</p>';
        else
        {
            imprimirTabulados(5);
            echo '<div class="tablaTituloBotones">';

            imprimirTabulados(6);
            echo '<hr /><br /><h3>Horas asignadas</h3>';

            $tabla = new TablasHorasAsignadas($reporte, $this->numeroDocumentoIngresado);
            $tabla->imprimir();

            imprimirTabulados(5);
            echo '</div>';
        }
    }
}
?>
