<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

require_once("Auth.php");
require_once("MDB2.php");
include_once("gui/Pagina.php");
include_once("gui/CuerpoLogin.php");
include_once("gui/CabeceraLogin.php");
include_once("gui/PiePaginaLogin.php");
include_once("control/GestorUsuarios.php");
include_once("entidad/Usuario.php");

/*
 * Gestiona el login requerido para cada pantalla.
 */

// TODO ver si se puede encapsular todo esto
function formularioLogin($username = null, $status = null, &$auth = null)
{
    $pagina = new Pagina("Control de acceso - Inicio");
    $pagina->setCabecera(new CabeceraLogin());
    $pagina->setCuerpo(new CuerpoLogin());
    $pagina->setPiePagina(new PiePaginaLogin());
    $pagina->mostrarPagina();
}

function mensajeLogout()
{
    $pagina = new Pagina("Control de acceso - Inicio");
    $pagina->setCabecera(new CabeceraLogin());
    $cuerpo = new CuerpoLogin();
    $cuerpo->setMensaje("Sesión cerrada");
    $pagina->setCuerpo($cuerpo);
    $pagina->setPiePagina(new PiePaginaLogin());
    $pagina->mostrarPagina();
}

function mensajeLoginExitoso()
{
    $gestorUsuarios = new GestorUsuarios();
    $usuario = $gestorUsuarios->getUsuario($_REQUEST['username']);
    $autenticacion = $GLOBALS['autenticacion'];
    $autenticacion->setAuthData('usuario', $usuario->getNombre() . ' ' . $usuario->getApellido());
}

function mensajeLoginFallido()
{
    echo "Datos incorrectos";
}

// Opciones de configuración del objeto Auth
$options = array("dsn" => "mysql://root:labsis@localhost/controlacceso",
                 "table" => "usuario",
                 "usernamecol" => "numeroDocumento",
                 "passwordcol" => "password",
                 "cryptType" => "sha1");

$autenticacion = new Auth("MDB2", $options, "formularioLogin");

// Asocia las funciones principales
$autenticacion->setLogoutCallback("mensajeLogout");
$autenticacion->setLoginCallback("mensajeLoginExitoso");
$autenticacion->setFailedLoginCallback("mensajeLoginFallido");

// Inicia el proceso de autenticación, sino hay una sesión abierta despliega una
// pantalla de login
$autenticacion->start();

?>
