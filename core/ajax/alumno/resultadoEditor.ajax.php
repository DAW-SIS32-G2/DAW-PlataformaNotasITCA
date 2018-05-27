<?php 
	session_start();
	$string = "<html><head><style type='text/css'>".$_POST['css']."</style><script type='text/javascript'>".$_POST['js']."</script></head><body>".$_POST['html']."</body></html>";

	$archivo = fopen("Archivos/Editor/resultado".$_SESSION['usuario'].".html","w");
	fputs($archivo,$string);
	fclose($archivo);
?>