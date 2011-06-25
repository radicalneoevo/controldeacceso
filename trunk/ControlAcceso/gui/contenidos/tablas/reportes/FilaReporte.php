<?php
/**
 * Description of FilaReporte
 *
 * @author Ramiro
 */
class FilaReporte
{
    protected $nombre;
    protected $apellido;
    protected $numeroDocumento;
    protected $area;

    function __construct()
    {

    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     *
     * @param string $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     *
     * @return Area
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     *
     * @param Area $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    public function imprimirCabecera()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<th class="tablaReporte">Nombre</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Apellido</th>';
        imprimirTabulados(7);
        echo '<th class="tablaReporte">Area</th>';

        imprimirTabulados(6);
        echo '</tr>';
    }

    public function imprimir()
    {
        imprimirTabulados(6);
        echo '<tr>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">'. $this->getNombre() . '</td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte"><a class="data" href="usuario.php?numeroDocumento='. $this->getNumeroDocumento() . '">' . $this->getApellido() . '</a></td>';

        imprimirTabulados(7);
        echo '<td class="tablaReporte">' . $this->area->getNombreArea() . '</td>';

        imprimirTabulados(6);
        echo '</tr>';
    }

    public function imprimirNotas()
    {
        imprimirTabulados(6);
        echo '<div class="notas">';

        imprimirTabulados(7);
        echo '<p>Click sobre el apellido para mayor información</p>';

        imprimirTabulados(6);
        echo '</div>';
    }
}
?>
