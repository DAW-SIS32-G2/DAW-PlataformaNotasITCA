<?php
  session_start();
  require_once "../config/variables.php";
  require_once "../config/bd.php";
  require_once "../core/funcionesbd.php";
  $_SESSION['usuario'] = $_POST['carnet'];
  //Carnet que servirá para hacer la consulta en la BD
  $carnet = $_POST['carnet'];

  if($_POST['enviar'] == "docente")
  {
    $carnet = $_POST['carnet'];
		$pass = $_POST['pass'];
		$conn = new funcionesBD();
		$mensaje = $conn->logueo($carnet,$pass,'docente');
    if($mensaje == 1)
    {
      $_SESSION['tipo'] = "docente";
      header("location: ".urlBase."docente");
    }
    else
    {
      ?>
      <script type="text/javascript">
          alert("Sus datos no son correctos");
          window.location.replace("<?= urlBase ?>");
      </script>
      <?php
    }
  }
  else {
    $carnet = $_POST['carnet'];
		$pass = $_POST['pass'];
		$conn = new funcionesBD();
		$mensaje = $conn->logueo($carnet,$pass,'alumno');
    if($mensaje == 1)
    {
      $_SESSION['tipo'] = "alumno";
      header("location: ".urlBase."alumno");
    }
    else
    {
      ?>
      <script type="text/javascript">
          alert("Sus datos no son correctos");
          window.location.replace("<?= urlBase ?>");
      </script>
      <?php
    }
  }

  //Funcion que procesará el login según la BD
  //$tipo se refiere a si es docente o alumno
  function procesar($tipo)
  {

  }
?>
