<?php 


namespace Controllers;
use MVC\Router;
use Model\Vendedor;



class VendedorControllers {

    public static function crear(Router $router) {
        
        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor;
        
          //ejecutar el codigo despues que el usuario completa el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        //crea una instancia

        $vendedor = new Vendedor($_POST['vendedor']);

        //validar que no hay campos vacios

        $errores = $vendedor->validar();
        if(empty($errores)){
            $vendedor->guardar();
        }
    }
        
        $router->render('vendedores/crear', [

            'errores' => $errores,
            'vendedor' => $vendedor

        ]);
    }


    public static function actualizar(Router $router) {
        $errores = Vendedor::getErrores();

        $id = validarORedireccionar('/admin');

        //obtener datos del vendedor actualizar 
        $vendedor = Vendedor::find($id);


        //ejecutar el codigo despues que el usuario completa el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Asiganr los valores
        $args = $_POST['vendedor'];

        //Sincronizar objeto en memoria con el que el usuario escribio
        $vendedor->sincronizar($args);

        //validacion 

        $errores = $vendedor->validar();
        if(empty($errores)){
            $vendedor->guardar();
        }
    }


        $router->render('vendedores/actualizar', [

            'errores' => $errores,
            'vendedor' => $vendedor

        ]);

    }


    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            

            // validar el id

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id){
                //Valida el tipo a eliminar
                $tipo = $_POST['tipo'];

                if(ValidadTipoContenido($tipo)){
                    $vendedor =Vendedor::find($id);
                    $vendedor->eliminar(); 
                }
            }
        }



    }

}






?>