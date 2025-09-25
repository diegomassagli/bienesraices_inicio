<?php
  require '../../includes/app.php'; 
  use App\Propiedad;
  use Intervention\Image\Drivers\Gd\Driver;
  use Intervention\Image\ImageManager as Image;

  estaAutenticado();

  $propiedad = new Propiedad();   // esto genera la instancia con los placeholders establecidos en el constructor

  // Consultar para obtener los vendedores
  $consulta = "SELECT * FROM vendedores";
  $resultado = mysqli_query($db, $consulta);

  // echo "<pre>";
  // var_dump($_SERVER["REQUEST_METHOD"]);
  // echo "</pre>";


  // Inicializo arreglo con mensajes de error y variables del formulario
  // $errores = [];
  $errores = Propiedad::getErrores();

  // Ejecutar el codigo despues de que el usuario envia el formulario
  if($_SERVER["REQUEST_METHOD"] === "POST") {  // para asegurarme que no venga vacio, antes de preguntar por los datos

    // debuguear($_POST);

    $propiedad = new Propiedad($_POST['propiedad']);

    // debuguear($_FILES['propiedad']);

    // generar un nombre unico
    $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";    
    IF($_FILES['propiedad']['tmp_name']['imagen']) {                               // si tenemos una imagen entonces...
      $manager = new Image(Driver::class);                            // leo la imagen y le aplico metodos de transformacion propios de intervetion
      $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombreImagen);      
    }
    
    $errores = $propiedad->validar();

    // debuguear($_FILES);

    if( empty( $errores ) ) {
      
      // subida de archivos
      if( !is_dir(CARPETA_IMAGENES) ) {
        mkdir(CARPETA_IMAGENES);        
      }
     
      // Guarda la imagen en el servidor (save metodo de Intervention)
      $imagen->save(CARPETA_IMAGENES . $nombreImagen);      
      
      $resultado = $propiedad->guardar();              

      if($resultado) {
        // redireccionar al usuario FUNCIONA SOLAMENTE SI NO LLEGASTE A MOSTRAR NINGUN ELEMENTO HTML, SINO NO FUNCIONA
        header('Location: /admin?resultado=1');
      }
    }
  }

  incluirTemplate('header');
?>

  <main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach( $errores as $error ):  ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>  

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">

      <?php include '../../includes/templates/formulario_propiedades.php' ?>

      <input type="submit" value="Crear Propiedad" class="boton boton-verde">

    </form>




  </main>

<?php incluirTemplate('footer'); ?>