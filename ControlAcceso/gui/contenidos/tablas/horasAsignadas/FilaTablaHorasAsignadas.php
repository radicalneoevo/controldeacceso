<?php

/**
 * Descripcion de FilaReporteHorasAsignadas
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 08-12-2009
 */
// TODO Buscar un mejor formato para guardar tiempo acumulado
class FilaTablaHorasAsignadas
{
    private $area;
    private $horasAsignadas;
    private $horasActualmenteAsignadas;

    function __construct()
    {
        $this->horasAsignadas = '00:00';
        $this->horasActualmenteAsignadas = '00:00';
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

    public function getHorasAsignadas()
    {
        return $this->horasAsignadas;
    }

    /**
     *
     * @param string $horasAsignadas
     */
    public function setHorasAsignadas($horasAsignadas)
    {
        $this->horasAsignadas = $horasAsignadas;
    }

    public function getHorasActualmenteAsignadas()
    {
        return $this->horasActualmenteAsignadas;
    }

    /**
     *
     * @param string $horasActualmenteAsignadas
     */
    public function setHorasActualmenteAsignadas($horasActualmenteAsignadas)
    {
        $this->horasActualmenteAsignadas = $horasActualmenteAsignadas;
    }

}
?>
