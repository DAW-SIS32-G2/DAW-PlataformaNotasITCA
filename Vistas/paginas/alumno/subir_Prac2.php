<?php
    session_start();
    require_once("./././core/funcionesbd.php");
    if(isset($_POST['subir']))
    {
        //Si se cargan varias tareas, necesitamos saber cuál campo se ha usado
        $nomControl = "guia".$_POST['subir'];

        //Obtenemos el nombre original
        $nomOriginal = $_FILES[$nomControl]['name'];

        //Ahora obtendremos la carpeta en donce se subiurá el archivo
        $objBD = new funcionesBD();
        $res = $objBD->ConsultaPersonalizada("SELECT directorio from tarea where idTarea = '".$_POST['subir']."'");
        while($fila = $res->fetch_array(MYSQLI_ASSOC))
        {
            $ruta = $fila['directorio'];
        }

        //Ahora generamos el nombre que le daremos al archivo subido
        $nuevoNom = $_POST['subir']."-".$_SESSION['usuario']."-".$nomOriginal;

        //Finalmente subimos el archivo con el nuevo nombre a la carpeta correspondiente
        if(move_uploaded_file($_FILES[$nomControl]['tmp_name'], dirname(__FILE__,4)."/Practicas/".$ruta."/".$nuevoNom))
        {
            //El archivo se movió con exito, procedemos a insertar el registro en tareas, para poder cerrarlo
            if($respuesta = $objBD->insertar("TareaSubidaPor","carnet,idTarea,ruta","'".$_SESSION['usuario']."','".$_POST['subir']."','".$ruta."/".$nuevoNom."'"))
            {
                //Si la inserción funciona, termina el proceso, se recarga
                ?>
                <script type="text/javascript">
                    alert("Practica subida con exito");
                    window.location.replace("subir_Prac");
                </script>
                <?php
            }
            else
            {
                echo "Algo salió mal con la insercion en la BD";
            }
        }
        else
        {
            echo "No se pudo subir el archivo";
        }
    }
?>