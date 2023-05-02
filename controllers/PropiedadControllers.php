<?php

    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

class PropiedadControllers{
        
        public static function index(Router $router){

            $propiedades = Propiedad::all();

            $vendedores = Vendedor::all();
            // muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null;
            
            $router->render('propiedades/admin', [
                'propiedades' => $propiedades,
                'resultado' => $resultado,
                'vendedores' => $vendedores
            ]);

        }

    public static function crear(Router $router){

                $vendedores = Vendedor::all();
                $propiedad = new Propiedad;
                $errores = Propiedad::getErrores();


                if($_SERVER['REQUEST_METHOD'] === 'POST') {

                    //Crea una nueva instancia
                    
                    $propiedad = new Propiedad($_POST['propiedad']);
            
                    
            
                        //generar un nombre unico
                        
                        $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";
            
                        //setear la imagen
            
                    //Realiza un resize a la imagen con inervention
            
                    if($_FILES['propiedad']['tmp_name']['imagen']){
                        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            
                        $propiedad->setImagen($nombreImagen);
                    
                    }
            
                    
                    //validar
                    $errores = $propiedad->validar();
            
                    
                    
                    
                    //revisar que el arreglo de errores este vacio
            
                    if(empty($errores)){
            
                    
                        /** SUBIDA DE ARCHIVOS */
                        
                        //CREAR carpeta
            
                    
                        if(!is_dir(CARPETA_IMAGENES)){
                            mkdir(CARPETA_IMAGENES);
                        }
            
                        //guardar la imagen en el servidor
            
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                        
                        //GUARDA EN LA BASE DE DATOS
                        $propiedad->guardar();
            
            
                    }
            
                }
        
                
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);

    }


    public static function actualizar(Router $router){
                
                $id = validarORedireccionar('/admin');

                $propiedad = Propiedad::find($id);

                $errores = Propiedad::getErrores();
                $vendedores = Vendedor::all();

            
                    //ejecutar el codigo despues que el usuario completa el formulario
        if($_SERVER['REQUEST_METHOD'] === 'POST') {


            // Asignar los atributos

            $args = $_POST['propiedad'];
        

            $propiedad->sincronizar($args);
            
            
            //validacion

            $errores = $propiedad->validar();


            //generar un nombre unico
                
            $nombreImagen = md5( uniqid(rand(), true)) . ".jpg";

            //subida de archivos

            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);

                $propiedad->setImagen($nombreImagen);
            
            }


            if(empty($errores)){

                //amacenar la imagen 
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                

                $propiedad->guardar();
    
            }

        }


                $router->render('propiedades/actualizar', [

                    'propiedad' => $propiedad,
                    'errores' => $errores,
                    'vendedores' => $vendedores

                ]);


    }


    public static function Eliminar(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT );
    
    
            if($id) {
    
                $tipo = $_POST['tipo'];
    
                if(ValidadTipoContenido($tipo)){
                    $propiedad = Propiedad::find($id);
    
                    $propiedad->eliminar();
    
                }    
            }
        }

    }



    
}








?>