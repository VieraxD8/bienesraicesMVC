<?php

namespace Controllers;

use MVC\Router;

use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class paginaControllers {
    
    public static function index(Router $router){
        
        $propiedades = Propiedad::get(3);

        $inicio = true;

        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        
        ]);

    }
        

        

    public static function nosotros(Router $router){

        
        $router->render('paginas/nosotros', [
            
        ]);
    }


    public static function propiedades(Router $router){
        
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', [
            
            'propiedades' => $propiedades
        ]);
    }
    

    public static function propiedad(Router $router){
            
        $id = validarORedireccionar('/propiedades');

        //Buscar la propiedad por su id

        $propiedad = Propiedad::find($id);


        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
          
        ]);
    }

    public static function blog(Router $router){
        
        $router->render('paginas/blog', [
            
          
        ]);
    }

    public static function entrada(Router $router){
        
    

        $router->render('paginas/entrada', [
            
          
        ]);
    }
    

    public static function contacto(Router $router){

        $mensaje = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $respuesta = $_POST['contacto'];


            //Crear una instancia de PHPMAILER

            $mail = new PHPMailer();

            //cONFIGURAR SIMP

            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'bc64327aa44b52';
            $mail->Password = '8c82f82775c2f4';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;


            //Configurar el contenido de email

            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje' ;

            //Habilitar HTML

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido

            $contenido = '<html>';
            $contenido .= ' <p> Tienes un nuevo Mensaje </p>';
            $contenido .= ' <p> Nombre: '. $respuesta['nombre'] .' </p>';
           


            // Enviar de forma condifionales algunos campos email o telefono 

            if($respuesta['contacto'] === 'telefono'){

                $contenido .= '<P> Eligio ser contactado por telefono: </p>';

                $contenido .= ' <p> Telefono: '. $respuesta['telefono'] .' </p>';

                $contenido .= ' <p> Fecha de contacto: '. $respuesta['fecha'] .' </p>';
                $contenido .= ' <p> Hora: '. $respuesta['hora'] .' </p>';


            } else {

                // Es email, entonces agregamos el campo de email
                $contenido .= '<P> Eligio ser contactado por email: </p>';
                $contenido .= ' <p> Email: '. $respuesta['email'] .' </p>';
            }


            
            $contenido .= ' <p> Mensaje: '. $respuesta['mensaje'] .' </p>';
            $contenido .= ' <p> Vende o Compra: '. $respuesta['tipo'] .' </p>';
            $contenido .= ' <p> Precio o Presupuesto: $'. $respuesta['precio'] .' </p>';
            $contenido .= ' <p> Prefiere ser contactado por: '. $respuesta['contacto'] .' </p>';
           
            $contenido .= '</html>';
            
            $mail->Body = $contenido;

            $mail->AltBody = " Es texo alternativo sin HTML";


            //Enviar email

            if($mail->send()){
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje = "El mensaje no se pudo enviar..";
            }


        }

        
        $router->render('paginas/contacto', [

            'mensaje' => $mensaje 
          
        ]);

    }
}




?>