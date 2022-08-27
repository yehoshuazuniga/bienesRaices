<?php

namespace Model;

class Admin extends ActiveRecord
{
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $password;
    public $email;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$errores[] = 'Email es obligatorio';
        }
        if (!$this->password) {
            self::$errores[] = 'Password es obligatorio';
        }
        return self::$errores;
    }

    public function existeUsuario()
    {
        //revisar si el usuario existe
        $query = "SELECT * FROM " . self::$tabla . " WHERE email ='" . $this->email . "' LIMIT 1";
        // debuguear($query);

        $resultado = self::$db->query($query);

        if (!$resultado->num_rows) {
            self::$errores[] = 'Usuario no existe';
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);
        // debuguear($autenticado);
        if (!$autenticado) {
            self::$errores[] = 'Password incorrecto';
            return;
        }
        return $autenticado;
    }

    public function autenticar(){
        session_start();

        //llenar el arreglo de session
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');

    }
}
