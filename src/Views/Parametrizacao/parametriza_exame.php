<?php
session_start();

?>
<!-- <script src='<?php echo $pathlib; ?>ajax/script.js'></script> -->

<h3 class="page-title">
	Parametrização <small> exames</small>
</h3>

<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="../painel/index">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
	</ul>
</div>
<?php

if ($_SESSION['msg']) {
?>
	<div class='alert alert-success'><?php echo $_SESSION['msg']; ?></div>
<?php } ?>
<!-- CONTEUDO DA APLICACAO -->
<div class="contentpanel">

	<div class="panel panel-default">

		<div class="panel-body">
			<!-- panel-body -->
			<h4 style="color:red; text-align: center;" id='erro'><?= $_GET['erro'] ?></h4>
			<form name='form1' id="form1" action='salvar' method='POST' class="form-horizontal" style="width:98%">

				<input type="hidden" name="fcodexame" value="<?php echo $_GET['nExame']; ?>">
				<input type="hidden" name="fusuario" value="<?php echo $_SESSION['usuario']['usuario']['LOGIN']; ?>">

				<div class="form-group">
					<div class="col-md-4 text-right">Cod. Exame:</div>
					<div class="col-md-8"><?php echo $data['dadosExames'][0]['ID_SHIFT']; ?></div>
				</div>

				<div class="form-group">
					<div class="col-md-4 text-right">Nome Exame:</div>
					<div class="col-md-8"><?php echo $data['dadosExames'][0]['SIMBOLOGIA']; ?></div>
				</div>

				<div class="form-group">
					<div class="col-md-4 text-right">Status:</div>
					<div class="col-md-8"><b><?php echo $data['dadosExames'][0]['STATUS']; ?></b></div>
				</div>


				<div class="row" style="width: 103%!important;">
					<div class="form-group">
						<label class="col-md-3 col-md-offset-1 control-label"><?php echo $titulo; ?>
							<?php echo $obrigatorio == 'S' ? '<span class="asterisk"><small>*</small></span>' : ''; ?></label>
						<div class="col-md-3">
							<select name='fcodarea[]' class="form-control chosen-select" data-placeholder="Selecione" required multiple>
								<option value="">Selecione</option>
								<?php  foreach($data['areas'] as $areas): ?>;
									<option value="<?php echo $areas['CODIGO']; ?>"><?php echo $areas['DESCRICAO_AREA']; ?></option>
									<?php endforeach; ?>
							</select>
						</div>




					</div>
				</div>

				<!-- <div class="form-group ">
					<label class="col-md-3 col-md-offset-1 control-label">Fase:</label>
					<div class="col-md-3">
						<select name='ffase[]' id='ffase' class="form-control chosen-select" data-placeholder="" required multiple>
							<option value="">Selecione...</option>
							<option value="C">Coleta</option>
							<option value="T">Triagem</option>
							<option value="A">Assinatura</option>
						</select>
					</div>

				</div> -->

				<div class="form-group">
					<label class="col-md-4 control-label">Meta em horas/minutos: </label>
					<div class="col-md-1">
						<input type="text" class='form-control time-panel' name='ftempometa_coleta' id="ftempometa_coleta" required placeholder="Coleta">
					</div>
					<!-- <label class="col-md-1 control-label">Meta - Triagem: </label> -->
					<div class="col-md-1">
						<input type="text" class='form-control time-panel' name='ftempometa_triagem' id="ftempometa_triagem" required placeholder="Triagem">
					</div>
					<!-- <label class="col-md-1 control-label">Meta - Assinatura: </label> -->
					<div class="col-md-1">
						<input type="text" class='form-control time-panel' name='ftempometa_assinatura' id="ftempometa_assinatura" required placeholder="Assinatura">
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-4 control-label">TAT: </label>
					<div class="col-md-1">
						<input type="text" class='form-control time-panel' name='ftat' id="ftat" required placeholder="TAT">
					</div>
					<!-- <label class="col-md-1 control-label">Meta - Triagem: </label> -->

				</div>
				<div class="form-group">
					<label class="col-md-4  control-label">Tipo:</label>
					<label class="control-label">
						<input type="radio" name='ftipo' value='1' id='tipo1'> Protocolo
					</label>
					<label class="control-label">
						<input type="radio" name='ftipo' value='2' id='tipo2'> Rotina
					</label>
					<label class="control-label">
						<input type="radio" name='ftipo' value='3' id='tipo3'> Urgente
					</label>

				</div>


				<div class="form-group">
					<div class="col-md-12 text-center">
						<button type="submit" class="btn btn-primary">Salvar</button>
					</div>
				</div>

			</form>
		</div><!-- panel-body -->
	</div>
</div><!-- contentpanel -->

<h3 class="page-title">
	Parâmetros cadastrados
</h3>

<div class="contentpanel">

	<div class="panel panel-default">

		<div class="panel-body">
			<div class=" row mb30"></div>

			<div class="row">
				<div class="col-md-12">
					<div id='resultado'>
						<?php
						if (count($data['historico']) == 0) {
						?>

							<div class='alert alert-danger'>Nenhuma parametrização feita para esse exame!</div>

						<?php
						} else {
						?>
							<table class="table table-bordered table-striped table-dark">
								<thead>
									<tr>

										<th style="text-align: center">Area</th>
										<th style="text-align: center">Meta - Coleta</th>
										<th style="text-align: center">Meta - Triagem</th>
										<th style="text-align: center">Meta - Assinatura</th>
										<th style="text-align: center">TAT</th>
										<th style="text-align: center">Usuário</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($data['historico'] as $historico):
									?>
										<tr>
											<!-- <td style="text-align:center">
											<a class="btn btn-primary" href="parametriza_exame?nExame=<?= $historico["ID_SHIFT"]; ?>"> <i class="fa fa-plus"></i> </a>
										</td> -->
											<td style="text-align:center"><?php echo $historico["AREA"]; ?></td>
											<td style="text-align:center"><b><?php echo $historico["META_TEMPO_COLETA"]; ?></b></td>
											<td style="text-align:center"><b><?php echo $historico["META_TEMPO_TRIAGEM"]; ?></b></td>
											<td style="text-align:center"><b><?php echo $historico["META_TEMPO_ASSINATURA"]; ?></b></td>
											<td style="text-align:center"><b><?php echo $historico["TAT"]; ?></b></td>

											<td style="text-align:center"><b><?php echo $historico["USUARIO"]; ?></b></td>
											<td style="text-align:center"><a class="btn btn-danger" href="excluir?id=<?php echo $historico["ID"]; ?>&fcodexame=<?php echo $historico["COD_EXAME"]; ?>"><i class="fa fa-trash"></i></a></td>
										</tr>
									<?php
									endforeach;
									?>
								</tbody>
							</table>
						<?php } ?>
					</div>
				</div>
			</div>


		</div><!-- panel-body -->
	</div><!-- contentpanel -->

	<!-- Modal -->
	<div class="modal position-relative d-block" tabindex="-1" role="dialog" id="myModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Excluir parâmetro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i aria-hidden="true" class="ki ki-close"></i>
					</button>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja excluir esse parâmetro?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-danger">Excluir</button>
				</div>
			</div>
		</div>
	</div><!-- modal -->

</div><!-- contentpanel -->