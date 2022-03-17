<div class="row">
    <!-- REUNIÔES -->
    <div class="col-lg-5" id="reuniao">
        <div class="panel panel-default">
            <div class="panel-heading textNome">
                Reuniões - Mês Atual
                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="panel panel-primary filterable col-md-13">
                            <div class="panel-heading">
                                <div class="pull-right">
                                    <button type="button" class="btn btn-sm btn-info btn-filter">
                                        <i class="fas fa-filter"></i> Filtro
                                    </button>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal" style="display: <?= $_SESSION['celula_incluir_reuniao'] == 1 ? "inline-block" : "none" ?>;">
                                        <i class="fas fa-plus"></i> Nova Reunião
                                    </button>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover table-responsive">
                                <thead>
                                    <tr class="filters">
                                        <th>
                                            <input type="text" class="form-control" placeholder="Data" disabled>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control" placeholder="Membros" disabled>
                                        </th>
                                        <th>
                                            <input type="text" class="form-control" placeholder="Visitantes" disabled>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $mes = date('m');
                                    $ano = date('Y');

                                    $queryListaReunioes .= " WHERE CR.id_celula =" . $_GET['idCelula'] . " AND CR.data_reuniao between '" . $ano . "-" . $mes . "-01' and '" . $ano . "-12-31'";
                                    $resutListaReunioes = $conn->query($queryListaReunioes);

                                    while ($listareuniao = $resutListaReunioes->fetch_assoc()) {
                                        //formato da data
                                        $dataReuniao = date('d/m/Y', strtotime($listareuniao['data_reuniao']));

                                        echo     '
													<tr>
														<td>
														<a href="javascript:" data-toggle="modal" data-target="#visualizarReuniao' . $listareuniao['id'] . '" title="Assunto: ' . $listareuniao['assunto'] . '">
														
														' . $dataReuniao . '
														</a>
														</td>
														<td>' . $listareuniao['participantes'] . '</td>
														<td>' . $listareuniao['visitantes'] . '</td>
													</tr>

													<!-- Modal -->
													<div class="modal fade" id="visualizarReuniao' . $listareuniao['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel"> Reunião - ' . $titulo . '
																	</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<form>
																		<div class="form-row">
																			<div class="form-group col-md-6">
																				<label for="inputEmail4">Data</label>: 
																				' . $dataReuniao . '
																			</div>
																			<div class="form-group col-md-6">
																				<label for="inputPassword4">Oferta</label>:
																				' . $listareuniao['ofertas'] . '
																			</div>
																		</div>
																		
																		<div class="form-row">
																			<div class="form-group col-md-6">			
																				<label for="inputPassword4">Membros:</label>
																				<ul class="list-group list-group-flush">
																					';
                                        $queryParticipantes = "SELECT 
																					CP.id_usuario,
																					CP.nome
																					FROM cfa_participantes CP
																					LEFT JOIN cfa_reuniao CR ON (CP.id_reuniao = CR.id) 
																					WHERE CR.id_celula = " . $_GET['idCelula'] . " 
																					AND CR.id = " . $listareuniao['id'] . "";

                                        $resultParticipantes = $conn->query($queryParticipantes);

                                        while ($participantes = $resultParticipantes->fetch_assoc()) {
                                            echo '<li class="list-group-item textNome">' . $participantes['nome'] . '</li>';
                                        }

                                        echo '
																					
																				</ul>
																			</div>

																			<div class="form-group col-md-6">
																				<label for="inputPassword4">Visitantes:</label>
																				<ul class="list-group list-group-flush">
																					';
                                        $queryVisitante = "SELECT 
																					CV.nome
																					FROM cfa_visitantes CV
																					LEFT JOIN cfa_reuniao CR ON (CV.id_reuniao = CR.id) 
																					WHERE CR.id_celula = " . $_GET['idCelula'] . " 
																					AND CR.id = " . $listareuniao['id'] . "";

                                        $resultVisitante = $conn->query($queryVisitante);

                                        while ($visitante = $resultVisitante->fetch_assoc()) {
                                            echo '<li class="list-group-item textNome">' . $visitante['nome'] . '</li>';
                                        }

                                        echo '
																					
																				</ul>
																			</div>
																		</div>

																		<div class="form-row">
																			<div class="form-group col-md-12">
																				<label for="inputCity">Assunto:</label>
																				<textarea class="form-control" id="message" name="assunto" placeholder="..." rows="5" maxlength="255">' . $listareuniao['assunto'] . '</textarea>
																			</div>
																		</div>
																		<a href="../back/excluirReuniao.php?idCelula=' . $_GET['idCelula'] . '&idReuniao=' . $listareuniao['id'] . '" class="btn btn-danger editar   ';
                                        if ($_SESSION['celula_incluir_reuniao'] == 0) {
                                            echo 'disabled';
                                        }
                                        echo '">Excluir</a>
																	</form>
																</div>
															</div>
														</div>
													</div>';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CHART REUNIÔES -->
	<div class="col-lg-7">
		<div class="panel panel-default">
			<div class="panel-heading textNome">
				Relatório presença - <?= date('Y') ?>
				<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
			</div>
			<div class="panel-body">
				<div class="canvas-wrapper">
					<canvas class="main-chart" id="line-chart" height="200" width="600"></canvas>
				</div>

				<div style="margin-left: 10px">
					<span>
						<h5>Legenda:
							<button class="btn btn-default" title="Visitantes"></button>
							<button class="btn btn-primary" title="Participantes (Membros)"></button>
						</h5>
					</span>
					<br />
				</div>
			</div>
		</div>

	</div>