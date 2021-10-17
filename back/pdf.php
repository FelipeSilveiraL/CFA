<?php
session_start();
//chamar o banco
require_once('../bd/conexao.php');
require_once('query.php');


switch ($_GET['modo']) {

	case '2':
		

		if (!empty($_GET['mes'])) {

			$queryUsuarios .= " WHERE U.deletar = 0 AND U.data_nascimento like '%/" . $_GET['mes'] . "/%'";
			$titulo = "<div><h1>Anivesariantes do Mês " . $_GET['mes'] . "</h1></div>";			
			$nomeArq = "cfa_aniversariantes.pdf";

		} else {

			$titulo = "<div><h1>Lista Membros</h1></div>";			
			$nomeArq = "cfa_membros.pdf";
		}

		$resultado = $conn->query($queryUsuarios);

		//corpo da msn
		$html = "
		<html>
			<style>
				td{
					border: solid 1px;
				}
			</style>	
			<body>
				";
		$html .= $titulo;
		$html .= "
				<table class='table table-sm' style='font-size:12px;'>
				  <thead>
					<tr>				
						<th scope='col'>NOME</th>
						<th scope='col'>E-MAIL</th>
						<th scope='col'>CELULAR</th>
						<th scope='col'>ESTADO CIVIL</th>				
						<th scope='col'>GENERO</th>				
						<th scope='col'>DATA NASCIMENTO</th>
						<th scope='col'>FAIXA ETARIA</th>
						<th scope='col'>CARGO</th>
						<th scope='col'>CELULA</th>
						<th scope='col'>ENDEREÇO</th>
						<th scope='col'>NUMERO</th>
						<th scope='col'>BAIRRO</th>
						<th scope='col'>CEP</th>
						<th scope='col'>CIDADE</th>
						<th scope='col'>ESTADO</th>
						<th scope='col'>PAIS</th>
					</tr>
				  </thead>
				  <tbody>";

		while ($membro = $resultado->fetch_assoc()) {

			$idade = date('Y') - date('Y', strtotime($membro['data_nascimento']));
			include('faixaEtaria.php');


			$html .= "
					<tr>";
			$html .=  empty($membro['nome']) ? '<td>----------</td>' : '<td>' . $membro['nome'] . " " . $membro['sobre_nome']  . '</td>';
			$html .=  empty($membro['email']) ? '<td>----------</td>' : '<td>' . $membro['email'] . '</td>';
			$html .=  empty($membro['celular']) ? '<td>----------</td>' : '<td>' . $membro['celular']  . '</td>';
			$html .=  empty($membro['estado_civil']) ? '<td>----------</td>' : '<td>' . $membro['estado_civil']  . '</td>';
			$html .=  empty($membro['genero']) ? '<td>----------</td>' : '<td>' . $membro['genero'] . '</td>';
			$html .=  empty($membro['data_nascimento']) ? '<td>----------</td>' : '<td>' . $membro['data_nascimento'] . '</td>';
			$html .=  empty($etaria) ? '<td>----------</td>' : '<td>' . $etaria . '</td>';
			$html .=  empty($membro['cargo']) ? '<td>----------</td>' : '<td>' . $membro['cargo'] . '</td>';
			$html .=  empty($membro['celula']) ? '<td>----------</td>' : '<td>' . $membro['celula'] . '</td>';
			$html .=  empty($membro['endereco']) ? '<td>----------</td>' : '<td>' . $membro['endereco'] . '</td>';
			$html .=  empty($membro['numero']) ? '<td>----------</td>' : '<td>' . $membro['numero'] . '</td>';
			$html .=  empty($membro['bairro']) ? '<td>----------</td>' : '<td>' . $membro['bairro']  . '</td>';
			$html .=  empty($membro['cep']) ? '<td>----------</td>' : '<td>' . $membro['cep'] . '</td>';
			$html .=  empty($membro['cidade']) ? '<td>----------</td>' : '<td>' . $membro['cidade'] . '</td>';
			$html .=  empty($membro['estado']) ? '<td>----------</td>' : '<td>' . $membro['estado'] . '</td>';
			$html .=  empty($membro['pais']) ? '<td>----------</td>' : '<td>' . $membro['pais'] . '</td>';

			$html .= "
					</tr>";
		}
		$html .= "</tbody>
				</table>
			</body>
		</html>";

		break;

	case '1':

		$titulo = "<div><h1>Células - C.F.A</h1></div>";
		$nomeArq = "cfa_celulas.pdf";
		$colspan = 3;

		//corpo da msn
		$html = "
		<html>
			<style>
				td{
					border: solid 1px;
				}
			</style>	
			<body>
				";
		$html .= $titulo;
		$html .= "
				<table class='table table-sm' style='font-size:12px;'>
				  <thead>
					<tr>				
						<th scope='col'>NOME</th>
						<th scope='col'>DIA SEMANA</th>
						<th scope='col'>HORARIO</th>
						<th scope='col'>LIDERANCA 1</th>
						<th scope='col'>LIDERANCA 2</th>		
						<th scope='col'>DATA INAUGURACAO</th>
						<th scope='col'>ENDEREÇO</th>
						<th scope='col'>NUMERO</th>
						<th scope='col'>BAIRRO</th>
						<th scope='col'>CEP</th>
						<th scope='col'>CIDADE</th>
						<th scope='col'>ESTADO</th>
						<th scope='col'>PAIS</th>
					</tr>
				  </thead>
				  <tbody>";

		while ($celula = $resultCelulas->fetch_assoc()) {

			$colspan = 3;

			$html .= "<tr>";
			$html .=  empty($celula ['nome']) ? '<td>----------</td>' : '<td>' . $celula['nome'] . '</td>';
			$html .=  empty($celula ['dia_semana']) ? '<td>----------</td>' : '<td>' . $celula['dia_semana']  . '</td>';
			$html .=  empty($celula  ['horario']) ? '<td>----------</td>' : '<td>' . $celula['horario']  . '</td>';

			$queryLIderesCelulas = "SELECT 
										U.nome,
										U.id
									FROM cfa_celula_lideres CLC
									LEFT JOIN cfa_usuarios U ON (CLC.id_usuario = U.id)
									WHERE CLC.id_celula = ".$celula['id'];

			$resultLideres = $conn->query($queryLIderesCelulas);

			while($lideres = $resultLideres->fetch_assoc()){
				$html .= '<td>' . $lideres['nome'] . '</td>';

				$colspan--;
			}
		
			$html .=  empty($celula ['data_abertura']) ? '<td colspan="'.$colspan.'">----------</td>' : '<td colspan="'.$colspan.'">' . $celula['data_abertura'] . '</td>';
			$html .=  empty($celula['endereco']) ? '<td>----------</td>' : '<td>' . $celula['endereco'] . '</td>';
			$html .=  empty($celula['numero']) ? '<td>----------</td>' : '<td>' . $celula['numero'] . '</td>';
			$html .=  empty($celula['bairro']) ? '<td>----------</td>' : '<td>' . $celula['bairro']  . '</td>';
			$html .=  empty($celula['cep']) ? '<td>----------</td>' : '<td>' . $celula['cep'] . '</td>';
			$html .=  empty($celula['cidade']) ? '<td>----------</td>' : '<td>' . $celula['cidade'] . '</td>';
			$html .=  empty($celula['estado']) ? '<td>----------</td>' : '<td>' . $celula['estado'] . '</td>';
			$html .=  empty($celula['pais']) ? '<td>----------</td>' : '<td>' . $celula['pais'] . '</td>';

			$html .= "
					</tr>";
		}
		$html .= "</tbody>
				</table>
			</body>
		</html>";

		break;
}

require_once '../dompdf/autoload.inc.php';
require_once '../dompdf/lib/html5lib/Parser.php';
require_once '../dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once '../dompdf/lib/php-svg-lib/src/autoload.php';
require_once '../dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation, landscape = paisagem; portrait = retrato
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($nomeArq, array("Attachment" => 1));//1 - Downlaod,  0 - Prévia
