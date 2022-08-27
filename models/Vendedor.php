<?php

namespace Model;

class Vendedor extends ActiveRecord
{

    protected static $tabla = 'vendedores';
    protected static $columnasBD = [
        'id', 'nombre', 'apellido', 'telefono'
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }
    
    public function validar()
    {
        if (empty($this->nombre)) {
            
            self::$errores[] = "Se debe añadir un nombre";
        }
        if (empty($this->apellido)) {
            self::$errores[] = "Se debe añadir un apellido";
        }
    
        if (empty($this->telefono)) {
            self::$errores[] = "Se debe añadir una telefono";
        }

        if(!preg_match('/[0-9]{9}/', $this->telefono)){
            self::$errores [] = 'Formarto de  telefono no valido';
        }

        return self::$errores;
    }
}
