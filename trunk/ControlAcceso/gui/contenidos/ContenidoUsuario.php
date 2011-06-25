<?php
include_once("control/GestorUsuarios.php");
require_once("HTML/Table.php");

/**
 * {@inheritdoc }
 */
class ContenidoUsuario extends Contenido
{
    /**
     * {@inheritdoc }
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * {@inheritdoc }
     */
    public function mostrarContenido()
    {
        imprimirTabulados(4);
        echo '<div id="contenido">';

        $this->imprimirTitulos();

        try
        {
            // Determina la acción a ejecutar
            // Muestra la ficha de usuario
            if(isset($_REQUEST["numeroDocumento"]))
                $this->imprimirUsuario();
            // Muestra el formulario para modificar un usuario
            elseif(isset($_REQUEST["modificarUsuario"]))
                $this->imprimirFormularioModificarUsuario();
            // Procesa la modificación de un usuario
            elseif(isset($_REQUEST["enviarModificarUsuario"]))
                $this->modificarUsuario();
            // Muestra el formulario para dar de alta un nuevo usuario
            elseif(isset($_REQUEST["nuevoUsuario"]))
                $this->imprimirFormularioNuevoUsuario();
            // Procesa el alta de un nuevo usuario
            elseif(isset($_REQUEST["enviarNuevoUsuario"]))
                $this->agregarUsuario();
            // Muestra la lista de usuarios en el sistema
            else
                $this->imprimirListaUsuarios();
        }
        catch(Exception $excepcion)
        {
            imprimirTabulados(5);
            echo '<h2>Se produjo un error al procesar la solicitud:</h2><br />';

            imprimirTabulados(5);
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
        echo '<h1>Usuarios</h1>';
       
        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra una lista con todos los usuarios del sistema.
     */
    // TODO Permitir ocultar los inactivos
    private function imprimirListaUsuarios()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Personal</h1>';

        $usuarios = $this->gestorUsuarios->getUsuarios();

        if(empty($usuarios))
        {
            imprimirTabulados(6);
            echo '<p>No hay usuarios cargados en el sistema</p>';

            // Cierra el contenedor tablaTituloBotones
            imprimirTabulados(5);
            echo '</div>';

            return;
        }

        $this->imprimirFormularioBusqueda();

        $clase = array('class' => 'tablaReporte');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        // Encabezado
        $tabla->setHeaderContents(0, 0, 'Nro');
        $tabla->setHeaderContents(0, 1, 'Apellido');
        $tabla->setHeaderContents(0, 2, 'Nombre');
        $tabla->setHeaderContents(0, 3, 'Area');
        $tabla->setRowAttributes(0, $clase, false);

        // Contenido
        for($fila = 0; $fila <= count($usuarios) - 1; $fila++)
        {
            $usuario = $usuarios[$fila];
            $tabla->setCellContents($fila + 1, 0, $fila + 1);
            $tabla->setCellContents($fila + 1, 1, '<a class="data" href="usuario.php?numeroDocumento='. $usuario->getNumeroDocumento() . '">' . $usuario->getApellido() . '</a>');
            $tabla->setCellContents($fila + 1, 2, $usuario->getNombre());
            $tabla->setCellContents($fila + 1, 3, $usuario->getNombreAreas());
            $tabla->setRowAttributes($fila + 1, $clase, false);
        }

        echo $tabla->toHtml();

        // Notas
        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>Click sobre el apellido para mayor información</p>';

        imprimirTabulados(6);
        echo '</div>';
        // Notas

        $this->imprimirBotonesPersonal();

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra un formulario para buscar usuarios.
     * Campos implementados: Número de documento.
     */
    private function imprimirFormularioBusqueda()
    {
        imprimirTabulados(5);
        echo '<form action="usuario.php" method="get">';

        imprimirTabulados(5);
        echo '<fieldset>';

        imprimirTabulados(5);
        echo '<legend>Buscar</legend>';

        imprimirTabulados(6);
        echo '<label for="numeroDocumento">Número de documento</label>';
        echo '<input class="campoTexto" id="numeroDocumento" type="text" name="numeroDocumento" value="" />';
        
        imprimirTabulados(6);
        echo '<input type="submit" name="botonConsultar"  value="Consultar" />';

        imprimirTabulados(5);
        echo '</fieldset>';

        imprimirTabulados(5);
        echo '</form>';
    }

    /**
     * Formulario con acciones disponibles para todo el personal.
     */
    private function imprimirBotonesPersonal()
    {
        imprimirTabulados(6);
        echo '<div class="contenedorBotones">';

        imprimirTabulados(6);
        echo '<form action="usuario.php" method="get">';

        imprimirTabulados(7);
        echo '<input type="submit" name="nuevoUsuario"  value="Nuevo usuario" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '</div>';
    }

    /**
     * Muestra la ficha de usuario.
     */
    private function imprimirUsuario()
    {
        $usuario = $this->gestorUsuarios->getUsuario($_REQUEST["numeroDocumento"]);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>' . $usuario->getNombre() . ' ' . $usuario->getApellido() . '</h1>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Tipo de documento');
        $tabla->setCellContents(0, 1, $usuario->getTipoDocumento());

        $tabla->setHeaderContents(1, 0, 'Número de documento');
        $tabla->setCellContents(1, 1, $usuario->getNumeroDocumento());

        $tabla->setHeaderContents(2, 0, 'Nombre');
        $tabla->setCellContents(2, 1, $usuario->getNombre());

        $tabla->setHeaderContents(3, 0, 'Segundo nombre');
        $tabla->setCellContents(3, 1, $usuario->getSegundoNombre());

        $tabla->setHeaderContents(4, 0, 'Apellido');
        $tabla->setCellContents(4, 1, $usuario->getApellido());

        $tabla->setHeaderContents(5, 0, 'Fecha de nacimiento');
        $tabla->setCellContents(5, 1, $usuario->getFechaNacimiento());

        $tabla->setHeaderContents(6, 0, 'Dirección');
        $tabla->setCellContents(6, 1, $usuario->getDireccion());

        $tabla->setHeaderContents(7, 0, 'Teléfono fijo');
        $tabla->setCellContents(7, 1, $usuario->getTelefonoFijo());

        $tabla->setHeaderContents(8, 0, 'Teléfono celular');
        $tabla->setCellContents(8, 1, $usuario->getTelefonoCelular());

        $tabla->setHeaderContents(9, 0, 'E-mail');
        $tabla->setCellContents(9, 1, $usuario->getEmail());

        $tabla->setHeaderContents(10, 0, 'Legajo');
        $tabla->setCellContents(10, 1, $usuario->getLegajo());

        $areas = '';
        foreach($usuario->getArea() as $value)
            $areas = $areas . $value->getNombreArea() . '<br />';

        $tabla->setHeaderContents(11, 0, 'Área');
        $tabla->setCellContents(11, 1, $areas);

        $tabla->setHeaderContents(12, 0, 'Tipo de usuario');
        $tabla->setCellContents(12, 1, $usuario->getNivel()->getNombre());

        $tabla->setHeaderContents(13, 0, 'Activo');
        $tabla->setCellContents(13, 1, ($usuario->getActivo() ? 'Si' : 'No'));

        $tabla->setHeaderContents(14, 0, 'Notas');
        $tabla->setCellContents(14, 1, $usuario->getNotas());

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, array('class' => 'tablaReporte'));

        echo $tabla->toHtml();

        $this->imprimirBotonesUsuario($usuario->getNumeroDocumento());

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra las acciones disponibles para un usuario.
     * @param integer $numeroDocumento
     */
    private function imprimirBotonesUsuario($numeroDocumento)
    {
        imprimirTabulados(6);
        echo '<div class="contenedorBotones">';
        
        imprimirTabulados(6);
        echo '<form class="soloBoton" action="usuario.php" method="get">';

        imprimirTabulados(7);
        echo '<input type="hidden" name="numeroDocumentoEditar"  value="' . $numeroDocumento . '" />';
        imprimirTabulados(7);
        echo '<input type="submit" name="modificarUsuario"  value="Modificar datos" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '<form class="soloBoton" action="horariohabitual.php" method="get">';
        
        imprimirTabulados(7);
        echo '<input type="hidden" name="numeroDocumento"  value="' . $numeroDocumento . '" />';

        imprimirTabulados(7);
        echo '<input type="submit" name="botonAsignarHorario" value="Asignar horario habitual" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '<form class="soloBoton" action="horarioasignado.php" method="get">';

        imprimirTabulados(7);
        echo '<input type="hidden" name="numeroDocumento"  value="' . $numeroDocumento . '" />';

        imprimirTabulados(7);
        echo '<input type="submit" name="botonAsignarHorario" value="Modificar horario" />';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '</div>';
    }

    /**
     * Muestra el formulario para editar los datos del usuario.
     */
    private function imprimirFormularioModificarUsuario()
    {
        $usuario = $this->gestorUsuarios->getUsuario($_REQUEST["numeroDocumentoEditar"]);

        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>' . $usuario->getNombre() . ' ' . $usuario->getApellido() . '</h1>';

        imprimirTabulados(6);
        echo '<form action="usuario.php" method="post">';

        imprimirTabulados(6);
        echo '<fieldset>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Tipo de documento');
        $tabla->setCellContents(0, 1, '<select class="cuadroSeleccionAlineado" name="tipoDocumento"><option>DNI</option><option>LE</option><option>LC</option></select>');

        $tabla->setHeaderContents(1, 0, 'Número de documento *');
        $tabla->setCellContents(1, 1, $usuario->getNumeroDocumento());

        $tabla->setHeaderContents(2, 0, 'Nombre *');
        $tabla->setCellContents(2, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="nombre" value="' . $usuario->getNombre() . '" />');

        $tabla->setHeaderContents(3, 0, 'Segundo nombre');
        $tabla->setCellContents(3, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="segundoNombre" value="' . $usuario->getSegundoNombre() . '" />');

        $tabla->setHeaderContents(4, 0, 'Apellido *');
        $tabla->setCellContents(4, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="apellido" value="' . $usuario->getApellido() . '" />');

        $tabla->setHeaderContents(5, 0, 'Fecha de nacimiento *');
        $tabla->setCellContents(5, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="fechaNacimiento" value="' . $usuario->getFechaNacimiento() . '" />');

        $tabla->setHeaderContents(6, 0, 'Dirección *');
        $tabla->setCellContents(6, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="direccion" value="' . $usuario->getDireccion() . '" />');

        $tabla->setHeaderContents(7, 0, 'Teléfono fijo');
        $tabla->setCellContents(7, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="telefonoFijo" value="' . $usuario->getTelefonoFijo() . '" />');

        $tabla->setHeaderContents(8, 0, 'Teléfono celular');
        $tabla->setCellContents(8, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="telefonoCelular" value="' . $usuario->getTelefonoCelular() . '" />');

        $tabla->setHeaderContents(9, 0, 'E-mail *');
        $tabla->setCellContents(9, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="email" value="' . $usuario->getEmail() . '" />');

        $tabla->setHeaderContents(10, 0, 'Legajo *');
        $tabla->setCellContents(10, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="legajo" value="' . $usuario->getLegajo() . '" />');

        $tabla->setHeaderContents(11, 0, 'Área *');
        $tabla->setCellContents(11, 1, $this->mostrarAreasMultipleSeleccion($usuario));

        $tabla->setHeaderContents(12, 0, 'Tipo de usuario');
        $tabla->setCellContents(12, 1, $this->mostrarNiveles($usuario));

        $activo = '<select class="cuadroSeleccionAlineado" name="activo">' .
                  '<option value="1"' . ($usuario->getActivo() ? ' selected' : '') . '>Si</option>' .
                  '<option value="0"' . (!$usuario->getActivo() ? ' selected' : '') . '>No</option></select>';
        
        $tabla->setHeaderContents(13, 0, 'Activo');
        $tabla->setCellContents(13, 1, $activo);

        $tabla->setHeaderContents(14, 0, 'Notas');
        $tabla->setCellContents(14, 1, '<textarea class="areaTexto" name="notas" rows="4" cols="20">' . $usuario->getNotas() . '</textarea>');

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, $clase);

        echo $tabla->toHtml();

        imprimirTabulados(6);
        echo '<input type="hidden" name="numeroDocumentoEditar"  value="' . $usuario->getNumeroDocumento() . '" />';

        imprimirTabulados(6);
        echo '<br /><input type="submit" name="enviarModificarUsuario"  value="Enviar" />';

        imprimirTabulados(6);
        echo '</fieldset>';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>(*) Campos obligatorios</p>';

        imprimirTabulados(6);
        echo '</div>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Muestra el formulario para dar de alta un nuevo usuario.
     */
    private function imprimirFormularioNuevoUsuario()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h1>Nuevo usuario</h1>';

        imprimirTabulados(6);
        echo '<form action="usuario.php" method="post">';

        imprimirTabulados(6);
        echo '<fieldset>';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Tipo de documento');
        $tabla->setCellContents(0, 1, '<select class="cuadroSeleccion cuadroSeleccionAlineado" name="tipoDocumento"><option>DNI</option><option>LE</option><option>LC</option></select>');

        $tabla->setHeaderContents(1, 0, 'Número de documento *');
        $tabla->setCellContents(1, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="numeroDocumentoNuevo" value="" />');

        $tabla->setHeaderContents(2, 0, 'Nombre *');
        $tabla->setCellContents(2, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="nombre" value="" />');

        $tabla->setHeaderContents(3, 0, 'Segundo nombre');
        $tabla->setCellContents(3, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="segundoNombre" value="" />');

        $tabla->setHeaderContents(4, 0, 'Apellido *');
        $tabla->setCellContents(4, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="apellido" value="" />');

        $tabla->setHeaderContents(5, 0, 'Fecha de nacimiento *');
        $tabla->setCellContents(5, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="fechaNacimiento" value="DD-MM-AAAA" />');

        $tabla->setHeaderContents(6, 0, 'Dirección *');
        $tabla->setCellContents(6, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="direccion" value="" />');

        $tabla->setHeaderContents(7, 0, 'Teléfono fijo');
        $tabla->setCellContents(7, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="telefonoFijo" value="" />');

        $tabla->setHeaderContents(8, 0, 'Teléfono celular');
        $tabla->setCellContents(8, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="telefonoCelular" value="" />');

        $tabla->setHeaderContents(9, 0, 'E-mail *');
        $tabla->setCellContents(9, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="email" value="" />');

        $tabla->setHeaderContents(10, 0, 'Legajo *');
        $tabla->setCellContents(10, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="legajo" value="" />');

        $tabla->setHeaderContents(11, 0, 'Área *');
        $tabla->setCellContents(11, 1, $this->mostrarAreasMultipleSeleccion());

        $tabla->setHeaderContents(12, 0, 'Tipo de usuario');
        $tabla->setCellContents(12, 1, $this->mostrarNiveles());

        $tabla->setHeaderContents(13, 0, 'Activo');
        $tabla->setCellContents(13, 1, '<select class="cuadroSeleccionAlineado" name="activo"><option value="1">Si</option><option value="0">No</option></select>');

        $tabla->setHeaderContents(14, 0, 'Notas');
        $tabla->setCellContents(14, 1, '<textarea class="areaTexto" name="notas" rows="4" cols="20"></textarea>');

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, $clase);

        echo $tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><input type="submit" name="enviarNuevoUsuario"  value="Enviar" >';

        imprimirTabulados(6);
        echo '</fieldset>';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>(*) Campos obligatorios</p>';

        imprimirTabulados(6);
        echo '</div>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Realiza las validaciones necesarias y agrega un nuevo usuario al sistema.
     * Informa errores mediante excepciones.
     */
    private function agregarUsuario()
    {
        // Estos campos deberían ser consistentes con los NOT NULL de la BD
        if(!empty($_REQUEST['tipoDocumento']) && !empty($_REQUEST['numeroDocumentoNuevo']) &&
           !empty($_REQUEST['nombre']) && !empty($_REQUEST['apellido']) &&
           !empty($_REQUEST['fechaNacimiento']) && !empty($_REQUEST['direccion']) &&
           !empty($_REQUEST['email']) && !empty($_REQUEST['legajo']) &&
           !empty($_REQUEST['area']) && isset($_REQUEST['tipoUsuario']) &&
            isset($_REQUEST['activo']))
        {
            $nuevoUsuario = new Usuario();
            $nuevoUsuario->setTipoDocumento($_REQUEST['tipoDocumento']);
            $nuevoUsuario->setNumeroDocumento($_REQUEST['numeroDocumentoNuevo']);
            $nuevoUsuario->setNombre($_REQUEST['nombre']);

            if(isset($_REQUEST['segundoNombre']))
                $nuevoUsuario->setSegundoNombre($_REQUEST['segundoNombre']);

            $nuevoUsuario->setApellido($_REQUEST['apellido']);
            $nuevoUsuario->setFechaNacimiento($_REQUEST['fechaNacimiento']);
            $nuevoUsuario->setDireccion($_REQUEST['direccion']);

            if(isset($_REQUEST['telefonoFijo']))
                $nuevoUsuario->setTelefonoFijo($_REQUEST['telefonoFijo']);

            if(isset($_REQUEST['telefonoCelular']))
                $nuevoUsuario->setTelefonoCelular($_REQUEST['telefonoCelular']);

            $nuevoUsuario->setEmail($_REQUEST['email']);

            $nuevoUsuario->setLegajo($_REQUEST['legajo']);

            $areas = array();
            foreach($_REQUEST['area'] as $value)
                array_push($areas, $this->gestorAreas->getArea($value));
            $nuevoUsuario->setArea($areas);

            $nuevoUsuario->setNivel($this->gestorNiveles->getNivel($_REQUEST['tipoUsuario']));

            if(isset($_REQUEST['notas']))
                $nuevoUsuario->setNotas($_REQUEST['notas']);

            if($_REQUEST['activo'] == 0 || $_REQUEST['activo'] == 1)
                $nuevoUsuario->setActivo($_REQUEST['activo']);
            else
                throw new Exception('El estado del usuario es incorrecto');

            $this->gestorUsuarios->insertarUsuario($nuevoUsuario);

            echo '<h2>Usuario agregado exitosamente</h2>';
            echo '<h3>La contraseña por defecto es: 12345678</h3>';

            $this->imprimirListaUsuarios();
        }
        else
            throw new Exception('No se especificó un campo obligatorio');
    }

    /**
     * Realiza las validaciones necesarias y modifica un usuario existente en el sistema.
     * Informa errores mediante excepciones.
     */
    private function modificarUsuario()
    {
        // Estos campos deberían ser consistentes con los NOT NULL de la BD
        if(!empty($_REQUEST['tipoDocumento']) &&
           !empty($_REQUEST['nombre']) && !empty($_REQUEST['apellido']) &&
           !empty($_REQUEST['fechaNacimiento']) && !empty($_REQUEST['direccion']) &&
           !empty($_REQUEST['email']) && !empty($_REQUEST['legajo']) &&
           !empty($_REQUEST['area']) && isset($_REQUEST['tipoUsuario']) &&
            isset($_REQUEST['activo']))
        {
            if(!empty($_REQUEST['numeroDocumentoEditar']))
                $usuario = $this->gestorUsuarios->getUsuario($_REQUEST["numeroDocumentoEditar"]);
            
            $usuario->setTipoDocumento($_REQUEST['tipoDocumento']);
            $usuario->setNombre($_REQUEST['nombre']);

            if(isset($_REQUEST['segundoNombre']))
                $usuario->setSegundoNombre($_REQUEST['segundoNombre']);

            $usuario->setApellido($_REQUEST['apellido']);
            $usuario->setFechaNacimiento($_REQUEST['fechaNacimiento']);
            $usuario->setDireccion($_REQUEST['direccion']);

            if(isset($_REQUEST['telefonoFijo']))
                $usuario->setTelefonoFijo($_REQUEST['telefonoFijo']);

            if(isset($_REQUEST['telefonoCelular']))
                $usuario->setTelefonoCelular($_REQUEST['telefonoCelular']);

            $usuario->setEmail($_REQUEST['email']);

            $usuario->setLegajo($_REQUEST['legajo']);

            $areas = array();
            foreach($_REQUEST['area'] as $value)
                array_push($areas, $this->gestorAreas->getArea($value));
            $usuario->setArea($areas);

            $usuario->setNivel($this->gestorNiveles->getNivel($_REQUEST['tipoUsuario']));

            if(isset($_REQUEST['notas']))
                $usuario->setNotas($_REQUEST['notas']);

            if($_REQUEST['activo'] == 0 || $_REQUEST['activo'] == 1)
                $usuario->setActivo($_REQUEST['activo']);
            else
                throw new Exception('El estado del usuario es incorrecto');

            $this->gestorUsuarios->modificarUsuario($usuario);

            echo '<h2>Usuario modificado exitosamente</h2>';

            $this->imprimirListaUsuarios();
        }
        else
            throw new Exception('No se especificó un campo obligatorio');
    }
}
?>
