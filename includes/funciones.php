<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('CARPETAS_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes');

function incluirTemplate(string $nombre, bool $inicio = false)
{
     include TEMPLATES_URL . "/{$nombre}.php";
}


function estaAutenticada()
{
     session_start();
     if (!$_SESSION['login']) {
          header('Location: /');
     }
}


function debuguear($param)
{
     echo '<pre>';
     var_dump($param);
     echo '</pre>';
     exit;
}

//escapa / sanitizar el html

function s($html)
{
     $s = htmlspecialchars($html);

     return $s;
}


//validar tiò de comtemido

function validarTipoContenido($tipo){
     $tipos = ['vendedor', 'propiedad'];
     return in_array($tipo, $tipos);

}

//muestra los mensajes
function muestaNotificaion($codigo){
     $mensaje ='';
     switch($codigo){
          case 1:
               $mensaje = 'Creado Correatmente';
          break;
          
          case 2:
               $mensaje = 'Actualizado Correatmente';
          break;
          case 3:
               $mensaje = 'Eliminado Correatmente';
          break;
          default:
               $mensaje = false;
          break;

     }
     return $mensaje; 
}

function validarORedireccionar(string $url){

     //validar id
     $id = $_GET['id'];
     $id = filter_var($id, FILTER_VALIDATE_INT);

     if (!$id) {
          header("Location: ${url}");
     }
     return $id;
}