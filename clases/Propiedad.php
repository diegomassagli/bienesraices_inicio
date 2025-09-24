<?php

  namespace App;
  class Propiedad {

    // Base de Datos  protectec para que solo se pueda acceder desde la clase. static para que se use siempre la misma conexion  y no se cree una nueva
    // $db NO VA A FORMAR PARTE DEL CONSTRUCTOR, NO SE VA A SOBREESCRIBIR Y VA A PERSISTIR
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];


    // Errores o Validacion (protected porque solo la clase es la que puede decir si es valido o no y static porque no requiero instanciarlo en otro lado)
    protected static $errores = [];
    

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    // Definir la conexion a la BD, como $db es static el metodo tambien
    public static function setDB($database) {        // DE NUEVO, TODO LO QUE ESTE COMO PUBLICO SE HACE REFERENCIA COMO "THIS" TODO LO QUE ESTE COMO STATIC SE HACE REFERENCIA COMO "SELF::"
      self::$db = $database;                         //los atributos que son staticos, que pertenecen a la clase, y no requieren instanciarse, se acceden como self::
    }


    public function __construct($args = [])
    {
      $this->id = $args['id'] ?? '';
      $this->titulo = $args['titulo'] ?? '';
      $this->precio = $args['precio'] ?? '';
      $this->imagen = $args['imagen'] ?? '';
      $this->descripcion = $args['descripcion'] ?? '';
      $this->habitaciones = $args['habitaciones'] ?? '';
      $this->wc = $args['wc'] ?? '';
      $this->estacionamiento = $args['estacionamiento'] ?? '';
      $this->creado = date('Y/m/d');
      $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }


    public function guardar() {

      // Sanitizar los datos
      $atributos = $this->sanitizarAtributos();

      // debuguear(array_keys($atributos));   // me devuelve las "claves" del arreglo que son los nombres de las columnas

      // $string = join(', ', array_keys($atributos));  // esta funcion aplana un arreglo y le puedo indicar que separador necesito que ponga
      // $string = join(', ', array_values($atributos)); // idem pero para los "valores" del arreglo
      // debuguear($string);

      // Insertar en la base de datos 
      $query = " INSERT INTO propiedades ( ";
      $query .= join(', ', array_keys($atributos));
      $query .= " ) VALUES ('"; 
      $query .= join("', '", array_values($atributos));
      $query .= " ') ";

      // self:: porque esta como static
      $resultado = self::$db->query($query);      
      return $resultado;
    }


    // Identificar y unir los atributos de la BD (armar un arreglo con nombre del campo de la BD y valor)
    public function atributos() {
      $atributos = [];
      foreach(self::$columnasDB as $columna) {
        if($columna === 'id') continue;
        $atributos[$columna] = $this->$columna;   // este $this hace referencia al objeto en memoria, el que tiene la propiedad precio, imagen, etc. que esta en el constructor
      }
      return $atributos;
    }

    public function sanitizarAtributos() {
      $atributos = $this->atributos();
      $sanitizado = [];

      foreach($atributos as $key => $value ) {
        // echo $key;
        // echo $value;
        $sanitizado [$key] = self::$db->escape_string($value);
      }
      return $sanitizado;
    }

    // Validacion
    public static function getErrores() {
      return self::$errores;
    }


    public function validar() {
      if(!$this->titulo || mb_strlen($this->titulo, 'UTF-8') > 45 ) {
        self::$errores[] = "Debes añadir un titulo y que sea inferior a 45 caracteres";
      }
      if(!$this->precio) {
        self::$errores[] = "El precio es obligatorio";
      }
      if( strlen( $this->descripcion ) < 50 ) {
        self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
      }
      if(!$this->habitaciones ) {
        self::$errores[] = "El numero de habitaciones es obligatorio";
      }
      if(!$this->wc ) {
       self:: $errores[] = "El numero de baños es obligatorio";
      }
      if(!$this->estacionamiento ) {
        self::$errores[] = "El numero de lugares de estacionamiento es obligatorio";
      }        
      if(!$this->vendedores_id ) {
        self::$errores[] = "Elije  un vendedor";
      }    
      if(!$this->imagen) {
        self::$errores[] = "Elije  una imagen, es obligatoria";
      }    
      return self::$errores;
    }
    
    public function setImagen($imagen) {
      if($imagen) {
        $this->imagen = $imagen;
      }
    }

    // Lista todos los registros
    public static function all() {
      $query = "SELECT * FROM propiedades";
      
      $resultado = self::consultarSQL($query);
      return $resultado;      
    }

    // Busca un registro por su ID
    public static function find($id) {
      $query = "SELECT * FROM propiedades WHERE id={$id}";      
      $resultado = self::consultarSQL($query);      
      return array_shift($resultado);      // devuelve la primer posicion del arreglo que en este caso es el objeto con todas los valores de esta propiedad
    }


    public static function consultarSQL($query) {
      // consultar la BD
      $resultado = self::$db->query($query);

      // iterar los resultados
      $array = [];
      while ($registro = $resultado->fetch_assoc()) {
        $array[] = self::crearObjeto($registro);
      }      

      // liberar la memoria
      $resultado->free();

      // retornar los resultados
      return $array;
    }
                                                                 // RECUERDO QUE ACTIVE RECORD PIDE OBJETOS !! NO ARREGLOS !!
    protected static function crearObjeto($registro) {          // este codigo crea un objeto en memoria en base a los resultados de la bd
      $objeto = new self;                                      // esto significa crear un nuevo objeto de la clase actual

      foreach ( $registro as $key => $value ) {
        if( property_exists( $objeto, $key ) ) {
          $objeto->$key = $value;
        }
      }
      return $objeto;
    }

  }
