
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

	div.innerHTML='\
					\
					<form method="post" enctype="multipart/form-data">\
						<input type="hidden" name="MAX_FILE_SIZE" value="62914560"> \
						<input type="file" name="guia">\
						\
						<input type="hidden" name="idModulo" value="'+idModulo+'">\
						<input type="submit" value="Subir guia al modulo" name="GuardarGuia">\
					</form>\
					';
}