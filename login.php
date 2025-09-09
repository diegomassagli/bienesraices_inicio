<?php

// importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

$errores = [];


// Autenticar el usuario
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email= mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL )) ;
  $password = mysqli_real_escape_string( $db, $password= $_POST['password'] );

  if(!$email) {
    $errores[] = "El Email es obligatorio o no es valido";
  }
  if(!$password) {
    $errores[] = "El Password es obligatorio o no es valido";
  }  

  if( empty( $errores ) ) {
    // revisar si el usuario existe
    $query = " SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($db, $query);

    if( $resultado->num_rows ) {
      $usuario = mysqli_fetch_assoc($resultado);
      // revisar si el password esta bien
      $auth = password_verify($password, $usuario['password']);
      if( $auth ) {
        // autenticar al usuario
        session_start();
        // llenar el arreglo de la sesion
        $_SESSION['usuario'] = $usuario['email'];
        $_SESSION['login'] = true;

        // una vez que el usuario esta logueado redirigirlo a la pagina inicial
        
        header('Location: /admin');

      } else {
        $errores[] = "El password es incorrecto";
      }

    } else {
      $errores [] = "El usuario no existe";
    }
  }
}

// Incluye el header
  require 'includes/funciones.php'; 
  incluirTemplate('header');
?>

  <main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesion</h1>

    <?php foreach($errores as $error) : ?>
      <div class="alerta error">
        <?php echo $error; ?>
      </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario">
      <fieldset>
        <legend>Email y Password</legend>
        
        <label for="email">Email</label>
        <input type="email" placeholder="Tu Email" id="email" name="email">

        <label for="password">Pasword</label>
        <input type="password" placeholder="Tu Password" id="password" name="password">

      </fieldset>
      <input type="submit" value="Iniciar Sesion" class="boton-verde"/>
    </form>
  </main>

<?php incluirTemplate('footer'); ?>