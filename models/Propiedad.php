<?php

namespace Model;

class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasBD = [
        'id', 'titulo', 'precio', 'imagen', 'descripcion',
        'habitaciones', 'wc', 'estacionamiento', 'creado',
        'vendedores_id'
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar()
    {

        if (empty($this->titulo)) {
            self::$errores[] = "Se debe añadir un titulo";
        }
        if (empty($this->precio)) {
            self::$errores[] = "Se debe añadir un precio";
        }
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "Se debe añadir un descripcion con al menos 50 caracteres";
        }
        if (empty($this->habitaciones)) {
            self::$errores[] = "Se debe añadir una habitaciones";
        }
        if (empty($this->wc)) {
            self::$errores[] = "Se debe añadir un wc";
        }
        if (empty($this->estacionamiento)) {
            self::$errores[] = "Se debe añadir un estacionamiento";
        }
        /*   if (!$this->vendedores_id) {
            self::$errores[] = "Se debe añadir un estacionamiento";
        }
 */
        if (!$this->imagen) {
            self::$errores[] = 'Se debe introducir una imagen';
        }

        return self::$errores;
    }

}

