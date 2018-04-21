<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Plataforma de Notas ITCA-FEPADE</title>
  <link rel="stylesheet" href="<?= css ?>reset.min.css">
  <!-- <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'> -->
  <link rel='stylesheet prefetch' href='<?= css ?>font-awesome.min.css'>
  <link rel="stylesheet" href="<?= css ?>style.css">
</head>
<body>
  <div class="container">
    <div class="form">
      <div class="thumbnail"><img src="<?= imagenes ?>logo-new-white.png" /></div>
      <form class="register-form" method="post" action="<?= urlBase ?>core/procesarusuario.php">
        <label>Docentes</label>
        <input type="text" name="carnet" placeholder="Carnet" required/>
        <input type="password" name="pass"  placeholder="Contraseña" required/>
        <button type="submit" name="enviar" value="docente">Iniciar Sesión</button>
        <p class="message">¿Eres un alumno? <a href="#">Inicia sesión aquí</a></p>
      </form>
      <form class="login-form"  method="post" action="<?= urlBase ?>core/procesarusuario.php">
        <label>Estudiantes</label>
        <input type="text" name="carnet" pattern="[0-9]{6}" placeholder="Carnet" required maxlength="6"/>
        <input type="password" name="pass"  placeholder="Contraseña" required/>
        <p class="message2">La clave por defecto es "itca" (Sin las comillas)</p>
        <button type="submit" name="enviar" value="alumno">Iniciar sesión</button>
        <p class="message">¿Eres un docente? <a href="#">Inicia sesión aquí</a></p>
      </form>
    </div>
  </div>
  <script src='<?= js ?>jquery.min.js'></script>
  <script src='<?= js ?>index.js'></script>
</body>

</html>
