<?php
session_start();


//var_dump($data['codigoOS']);

?>
<!-- <script src='<?php echo $pathlib; ?>ajax/script.js'></script> -->

<h3 class="page-title">
	Gerenciamento de OS <small> painel</small>
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
			<form name='form_gerenciaos' id="form_gerenciaos" action='salvar' method='POST' class="form-horizontal" style="width:98%">
				<!-- <input type="hidden" name="fcodexame" value="<?php echo $_GET['nExame']; ?>"> -->
				<input type="hidden" name="fusuario" value="<?php echo $_SESSION['usuario']['usuario']['LOGIN']; ?>">
				<div class="form-group">
					<label class="col-md-4 control-label">Código OS: </label>
					<div class="col-md-4">
						<select name="fcodigoos" id="fcodigoos" class="form-control select2me select2-offscreen" data-live-search="true">
							<?php foreach ($data['codigoOS'] as $codigoOS) : ?>;
							<option value="<?php echo $codigoOS['ORDEMSERVICO']; ?>"><?php echo $codigoOS['ORDEMSERVICO']; ?> - <?php echo $codigoOS['PACIENTE_NOME']; ?></option>
						<?php endforeach; ?>
						</select>
						<!-- <input type="text" class='form-control' name='fcodigoos' id="fcodigoos" required placeholder="Insira a OS"> -->
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-primary" style="margin-top: 5px;">Salvar</button>
						</div>
					</div>
			</form>
		</div><!-- panel-body -->
	</div>
</div><!-- contentpanel -->

<h3 class="page-title">
	Listagem de OS cancelada
</h3>

<div class="contentpanel">

	<div class="panel panel-default">

		<div class="panel-body">
			<div class=" row mb30"></div>

			<div class="row">
				<div class="col-md-12">
					<div id='resultado'>
						<?php
						//var_dump($data['lista']);
						if (count($data['lista']) == 0) {
						?>

							<div class='alert alert-danger'>Nenhuma OS retirada do painel!</div>

						<?php
						} else {
						?>
							<table class="table parametrizacao table-bordered table-striped table-dark">
								<thead>
									<tr>

										<th style="text-align: center">Código</th>
										<th style="text-align: center">OS</th>
										<th style="text-align: center">Usuário</th>
										<th style="text-align: center">Data</th>

									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($data['lista'] as $historico) :
									?>
										<tr>
											<!-- <td style="text-align:center">
											<a class="btn btn-primary" href="parametriza_exame?nExame=<?= $historico["ID_SHIFT"]; ?>"> <i class="fa fa-plus"></i> </a>
										</td> -->
											<td style="text-align:center"><?php echo $historico["ID"]; ?></td>
											<td style="text-align:center"><b><?php echo $historico["ORDEMSERVICO"]; ?></b></td>
											<td style="text-align:center"><b><?php echo $historico["USUARIO"]; ?></b></td>
											<td style="text-align:center"><b><?php echo $historico["DATA"]; ?></b></td>

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
