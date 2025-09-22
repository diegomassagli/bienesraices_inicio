<?php
  require '../../includes/app.php'; 
  use App\Propiedad;
  use Intervention\Image\Drivers\Gd\Driver;
  use Intervention\Image\ImageManager as Image;

  estaAutenticado();

  // Consultar para obtener los vendedores
  $consulta = "SELECT * FROM vendedores";
  $resultado = mysqli_query($db, $consulta);

  // echo "<pre>";
  // var_dump($_SERVER["REQUEST_METHOD"]);
  // echo "</pre>";


  // Inicializo arreglo con mensajes de error y variables del formulario
  // $errores = [];
  $errores = Propiedad::getErrores();

  
  $titulo = '';
  $precio = '';
  $descripcion = '';
  $habitaciones = '';
  $wc = '';
  $estacionamiento = '';
  $vendedores_Id = '';
  $creado = '';

  // Ejecutar el codigo despues de que el usuario envia el formulario
  if($_SERVER["REQUEST_METHOD"] === "POST") {  // para asegurarme que no venga vacio, antes de preguntar por los datos

    $propiedad = new Propiedad($_POST);

    // generar un nombre unico
    $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";    
    IF($_FILES['imagen']['tmp_name']) {                               // si tenemos una imagen entonces...
      $manager = new Image(Driver::class);                            // leo la imagen y le aplico metodos de transformacion propios de intervetion
      $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600, 'center');
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
      <fieldset>
        <legend>Informacion General</legend>

        <label for="titulo">Titulo</label>
        <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

        <label for="precio">Precio</label>
        <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

        <label for="imagen">Imagen</label>
        <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">

        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion"><?php echo $descripcion;?></textarea>
      </fieldset>

      <fieldset>
        <legend>Informacion Propiedad</legend>

        <label for="habitaciones">Habitaciones</label>
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej.3" min="1" max="9" value="<?php echo $habitaciones; ?>">

        <label for="wc">Baños</label>
        <input type="number" id="wc" name="wc" placeholder="Ej.3" min="1" max="9" value="<?php echo $wc; ?>">

        <label for="estacionamiento">Estacionamiento</label>
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej.3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
      </fieldset>

      <fieldset>
        <legend>Vendedor</legend>

        <select name="vendedores_id">
          <option value="">-- Selecciona un Vendedor --</option>
          <?php while($vendedor = mysqli_fetch_assoc($resultado) ): ?>

            <option 
              <?php echo $vendedores_Id === $vendedor['id'] ? 'selected' : ''; ?>   
              value="<?php echo $vendedor['id'] ?>">
              <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?>
            </option>

          <?php endwhile; ?>
        </select>
      </fieldset>

      <input type="submit" value="Crear Propiedad" class="boton boton-verde">

    </form>




  </main>

<?php incluirTemplate('footer'); ?>