<?php

//var_dump($data['coletas']);

$dentro = 0;
$fora = 0;

foreach ($data['painel'] as $id => $value) {
	if ($value['STATUS'] != 'PRETO') {
		$dentro += $value['QUANTIDADE'];
	} else {
		$fora += $value['QUANTIDADE'];
	}


	//var_dump($value);
}

function formatarTempo($tempo)
{
	$aux = explode(':', $tempo);

	$horas = $aux[0];
	$minutos = $aux[1];

	$horasParaMinuto = 0;

	if ($horas > 0) {
		$horasParaMinuto = $horas * 60;
	}
	return $minutos + $horasParaMinuto;
}

function formatarTempoCompleto($minutos)
{

	//var_dump($minutos);
	if ($minutos < 0) {
		$minutos = abs($minutos);
		$value = "-";
	} else {
		$value = "+";
	}

	//var_dump(abs($minutos));

	$horas = floor($minutos / 60);
	$min = $minutos - (60 * $horas);
	$aux = explode('.', $min);

	if (is_array($aux)) {
		$seg = round((60 * (substr(round($aux[1]), 0, 2) / 100)));
		$min = $aux[0];
	} else {
		$seg = 0;
	}

	if ($horas < 10) {
		$horas = '0' . $horas;
	}
	if ($min < 10) {
		$min = '0' . $min;
	}
	if ($seg < 10) {
		$seg = '0' . $seg;
	}

	return $value . $horas . ":" . $min . ":" . $seg;
}

?>

<style>
	/* body {


		background: linear-gradient(to right, #00dbbb, #00c3f7);
	} */


	.alerts-border {
		background-color: #f8d7da;
		animation: blink 1s;
		animation-iteration-count: infinite;
	}

	.protocolo {
		padding: 2%;
		color: #721c24;
		background-color: #f8d7da;
		border-color: #f5c6cb;
		border-radius: 5%;
		width: 100%;
	}

	.urgencia {
		padding: 2%;
		color: #856404;
		background-color: #fff3cd;
		border-color: #ffeeba;
		border-radius: 5%;
	}

	.circle {
		border-radius: 50%;
		width: 20px;
		height: 20px;
	}

	.green {
		background: green;
	}

	.red {
		background: red;
	}

	.black {
		background: black;
	}

	.yellow {
		background: yellow;
	}
</style>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="margin-top: 10px;">
	<div class="container-xxl" id="kt_content_container">
		<div class="row g-6 g-xl-9">
			<div class="col-lg-6 col-xxl-6">
				<div class="card h-70">
					<div class="card-body p-9">

						<div class="fs-2hx fw-bolder" style="text-align: center"><img src="<?= $GLOBALS['base_dir']; ?>/Assets/img/verde.png" width=50 height=50 style="transform:rotate(180deg); opacity: 0.5;">Exames dentro da meta: <span class="text-gray-700" style="font-size: 25pt;"><?php echo $dentro ?></span></div>


						<!-- <div class="separator separator-dashed"></div> -->
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-xxl-6">
				<div class="card h-70">
					<div class="card-body p-9">
						<div class="fs-2hx fw-bolder" style="text-align: center"><img src="<?= $GLOBALS['base_dir']; ?>/Assets/img/vermelho.png" width=50 height=50 style="opacity: 0.5;">Exames fora da meta: <span class="text-gray-700" style="font-size: 25pt;"><?php echo $fora ?></span></div>
						<!-- <div class="fs-4 fw-bold text-gray-400 mb-7">Exames fora da meta</div> -->

						<!-- <div class="separator separator-dashed"></div> -->
					</div>
				</div>
			</div>

			<div class="card mb-5 mb-xl-8">
				<!--begin::Header-->

				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body py-3">
					<!--begin::Table container-->
					<div class="table-responsive">
						<!--begin::Table-->
						<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" style="tr:nth-child(even)" id="tabelaAssinaturas">
							<!--begin::Table head-->
							<thead>
								<tr class="fw-bolder text-muted">

									<th class="min-w-120px" style="text-align: center; width: 100px;">Tipo</th>
									<th class="min-w-120px" style="text-align: center">OS</th>
									<th class="min-w-120px" style="text-align: center">Nome Completo</th>
									<th class="min-w-120px" style="text-align: center">Data Nascimento</th>
									<th class="min-w-120px" style="text-align: center">Data Triagem</th>
									<th class="min-w-120px" style="text-align: center">Unidade Coleta</th>
									<th class="min-w-120px" style="text-align: center">Setor</th>
									<th class="min-w-120px" style="text-align: center">Deflator</th>
									<th class="min-w-120px" style="text-align: center">Meta</th>
									<th class="min-w-120px" style="text-align: center">Tempo</th>
									<th class="min-w-120px" style="text-align: center">TAT</th>
									<!-- <th class="min-w-120px">Setor Execução</th> -->
									<!-- <th class="min-w-120px">Exame</th>
                                     <th class="min-w-120px">Local</th>
                                     <th class="min-w-120px">Meta</th>-->
									<th class="min-w-120px" style="text-align: center">Status</th>
								</tr>
							</thead>
							<!--end::Table head-->
							<!--begin::Table body-->
							<tbody>
								<!-- <?php foreach ($data['coletas'] as $atendimento) { ?>
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div class="d-flex justify-content-start flex-column">
													<a href="#" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo $atendimento['PACIENTE'] ?></a>
												</div>
											</div>
										</td>
										<td>
											<a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6"><?php echo $atendimento['MEDICO'] ?></a>
										</td>
										<td>
											<a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6"><?php echo $atendimento['DESCRICAO'] ?></a>
										</td>
										<td class="text-end">
											<div class="d-flex flex-column w-100 me-2">
												<div class="d-flex flex-stack mb-2">
													<span class="text-muted me-2 fs-7 fw-bold"><?php echo $atendimento['STATUS'] ?></span>
												</div>
											</div>
										</td>
									</tr>
								<?php	} ?> -->

								<?php foreach ($data['coletas'] as $coleta) :

									$coleta["DEFLATOR"] = formatarTempoCompleto($coleta['DEFLATOR']);


									if ($coleta["TIPO"] == "Protocolo") {
										$class = "protocolo";
										$class_tr = "alerts-border";
									} else if ($coleta["TIPO"] == "Urgente") {
										$class = "urgencia";
										$class_tr = "urgencia";
									} else {
										$class = "";
										$class_tr = "";
									}

									if ($coleta["STATUS"] == "PRETO") {
										$class_status = "circle black";
									} else if ($coleta["STATUS"] == "VERDE") {
										$class_status = "circle green";
									} else if ($coleta["STATUS"] == "AMARELO") {
										$class_status = "circle yellow";
									} else {
										$class_status = "circle red";
									}

									if ($coleta["DEFLATOR"][0] == "+") {
										$color = "green";
									} else if ($coleta["DEFLATOR"][0] == "-") {
										$color = "red";
									} else {
										$color = "";
									}

								?>
									<tr class="<?php echo $class_tr; ?>">
										<td style="text-align:center">
											<div class="<?php echo $class; ?>"><?php echo $coleta["TIPO"]; ?></div>
										</td>
										<td style="text-align:center"><b><?php echo $coleta["ORDEMSERVICO"]; ?></b></td>
										<td style="text-align:center"><b><?php echo $coleta["PACIENTE_NOME"]; ?></b></td>
										<td style="text-align:center"><b><?php echo $coleta["PACIENTE_DATANASCIMENTO"]; ?></b></td>
										<td style="text-align:center"><b><?php echo $coleta["DATA_COLETA"]; ?></b></td>

										<td style="text-align:center"><b><?php echo $coleta["UNIDADECOLETA"]; ?></b></td>
										<td style="text-align:center"><b><?php echo $coleta["SETOR"]; ?></b></td>
										<td style="text-align:center"><b>
												<span style="color:<?php echo $color; ?>"><?php echo $coleta["DEFLATOR"]; ?></span>
											</b></td>
										<td style="text-align:center"><b><?php echo $coleta["META"]; ?></b></td>
										<td style="text-align:center"><b>
												<div id="data-hora-<?php echo $coleta['ORDEMSERVICO']; ?>-<?php echo $nCount1; ?>"></div>
											</b></td>
										<td style="text-align:center"><b><?php echo $coleta["TAT"]; ?></b></td>
										<td style="text-align:center">
											<div class="<?php echo $class_status; ?>" style="margin-left: 45%;"></div>
										</td>
									</tr>
								<?php $nCount1++;
								endforeach; ?>
							</tbody>
							<!--end::Table body-->
						</table>
						<!--end::Table-->
					</div>
					<!--end::Table container-->
				</div>
				<!--begin::Body-->
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {
		const tableAssinaturas = $("#tabelaAssinaturas").dataTable({
			"sPaginationType": "full_numbers",
			"pageLength": 10,
			"oLanguage": {
				"sEmptyTable": "Nenhum exame na fila",
				"sInfo": "",
				"sInfoEmpty": "",
				"sInfoFiltered": "",
				"sInfoPostFix": "",
				"sInfoThousands": ".",
				"sLengthMenu": "",
				"sLoadingRecords": "Carregando...",
				"sProcessing": "Processando...",
				"sZeroRecords": "Nenhum registro encontrado",
				"sSearch": "",
				"oPaginate": {
					"sNext": "",
					"sPrevious": "",
					"sFirst": "",
					"sLast": ""
				}

			}
		});

		const totalRowsAssinaturas = tableAssinaturas.fnGetData().length;
		const qtdPaginasAssinaturas = totalRowsAssinaturas / 10;

		var paginaAssinaturas = 0;

		setInterval(function() {
			//var qtdPaginasAssinaturas = totalRowsAssinaturas / 10;

			//console.log(totalRowsAssinaturas);
			if (qtdPaginasAssinaturas > 1) {
				tableAssinaturas.fnPageChange(paginaAssinaturas++);
			}
			if (paginaAssinaturas == qtdPaginasAssinaturas) {
				paginaAssinaturas = 0;
			}


		}, 30000);

	});
	var Inside = function() {

		// setTimeout(function() {
		// 	location.reload();
		// }, 60000);

		var handleGrafico = function() {


			// const ctx = document.getElementById('kt_chartjs_3');
			// const myChart = new Chart(ctx, {
			// 	type: 'doughnut',
			// 	data: {
			// 		labels: ['Qnt.Agendamentos', 'Qnt.Atend', 'Faltas'],
			// 		datasets: [{
			// 			label: 'Quantidade',
			// 			render: 'value',
			// 			fontSize: 10,
			// 			data: [20, 15, 4],
			// 			backgroundColor: [
			// 				'rgba(255, 99, 132, 2)',
			// 				'rgba(54, 162, 235, 2)',
			// 				'rgba(255, 206, 86, 2)'
			// 			],
			// 			borderColor: [
			// 				'rgba(255, 99, 132, 1)',
			// 				'rgba(54, 162, 235, 1)',
			// 				'rgba(255, 206, 86, 1)'
			// 			],
			// 			borderWidth: 1
			// 		}]
			// 	},

			// });
		}

		return {
			init: function() {
				handleGrafico();
			}

		};


	}();
</script>

<script>
	const options = {
		timeZone: 'America/Sao_Paulo',
		hour: 'numeric',
		minute: 'numeric',
		second: 'numeric'
	};
	const date = new Intl.DateTimeFormat([], options);



	const Interval = window.setInterval(function() {

		<?php foreach ($data['coletas'] as $coleta) : ?>

			var aux = '<?php echo $coleta['DATA_COLETA']; ?>';


			var auxBarra = aux.split('/');
			var auxEspaco = auxBarra[2].split(' ');
			var auxPontos = auxEspaco[1].split(':');


			var ano = parseInt((auxEspaco[0]));
			var mes = parseInt(auxBarra[1]);
			var dia = parseInt(auxBarra[0]);
			var hora = parseInt(auxPontos[0]);
			var minuto = parseInt(auxPontos[1]);
			var segundo = parseInt(auxPontos[2]);

			//console.log(auxBarra);

			var dataInicio = new Date(ano, mes - 1, dia, hora, minuto, segundo, '');

			//console.log(dataInicio);

			//02/05/2022 13:31:00
			//new Date(ano, mês, dia, hora, minuto, segundo, milissegundo);
			//console.log('<?php echo $coleta['DATA_COLETA']; ?>');
			var dataInicioFormatada = new Date('<?php echo $coleta['DATA_COLETA']; ?>');
			//console.log(dataInicioFormatada);
			// Pega o horário atual
			var dataTermino = new Date();

			var dataTerminoFormatada = date.format(new Date());


			var diferencaTempo = dataTermino - dataInicio;

			if (diferencaTempo < 0) {
				diferencaTempo = 0;
			}

			// console.log(dataInicio);
			// console.log(dataTermino);

			// var diferencaTempo = Math.abs(dataTermino - dataInicio);
			// console.log(diferencaTempo);
			// var hour = (Math.floor(diferencaTempo / 3600));
			// var min = (Math.floor(diferencaTempo / 60000));
			// var sec = ((diferencaTempo % 60000) / 1000).toFixed(0);

			var sec = Math.floor((diferencaTempo / 1000) % 60);
			var min = Math.floor((diferencaTempo / (1000 * 60)) % 60);
			var hour = Math.floor((diferencaTempo / (1000 * 60 * 60)));

			hour = (hour < 10) ? "0" + hour : hour;
			min = (min < 10) ? "0" + min : min;
			sec = (sec < 10) ? "0" + sec : sec;


			// Formata a data conforme dd/mm/aaaa hh:ii:ss
			//const dataHora = zeroFill(dataInicio.getHours()) + ':' + zeroFill(dataInicio.getMinutes()) + ':' + zeroFill(dataInicio.getSeconds());
			// console.log('data-hora-<?php echo $coleta['ID']; ?>-<?php echo $nCount; ?>');
			// Exibe na tela usando a div#data-hora
			document.getElementById('data-hora-<?php echo $coleta['ORDEMSERVICO']; ?>-<?php echo $nCount; ?>').innerHTML = hour + ":" + min + ":" + sec;

		<?php $nCount++;
		endforeach; ?>
		//console.log("FIM");
	}, 1000);



	const myInterval = window.setInterval(function() {
		if ($('#modal_detalhe').hasClass('in') == false) {
			location.reload();
		}
		//location.reload();
	}, 60000);


	function f_busca_exame(codigo, tipo, setor) {
		$.ajax({
			url: 'buscaExamesColetas',
			type: 'POST',
			data: {
				'pCodigo': codigo,
				'pTipo': tipo,
				'pSetor': setor
			},
			success: function(data) {
				//alert(data);
				$("#modal-titulo").html("Exames Solicitados");
				$("#mensagem_detalhe").html(data);
				$("#modal_detalhe").modal("show");

			}
		});


	}
</script>