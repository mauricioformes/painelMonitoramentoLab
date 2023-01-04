<?php
session_start();


$pathphp = "../../Assets/global/";
$pathlib = "../../lib/";
// require_once($pathphp."header.php"); 

require_once($pathlib . "/bd/bd_hosp.php");


?>

<!-- TITULO DA APLICACAO -->
<!-- <div class="pageheader">
	<h2><i class="glyphicon  glyphicon-list-alt"></i>Complemento Emergência</h2>
	<div class="breadcrumb-wrapper">
		<span class="label">Você esta aqui:</span>
		<ol class="breadcrumb">
			<li>Autorizador</li>
			<li>Comp. Emergência</li>
		</ol>
	</div>
</div> -->
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
<!-- 
			<form name='form1' id="form_pesquisar" action='#' class="form-horizontal" method='POST'>

				<div class=" form-group" id="linha_processo">
					<label class="col-md-2 col-sm-2 col-md-offset-1 control-label">Filtro:</label>
					<div class="col-md-6 col-sm-6" id="linha_valor">
						<input type="text" class='form-control' name='valor' id='valor' placeholder='Insira um nome...' value="<?php echo $_POST["valor"]; ?>">
					</div>

					<div class="col-md-1 col-sm-1 text-center ">
						<button type='button' name='pesquisar' id="pesquisar" class='btn btn-primary' value='Pesquisar'><i class="glyphicon glyphicon-search"></i> Pesquisar</button>
					</div>
				</div>


			</form> -->
			<div class=" row mb30"></div>

			<div class="row">
				<div class="col-md-12">
					<div id='resultado'>

						<?php

						$cSQL = "select distinct id_shift, nvl(simbologia, simbologia_grupo) simbologia, case when ativo = 'A' then 'Ativo' else 'Inativo' end status
							from proc_serv_exames_shift
						   where id_shift is not null and simbologia is not null
						   and kit_sepse is null
						   and kit_avc is null
						   and id_shift is not null
						   and id_shift is not null
						   and nvl(flg_protocolo, 'N') = 'N'
						   order by 2 ";

						//echo "<pre>".$cSQL."</pre>";
						$oRS = OCIParse($oConBD, $cSQL);
						OCIExecute($oRS);

						oci_fetch_all($oRS, $exames, null, null, OCI_FETCHSTATEMENT_BY_ROW);

						//var_dump($exames);

						?>
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
								for ($i = 0; $i <= count($exames)-1; $i++) {
								?>
									<tr>
										<td style="text-align:center">
											<a class="btn btn-primary" href="parametriza_exame?nExame=<?= $exames[$i]["ID_SHIFT"]; ?>"> <i class="fa fa-plus"></i> </a>
										</td>
										<td style="text-align:center"><?php echo $exames[$i]["ID_SHIFT"]; ?></td>
										<td style="text-align:center"><?php echo $exames[$i]["SIMBOLOGIA"]; ?></td>
										<td style="text-align:center"><b><?php echo $exames[$i]["STATUS"]; ?></b></td>
									</tr>
								<?php
								}

								if (count($exames) == 0) {
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


						<!-- <div class="row">
											<div class="col-md-11 col-md-offset-1"><b>Legenda:</b>
													<br/><i class="btn  btn-default  btn-xs fa fa-hospital-o" style="margin-left:20px"></i> Eletivo <i class="btn  btn-danger  btn-xs fa fa-ambulance" style="margin-left:20px"> </i> Urgência <span class="text-primary" style="margin-left:20px"><i class="fa fa-cogs"></i></span> Em Análise <span class="text-success"  style="margin-left:20px"><i class="fa fa-thumbs-up"></i></span> Autorizado <span class="text-danger"  style="margin-left:20px"><i class="fa fa-thumbs-down"></i></span> Não Autorizado<span class="text-danger"  style="margin-left:20px"><i class="fa fa-times"></i></span> Cancelada
											</div>
										</div> -->
						<?php

						OCILogOff($oConBD);

						?>
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

