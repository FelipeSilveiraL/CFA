
function myFunctionOrigem() {
    var valueDoador = document.getElementById("listOrigem").value;

    if (valueDoador == 7) {
        document.getElementById("doador").style.display = "block";
        document.getElementById('cpfDoador').required = true
        document.getElementById('nacionalidadeDoador').required = true
        document.getElementById('civilDoador').required = true
        document.getElementById('profissaoDoador').required = true
        document.getElementById('nomeDoador').required = true
        document.getElementById('rgDoador').required = true
        document.getElementById('lgpd').required = true
    } else {
        document.getElementById('cpfDoador').required = false
        document.getElementById('nacionalidadeDoador').required = false
        document.getElementById('civilDoador').required = false
        document.getElementById('profissaoDoador').required = false
        document.getElementById('rgDoador').required = false
        document.getElementById("doador").style.display = "none";
        document.getElementById("cpfDoador").value = '';
        document.getElementById("nomeDoador").value = '';        
        document.getElementById('nacionalidadeDoador').value = '';
        document.getElementById('civilDoador').value = '';
        document.getElementById('profissaoDoador').value = '';
        document.getElementById('rgDoador').value = '';
    }
}

function myFuncionTermo() {
    let lgpd = document.getElementById('lgpd');

    if (lgpd.checked) {
        document.getElementById("cpfDoador").disabled = false;
    } else {
        document.getElementById("cpfDoador").disabled = true;
        document.getElementById("cpfDoador").value = '';
    }
}