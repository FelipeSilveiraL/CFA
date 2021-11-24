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

		}else{

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
