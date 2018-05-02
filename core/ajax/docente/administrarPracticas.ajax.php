<?php
  define('__ROOT__',dirname(dirname(dirname(dirname(__FILE__)))));
  require_once(__ROOT__.'/core/funcionesbd.php');
  $objDocenteModelo=new docenteModelo();

  //La condicion luego se actualizará conforme a los docentes que impartan en cada grupo
  $modulo = $_POST['modulo'];

  $resultado=$objDocenteModelo->BuscarPonderaciones($modulo);

  if(gettype($resultado)=="string")
  {
    echo $resultado;
  }
  else
  {
    if ($resultado->num_rows==0)
    {
      echo "Este modulo no tiene ponderaciones asignadas. Por favor comuniquese con su administrador de bases de datos.";
    }
    else
    {
      $i=0;
      while($arrayPonderaciones=$resultado->fetch_array(MYSQLI_ASSOC))
      {
        $ponderacionesOrdenadas[$i]=$arrayPonderaciones['nombrePonderacion'];
        $porcentajesOrdenados[$i]=$arrayPonderaciones['porcentaje'];
        $idPonderaciones[$i]=$arrayPonderaciones['idPonderacion'];
        $i++;
      }

      $conteo=count($ponderacionesOrdenadas);

      echo '<select name="ponderacion">';

      for ($i=0;$i<$conteo;$i++)
      { 
        ?>
          
          <option value="<?php echo $idPonderaciones[$i]; ?>"><?php echo $ponderacionesOrdenadas[$i]." - ".$porcentajesOrdenados[$i]."%"; ?></option>

        <?php
      }

      echo "</select>";
    }
    
  }

?>
