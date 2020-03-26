
function Longitud(form) {
	for (i = 0; i < form.elements.length; i++) {
		//Rutina para validar  la longitud de los campos
		if (form.elements[i].type == "text" && form.elements[i].value.length >= 50) {
			alert("El campo" + " " + form.elements[i].name + " " + "Tiene longitud no v\u00E1lida");
		}
	}
}

//Envia solicitando confirmación
function Enviar(form) {
	for (i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "text" || form.elements[i].type == "select-one"|| form.elements[i].type == "password") {
			if (form.elements[i].value == "") {
				if (form.elements[i].type == "text"|| form.elements[i].type == "password") {
					alert("Por favor complete todos los campos del formulario");
					form.elements[i].focus();
					return false;
				} else {
					alert("Por favor selecione un valor para el campo");
					form.elements[i].focus();
					return false;
				}
			} // form
		}
	}
	var pregunta = confirm("\u00BFEst\u00E1 Seguro?");
	if (pregunta == true) {
		form.submit();
	} else
		return false;
}
/*
function Enviar0(form) {
	for (i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "text" || form.elements[i].type == "select-one")
			if (form.elements[i].value == "") {
				if (form.elements[i].type == "text") {
					alert("Por favor complete todos los campos del formulario");
					form.elements[i].focus();
					return false;
				} else {
					alert("Por favor selecione un valor para el campo");
					form.elements[i].focus();
					return false;
				}

			} // form
	}
	form.submit();
}

function Enviar1(form) {
	var answer = confirm("\u00BFEst\u00E0 Seguro?");
	if (answer) {
		form.submit();
	}
}
*/

function aceptaNum(evt) {
	var nav4 = window.Event ? true : false;
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
}

function valida_texto(texto) {
	if (texto.length < 4) {
		alert("Escriba por lo menos 4 caracteres en el campo");
		//return (false);
	}

	var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú";
	var checkStr = texto;
	var allValid = true;
	for (i = 0; i < checkStr.length; i++) {
		ch = checkStr.charAt(i);
		for (j = 0; j < checkOK.length; j++)
			if (ch == checkOK.charAt(j))
				break;
		if (j == checkOK.length) {
			allValid = false;
			break;
		}
	}
	if (!allValid) {
		alert("Escriba s\u00F2lo letras en el campo");
		return (false);
	}
}

function aceptaLetra(evt) {
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (key == 32) || (key == 180) || (key == 193) || (key == 201) || (key == 205) || (key == 209) || (key == 211) || (key == 218) || (key == 220) || (key == 225) || (key == 233) || (key == 237) || (key == 241) || (key == 243) || (key == 250) || (key == 252));
}

function fecha() {
	hoy = new Date();
	num = ((hoy.getDate() < 10) ? "0" : "") + hoy.getDate();
	mes = hoy.getMonth() + 1;
	agno = hoy.getFullYear();
	Hoy = (agno + "-" + mes + "-" + num);
	document.write('<input name="FecCambio" type="text" readonly value=' + Hoy + '>');
}
/*
function Enviar2(form) {
	for (i = 0; i < form.elements.length; i++) {
		if (document.getElementById('combo').value == '') {
			alert("Debe seleccionar un valor");
			form.elements[i].focus();
			return false;
		}
	}
	form.submit();
}
*/
function commaSplit(srcNumber) {
	var txtNumber = '' + srcNumber;
	if (isNaN(txtNumber) || txtNumber == "") {
		//alert("Eso no parece ser un n�mero v�lido. Por favor, prueba de nuevo.");
		//fieldName.select();
		//fieldName.focus();
	} else {
		var rxSplit = new RegExp('([0-9])([0-9][0-9][0-9][,.])');
		var arrNumber = txtNumber.split('.');
		arrNumber[0] += '.';
		do {
			arrNumber[0] = arrNumber[0].replace(rxSplit, '$1,$2');
		} while (rxSplit.test(arrNumber[0]));
		if (arrNumber.length > 1) {
			return arrNumber.join('');
		} else {
			return arrNumber[0].split('.')[0];
		}
	}
}

function togglecomments(postid) {
	var whichpost = document.getElementById(postid);
	if (whichpost.className == "commentshown") {
		whichpost.className = "commenthidden";
	} else {
		whichpost.className = "commentshown";
	}
}
/*
	function stopRKey(evt) 
	{
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text")) 
		{
			return false;
		}
	}
*/