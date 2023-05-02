<?php 

namespace Model;

class ActiveRecord {

        //Base de Datos

        protected static $db;
        protected static $columnasDB = [];

        protected static $tabla = '';
    
    
        //Errores o vlaidacion
    
        protected static $errores = [];

     //definir la conexion a la base de datos
    
     public static function setDB($database){
        self::$db = $database;
    }

       //validacion
    
       public static function getErrores() {

        return static::$errores;
    }


     //validacion 
     public function validar() {

        static::$errores = [];
        
        return static::$errores;
    }

   
    
    
        public function guardar(){
            if (!is_null($this->id)) {

                 //Actualizar
                 $this->actualizar();
                
             } else{
                 //Creando un nuevo registro
                 $this->crear();
              
             }
         }

            //Lista todas las propiedades
    
        public static function all() {
    
            $query = "SELECT * FROM " . static::$tabla;
    
            $resultado = self::consultarSQL($query);
    
            return $resultado;
    
        }

        //obtiene determinado numero de registros

        public static function get($cantidad) {
    
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
    
            $resultado = self::consultarSQL($query);
    
            return $resultado;
    
        }


        
        //Busca una propiedad por su id
    
        public static function find($id){
            
            $query = "SELECT * FROM " . static::$tabla  . " WHERE id = {$id}";
            
            $resultado = self::consultarSQL($query);
    
            return array_shift($resultado);
        
        }

    
        public function crear() {
    
            //Sanitizar los datos
    
            $atributos = $this->sanitizarAtributos();
    
        
            // insertar en la base de datos
    
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ',array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .=  join("', '",array_values($atributos));
            $query .= " ')";
    
        
    
            $resultado = self::$db->query($query);
    
            if($resultado) {
                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }

    
        }
    
    
        public function actualizar(){
    
            //Sanitizar los datos
    
            $atributos = $this->sanitizarAtributos();
    
            $valores = [];
    
            foreach( $atributos as $key => $value){
                $valores[] = "{$key}='{$value}'";
            }
    
            $query = " UPDATE " . static::$tabla  ." SET "; 
            $query .= join(', ', $valores );
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1 ";
    
            $resultado = self::$db->query($query);
    
            if($resultado) {
                // Redireccionar al usuario.
                header('Location: /admin?resultado=2');
            }
            
        }
    
        //Eliminar
    
        public function eliminar(){
      
    
             //Elimina la propiedad
    
             $query = "DELETE FROM " . static::$tabla  . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
    
             $resultado = self::$db->query($query);
    
             if($resultado){
    
                $this->borrarImagen();
    
                header('location: /admin?resultado=3');
            }
    
            
        }

        public static function consultarSQL($query){
    
            //consultar la base de datos
    
            $resultado = self::$db->query($query);
    
            // iterar el resultados
    
            $array = [];
    
            while( $registro = $resultado->fetch_assoc()){
                $array[] = static::crearObjeto($registro);
            }
    
            //liberar la memoria
    
            $resultado->free();
    
            //retornar los resultados
    
            return $array;
    
        }

        protected static function crearObjeto($registro) {
    
            $objeto = new static;
    
            foreach($registro as $key => $value){
                if( property_exists( $objeto, $key)){
                    $objeto->$key = $value;
                }
            }
    
            return $objeto;
    
        }
    
    
       
    
        public function atributos() {
            $atributos = [];
            foreach(static::$columnasDB as  $columna) {
    
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
    
            return $atributos;
    
        }
    
        public function sanitizarAtributos() {
    
           $atributos = $this->atributos();
           $sanitizado = [];
        
           foreach( $atributos as $key => $value){
                
                $sanitizado[$key] = self::$db->escape_string($value);
           }
    
           return $sanitizado;
    
        }


         //sincronizar el objeto en memoria con los cambios realizados pr el usuario
    
         public function sincronizar( $args = []){
    
            foreach($args as $key => $value){
                if(property_exists($this, $key ) && !is_null($value)){
                    $this->$key = $value;
                }
            }
    
        }
    
        //subida de archivos
    
        public function setImagen($imagen){
    
            //Eliminar la imagen previa
    
            if(!is_null($this->id)){
                //Comprobar si existe el archivo
               $this->borrarImagen();
            }
            //asigar al atributo de imagen el nombre de la imagen
            if($imagen){
                $this->imagen = $imagen;
            }
    
        }
    
        //Eliminr el archivo
    
        public function borrarImagen(){
    
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
    
                if($existeArchivo){
                    unlink(CARPETA_IMAGENES . $this->imagen);
                }
    
    
        }
    
    
       

}






?>