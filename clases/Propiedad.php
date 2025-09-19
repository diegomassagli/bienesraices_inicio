<?php

  namespace App;
  class Propiedad {

    // Base de Datos  protectec para que solo se pueda acceder desde la clase. static para que se use siempre la misma conexion  y no se cree una nueva
    // $db NO VA A FORMAR PARTE DEL CONSTRUCTOR, NO SE VA A SOBREESCRIBIR Y VA A PERSISTIR
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

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
      $this->imagen = $args['imagen'] ?? 'imagen.jpg';
      $this->descripcion = $args['descripcion'] ?? '';
      $this->habitaciones = $args['habitaciones'] ?? '';
      $this->wc = $args['wc'] ?? '';
      $this->estacionamiento = $args['estacionamiento'] ?? '';
      $this->creado = date('Y/m/d');
      $this->vendedores_id = $args['vendedores_id'] ?? '';
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

      // debuguear($query);

      // self:: porque esta como static
      $resultado = self::$db->query($query);

      debuguear($resultado);
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

  }
