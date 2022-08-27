<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }
    public static function propiedades(Router $router)
    {

        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');
        //buscar la propiedad por su id 
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', []);
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $respuestas = $_POST['contacto'];
            // crear una instancia de php mailer
            $mail = new PHPMailer();
/*             debuguear($respuestas);
 */            //configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '0f9235b40649d6';
            $mail->Password = '129f0e235aa27f';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            //habilitar html
            $mail->isHTML(true);
            $mail->CharSet = 'UTF8';

            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje </p>';
            $contenido .= '<p>Nombre:  ' . $respuestas['nombre'] . ' </p>';
            $contenido .= '<p>Mensaje:  ' . $respuestas['mensaje'] . ' </p>';

            //evniar de forma condicional alguinos campos de e mail o telefono

            if($respuestas['contacto'] === 'telefono'){
                //selecciono el mail
                $contenido .= '<p> Eligió ser contactdo por telefono</p>';
                $contenido .= '<p>Telefono:  ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Fecha contacto:  ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora contacto:  ' . $respuestas['hora'] . ' </p>';
            }else{

                //selecciono el mail
                $contenido.= '<p> Eligió ser contactdo por mail</p>';
                $contenido .= '<p>Email:  ' . $respuestas['email'] . ' </p>';

            }
            $contenido .= '<p>Vende o compra:  ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o Presupuesto:  $' . $respuestas['precio'] . ' </p>';
            $contenido .= '<p>Prefiere ser contactado por:  ' . $respuestas['contacto'] . ' </p>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            $mail->AltBody = 'Estos es un texto alternativo sin html';
            if ($mail->send()) {
                $mensaje= 'Mensaje enviado';
            } else {
                $mensaje= 'Mensaje no enviado';
            }
        }

        $router->render('paginas/contacto', [
            'mensaje'=> $mensaje
        ]);
    }
}
