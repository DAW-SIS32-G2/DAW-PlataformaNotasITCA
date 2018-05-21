
function mostrarDiv(tipoDiv,idModulo)
{
	var div = document.getElementById('div'+tipoDiv);

	if(div.classList.contains('visible'))
	{
		div.classList.remove('visible');
		div.classList.add('oculto');
	}
	else
	{
		div.classList.remove('oculto');
		div.classList.add('visible');
	}

	if(tipoDiv == "SubirGuias" && div.classList.contains('visible'))
	{
		div.innerHTML='\
					\
					<button onclick="mostrarDiv(\''+tipoDiv+'\',0)">X</button><br><br><h3>Subir guias</h3>\
					<form method="post" enctype="multipart/form-data">\
						<input type="hidden" name="MAX_FILE_SIZE" value="62914560"> \
						<input type="file" name="guia"><br><br>\
						<input type="hidden" name="idModulo" value="'+idModulo+'">\
						<input type="submit" value="Subir guia al modulo" name="GuardarGuia">\
					</form>\
					';
	}
	else if(tipoDiv == "Practicas" && div.classList.contains('visible'))
	{
		div.innerHTML='\
					\
					<button onclick="mostrarDiv(\''+tipoDiv+'\','+idModulo+')">X</button><br><br><h3>Ver guias</h3><br>\
					<div id="verGuias"></div>\
					';
					mostrarGuias(idModulo);
	}

	
}

function comprimirGuias(ruta,archivo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/zip',
	      data      : {ruta : ruta, archivo : archivo, comprimir : true},
	      success   : function(respuesta)
	      {
	        descargar(respuesta);
	      }
	  });
}

function descargar(archivo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/procesarDescarga',
	      data      : {ruta: archivo},
	      success   : function(respuesta)
	      {
	        window.location.href="descargar";
	      }
	  });
	
}
/*Fuera de uso*/
/*
function borrarZip(ruta)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/zip',
	      data      : {ruta: ruta, borrar : true},
	      success   : function(respuesta)
	      {
	        
	      }
	  });
}
*/
function actualizarTotal(idTotal,idAgregar,valorActual)
{
	var total = document.getElementById(idTotal);
	var agregar = document.getElementById(idAgregar).value;

	if(agregar==="")
	{
		agregar=0;
	}

	var totalCant = total.value;

	

	totalCant= parseFloat(totalCant-valorActual);

	totalCant=Math.round(totalCant);

	totalCant=parseFloat(totalCant) + parseFloat(agregar);

	total.value=totalCant;

	document.getElementById(idAgregar).setAttribute("onkeyup", "actualizarTotal("+idTotal+","+idAgregar+","+agregar+");");
	document.getElementById(idAgregar).setAttribute("onchange", "actualizarTotal("+idTotal+","+idAgregar+","+agregar+");");
	
}

function verificarPonderaciones(idTotal)
{
	var total=document.getElementById(idTotal);
	
	if(total.value != 100)
	{
		alert('Error. El total de las ponderaciones debe ser igual a 100%.');
		return false;
	}
	else
	{
		return true;
	}
}
