<?php

  namespace App;
  class Propiedad {

    // Base de Datos  protectec para que solo se pueda acceder desde la clase. static para que se use siempre la misma conexion  y no se cree una nueva
    // $db NO VA A FORMAR PARTE DEL CONSTRUCTOR, NO SE VA A SOBREESCRIBIR Y VA A PERSISTIR
    protected static $db;

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_Id;

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
      $this->vendedores_Id = $args['vendedores_id'] ?? '';
    }


    public function guardar() {
      // Insertar en la base de datos 
      $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_Id) 
      VALUES ('$this->titulo', '$this->precio', '$this->imagen',  '$this->descripcion', '$this->habitaciones', '$this->wc', '$this->estacionamiento', '$this->creado', '$this->vendedores_Id') ";

      // self:: porque esta como static
      $resultado = self::$db->query($query);

      debuguear($resultado);
    }

    // Definir la conexion a la BD, como $db es static el metodo tambien
    public static function setDB($database) {
      self::$db = $database;
    }


  }
