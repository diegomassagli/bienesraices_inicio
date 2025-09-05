<?php

  // Base de Datos (importar la conexion
  require ('../includes/config/database.php');
  $db = conectarDB();  

  // escribir el query 
  $consulta = "SELECT * FROM propiedades";

  // consultar la Base de Datos
  $resultadoConsulta = mysqli_query($db, $consulta);

  // Muestra mensaje condicional
  $resultado = $_GET['resultado'] ?? null;

  // incluye un template
  require '../includes/funciones.php'; 
  incluirTemplate('header');
?>

  <main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php if( intval( $resultado ) === 1): ?>
      <p class="alerta exito">Anuncio Creado Correctamente</p>           
    <?php endif; ?>
    <?php if( intval( $resultado ) === 2): ?>
      <p class="alerta exito">Anuncio Actualizado Correctamente</p>           
    <?php endif; ?>    

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>    

    <table class="propiedades">
      <thead>
        <tr>
          <th>ID</th>
          <th>Titulo</th>
          <th>Imagen</th>
          <th>Precio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody> <!-- Mostrar los Resultados -->
        <?php while ( $propiedad = mysqli_fetch_assoc($resultadoConsulta)): ?>
          <tr>
            <td><?php echo $propiedad['id'];?></td>
            <td><?php echo $propiedad['titulo'];?> </td>
            <td><img src="/imagenes/<?php echo $propiedad['imagen'];?>" class="imagen-tabla" alt="Imagen Propiedad"></td>
            <td>$<?php echo $propiedad['precio'];?></td>
            <td>
              <a href="#" class="boton-rojo-block">Eliminar</a>
              <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
            </td>           
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>

<?php 
  // opcional: cerrar la conexion
  mysqli_close($db);

  incluirTemplate('footer'); 
?>