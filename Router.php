<?php

namespace MVC;

class Router
{

    public $rutasGet = [];
    public $rutasPost = [];

    /*     public function __construct()
    {
    } */

    public function get($url, $fn)
    {
        $this->rutasGet[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->rutasPost[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();
        $auth = $_SESSION['login'] ?? null;

        //arreglo de rutas protegidas = []
        $rutas_protegidas =[
            '/admin',
            '/propiedades/crear',
            '/propiedades/actualizar',
            '/propiedades/eliminar',
            '/vendedores/crear',
            '/vendedores/actualizar',
            '/vendedores/eliminar'
        ];


        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        //debuguear($urlActual);

        if ($metodo === 'GET') {
            $fn = $this->rutasGet[$urlActual] ?? null;
        }else{

           // debuguear($this);
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        //proteger las rutas
        if(in_array($urlActual, $rutas_protegidas) && !$auth){
            header('Location: /');
        }

        if ($fn) {
            //la funcion existe y hay yuna funcion
         //debuguear($this);
            call_user_func($fn, $this);
        }else{
            echo 'pagina no hya';
        }
    }

    public function render($view, $datos=[]){
        foreach ($datos as $key => $value) {
            # code...
            $$key = $value;
        }
        ob_start(); //almacenamiento en memoria durante un momento
        
        include __DIR__."/views/$view.php";
        $contenido = ob_get_clean(); //limpia el buffer
        include __DIR__."/views/layout.php";

    }
}
