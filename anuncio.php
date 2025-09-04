<?php
  require 'includes/funciones.php'; 
  incluirTemplate('header');
?>

  <main class="contenedor seccion contenido-centrado">
    <h1>Casa en Venta frente al bosque</h1>
    <div class="imagen">
      <picture>
        <source srcset="build/img/destacada.webp" type="image/webp">
        <source srcset="build/img/destacada.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada.jpg" alt="Imagen Destacada">
      </picture>
    </div> <!-- .imagen -->

    <div class="resumen-propiedad">
      <p class="precio">$3.000.000</p>
      <ul class="iconos-caracteristicas">
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
          <p>3</p>
        </li>
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
          <p>3</p>
        </li>
        <li>
          <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
          <p>4</p>
        </li>                                    
      </ul>
      <p>
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum recusandae voluptas nulla beatae? Repudiandae, magni non praesentium, eius reprehenderit architecto commodi impedit ad illo delectus recusandae iste nam veritatis vel!loremlorem Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, tempora quod optio facilis esse quis quidem fuga nostrum hic minima, quisquam reprehenderit cum. Minus, culpa a quo libero omnis officiis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo vitae consequuntur quis voluptate accusantium quam aspernatur omnis, ipsa recusandae optio error nemo placeat earum ex exercitationem suscipit voluptatem ratione nesciunt?</p>

        <p>iste nam veritatis vel!loremlorem Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, tempora quod optio facilis esse quis quidem fuga nostrum hic minima, quisquam reprehenderit cum. Minus, culpa a quo libero omnis officiis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo vitae consequuntur quis voluptate accusantium quam aspernatur omnis, ipsa recusandae optio error nemo placeat earum ex exercitationem suscipit voluptatem ratione nesciunt?
      </p>


    </div>




  </main>

<?php incluirTemplate('footer'); ?>
