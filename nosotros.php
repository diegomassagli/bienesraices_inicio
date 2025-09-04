<?php
  require 'includes/funciones.php'; 
  incluirTemplate('header');
?>


  <main class="contenedor seccion">
    <h1>Conoce sobre Nosotros</h1>
    <div class="contenido-nosotros">
      <div class="imagen">
        <picture>
          <source srcset="build/img/nosotros.webp" type="image/webp">
          <source srcset="build/img/nosotros.jpg" type="image/jpeg">
          <img loading="lazy" src="build/img/nosotros.jpg" alt="Imagen Sobre Nosotros">
        </picture>
      </div> <!-- .imagen -->
      <div class="texto-nosotros">
        <blockquote>25 Años de experiencia</blockquote>
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dolorum recusandae voluptas nulla beatae? Repudiandae, magni non praesentium, eius reprehenderit architecto commodi impedit ad illo delectus recusandae iste nam veritatis vel!loremlorem Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, tempora quod optio facilis esse quis quidem fuga nostrum hic minima, quisquam reprehenderit cum. Minus, culpa a quo libero omnis officiis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo vitae consequuntur quis voluptate accusantium quam aspernatur omnis, ipsa recusandae optio error nemo placeat earum ex exercitationem suscipit voluptatem ratione nesciunt?</p>

          <p>iste nam veritatis vel!loremlorem Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, tempora quod optio facilis esse quis quidem fuga nostrum hic minima, quisquam reprehenderit cum. Minus, culpa a quo libero omnis officiis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo vitae consequuntur quis voluptate accusantium quam aspernatur omnis, ipsa recusandae optio error nemo placeat earum ex exercitationem suscipit voluptatem ratione nesciunt?
        </p>
      </div> <!-- .texto-nosotros -->      

    </div>
  </main>

  <section class="contenedor seccion">
    <h1>Mas Sobre Nosotros</h1>
    <div class="iconos-nosotros">

      <div class="icono">
        <img src="build/img/icono1.svg" alt="icono seguridad" loading="lazy">
        <h3>Seguridad</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero temporibus harum doloribus id nobis aliquam sequi omnis aut quibusdam sunt ex repudiandae officia explicabo a neque dolore repellat, culpa autem?lorem</p>
      </div> <!-- .icono -->

      <div class="icono">
        <img src="build/img/icono2.svg" alt="icono precio" loading="lazy">
        <h3>Precio</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero temporibus harum doloribus id nobis aliquam sequi omnis aut quibusdam sunt ex repudiandae officia explicabo a neque dolore repellat, culpa autem?lorem</p>
      </div> <!-- .icono -->

      <div class="icono">
        <img src="build/img/icono3.svg" alt="icono tiempo" loading="lazy">
        <h3>A Tiempo</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Libero temporibus harum doloribus id nobis aliquam sequi omnis aut quibusdam sunt ex repudiandae officia explicabo a neque dolore repellat, culpa autem?lorem</p>
      </div> <!-- .icono -->            

    </div> <!-- .iconos-nosotros -->
  </section>

<?php incluirTemplate('footer'); ?>