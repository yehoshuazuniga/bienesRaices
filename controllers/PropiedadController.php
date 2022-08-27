<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
   public static function index(Router $router)
   {
      $propieades = Propiedad::all();
      $vendedores = Vendedor::all();

      // mensaje condicional
      $resultado = $_GET['resultado'] ?? null;
      $router->render(
         'propiedades/admin',
         [
            'propiedades' => $propieades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
         ]
      );
   }
   public static function crear(Router $router)
   {
      $propiedad = new Propiedad();
      $vendedores = Vendedor::all();
      //array mensajes d error
      $errores = Propiedad::getErrores();

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         //crea una nueva instancia
         $propiedad = new Propiedad($_POST['propiedad']);
         //genarar nombre un unico de imagen
         $nombreImagen = '/' . md5(uniqid(rand())) . '.jpg';
         //setear imagen
         //realiza un resize a la imagen con  intervention
         if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->seTImagen($nombreImagen);
         }
         $errores = $propiedad->validar();
         //debuguear($propiedad);

         if (empty($errores)) {
            //crear  carpeta 
            if (!is_dir(CARPETAS_IMAGENES)) {
               mkdir(CARPETAS_IMAGENES);
            }
            //guardar la imagen en el servidor
            $image->save(CARPETAS_IMAGENES . $nombreImagen);
            //guardar en la base de datos
            $propiedad->guardar();
         }
      }


      $router->render('propiedades/crear', [
         'propiedad' => $propiedad,
         'vendedores' => $vendedores,
         'errores' => $errores
      ]);
   }
   public static function actualizar(Router $router)
   {
      $id = validarORedireccionar('../admin');
      $propiedad = Propiedad::find($id);
      $errores = Propiedad::getErrores();
      $vendedores = Vendedor::all();

      //metodo post para actualizar
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         //asignar los atributos


         $args = $_POST['propiedad'];
         $propiedad->sincronizar($args);
         $errores = $propiedad->validar();

         //subida de archivos

         //genarar nombre un unico de imagen
         $nombreImagen = '/' . md5(uniqid(rand())) . '.jpg';

         if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
            $propiedad->seTImagen($nombreImagen);
         }


         if (empty($errores)) {
            if ($_FILES['propiedad']['tmp_name']['imagen']) {

               //alamacenar imagem
               $image->save(CARPETAS_IMAGENES . $nombreImagen);
            }
            $resultado = $propiedad->guardar();
         }
      }

      $router->render('/propiedades/actualizar', [
         'propiedad' => $propiedad,
         'errores' => $errores,
         'vendedores' => $vendedores
      ]);
   }

   public static function eliminar()
   {

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         //validar id
         $id = $_POST['id'];
         $id = filter_var($id, FILTER_VALIDATE_INT);

         if ($id) {
            $tipo = $_POST['tipo'];
            if (validarTipoContenido($tipo)) {
               $propiedad = Propiedad::find($id);
               $propiedad->eliminar();
            }
         }
      }
   }
}
