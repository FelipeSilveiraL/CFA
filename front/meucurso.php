<div class="row" style="display: <?= empty($_GET['idMembro']) ? 'none' : 'block' ?>" id="alunos">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading textNome">
							<i class="fas fa-book"></i> Meus Cursos
						</div>
						<div class="panel-body">
							<div class="col-md-12">
								<div class="row">
									<div class="panel panel-primary filterable col-md-13">
										<table class="table table-bordered table-hover table-responsive">
											<thead>
												<tr class="filters">
													<th>
														<input type="text" class="form-control" placeholder="Nome" disabled>
													</th>
													<th>
														<input type="text" class="form-control" placeholder="Data Inicio" disabled>
													</th>
													<th>
														<input type="text" class="form-control" placeholder="Data Fim" disabled>
													</th>
													<th>
														<input type="text" class="form-control" placeholder="Status" disabled>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php

												$queryEstudantes .= " WHERE CES.id_usuario = " . $_GET['idMembro'];
												$resultEstudantes = $conn->query($queryEstudantes);

												while ($estudantes = $resultEstudantes->fetch_assoc()) {
													echo '<tr>';
													echo '<td><a href="novoEstudo.php?pagina=7&idEstudo='.$estudantes['id_estudo'].'">' . $estudantes['nomeEstudo'] . '</a></td>';
													echo '<td>' . date('d/m/Y', strtotime($estudantes['data_inicio'])) . '</td>';
													echo '<td>' . date('d/m/Y', strtotime($estudantes['data_fim'])) . '</td>';
													echo '<td style="background:';
													echo $estudantes['status'] == 'Concluido' ? '#80f580' : '#f9dfaf';
													echo '">' . $estudantes['status'] . '</td>';
													echo '</tr>';
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
			</div><!-- /.panel-->