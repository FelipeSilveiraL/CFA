<?php
include('query.php');
include('counts.php');


echo '
<script>

var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};

var lineChartData = {
    labels: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
    datasets: [{
            label: "Participantes(Membros)",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: ["' . $janeiroV['visitantes'] . '","' . $fevereiroV['visitantes'] . '","' . $marcoV['visitantes'] . '","' . $abrilV['visitantes'] . '","' . $maioV['visitantes'] . '","' . $junhoV['visitantes'] . '","' . $julhoV['visitantes'] . '","' . $agostoV['visitantes'] . '","' . $setembroV['visitantes'] . '","' . $outubroV['visitantes'] . '","' . $novembroV['visitantes'] . '","' . $dezembroV['visitantes'] . '"]
        },
        {
            label: "Visitantes",
            fillColor: "rgba(48, 164, 255, 0.2)",
            strokeColor: "rgba(48, 164, 255, 1)",
            pointColor: "rgba(48, 164, 255, 1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(48, 164, 255, 1)",
            data: ["' . $janeiroP['participantes'] . '","' . $fevereiroP['participantes'] . '","' . $marcoP['participantes'] . '","' . $abrilP['participantes'] . '","' . $maioP['participantes'] . '","' . $junhoP['participantes'] . '","' . $julhoP['participantes'] . '","' . $agostoP['participantes'] . '","' . $setembroP['participantes'] . '","' . $outubroP['participantes'] . '","' . $novembroP['participantes'] . '","' . $dezembroP['participantes'] . '"]
        }
    ]

}
	
    
var happydata = {
    labels : ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
    datasets : [
        
        {
            fillColor : "rgba(48, 164, 255, 0.2)",
            strokeColor : "rgba(48, 164, 255, 0.8)",
            highlightFill : "rgba(48, 164, 255, 0.75)",
            highlightStroke : "rgba(48, 164, 255, 1)",
            data : ["' . $janeiro['aniversarios'] . '","' . $fevereiro['aniversarios'] . '","' . $marco['aniversarios'] . '","' . $abril['aniversarios'] . '","' . $maio['aniversarios'] . '","' . $junho['aniversarios'] . '","' . $julho['aniversarios'] . '","' . $agosto['aniversarios'] . '","' . $setembro['aniversarios'] . '","' . $outubro['aniversarios'] . '","' . $novembro['aniversarios'] . '","' . $dezembro['aniversarios'] . '"]
        }
    ]

}        

var etarias = [';

$babys = 0;
$kids = 0;
$juvenis = 0;
$jovem = 0;
$adulto = 0;
$idoso = 0;

while ($etinias = $resultEtinias->fetch_assoc()) {

    $idade = date('Y') - date('Y', strtotime($etinias['data_nascimento']));

    if ($idade <= 3) {
        $babys++;
    } elseif ($idade >= 4 and $idade <= 9) {
        $kids++;
    } elseif ($idade >= 10 and $idade <= 13) {
        $juvenis++;
    } elseif ($idade >= 14 and $idade < 19) {
        $jovem++;
    } elseif ($idade > 19 and $idade <= 59) {
        $adulto++;
    } else {
        $idoso++;
    }
}

echo  '
    {
        value: ' . $babys . ',
        color:"#ff30e6",
        highlight: "#62b9fb",
        label: "Babys" //0 até 3 anos
    },
    {
        value: ' . $kids . ',
        color:"#30a5ff",
        highlight: "#62b9fb",
        label: "Kids" //4 até 9 anos
    },
    {
        value: ' . $juvenis . ',
        color:"#3dd14f",
        highlight: "#62b9fb",
        label: "Juvenis" //10 até 13 anos
    },
    {
        value: ' . $jovem . ',
        color: "#ffb53e",
        highlight: "#fac878",
        label: "Jovem" //13 até 19 anos
    },
    {
        value: ' . $adulto . ',
        color: "#006400",
        highlight: "#32CD32",
        label: "Adulto" // 20 até 59 anos
    },
    {
        value: ' . $idoso . ',
        color: "#f9243f",
        highlight: "#f6495f",
        label: "Idoso" //apartir de 60 anos
    }

];

var cargos = [';

function random_color($start = 0x000000, $end = 0xFFFFFF)
{
    return sprintf('#%06x', mt_rand($start, $end));
}

while ($cargos = $resultCargos->fetch_assoc()) {
    echo '
        {
            value: ' . $cargos['cargo'] . ',
            color:"' . random_color() . '",
            highlight: "' . random_color() . '",
            label: "' . $cargos['nome'] . '"
        },';
}

echo ' ];


var civil = [';

$casado = 0;
$solteiro = 0;

while ($civil = $resultCivil->fetch_assoc()) {


    if ($civil['estado_civil'] == 1) {
        $casado++;
    } else {
        $solteiro++;
    }
}

echo '
    {
        value: ' . $casado . ',
        color:"#30a5ff",
        highlight: "#62b9fb",
        label: "Casado"
    },
    {
        value: ' . $solteiro . ',
        color: "#ffb53e",
        highlight: "#fac878",
        label: "Solteiro"
    }

];

var sexos = [';

$homem = 0;
$mulher = 0;

while ($sexo = $resultSexo->fetch_assoc()) {


    if ($sexo['sexo'] == 1) {
        $homem++;
    } else {
        $mulher++;
    }
}

echo '
    {
        value: ' . $homem . ',
        color:"#30a5ff",
        highlight: "#62b9fb",
        label: "Masculino"
    },
    {
        value: ' . $mulher . ',
        color: "#f703d9",
        highlight: "#f96ee8",
        label: "Feminino"
    }

];

</script>
';
