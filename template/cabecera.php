<?php
session_start();
if(!isset($_SESSION["nombre_usuario"])) {
    header("Location: ../index.php");
    exit();
    
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">RedSocial</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./mostraramigos.php">Amigos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./admin/index.php">Login admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./cerrar.php">cerrar</a>
        </li>
      </ul>
     
    </div>
  </div>
</nav>
<br>
  <div
    class="container">
    <br>
    <div
      class="row">