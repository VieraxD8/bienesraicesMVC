<?php

namespace MVC;

    class Router {

        public $rutaGET = [];
        public $rutaPOST = [];

        public function get($url, $fn){
            $this->rutaGET[$url] = $fn;
        }

        public function post($url, $fn){
            $this->rutaPOST[$url] = $fn;
        }

        
        
        public function ComprobarRutas(){

            session_start();

            $auth = $_SESSION['login'] ?? null;

            //Arreglos de rutas protegidas

            $rutas_protegidas = ['/admin', '/propiedades/crear' , '/propiedades/actualizar', '/propiedades/eliminar','/vendedores/crear', '/vendedores/actualizar' ,'/vendedores/eliminar' ];
 

            
            $urlActual = $_SERVER['PATH_INFO'] ?? '/';
            $metodo = $_SERVER['REQUEST_METHOD'];

            
            if($metodo === 'GET'){
                $fn = $this->rutaGET[$urlActual] ?? null;
            }else {
           
                $fn = $this->rutaPOST[$urlActual] ?? null;
            }

            // proteguer la rutas

            if(in_array($urlActual, $rutas_protegidas) &&  !$auth){
                header('Location: /');
             }



            if($fn){
                //La URL existe y hay una funcion asociada
               
                call_user_func($fn, $this);

            } else {
                echo "Pagina No Encontrada";
            }


        }

        //Mostrar desde la vista
        public function render($view, $datos = []){


            foreach( $datos as $key => $value ) {
                $$key = $value;
            }

            ob_start();
            
            include __DIR__ . "/views/$view.php";

            $contenido = ob_get_clean();


            include __DIR__ . "/views/layout.php";

        }


    }






?>