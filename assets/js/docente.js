/*Funciones generales*/


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

function comprimirDirectorio(ruta,archivo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/zip',
	      data      : {ruta : ruta, archivo : archivo, comprimirDirectorio : true},
	      success   : function(respuesta)
	      {
	      	if(!respuesta)
	      	{
	      		alert("No hay archivos en este directorio.");
	      	}
	      	else
	      	{
		        descargar(respuesta);
	      	}
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

var resultadoVerificarDocente="";
function verificarDocente()
{
	var carnet=document.getElementById('carnetDocente');
	var contra=document.getElementById('contraDocente');

	verificarEnvioFormulario(contra.value,carnet.value);

	var resultado=resultadoVerificarDocente;
	
	if(resultado==1)
	{
		return true;
	}
	else if(resultado==0)
	{
		alert("Las contraseñas no coinciden. Intentelo de nuevo");
		document.getElementById('contraDocente').value="";
		document.getElementById('contraDocente').focus();
		return false;
	}
	
}

/*Funciones para admin grupo*/

function mostrarGuias(idModulo)
{
  $.ajax({
      type      : 'post',
      url       : 'ajax/adminGrupo',
      data      : {"idModulo": idModulo, mostrarGuias : true},
      success   : function(respuesta)
      {
        document.getElementById('practicas').innerHTML = respuesta;
      }
  })

}

function mostrarDiv(tipoDiv,idModulo)
{
	var div = document.getElementById('div'+tipoDiv);

	if(div.classList.contains('visible'))
	{
		div.classList.remove('visible');
		div.classList.add('oculto');

		div.innerHTML="";
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
	else if(tipoDiv == 'Contra' && div.classList.contains('visible'))
	{
		div.innerHTML='\
					\
					<button onclick="mostrarDiv(\''+tipoDiv+'\','+idModulo+')">X</button><br><br><h3>Administrar seguridad</h3><br>\
					<div id="adminSeguridad"></div>\
					';
					mostrarAdminSeguridad(idModulo);
	}
	else if(tipoDiv == 'Ponderaciones' && div.classList.contains('visible'))
	{
		div.innerHTML='\
					\
					<button onclick="mostrarDiv(\''+tipoDiv+'\','+idModulo+')">X</button><br><br><h3>Administrar ponderaciones</h3><br>\
					<div id="adminPonderaciones"></div>\
					';
					mostrarAdminPonderaciones(idModulo);
	}
	else if(tipoDiv == 'EstadoModulo' && div.classList.contains('visible'))
	{
		div.innerHTML='\
					\
					<button onclick="mostrarDiv(\''+tipoDiv+'\','+idModulo+')">X</button><br><br><h3>Administrar modulo</h3><br>\
					<div id="adminModulo"></div>\
					';
					mostrarAdminModulo(idModulo);
	}

	
}

function comprimirGuias(rutaG,archivo,rutaP)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/zip',
	      data      : {rutaGuias : rutaG, archivo : archivo, rutaPracticas : rutaP, comprimir : true},
	      success   : function(respuesta)
	      {
	      	if(!respuesta)
	      	{
	      		alert("No hay archivos en este modulo.");
	      	}
	      	else
	      	{
		        descargar(respuesta);
	      	}
	      }
	  });
}


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
	
	if(total.value > 100 || total.value < 0)
	{
		alert('Error. El total de las ponderaciones no debe ser mayor a 100% ni menor a 0%.');
		return false;
	}
	else
	{
		return true;
	}
}
	


function verificarEnvioFormulario(contra,carnet)
{
	$.ajax({
	      type      : 'post',
	      async		:  false,
	      url       : 'ajax/adminGrupo',
	      data      : {contraDocente: contra, carnetDocente : carnet, validarContraDocente : true},
	      success   : function(respuesta)
	      {
	      	resultadoVerificarDocente= respuesta;
	      }
	  });
}



function mostrarAdminSeguridad(idModulo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, adminSeguridad : true},
	      success   : function(respuesta)
	      {
	        document.getElementById('seguridadMod').innerHTML = respuesta;
	      }
	  });
}

function mostrarAdminPonderaciones(idModulo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, mostrarModificarPonderaciones : true},
	      success   : function(respuesta)
	      {
	        document.getElementById('adminPonderaciones').innerHTML = respuesta;
	      }
	  });
}

function mostrarAdminModulo(idModulo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, mostrarAdminModulo : true},
	      success   : function(respuesta)
	      {
	        document.getElementById('adminModulo').innerHTML = respuesta;
	      }
	  });
}

function agregarPonderacion(idModulo, totalPorcentajes)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, totalPorcentajes : totalPorcentajes, agregarPonderacion : true},
	      success   : function(respuesta)
	      {
	        document.getElementById('adminPonderaciones').innerHTML = respuesta;
	      }
	  });
}

function mostrarModificarContra(idModulo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, mostrarModificarContra : true},
	      success   : function(respuesta)
	      {
	      	$("#seguridadModal").modal('hide')
	        document.getElementById('adminSeguridad').innerHTML = respuesta;
	        $("#adminSeguridadModal").modal('show')
	      }
	  });
}

function mostrarEliminarContra(idModulo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idModulo: idModulo, mostrarEliminarContra : true},
	      success   : function(respuesta)
	      {
	      	$("#seguridadModal").modal('hide')
	        document.getElementById('adminSeguridad').innerHTML = respuesta;
	        $("#adminSeguridadModal").modal('show')
	      }
	  });
}

function confirmarBorrarPonderacion(idPonderacion, idModulo)
{
		$.ajax({
	      type      : 'post',
	      url       : 'ajax/adminGrupo',
	      data      : {idPonderacion: idPonderacion, idModulo : idModulo, ConfirmarBorrarPonderacion : true},
	      success   : function(respuesta)
	      {
	        document.getElementById('adminPonderaciones').innerHTML = respuesta;
	      }
	  });
}

function comprimirPracticasPonderacion(rutaArchivo, archivo)
{
	$.ajax({
	      type      : 'post',
	      url       : 'ajax/zip',
	      data      : {rutaArchivo : rutaArchivo, archivo : archivo, comprimirPracticasPonderacion : true},
	      success   : function(respuesta)
	      {
	      	if(!respuesta)
	      	{
	      		alert("No hay archivos en esta ponderacion.");
	      	}
	      	else
	      	{
		        descargar(respuesta);
	      	}
	      }
	  });
}

function verificarMaximoPorcentaje(porcentajeMaximo)
{
	var porcentaje=document.getElementById('porcentajePonderacion');

	if(porcentaje.value>parseInt(porcentajeMaximo))
	{
		alert('El porcentaje no puede exceder el '+porcentajeMaximo+'%.');
		porcentaje.focus();
		return false;
	}
	else
	{
		return true;
	}
}


//Funciones para notas
function cargarPracticas(val)
{
$.ajax({

  type      : 'post',
  url       : 'ajax/nota',
  data      : {grupo : val},
  success   : function(select)
  {
    $('#practicas').html(select)
  }
})
}

function cargarAlumnos(tarea)
{
$.ajax({

  type      : 'post',
  url       : 'ajax/nota',
  data      : {idTarea : tarea,
               idModulo  : $("input[name=idModulo]").val()
              },
  success   : function(select)
  {
    $('#tablaRes').html(select)
  }
})
}

function updNota(identificador)
{
var valores = "#valores"+identificador;
var ejercicios = "#ejercicios"+identificador;
var not = "#nota"+identificador;
var val = $(valores).val();
var eje = $(ejercicios).val();
var nota = ((val/eje)*10).toFixed(2);
$(not).html(nota);
}       

function validarNotas(total)
{
	var valores = [];
	$("input[name='valor']").each(function() {
	    valores.push($(this).val());
	});

	var maximo = []
	$("input[name='valor']").each(function() {
	    maximo.push($(this).attr("max"));
	});
	var correctos = 0;

	for(var i=0;i<total;i++)
	{
		var campo = "#valid" + parseInt(i+1);
		if(parseInt(valores[i]) > parseInt(maximo[i]))
		{
			$(campo).html("<small style='color:red'>El valor excede el máximo permitido</small>");
		}
		else
		{
			correctos++;
			$(campo).html("");
		}
	}

	if(correctos == total)
	{
		serializar();
	}
}

function serializar()
{
var valores = [];
$("input[name='valor']").each(function() {
    valores.push($(this).val());
});

var carnets = [];
$("input[name='carnet']").each(function() {
    carnets.push($(this).val());
});

$.ajax({
  type    : 'post',
  url     : 'ajax/nota',
  data    : {
              'actualizar' : 1,
              'valores'    : valores,
              'carnets'    : carnets,
              'tarea'	   : $("#grupo").val(),
            },
  success : function(mensaje) {
              $("#mensajenotas").html(mensaje);
            }
});
}    

//Funcion para modificar datos del estudiante
function modificarAlumno()
{
	var nombres = $("#nombres").val();
	var apellidos = $("#apellidos").val();
	var cont = 0;

	if(nombres == "")
	{
		$("#respuestaNom").html("<small style='color: red'>Este campo no puede estar vacío</small>");
		cont++;
	}
	else
	{
		$("#respuestaNom").html("");
	}

	if(apellidos == "")
	{
		$("#respuestaApe").html("<small style='color: red'>Este campo no puede estar vacío</small>");
		cont++;
	}
	else
	{
		$("#respuestaApe").html("");
	}

	if(cont == 0)
	{
		$.ajax({
			type	: 'post',
			url		: 'ajax/progrupo',
			data    : {
						'modificar' : 1,
						'nombres' 	: nombres,
						'apellidos' : apellidos,
						'carnet'	: $("#carnet2").val()
					  },
			success : function(mensaje)
					  {
					  		if(mensaje == 1)
					  		{
					  			$("#modificarModal").modal('hide');
					  			$("#respuestaForm").modal('show');
					  		};
					  }
		});
		
	}
}

//Funcion para desinscribir un alumno
function EliminarAlumno()
{
	$.ajax({
		type	: "post",
		url		: "ajax/progrupo",
		data    : {
					'eliminar' 	: 1,
					'carnet'	: $("#carnet").val(),
					'idModulo'  : $("#idmodulo").val()
				  },
		success : function(e) {
					if(e == 1)
					{
						$("#eliminarModal").modal('hide');
					  	$("#respuestaForm").modal('show');
					}
					else
					{
						alert(e);
					}
				  }
	})
}

//Funcion para cambiar la clave de un docente
function cambiarPassDocente()
{
	var carnet = $("#carnet").val();
	var passOrig = $("#passOrig").val();
	var pass1 = $("#passN1").val();
	var pass2 = $("#passN2").val();
	var vacios = 0;

	if(carnet == "" || passOrig == "" || pass1 == "" || pass2 == "")
		vacios++;
	else
		vacios = 0;

	if(vacios == 0)
	{
		$.ajax({
			type	: "post",
			url		: "ajax/cambiarclave",
			data 	: {
						"carnet"	: carnet,
						"passOrig"	: passOrig,
						"pass1"		: pass1,
						"pass2"		: pass2,
					  },
			success : function(mensaje)
					  {
					  	$("#respuesta").html(mensaje)
					  }
		});
	}
	else
	{
		$("#respuesta").html("<div class='alert alert-danger'><strong>Error:</strong> Uno o más campos están vacíos, revise e intente de nuevo</div>")
	}
}

/*Funciones para administrarPracticas.php*/

function mostrarPonderaciones()
{
  //Procesar
  $.ajax({
      type      : 'post',
      url       : 'ajax/administrarPracticas',
      data      : {modulo: $('#moduloIngresar').val(),administrar: "true"},
      success   : function(respuesta)
      {
        document.getElementById('resultado').innerHTML = respuesta;
      }
  })

}

function mostrarPracticas()
{
  //Procesar
  $.ajax({
      type      : 'post',
      url       : 'ajax/administrarPracticas',
      data      : {modulo: $('#moduloMostrar').val(),mostrar: "true"},
      success   : function(respuesta)
      {
        document.getElementById('resultadoPracticas').innerHTML = respuesta;
      }
  })

}