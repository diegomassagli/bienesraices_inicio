<?php
  if( !isset( $_SESSION ) ) {
    session_start();     
  } 

  $_SESSION = [];             // en lugar de hacer un destroy, para limpiar las sesiones lo igualo a un arreglo vacio
  header('Location: /');

