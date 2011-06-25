<?php
include_once("Cuerpo.php");
require_once("HTML/Table.php");

/**
 * Sección central del sitio para usuarios no autenticados.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 01-04-2010
 * @version 0.5
 */
class CuerpoLogin extends Cuerpo
{
    protected $mensaje;

    /**
     * Constructor por defecto.
     */
    function __construct()
    {

    }

    public function mostrarCuerpo()
    {
        imprimirTabulados(3);
        echo '<div id="cuerpo">';

        if(isset($this->mensaje))
            echo "<h1>$this->mensaje</h1>";

        $this->imprimirFormularioLogin();

        echo '<div style="clear: both; height: 1px"></div>';

        imprimirTabulados(3);
        echo '</div>';
    }

    /**
     * Muestra el formulario para iniciar sesión.
     */
    private function imprimirFormularioLogin()
    {
        imprimirTabulados(5);
        echo '<div class="tablaTituloBotones">';

        imprimirTabulados(6);
        echo '<h2>Iniciar sesión</h2>';

        imprimirTabulados(6);
        echo '<form action="index.php" method="post">';

        imprimirTabulados(6);
        echo '<fieldset class="login">';

        imprimirTabulados(6);
        $clase = array('class' => 'tablaCarga');
        $tabla = new HTML_Table($clase);
        $tabla->setAutoGrow(true);

        $tabla->setHeaderContents(0, 0, 'Usuario');
        $tabla->setCellContents(0, 1, '<input class="campoTexto campoTextoAlineado" type="text" name="username" value="" />');

        $tabla->setHeaderContents(1, 0, 'Contraseña');
        $tabla->setCellContents(1, 1, '<input class="campoTexto campoTextoAlineado" type="password" name="password" value="" />');

        $tabla->setColAttributes(0, $clase);
        $tabla->setColAttributes(1, $clase);

        echo $tabla->toHtml();

        imprimirTabulados(6);
        echo '<br /><input type="submit" name="botonIniciarSesion"  value="Iniciar sesión" >';

        imprimirTabulados(6);
        echo '</fieldset>';

        imprimirTabulados(6);
        echo '</form>';

        imprimirTabulados(5);
        echo '</div>';
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }
}
?>
