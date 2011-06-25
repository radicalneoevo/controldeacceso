<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

/**
 * Dia de la semana y hora que normalmente cumple un usuario. Está asociado a
 * un período y área en particular.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Periodo
 * @see Area
 * @see DiaSemana
 */
class HorarioHabitual
{
    private $idHorarioHabitual;
    private $area;
    private $dia;
    private $ingreso;
    private $egreso;
    private $usuario;
    private $periodo;
    private $confirmado;

    function __construct()
    {

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

    /**
     *
     * @return DiaSemana
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     *
     * @param DiaSemana $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * Retorna la hora de ingreso como objeto DateTime
     * @return DateTime
     */
    public function getIngreso()
    {
        return $this->ingreso;
    }

    /**
     * Establece la hora de ingreso desde un string con la forma 'H:i'
     * @param string $ingreso
     */
    public function setIngreso($ingreso)
    {
        $ingreso = trim($ingreso);
        $ingreso = substr($ingreso, 0, 5);
        $ingreso = DateTime::createFromFormat('!H:i', $ingreso);

        if(!empty($ingreso))
            $this->ingreso = $ingreso;
        else
            throw new Exception('Hora de ingreso incorrecta');
    }

    /**
     * Retorna la hora de ingreso con formato 'H:i'
     * @return string
     */
    public function imprimirIngreso()
    {
        return $this->ingreso->format('H:i');
    }

    /**
     * Retorna la hora de egreso como objeto DateTime
     * @return DateTime
     */
    public function getEgreso()
    {
        return $this->egreso;
    }

    /**
     * Establece la hora de egreso desde un string con la forma 'H:i'
     * @param string $egreso
     */
    public function setEgreso($egreso)
    {
        $egreso = trim($egreso);
        $egreso = substr($egreso, 0, 5);
        $egreso = DateTime::createFromFormat('!H:i', $egreso);

        if(!empty($egreso))
            $this->egreso = $egreso;
        else
            throw new Exception('Hora de egreso incorrecta');
    }

    /**
     * Retorna la hora de egreso con formato 'H:i'
     * @return string
     */
    public function imprimirEgreso()
    {
        return $this->egreso->format('H:i');
    }

    /**
     *
     * @return integer
     */
    public function getIdHorarioHabitual()
    {
        return $this->idHorarioHabitual;
    }

    /**
     *
     * @param integer $idHorario
     */
    public function setIdHorarioHabitual($idHorarioHabitual)
    {
        $this->idHorarioHabitual = $idHorarioHabitual;
    }

    /**
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     *
     * @param Usuario $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     *
     * @param Horario $horario
     * @return boolean
     */
    public function igual($horario)
    {
        return $this->idHorario == $horario->getIdHorario();
    }

    public function getConfirmado()
    {
        return $this->confirmado;
    }

    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;
    }
    
}
?>
