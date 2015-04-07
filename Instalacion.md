# Instalación #

---

## 1) Instalación del Panel de control web ##

**Requisitos:**
  * Apache 2.2.13
  * MySQL 5.1.38
  * PHP 5.3
  * PEAR 1.9.0
    * Auth 1.6.2
    * DB 1.7.14RC1 beta
    * HTML\_Common 1.2.5
    * HTML\_Table 1.8.2
    * MDB2 2.5.0b2 beta
    * MDB2\_Driver\_mysql 1.5.0b2 beta

Para que el servidor MySQL sea accesible externamente hay que poner lo siguiente en el archivo **my.conf**
```
bind-address    = 0.0.0.0
# skip-networking
```

**Instrucciones:**
  1. Descomprimir el archivo _UniServer.rar_
  1. Dentro de la carpeta descomprimida, iniciar el servidor con _"Start.exe"_, va a aparecer un icono azul en el área de notificación
  1. Click derecho sobre el icono del servidor y luego en _"Install and Run All Services"_, se va abrir el navegador por defecto con la página principal del Servidor WAMP
  1. Click en _"Server Administration"_, loguearse con los datos provistos
  1. En el panel de control de web, en la izquierda en _"Tools"_, ir a la opción _phpMyAdmin_
  1. En la pestaña _"SQL"_ correr el script con la base de datos
  1. Ir a la carpeta donde se descomprimió el Servidor WAMP y luego a _www_, allí pegar la carpeta _"controlacceso"_ con el código
  1. Editar los datos de conexión a la Base de datos en la clase _DAO.php_ dentro de _controlacceso/dao_
  1. Editar los datos de autenticación HTTP en el archivo _login.php_ dentro de _controlacceso_
  1. Acceder a la aplicación en la URL http://hostservidorweb/controlacceso/

---

## 2) Instalación del Cliente ##



**Requisitos:**
  * .NET FRAMEWORK 3.5
  * Mysql .NET CONNECTOR

Hay algunos parametros de la base de datos que deben cambiarse antes de hacer un **publish**. En el archivo app.conf.
```
<appSettings file="db.config">
    <add key="dbLocation" value="192.168.1.101" />
    <add key="dbUser" value="cliente" />
    <add key="ClientSettingsProvider.ServiceUri" value="" />
</appSettings>
```


---



