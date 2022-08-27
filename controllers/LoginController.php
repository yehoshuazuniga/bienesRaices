<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {

        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            $errores = $auth->validar();
            //debuguear($_POST);
            //  debuguear($errores);

            if (empty($errores)) {
                //verificar si el usuario existe
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    //verifica si el usuario  existe o no ( mensaje de erro)
                    $errores = Admin::getErrores();
                } else {
                    $autenticado =  $auth->comprobarPassword($resultado);


                    if ($autenticado) {
                        //verificar password
                        $auth->autenticar();
                    } else {
                        //password incorrecto mensaje de error
                        $errores  = Admin::getErrores();
                    }
                }
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];

        /*         session_destroy()
 */
        header('Location: /');
    }
}
