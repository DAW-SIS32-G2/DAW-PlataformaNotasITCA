<?php
  session_start();
  @define("__ROOT__", dirname(dirname(__FILE__)));
  require_once __ROOT__."/config/variables.php";
  require_once __ROOT__."/config/bd.php";
  require_once __ROOT__."/core/funcionesbd.php";


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
      $_SESSION['usuario'] = $_POST['carnet'];
      $_SESSION['tipo'] = "docente";
      header("location: ".urlBase."docente");
    }
    else
    {
      unset($_SESSION['usuario']);
      ?>
      <script type="text/javascript">
          alert("<?php echo $mensaje ?> Sus datos no son correctos");
          window.location.replace("<?= urlBase ?>");
      </script>
      <?php
    }
  }
  else
  {
    $carnet = $_POST['carnet'];
		$pass = $_POST['pass'];
		$conn = new funcionesBD();
		$mensaje = $conn->logueo($carnet,$pass,'Usuario');
    if($mensaje == 1)
    {
      $_SESSION['usuario'] = $_POST['carnet'];
      $_SESSION['tipo'] = "alumno";
      header("location: ".urlBase."alumno");
    }
    else
    {
      unset($_SESSION['usuario']);
      ?>
      <script type="text/javascript">
          alert("Sus datos no son correctos");
          window.location.replace("<?= urlBase ?>");
      </script>
      <?php
    }
  }
?>
