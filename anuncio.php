<?php
  // recupero el id de la url
  $id = $_GET['id'];  
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if(!$id) {
    header('Location: /');      // si no hay un id valido, lo devuelvo a la pagina principal
  }

  require 'includes/app.php';   
  $db = conectarDB();  

  // escribir el query 
  $consulta = "SELECT * FROM propiedades WHERE id={$id}";

  // consultar la Base de Datos
  $resultado = mysqli_query($db, $consulta);
  // valido que haya encontrado un registro (usamos notacion objetos)
  if(!$resultado->num_rows) {
    header('Location: /');  
  }
  $propiedad = mysqli_fetch_assoc($resultado);

  incluirTemplate('header');
?>

  <main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad['titulo'];?></h1>
    <div class="imagen">
      <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen'];?>" alt="Imagen Destacada">
    </div> <!-- .imagen -->

    <div class="resumen-propiedad">
      <p class="precio">$<?php echo $propiedad['precio'];?></p>
      <ul class="iconos-caracteristicas">
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
          <p><?php echo $propiedad['wc'];?></p>
        </li>
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
          <p><?php echo $propiedad['estacionamiento'];?></p>
        </li>
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
          <p><?php echo $propiedad['habitaciones'];?></p>
        </li>                                    
      </ul>
      <p><?php echo $propiedad['descripcion'];?> </p>


    </div> <!-- .resumen-propiedad -->

  </main>

<?php
  mysqli_close($db);

  incluirTemplate('footer');
?>

