<?php
include_once("control/GestorUsuarios.php");
include_once("control/GestorAreas.php");
include_once("control/GestorNiveles.php");

/**
 * En esta sección se despliega el contenido principal del sitio, cada pantalla
 * implementa un contenido específico según su función.
 * 
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
class Contenido
{
    /**
     * Controlador
     * @var GestorUsuarios
     */
    protected $gestorUsuarios;

    /**
     * Controlador
     * @var GestorAreas
     */
    protected $gestorAreas;

    /**
     * Controlador
     * @var GestorNiveles
     */
    protected $gestorNiveles;

    /**
     * Constructor por defecto. Inicializa los controladores.
     */
    function __construct()
    {
        $this->gestorUsuarios = new GestorUsuarios();
        $this->gestorAreas = new GestorAreas();
        $this->gestorNiveles = new GestorNiveles();
    }

    /**
     * Muestra la caja de contenido.
     */
    public function mostrarContenido()
    {
        imprimirTabulados(4);
        echo '<div id="contenido">';

        $this->imprimirTitulos();

        // Contenido dinámico

        imprimirTabulados(4);
        echo '</div>';
    }

    /**
     * Título principal y subtítulos.
     */
    private function imprimirTitulos()
    {
        imprimirTabulados(5);
        echo '<div id="titulos">';

        imprimirTabulados(6);
        echo '<h1>Bienvenido al sistema de control de acceso de personal</h1>';

        imprimirTabulados(6);
        echo '<h2>Novedades:</h2>';

        imprimirTabulados(5);
        echo '</div>';
    }

    /**
     * Imprime un menú desplegable con los dias de la semana y sus respectivos códigos.
     * Estandar ODBC: Domingo = 1, Lunes = 2, etc.
     * @param string $diaSeleccionado Cadena con el nombre del día a seleccionar
     * Default: Lunes
     * @return string Lista HTML de selección simple.
     */
    protected function mostrarDias($diaSeleccionado)
    {
        if(empty($diaSeleccionado))
            $diaSeleccionado = 'Lunes';

        $salida = '<select name="dia" >';

        $salida = $salida . '<option value="1" '. (strcmp($diaSeleccionado, 'Domingo') == 0 ? 'selected' : '') . ' >Domingo</option>';
        $salida = $salida . '<option value="2" '. (strcmp($diaSeleccionado, 'Lunes') == 0 ? 'selected' : '') . ' >Lunes</option>';
        $salida = $salida . '<option value="3" '. (strcmp($diaSeleccionado, 'Martes') == 0 ? 'selected' : '') . ' >Martes</option>';
        $salida = $salida . '<option value="4" '. (strcmp($diaSeleccionado, 'Miercoles') == 0 ? 'selected' : '') . ' >Miercoles</option>';
        $salida = $salida . '<option value="5" '. (strcmp($diaSeleccionado, 'Jueves') == 0 ? 'selected' : '') . ' >Jueves</option>';
        $salida = $salida . '<option value="6" '. (strcmp($diaSeleccionado, 'Viernes') == 0 ? 'selected' : '') . ' >Viernes</option>';
        $salida = $salida . '<option value="7" '. (strcmp($diaSeleccionado, 'Sabado') == 0 ? 'selected' : '') . ' >Sabado</option>';

        $salida = $salida . '</select>';

        return $salida;
    }

    /**
     * Imprime un menú desplegable con las áreas disponibles en el sistema y sus respectivos códigos.
     * @return string Lista HTML de selección simple.
     */
    protected function mostrarAreasSimpleSeleccion()
    {
        $areas = $this->gestorAreas->getAreas();

        $salida = '<select class="cuadroSeleccionAlineado" name="area">';

        foreach ($areas as $value)
        {
            $salida = $salida . '<option value="' . $value->getIdArea() . '">' .
                    $value->getNombreArea() . '</option>';
        }

        $salida = $salida . '</select>';

        return $salida;
    }

    /**
     * Imprime un menú desplegable con las áreas disponibles en el sistema y sus respectivos códigos.
     * Añade la opción todas (código 0).
     * @return string Lista HTML de selección simple.
     */
    protected function mostrarAreasSimpleSeleccionTodas()
    {
        $areas = $this->gestorAreas->getAreas();

        $salida = '<select class="cuadroSeleccionAlineado" name="area">';

        $salida = $salida . '<option value="0">Todas</option>';

        foreach ($areas as $value)
        {
            $salida = $salida . '<option value="' . $value->getIdArea() . '">' .
                    $value->getNombreArea() . '</option>';
        }

        $salida = $salida . '</select>';

        return $salida;
    }

    /**
     * Imprime un menú desplegable con las áreas disponibles en el sistema y sus respectivos códigos.
     * @param $usuario Usuario del que se extraen las áreas a seleccionar por defecto.
     * @return string Lista HTML de selección múltiple.
     */
    protected function mostrarAreasMultipleSeleccion($usuario)
    {
        $areas = $this->gestorAreas->getAreas();

        $salida = '<select class="cuadroSeleccionAlineado" name="area[]" multiple>';

        // Nuevo usuario
        if(empty($usuario))
            foreach($areas as $value)
                $salida = $salida . '<option value="' . $value->getIdArea() . '">' .
                          $value->getNombreArea() . '</option>';
        // Usuario existente
        else
            foreach($areas as $value)
                $salida = $salida . '<option value="' . $value->getIdArea() . '"' . 
                          ($usuario->perteneceAlArea($value) ? ' selected' : '') . '>' .
                          $value->getNombreArea() . '</option>';

        $salida = $salida . '</select>';

        return $salida;
    }

    /**
     * Imprime un menú desplegable con las niveles disponibles en el sistema y sus respectivos códigos.
     * @param $usuario Usuario del que se extrae el nivel a seleccionar por defecto.
     * @return string Lista HTML de selección simple.
     */
    protected function mostrarNiveles($usuario)
    {
        $niveles = $this->gestorNiveles->getNiveles();

        $salida = '<select class="cuadroSeleccionAlineado" name="tipoUsuario">';

        // Nuevo usuario
        if(empty($usuario))
            foreach ($niveles as $value)
                $salida = $salida . '<option value="' . $value->getIdNivel() . '">' .
                          $value->getNombre() . '</option>';
        // Usuario existente
        else
            foreach ($niveles as $value)
                $salida = $salida . '<option value="' . $value->getIdNivel() . '"' .
                          ($usuario->perteneceAlNivel($value) ? ' selected' : '') . '>' .
                          $value->getNombre() . '</option>';

        $salida = $salida . '</select>';

        return $salida;
    }
}
?>
