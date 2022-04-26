function ValidarCPF(cpf) {

	cpf = cpf.value.replace(".", "")
	cpf = cpf.replace(".", "")
	cpf = cpf.replace("-", "")

	var Soma;
	var Resto;
	Soma = 0;

	var invalidCPF = ['00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999']

	var valido = invalidCPF.indexOf(cpf);

	if (valido >= 0) {

		var retorno = false;

	} else {

		strCPF = cpf;

		for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
		Resto = (Soma * 10) % 11;

		if ((Resto == 10) || (Resto == 11)) Resto = 0;
		if (Resto != parseInt(strCPF.substring(9, 10))) {

			var retorno = false;

		} else {

			Soma = 0;
			for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
			Resto = (Soma * 10) % 11;

			if ((Resto == 10) || (Resto == 11)) Resto = 0;
			if (Resto != parseInt(strCPF.substring(10, 11))) {
				var retorno = false;
			} else {
				var retorno = true;
			}
		}
	}

	if (retorno != true) {
		alert('CPF invalido!');
		document.getElementById("cpfDoador").value = '';
	}
}

function fMasc(objeto, mascara) {
	obj = objeto
	masc = mascara
	setTimeout("fMascEx()", 1)
}

function fMascEx() {
	obj.value = masc(obj.value)
}

function mCPF(cpf) {
	cpf = cpf.replace(/\D/g, "")
	cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
	cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
	cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
	return cpf
}

function mask(o, f) {
	setTimeout(function () {
		var v = mphone(o.value);
		if (v != o.value) {
			o.value = v;
		}
	}, 1);
}

function mphone(v) {
	var r = v.replace(/\D/g, "");
	r = r.replace(/^0/, "");
	if (r.length > 10) {
		r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
	} else if (r.length > 5) {
		r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
	} else if (r.length > 2) {
		r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
	} else {
		r = r.replace(/^(\d*)/, "($1");
	}
	return r;
}

function casado() {
	var casado = document.getElementById('civil').value;

	if(casado == 1){
		document.getElementById('conjuge').style.display = "block";

	}else{
		document.getElementById('conjuge').style.display = "none";
	}
}

function filhos() {
	var filho = document.getElementById('possuiFilhos').value;

	if(filho == 1){
		document.getElementById('addFilho').style.display = "block";

	}else{
		document.getElementById('addFilho').style.display = "none";
	}
}

function cargoMembro() {
	var cargo = document.getElementById('cargo').value;

	if(cargo == 5){
		document.getElementById('mostrarSenha').style.display = "block";

	}else{
		document.getElementById('mostrarSenha').style.display = "none";
	}
}