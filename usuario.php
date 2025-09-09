<?php

  // importar la conexion
  require 'includes/config/database.php';
  $db = conectarDB();

  // crear un email y passoword
  $email = "diegomassagli@gmail.com";
  $password = "12691269";
  $passwordHash = password_hash($password, PASSWORD_BCRYPT);  // GENERA 60 CARACTERES FIJOS

  // Query para crear el usuario
  $query = " INSERT INTO usuarios (email, password) VALUES ('{$email}','{$passwordHash}');";

  // Agregarlo a la base de datos
  mysqli_query($db, $query);

?>