<?php 

namespace Model;

class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'banos', 'estacionamiento', 'creado', 'vendedores_id'];

     
        
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $banos;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;


    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->banos = $args['banos'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
        
    }

     //validacion 
     public function validar() {
            
        if(!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if(!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
    
        }

        if(strlen($this->descripcion) < 50) {
            self::$errores[] = "La descripcion es obligatorio y debe tener al menos 50 caracteres";
    
        }

        if(!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
    
        }

        if(!$this->banos) {
            self::$errores[] = "El numero de baños es obligatorio";
    
        }

        if(!$this->estacionamiento) {
            self::$errores[] = "El numero de estacionamiento es obligatorio";
    
        }

        if(!$this->vendedores_id) {
            self::$errores[] = "Elige un vendedor";
    
        }

        if(!$this->imagen){
         self::$errores[] = "La imagen es Obligatoria";
         }

        return self::$errores;
    }

} 


?>