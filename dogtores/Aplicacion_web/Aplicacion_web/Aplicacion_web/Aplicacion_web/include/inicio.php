<?php
  session_start();
  
  if (!isset($_SESSION["usuario"])) {
    header("Location: Login.html");
    exit();
  }

?>


<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bienvenido</title>
</head>
<body>
  <h1>Hola, <?php echo htmlspecialchars($_SESSION["usuario"]); ?> 👋</h1>
  <p>¡Has iniciado sesión correctamente!</p>
  <a href="include/logout.php">Cerrar sesión</a>
</body>
</html>