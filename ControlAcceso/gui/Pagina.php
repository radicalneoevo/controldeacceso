<?php
include_once("Utilidades.php");
include_once("Cabecera.php");
include_once("Cuerpo.php");
include_once("PiePagina.php");

/**
 * Página del sitio genérica.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 */
// TODO agregar hoja de estilos de impresion
class Pagina
{
    // Etiquetas de la cabecera
    protected $title;

    // Etiquetas meta
    protected $contentType;
    protected $author;
    protected $robots;
    protected $description;

    // Etiquetas link
    protected $favicon;
    
    /**
     * Arreglo de 
     * @var array
     */
    protected $hojasEstilos;

    // Etiquetas script
    /**
     * Arreglo de rutas a scripts
     * @var array
     */
    protected $scripts;
    // Etiquetas de la cabecera


    // Secciones del sitio
    /**
     * Sección superior del sitio.
     * @var Cabecera
     */
    protected $cabecera;

    /**
     * Sección central del sitio.
     * @var Cuerpo
     */
    protected $cuerpo;

    /**
     * Sección inferior del sitio
     * @var PiePagina
     */
    protected $piePagina;
    // Secciones del sitio

    function __construct($titulo)
    {
        $this->title = $titulo;

        // Etiquetas meta
        $this->contentType = 'text/html; charset=UTF-8';
        $this->author = 'Savoie Ramiro';
        $this->robots = 'noindex, nofollow';
        $this->description = 'Sistema de control de acceso de personal del Laborario de sistemas';

        // Etiquetas link
        $this->favicon = 'recursos/favicon.ico';
        $this->hojasEstilos = array();
        $this->agregarHojasEstilos('css/controlacceso.css', 'screen,projection');
        $this->agregarHojasEstilos('gui/calendario/calendar-green.css', 'screen,projection');

        // Etiquetas script
        $this->scripts = array();

        // Secciones del sitio
        $this->cabecera = new Cabecera();
        $this->cuerpo = new Cuerpo();
        $this->piePagina = new PiePagina();
    }

    /**
     *
     * @param string $value Texto encerrado por la etiqueta.
     */
    public function setTitle($value)
    {
        $this->title = $value;
    }

    private function mostrarTitle()
    {
        imprimirTabulados(2);
        echo '<title>' . $this->title . '</title>';
    }

    /**
     *
     * @param string $contentType Valor del atributo content
     */
    public function  setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    private function mostrarContentType()
    {
        imprimirTabulados(2);
        echo '<meta http-equiv="content-type" content="' . $this->contentType . '" />';
    }

    /**
     *
     * @param string $author Valor del atributo content
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    private function mostrarAuthor()
    {
        imprimirTabulados(2);
        echo '<meta name="author" content="' . $this->author . '" />';
    }

    /**
     *
     * @param string $robots Valor del atributo content
     */
    public function setRobots($robots)
    {
        $this->robots = $robots;
    }

    private function mostrarRobots()
    {
        imprimirTabulados(2);
        echo '<meta name="robots" content="' . $this->robots . '" />';
    }

    /**
     *
     * @param string $description Valor del atributo content
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    private function mostrarDescription()
    {
        imprimirTabulados(2);
        echo '<meta name="description" content="' . $this->description . '" />';
    }

    /**
     *
     * @param string $favicon Valor del atributo href
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;
    }

    public function mostrarFavicon()
    {
        imprimirTabulados(2);
        echo '<link href="' . $this->favicon . '" rel="icon" type="image/ico" />';
    }

    /**
     *
     * @param string $href Valor del atributo href
     * @param string $media Valor del atributo media
     * @param string $title Valor del atributo title
     */
    public function agregarHojasEstilos($href, $media)
    {
        $hojaEstilos = array($href, $media);
        array_push($this->hojasEstilos, $hojaEstilos);
    }

    public function mostrarHojasEstilos()
    {
        if(empty($this->hojasEstilos))
            return;
        else
            foreach($this->hojasEstilos as $hojaEstilos)
            {
                imprimirTabulados(2);
                echo '<link href="' . $hojaEstilos[0] . '" rel="stylesheet" type="text/css" media="' . $hojaEstilos[1] . '" />';
            }
    }

    /**
     *
     * @param string $script Valor del atributo src
     */
    public function agregarScript($script)
    {
        array_push($this->scripts, $script);
    }

    public function mostrarScripts()
    {
        if(empty($this->scripts))
            return;
        else
            foreach($this->scripts as $value)
            {
                imprimirTabulados(2);
                echo '<script type="text/javascript" src="' . $value . '"></script>';
            }
    }

    public function mostrarPagina()
    {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        echo "\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">';
        $this->mostrarHead();
        $this->mostrarBody();
        echo '</html>';
    }

    public function mostrarHead()
    {
        echo "\n\t<head>";
        $this->mostrarTitle();
        // Etiquetas meta
        $this->mostrarContentType();
        $this->mostrarAuthor();
        $this->mostrarRobots();
        $this->mostrarDescription();

        // Etiquetas link
        $this->mostrarFavicon();
        $this->mostrarHojasEstilos();

        // Etiquetas scripts
        $this->mostrarScripts();
        echo "\n\t</head>";
    }

    public function mostrarBody()
    {
        echo "\n\t<body>";
        $this->mostrarWrapper();
        echo "\n\t</body>\n";
    }

    public function mostrarWrapper()
    {
        imprimirTabulados(2);
        echo '<div id="wrapper">';

        $this->cabecera->mostrarCabecera();
        $this->cuerpo->mostrarCuerpo();
        $this->piePagina->mostrarPiePagina();

        imprimirTabulados(2);
        echo '</div>';
    }

    public function setCabecera($cabecera)
    {
        $this->cabecera = $cabecera;
    }

    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;
    }

    public function setPiePagina($piepagina)
    {
        $this->piePagina = $piepagina;
    }

    public function getCabecera()
    {
        return $this->cabecera;
    }

    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    public function getPiePagina()
    {
        return $this->piePagina;
    }
}
?>
