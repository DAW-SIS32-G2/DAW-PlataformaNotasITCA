
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
						<font color="red">Puede subir archivos con espacios, tildes o lo que a usted le de la gana</font>\
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