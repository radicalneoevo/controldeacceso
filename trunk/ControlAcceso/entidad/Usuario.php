<?php
/*
 * Universidad Tecnológica Nacional - Facultad Regional Santa Fe
 * Laboratorio de Sistemas - Sistema de control de acceso de personal
 */

include_once("gui/Utilidades.php");

/**
 * Usuario del sistema.
 *
 * @author Ramiro Savoie (rsavo84@gmail.com)
 * @since 10-11-2009
 * @version 0.5
 * @see Area
 * @see Nivel
 */
// TODO Buscar para parsear numeros
class Usuario
{

    /**
     * @var string Tipo de documento (DNI, LE o LC)
     */
    private $tipoDocumento;

    
    private $numeroDocumento;
    private $nombre;
    private $segundoNombre;
    private $apellido;
    private $fechaNacimiento;
    private $direccion;
    private $telefonoFijo;
    private $telefonoCelular;
    private $email;
    private $legajo;
    private $foto;
    private $area; // Array de areas
    private $nivel;
    private $notas;
    private $activo;

    function __construct()
    {

    }

    /**
     *
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    /**
     *
     * @param string $tipoDocumento
     */
    public function setTipoDocumento($tipoDocumento)
    {
        $tipoDocumento = trim($tipoDocumento);
        $tipoDocumento = strtoupper($tipoDocumento);

        if(strcmp($tipoDocumento, 'DNI') == 0 || strcmp($tipoDocumento, 'LE') == 0 ||
           strcmp($tipoDocumento, 'LC') == 0)
            $this->tipoDocumento = $tipoDocumento;
        else
            throw new Exception('El tipo de documento debe ser DNI, LE o LC');
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
        $numeroDocumento = trim($numeroDocumento);

        if(intVal($numeroDocumento) != 0)
            if(strlen($numeroDocumento) >= 7 && strlen($numeroDocumento) <= 8)
                $this->numeroDocumento = $numeroDocumento;
            else
               throw new Exception('El número de documento solo puede tener 7 u 8 dígitos');
        else
            throw new Exception('El número de documento solo puede tener números');
    }

    /**
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $nombre = trim($nombre);
        $nombre = strtolower($nombre);
        $nombre = ucfirst($nombre);

        if(strlen($nombre) >= 3)
            if(str_word_count($nombre) == 1)
                $this->nombre = $nombre;
            else
                throw new Exception('Colocar solo el primer nombre, segundo o más nombre van en el campo "Segundo nombre"');
        else
            throw new Exception('La longitud del nombre debe ser de 3 o más caracteres');
    }

    /**
     *
     * @return string
     */
    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    /**
     *
     * @param string $segundoNombre
     */
    public function setSegundoNombre($segundoNombre)
    {
        if(empty($segundoNombre))
            $this->segundoNombre = $segundoNombre;
        else
        {
            $segundoNombre = trim($segundoNombre);
            $segundoNombre = strtolower($segundoNombre);

            if(str_word_count($segundoNombre) == 1)
                $segundoNombre = ucfirst($segundoNombre);
            else
                $segundoNombre = ucwords($segundoNombre); // Para formatear varios nombres

            if(strlen($segundoNombre) >= 3)
                $this->segundoNombre = $segundoNombre;
            else
                throw new Exception('La longitud del segundo nombre debe ser de 3 o más caracteres');
        }
    }

    /**
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $apellido = trim($apellido);
        $apellido = strtolower($apellido);

        if(str_word_count($apellido) == 1)
            $apellido = ucfirst($apellido);
        else
            $apellido = ucwords($apellido); // Para formatear varios apellidos

        if(strlen($apellido) >= 3)
            $this->apellido = $apellido;
        else
            throw new Exception('La longitud del apellido debe ser de 3 o más caracteres');
    }

    /**
     * Retorna la fecha como string con formato 'd-m-y'
     * @return string
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento->format('d-m-Y');
    }

    /**
     * Establece la fecha desde un string con formato 'd-m-y'
     * @param string $fechaNacimiento
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $fechaNacimiento = trim($fechaNacimiento);

        validarFecha($fechaNacimiento);

        $this->fechaNacimiento = DateTime::createFromFormat('!d-m-Y', $fechaNacimiento);
    }

    /**
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     *
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $direccion = trim($direccion);
        $direccion = strtolower($direccion);

        if(str_word_count($direccion) == 1)
            $direccion = ucfirst($direccion);
        else
            $direccion = ucwords($direccion);  // Para formatear varios nombres
        
        if(strlen($direccion) >= 3)
            $this->direccion = $direccion;
        else
            throw new Exception('La longitud de la dirección debe ser de 7 o más caracteres');
    }

    /**
     *
     * @return string
     */
    public function getTelefonoFijo()
    {
        return $this->telefonoFijo;
    }

    /**
     *
     * @param string $telefonoFijo
     */
    public function setTelefonoFijo($telefonoFijo)
    {
        if(empty ($telefonoFijo))
            $this->telefonoFijo = $telefonoFijo;
        else
        {
            $telefonoFijo = trim($telefonoFijo);

            if(intVal($telefonoFijo) != 0)
                if(strlen($telefonoFijo) >= 6 && strlen($telefonoFijo) <= 20)
                    $this->telefonoFijo = $telefonoFijo;
                else
                   throw new Exception('El teléfono solo puede tener entre 10 y 20 dígitos');
            else
                throw new Exception('El teléfono solo puede tener números');
        }
    }

    /**
     *
     * @return string
     */
    public function getTelefonoCelular()
    {
        return $this->telefonoCelular;
    }

    /**
     *
     * @param string $telefonoCelular
     */
    public function setTelefonoCelular($telefonoCelular)
    {
        if(empty($telefonoCelular))
            $this->telefonoCelular = $telefonoCelular;
        else
        {
            $telefonoCelular = trim($telefonoCelular);

            if(intVal($telefonoCelular) != 0)
                if(strlen($telefonoCelular) >= 10 && strlen($telefonoCelular) <= 20)
                    $this->telefonoCelular = $telefonoCelular;
                else
                   throw new Exception('El teléfono celular solo puede tener entre 10 y 20 dígitos');
            else
                throw new Exception('El teléfono celular solo puede tener números');
        }
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $email = trim($email);
        $email = strtolower($email);

        if(strlen($email) >= 10)
            if(str_word_count($email, 0, '0123456789@.-_') == 1)
                if(substr_count($email, '@') == 1)
                    $this->email = $email;
                else
                    throw new Exception('El email debe contener solo un arroba');
            else throw new Exception('El email solo puede contener caracteres alfanumericos o alguno de los siguientes caracteres: . - _');
        else
            throw new Exception('La longitud del email debe ser de 10 o más caracteres');
    }

    /**
     *
     * @return integer
     */
    public function getLegajo()
    {
        return $this->legajo;
    }

    /**
     *
     * @param integer $legajo
     */
    public function setLegajo($legajo)
    {
        $this->legajo = $legajo;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     *
     * @return array
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Retorna un string con las áreas a las que pertenece el usuario
     * @return string
     */
    public function getNombreAreas()
    {
        $areas = '';

        if(count($this->area) == 1)
        {
            $area = array_pop($this->area);
            $areas = $areas . $area->getNombreArea();
        }
        else
            foreach($this->area as $value)
                $areas = $areas . $value->getNombreArea() . '<br />';

        return $areas;
    }

    /**
     *
     * @param array $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     *
     * @return Nivel
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     *
     * @param Nivel $nivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    /**
     *
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     *
     * @param string $notas
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
    }

    /**
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     *
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     *
     * @return string
     */
    public function getNombreyApellido()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     *
     * @param Area $otraArea
     * @return boolean
     */
    public function perteneceAlArea($otraArea)
    {
        foreach($this->area as $value)
        {
            if($value->igual($otraArea))
                return true;
        }
        
        return false;
    }

    /**
     *
     * @param Nivel $otroNivel
     * @return boolean
     */
    public function perteneceAlNivel($otroNivel)
    {
        if($this->nivel->igual($otroNivel))
            return true;
        else
            return false;
    }

    /**
     *
     * @param Usuario $usuario
     * @return boolean
     */
    public function mismasAreas($usuario)
    {
        foreach($this->area as $value)
        {
            if(!$usuario->perteneceAlArea($value))
                return false;
        }

        return true;
    }

    /**
     *
     * @param Usuario $usuario
     * @return boolean
     */
    public function exactamenteMismaArea($usuario)
    {
        return $this->mismasAreas($usuario) && $this->cantidadAreas() == $usuario->cantidadAreas();
    }

    /**
     *
     * @return boolean
     */
    public function perteneceDosAreas()
    {
        return count($this->area) >= 2;
    }

    /**
     *
     * @return integer
     */
    public function cantidadAreas()
    {
        return count($this->area);
    }

    /**
     *
     * @param Usuario $usuario
     * @return boolean
     */
    public function igual($usuario)
    {
        if(strcmp($this->tipoDocumento, $usuario->getTipoDocumento()) != 0)
            return false;
     
        if(strcmp($this->numeroDocumento, $usuario->getNumeroDocumento()) != 0)
            return false;

        if(strcmp($this->nombre, $usuario->getNombre()) != 0)
            return false;

        if(strcmp($this->segundoNombre, $usuario->getSegundoNombre()) != 0)
            return false;

        if(strcmp($this->apellido, $usuario->getApellido()) != 0)
            return false;

        if(strcmp($this->fechaNacimiento, $usuario->getFechaNacimiento()) != 0)
            return false;

        if(strcmp($this->direccion, $usuario->getDireccion()) != 0)
            return false;

        if(strcmp($this->telefonoFijo, $usuario->getTelefonoFijo()) != 0)
            return false;

        if(strcmp($this->telefonoCelular, $usuario->getTelefonoCelular()) != 0)
            return false;

        if(strcmp($this->email, $usuario->getEmail()) != 0)
            return false;

        if(strcmp($this->notas, $usuario->getNotas()) != 0)
            return false;

        if($this->activo != $usuario->getActivo())
            return false;

        if(!$this->exactamenteMismaArea($usuario))
            return false;

        if(!$this->nivel->igual($usuario->getNivel()))
            return false;
        
        return true;
    }
}
?>
