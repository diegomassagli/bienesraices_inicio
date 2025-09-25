<?php

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;
  require '../../includes/app.php'; 
  estaAutenticado();

  // Validar por Id valido
  $id = $_GET['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if(!$id) {
    header('Location: /admin');
  }

  // obtener los datos de la propiedad a actualizar
  $propiedad = Propiedad::find($id);
  //debuguear($propiedad);

  // Consultar para obtener los vendedores
  $consulta = "SELECT * FROM vendedores";
  $resultado = mysqli_query($db, $consulta);

  // echo "<pre>";
  // var_dump($_SERVER["REQUEST_METHOD"]);
  // echo "</pre>";


  // Inicializo arreglo con mensajes de error y variables del formulario
  $errores = Propiedad::getErrores();

  // Ejecutar el codigo despues de que el usuario envia el formulario
  if($_SERVER["REQUEST_METHOD"] === "POST") {  // para asegurarme que no venga vacio, antes de preguntar por los datos      

    // asignar los atributos
    $args = $_POST['propiedad'];
    $propiedad->sincronizar($args);  

    // debuguear($propiedad);

    // validacion 

    $errores = $propiedad->validar();

    // subida de archivos
    $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";    
    IF($_FILES['propiedad']['tmp_name']['imagen']) {                               
      $manager = new Image(Driver::class);                            
      $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombreImagen);      
    }    

    // Revisar que el arreglo de errores este vacio
    if( empty( $errores ) ) {      



      exit;

      // Insertar en la base de datos 
      $query = " UPDATE propiedades SET 
        titulo='" .$titulo. "', 
        precio='" .$precio. "', 
        imagen='" .$nombreImagen. "', 
        descripcion='" .$descripcion. "', 
        habitaciones=" .$habitaciones. ", 
        wc=" .$wc. ", 
        estacionamiento="  .$estacionamiento. ", 
        vendedores_id="  .$vendedores_id. " 
        WHERE id=" .$id;
      
      // echo $query;
  
      $resultado = mysqli_query($db, $query);
  
      if($resultado) {
        // redireccionar al usuario FUNCIONA SOLAMENTE SI NO LLEGASTE A MOSTRAR NINGUN ELEMENTO HTML, SINO NO FUNCIONA
        header('Location: /admin?resultado=2');
      }
    }
  }


  incluirTemplate('header');
?>

  <main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach( $errores as $error ):  ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>  
 
    <form class="formulario" method="POST" enctype="multipart/form-data">   <!-- LE SACO EL ACTION, ASI AUTOMATICAMENTE LO ENVIA A LA MISMA PAGINA RESPETANDO LA URL QUE YA TIENE EL ID -->
      
      <?php include '../../includes/templates/formulario_propiedades.php' ?>

      <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

    </form>




  </main>

<?php incluirTemplate('footer'); ?>