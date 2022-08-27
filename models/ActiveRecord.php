<?php

namespace Model;

class ActiveRecord
{
    //base de datos
    protected static  $db;
    protected static $columnasBD = [];
    protected static $tabla = '';

    //errores
    protected static $errores = [];


    //definir la coneccion a la bas de datos 
    public static function setDB($dataBase)
    {
        self::$db = $dataBase;
    }

    public function guardar()
    {
        $resultado = '';

        if (!is_null($this->id)) {
            //actualizar
            $this->actulizar();
        } else {
            // cradno un nuevo registro

            $resultado = $this->crear();
        }
    }

    public function crear()
    {
        // sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $query = "  INSERT INTO " . static::$tabla . " (";

        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ( '";
        $query .= join("', '", array_values($atributos));
        $query .= "')";
        $resultado = self::$db->query($query);
        //meresultadonsaje de exito o error
        if ($resultado) {
            header('Location: ../admin?resultado=1');
        }
    }

    public function actulizar()
    {
        // sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id ='" . self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // echo "insertado correctamente" . $resultado->error_log;
            header('Location: ../admin?resultado=2');
        }
    }

    //eliminar registros
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id);
        $query .= " LIMIT 1";
        $resultado = self::$db->query($query);
        if ($resultado) {
            $this->borrarImagen();
            header('Location: ../admin?resultado=3');
        }
    }


    // mapea los atributos de la bas de datos
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasBD as $columna) {
            if ($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }



    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }



    //subido de archivos
    public function seTImagen($image)
    {
        //eliminar imagen previa
        if (!is_null($this->id)) {

            $this->borrarImagen();
        }

        if ($image) {
            //asignar al atributo de la imagen el nombre de la imagen
            $this->imagen = $image;
        }
    }
    //eliminar el archivo
    public function borrarImagen()
    {
        //comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETAS_IMAGENES . $this->imagen);

        // debuguear($existeArchivo);
        if ($existeArchivo) {
            unlink((CARPETAS_IMAGENES . $this->imagen));
        }
    }

    //validadcio

    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //lista todas las propiedades

    public static function all()
    {
        $query = ' SELECT * FROM ' . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //obtine determinado numero de registros
    public static function get($cantidad)
    {
        $query = ' SELECT * FROM ' . static::$tabla . ' LIMIT ' . $cantidad;
       // debuguear($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //busca un registro por su id

    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id ={$id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // consulta bbdd 
        $resultado = self::$db->query($query);

        //iterar los resultadors
        $array = [];

        while ($registro = $resultado->fetch_assoc()) {

            $array[] = static::crearObjeto($registro);
        }
        // liberar memoria
        $resultado->free();

        //retornasr los resulytados


        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key =>  $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //sincroniza el obj en memoria con los cambios del usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
