<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{

    public static function crear(Router $router)
    {

        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //crear una nueva unstancia de vendedor

            $vendedor = new Vendedor($_POST['vendedor']);
            //validar campo de formulario
            $errores = $vendedor->validar();
            //  debuguear($vendedor);

            // no hay errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('../admin');
        //obtener los datos del vendedor

        $vendedor = Vendedor::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //asignar  los valores

            $args = $_POST['vendedor'];

            //sincronizar objeto en memoria con lo del usuario
            $vendedor->sincronizar($args);

            //validacion

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor

        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo = $_POST['tipo'];
            // valido el tipo a eliminar

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}
