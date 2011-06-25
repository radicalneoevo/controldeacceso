<?php
require_once "Auth.php";
require_once "MDB2.php";

function formularioLogin($username = null, $status = null, &$auth = null)
{
    echo '<h1>Iniciar sesión</h1>';
    echo '<form method="post" action="pruebaLogin.php">';
    echo '<p>Usuario:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="username"></p>';
    echo '<p>Password:&nbsp;&nbsp;<input type="password" name="password"></p>';
    echo '<input type="submit" name="botonIniciarSesion" value="Iniciar sesión">';
    echo '</form>';
}

function formularioLogout()
{
    echo '<form method="post" action="pruebaLogin.php">';
    echo '<input type="submit" name="botonCerrarSesion" value="Cerrar sesión">';
    echo '</form>';
}

function mensajeLogout()
{
    echo '<h1>Ha cerrado sesión</h1>';
}

function mensajeLoginExitoso()
{
    echo '<h1>Ha iniciado sesión</h1>';
}

function mensajeLoginFallido()
{
    echo '<h1>No se pudo iniciar sesión</h1>';
}

$options = array("dsn" => "mysql://root:labsis@localhost/controlacceso",
                 "table" => "usuario",
                 "usernamecol" => "numeroDocumento",
                 "passwordcol" => "password",
                 "cryptType" => "sha1");

$autenticacion = new Auth("MDB2", $options, "formularioLogin");
$autenticacion->setLogoutCallback("mensajeLogout");
$autenticacion->setLoginCallback("mensajeLoginExitoso");
$autenticacion->setFailedLoginCallback("mensajeLoginFallido");
$autenticacion->start();

if($autenticacion->checkAuth())
{
    if(isset($_POST['botonCerrarSesion']))
    {
        $autenticacion->logout();
        $autenticacion->start();
    }
    else
    {
        echo '<p>Logueado como: ' . $autenticacion->getUsername() . '</p>';
        formularioLogout();
    }
}
?>
