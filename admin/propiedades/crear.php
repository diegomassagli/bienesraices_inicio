<?php

  // Base de Datos
  require ('../../includes/config/database.php');
  $db = conectarDB();  


  // Consultar para obtener los vendedores
  $consulta = "SELECT * FROM vendedores";
  $resultado = mysqli_query($db, $consulta);

  // echo "<pre>";
  // var_dump($_SERVER["REQUEST_METHOD"]);
  // echo "</pre>";


  // Inicializo arreglo con mensajes de error y variables del formulario
  $errores = [];

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

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // // para leer las imagenes o archivos subidos no se usa la superglobal $_POST sin $_FILES (y necesito en enctype en el form)

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    
    // evita inyeccion sql mysqli_real_escape_string  (ademas deberiamos  utilizar FILTER_VALIDATE Y FILTER_SANITIZE)
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedores_Id = mysqli_real_escape_string($db, $_POST['vendedor']);
    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];
    $creado = date('Y/m/d');  

    if(!$titulo) {
      $errores[] = "Debes añadir un titulo";
    }
    if(!$precio) {
      $errores[] = "El precio es obligatorio";
    }
    if( strlen( $descripcion ) < 50 ) {
      $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
    }
    if(!$habitaciones ) {
      $errores[] = "El numero de habitaciones es obligatorio";
    }
    if(!$wc ) {
      $errores[] = "El numero de baños es obligatorio";
    }
    if(!$estacionamiento ) {
      $errores[] = "El numero de lugares de estacionamiento es obligatorio";
    }        
    if(!$vendedores_Id ) {
      $errores[] = "Elije  un vendedor";
    }    
    if(!$imagen['name'] ) {
      $errores[] = "Elije  una imagen, es obligatoria";
    }    
    // validar por tamaño por ejemplo maximo 100Kb
    $medida = 1024 * 1000;
    if($imagen['size'] > $medida || $imagen['error']) {
      $errores[] = "Elije  una imagen mas pequeña, el maximo son 1Mb";
    }    


    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    // Revisar que el arreglo de errores este vacio
    if( empty( $errores ) ) {

      // subida de archivos
      // crear carpeta
      $carpetaImagenes = '../../imagenes/';
      if( !is_dir($carpetaImagenes) ) {
        mkdir($carpetaImagenes);        
      }
      // generar un nombre unico
      $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

      // subir la imagen
      move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );     

      // Insertar en la base de datos 
      $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_Id) 
      VALUES ('$titulo', '$precio', '$nombreImagen',  '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_Id') ";
  
      //echo $query;
  
      $resultado = mysqli_query($db, $query);
  
      if($resultado) {
        // redireccionar al usuario FUNCIONA SOLAMENTE SI NO LLEGASTE A MOSTRAR NINGUN ELEMENTO HTML, SINO NO FUNCIONA
        header('Location: /admin?resultado=1');
      }
    }
  }


  require '../../includes/funciones.php'; 
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

        <select name="vendedor">
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