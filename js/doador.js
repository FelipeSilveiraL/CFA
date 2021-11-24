
function myFunctionOrigem() {
    var valueDoador = document.getElementById("listOrigem").value;

    if (valueDoador == 7) {
        document.getElementById("doador").style.display = "block";
        document.getElementById('cpfDoador').required = true
        document.getElementById('nomeDoador').required = true
        document.getElementById('lgpd').required = true
    } else {
        document.getElementById('cpfDoador').required = false
        document.getElementById("doador").style.display = "none";
        document.getElementById("cpfDoador").value = '';
        document.getElementById("nomeDoador").value = '';
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