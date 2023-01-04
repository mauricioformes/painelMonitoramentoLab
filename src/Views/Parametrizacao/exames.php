<?php
session_start();

?>

<!-- TITULO DA APLICACAO -->
<?php
$title="Painel";
?>
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

<!-- CONTEUDO DA APLICACAO -->
<div class="contentpanel">

	<div class="panel panel-default">

		<div class="panel-body">
			<!-- panel-body -->

			<div class=" row mb30"></div>

			<div class="row">
				<div class="col-md-12">
					<div id='resultado'>
						<table class="table parametrizacao table-bordered table-striped table-dark">
							<thead>
								<tr>
									<th></th>
									<th style="text-align: center">ID SHIFT</th>
									<th style="text-align: center">Exame</th>
									<th style="text-align: center">Status</th>
								</tr>
							</thead>
							<tbody>
								<?php	
						
								foreach($data['exames'] as $exames):
								?>
									<tr>
										<td style="text-align:center">
											<a class="btn btn-primary" href="parametriza_exame?nExame=<?= $exames["ID_SHIFT"]; ?>"> <i class="fa fa-plus"></i> </a>
										</td>
										<td style="text-align:center"><?php echo $exames["ID_SHIFT"]; ?></td>
										<td style="text-align:center"><?php echo $exames["SIMBOLOGIA"]; ?></td>
										<td style="text-align:center"><b><?php echo $exames["STATUS"]; ?></b></td>
									</tr>
								<?php
								endforeach;

								if (count($data) == 0) {
									?>
									<tr>
										<td colspan='5'>
											<div class='alert alert-danger'>Nenhum exame encontrado!</div>
										</td>
									</tr>
								<?php
								}

								//echo $cHtml1;
								?>
							</tbody>
						</table>

					</div>
				</div>
			</div>


		</div><!-- panel-body -->
	</div><!-- contentpanel -->

	<!-- Modal -->
	<div class="modal fade" id="modal_detalhe" tabindex="-1" aria-labelledby="modal_detalhe_procedLabel" data-backdrop="static" aria-hidden="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="modal_detalhe_procedLabel"><span class="glyphicon glyphicon-pencil  text-info"></span> <span id="modal-titulo" class=" text-info">Detalhes</span></h4>
				</div>
				<div class="modal-body">
					<div id="mensagem_detalhe" style="height:450px; overflow-y:auto"> </div>
				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->

</div><!-- contentpanel -->

