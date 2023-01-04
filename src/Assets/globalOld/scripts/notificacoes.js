
$(document).ready(function () {


	$("#loading").dialog({
		closeOnEscape: false,
		open: function (event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog || ui).hide();
		},
		open: function () {
			$(this).closest(".ui-dialog").find(".ui-dialog-titlebar:first").hide();
		},
		width: 50,
		autoOpen: false,
		modal: true,
		resizable: false,
		show: {
			effect: "fade",
			duration: 200
		},
		hide: {
			effect: "fade",
			duration: 200
		}
	});
	// Chosen Select
	$(".chosen-select").chosen({
		'width': '100%',
		'white-space': 'nowrap'
	});
	$(".data-panel").datepicker({
		monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
		dateFormat: "dd/mm/yy",
		dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"]
	});

	$(".time-panel").timepicker({
		showInputs: false,
		defaultTime: '',
		minuteStep: 1,
		disableFocus: true,
		template: 'dropdown',
		showMeridian: false
	});

	$(".table.parametrizacao").dataTable({
		"sPaginationType": "full_numbers",
		//"pageLength": 20,
		"oLanguage": {
			"sEmptyTable": "Nenhum registro encontrado na tabela",
			"sInfo": "Mostrar _START_ até _END_ do _TOTAL_ registros",
			"sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
			"sInfoFiltered": "(Filtrar de _MAX_ total registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "Mostrar _MENU_ registros por pagina",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Proximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Ultimo"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		}
	});

});



function formatarTempoCompleto(minutos) {

	var sec_num = parseInt(minutos, 10); // don't forget the second param
	var hours = Math.floor(sec_num / 3600);
	var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
	var seconds = sec_num - (hours * 3600) - (minutes * 60);

	if (hours < 10) { hours = "0" + hours; }
	if (minutes < 10) { minutes = "0" + minutes; }
	if (seconds < 10) { seconds = "0" + seconds; }



	return minutes + ':' + seconds;


}


function f_geraHTML(coleta) {

	var class_tr = "";
	var class_status = "";
	var class_div = "";
	var html = "";
	for (var i = 0; i < coleta.coletas.length; i++) {
		if (coleta.coletas[i].TIPO == "Protocolo") {
			class_div = "protocolo";
			class_tr = "alerts-border";
		} else if (coleta.coletas[i].TIPO == "Urgente") {
			class_div = "urgencia";
			class_tr = "urgencia";
		} else {
			class_div = "";
			class_tr = "";
		}




		if (coleta.coletas[i].STATUS == "PRETO") {
			class_status = "circle black";
		} else if (coleta.coletas[i].STATUS == "VERDE") {
			class_status = "circle green";
		} else if (coleta.coletas[i].STATUS == "AMARELO") {
			class_status = "circle yellow";
		} else {
			class_status = "circle red";
		}

		html += '<tr class="' + class_tr + '">' +
			'<td style="text-align:center">' +
			'<div class="' + class_div + '">' + coleta.coletas[i].TIPO + '</div>' +
			' </td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].ORDEMSERVICO + '</b></td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].PACIENTE_NOME + '</b></td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].PACIENTE_DATANASCIMENTO + '</b></td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].DATA_COLETA + '</b></td>' +

			'<td style="text-align:center"><b>' + coleta.coletas[i].UNIDADECOLETA + '</b></td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].SETOR + '</b></td>' +
			'<td style="text-align:center"><b>' + coleta.coletas[i].META + '</b></td>' +
			'<td style="text-align:center"><b>' +
			'<div id="data-hora-' + coleta.coletas[i].ORDEMSERVICO + '-' + i + '"></div>' +
			'</b></td>' +
			'<td style="text-align:center">' +
			'<div class="' + class_status + '" style="margin-left: 45%;"></div>' +
			'</td>' +
			"<td style='text-align:center'><a class='btn btn-primary' onclick='f_busca_exame_coleta(\"" + coleta.coletas[i].ORDEMSERVICO + "\", \"" + coleta.coletas[i].EXAME_TIPOATENDIMENTO + "\", \"" + coleta.coletas[i].SETOR_PARAMETRO + "\");'> <i class='fa fa-plus'></i> </a></td>" +
			'</tr>';
	}

	return html;
}


function f_geraHTMLTriagem(triagem) {
	var class_tr = "";
	var class_status = "";
	var class_div = "";
	var html = "";


	for (var i = 0; i < triagem.triagens.length; i++) {

		if (triagem.triagens[i].TIPO == "Protocolo") {
			class_div = "protocolo";
			class_tr = "alerts-border";
		} else if (triagem.triagens[i].TIPO == "Urgente") {
			class_div = "urgencia";
			class_tr = "urgencia";
		} else {
			class_div = "";
			class_tr = "";
		}

		if (triagem.triagens[i].DEFLATOR >= 0) {
			var sinal = "+";
		} else {
			var sinal = "-";
		}



		if (triagem.triagens[i].STATUS == "PRETO") {
			class_status = "circle black";
		} else if (triagem.triagens[i].STATUS == "VERDE") {
			class_status = "circle green";
		} else if (triagem.triagens[i].STATUS == "AMARELO") {
			class_status = "circle yellow";
		} else {
			class_status = "circle red";
		}

		html += '<tr class="' + class_tr + '">' +
			'<td style="text-align:center">' +
			'<div class="' + class_div + '">' + triagem.triagens[i].TIPO + '</div>' +
			' </td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].ORDEMSERVICO + '</b></td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].PACIENTE_NOME + '</b></td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].PACIENTE_DATANASCIMENTO + '</b></td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].DATA_COLETA + '</b></td>' +

			'<td style="text-align:center"><b>' + triagem.triagens[i].UNIDADECOLETA + '</b></td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].SETOR + '</b></td>' +
			'<td style="text-align:center"><b>' + sinal + ' ' + formatarTempoCompleto(Math.abs(triagem.triagens[i].DEFLATOR)) + '</b></td>' +
			'<td style="text-align:center"><b>' + triagem.triagens[i].META + '</b></td>' +
			'<td style="text-align:center"><b>' +
			'<div id="data-hora-' + triagem.triagens[i].ORDEMSERVICO + '-' + i + '"></div>' +
			'</b></td>' +
			'<td style="text-align:center">' +
			'<div class="' + class_status + '" style="margin-left: 45%;"></div>' +
			'</td>' +
			"<td style='text-align:center'><a class='btn btn-primary' onclick='f_busca_exame_triagem(\"" + triagem.triagens[i].ORDEMSERVICO + "\", \"" + triagem.triagens[i].EXAME_TIPOATENDIMENTO + "\", \"" + triagem.triagens[i].SETOR_PARAMETRO + "\");'> <i class='fa fa-plus'></i> </a></td>" +
			'</tr>';

	}

	return html;
}


function f_geraHTMLAssinatura(assinatura) {
	var class_tr = "";
	var class_status = "";
	var class_div = "";
	var html = "";

	for (var i = 0; i < assinatura.assinaturas.length; i++) {

		if (assinatura.assinaturas[i].TIPO == "Protocolo") {
			class_div = "protocolo";
			class_tr = "alerts-border";
		} else if (assinatura.assinaturas[i].TIPO == "Urgente") {
			class_div = "urgencia";
			class_tr = "urgencia";
		} else {
			class_div = "";
			class_tr = "";
		}

		if (assinatura.assinaturas[i].DEFLATOR >= 0) {
			var sinal = "+";
		} else {

			var sinal = "-";
		}


		if (assinatura.assinaturas[i].STATUS == "PRETO") {
			class_status = "circle black";
		} else if (assinatura.assinaturas[i].STATUS == "VERDE") {
			class_status = "circle green";
		} else if (assinatura.assinaturas[i].STATUS == "AMARELO") {
			class_status = "circle yellow";
		} else {
			class_status = "circle red";
		}

		html += '<tr class="' + class_tr + '">' +
			'<td style="text-align:center">' +
			'<div class="' + class_div + '">' + assinatura.assinaturas[i].TIPO + '</div>' +
			' </td>' +
			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].ORDEMSERVICO + '</b></td>' +
			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].PACIENTE_NOME + '</b></td>' +
			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].PACIENTE_DATANASCIMENTO + '</b></td>' +
			//'<td style="text-align:center"><b>' + assinatura.assinaturas[i].DATA_COLETA + '</b></td>' +

			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].UNIDADECOLETA + '</b></td>' +
			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].SETOR + '</b></td>' +
			'<td style="text-align:center"><b>' + sinal + ' ' + formatarTempoCompleto(Math.abs(assinatura.assinaturas[i].DEFLATOR)) + '</b></td>' +
			'<td style="text-align:center"><b>' + assinatura.assinaturas[i].META + '</b></td>' +
			'<td style="text-align:center"><b>' +
			'<div id="data-hora-' + assinatura.assinaturas[i].ORDEMSERVICO + '-' + i + '"></div>' +
			'<div id="data-hora-' + assinatura.assinaturas[i].TAT + '-' + i + '"></div>' +
			'</b></td>' +
			'<td style="text-align:center">' +
			'<div class="' + class_status + '" style="margin-left: 45%;"></div>' +
			'</td>' +
			"<td style='text-align:center'><a class='btn btn-primary' onclick='f_busca_exame_assinatura(\"" + assinatura.assinaturas[i].ORDEMSERVICO + "\", \"" + assinatura.assinaturas[i].EXAME_TIPOATENDIMENTO + "\", \"" + assinatura.assinaturas[i].SETOR_PARAMETRO + "\");'> <i class='fa fa-plus'></i> </a></td>" +
			'</tr>';

	}

	return html;
}

var IntervalColeta = "";
var IntervalAssinatura = "";
var IntervalTriagem = "";
clearInterval(IntervalColeta);
clearInterval(IntervalTriagem);
clearInterval(IntervalAssinatura);

// NECESSÁRIO VERIFICAR O INNER.HTML QUE FAZ POIS GERA ERRO / ESTÁ TENTANDO INSERIR CONTEUDO EM UMA DIV INEXISTENTE
function ajaxColetas() {
	var dados = $('#form_coletas').serialize();

	$("#dashboardColeta").attr("href", "visualizacaoColetas?" + dados);

	var html = "";

	$.ajax({
		url: 'painel/ajaxColetas',
		type: 'GET',
		data: dados,
		success: function (data) {
			var coleta = JSON.parse(data);

			html = f_geraHTML(coleta); // GERA HTML DE RETORNO PARA A TABLE
			$("#resultado").empty();
			$("#resultado").html(html);
			$("#exibeTabelaColeta").attr("hidden", false);
			$("#loading").dialog("close");


			IntervalColeta = window.setInterval(function () {

				tempo(coleta.coletas); // CHAMA FUNÇÃO QUE GERA O CRONOMETRO PRA CARA PACIENTE
			}, 1000);

		},


	})



}

function ajaxTriagens() {
	var dados = $('#form_triagem').serialize();

	$("#dashboardTriagem").attr("href", "visualizacaoTriagens?" + dados);

	var html = "";
	$.ajax({
		url: 'painel/ajaxTriagens',
		type: 'GET',
		data: dados,
		success: function (data) {
			var triagem = JSON.parse(data);

			html = f_geraHTMLTriagem(triagem);
			$("#resultado").empty();
			$("#resultado").html(html);
			$("#exibeTabelaTriagem").attr("hidden", false);
			$("#loading").dialog("close");

			IntervalTriagem = window.setInterval(function () {

				tempo(triagem.triagens); // CHAMA FUNÇÃO QUE GERA O CRONOMETRO PRA CARA PACIENTE
			}, 1000);


		}
	})

}

function ajaxAssinaturas() {
	var dados = $('#form_assinaturas').serialize();

	$("#dashboardAssinatura").attr("href", "visualizacaoAssinaturas?" + dados);

	var html = "";
	$.ajax({
		url: 'painel/ajaxAssinaturas',
		type: 'GET',
		data: dados,
		success: function (data) {
			var assinatura = JSON.parse(data);



			html = f_geraHTMLAssinatura(assinatura); // GERA HTML PARA ALIMENTAR TABLE DE RETORNO

			$("#resultado").empty();
			$("#resultado").html(html);
			$("#exibeTabelaAssinatura").attr("hidden", false);
			$("#loading").dialog("close");


			IntervalAssinatura = window.setInterval(function () {

				tempo(assinatura.assinaturas); // CHAMA FUNÇÃO QUE GERA O CRONOMETRO PRA CARA PACIENTE
			}, 1000);

		}
	})

}


function tempo(valores) {




	for (var i = 0; i < valores.length; i++) {

		var aux = valores[i].DATA_COLETA;


		var auxBarra = aux.split('/');
		var auxEspaco = auxBarra[2].split(' ');
		var auxPontos = auxEspaco[1].split(':');


		var ano = parseInt((auxEspaco[0]));
		var mes = parseInt(auxBarra[1]);
		var dia = parseInt(auxBarra[0]);
		var hora = parseInt(auxPontos[0]);
		var minuto = parseInt(auxPontos[1]);
		var segundo = parseInt(auxPontos[2]);

		var dataInicio = new Date(ano, mes - 1, dia, hora, minuto, segundo, '');

		var dataInicioFormatada = new Date("'" + valores[i].DATA_COLETA + "'");

		// Pega o horário atual
		var dataTermino = new Date();

		var dataTerminoFormatada = date.format(new Date());


		var diferencaTempo = dataTermino - dataInicio;

		if (diferencaTempo < 0) {
			diferencaTempo = 0;
		}

		var sec = Math.floor((diferencaTempo / 1000) % 60);
		var min = Math.floor((diferencaTempo / (1000 * 60)) % 60);
		var hour = Math.floor((diferencaTempo / (1000 * 60 * 60)) % 24);

		hour = (hour < 10) ? "0" + hour : hour;
		min = (min < 10) ? "0" + min : min;
		sec = (sec < 10) ? "0" + sec : sec;



		if ($('#data-hora-' + valores[i].ORDEMSERVICO + '-' + i + '').length) { // Exibe na tela usando a div#data-hora
			document.getElementById('data-hora-' + valores[i].ORDEMSERVICO + '-' + i + '').innerHTML = hour + ":" + min + ":" + sec;
		} else {

		}

	}



}


$("#pesquisarColetas").click(function (event) {



	$("#loading").dialog("open");
	//$(this).prop("disabled", true);
	ajaxColetas();

	const myInterval = window.setInterval(function () {
		if ($('#modal_detalhe').hasClass('in') == false) {
			ajaxColetas();
		}
		//location.reload();
	}, 20000);

});



$("#pesquisarTriagens").click(function (event) {



	$("#loading").dialog("open");
	//$(this).prop("disabled", true);
	ajaxTriagens();

	const triagemIterval = window.setInterval(function () {
		if ($('#modal_detalhe').hasClass('in') == false) {
			ajaxTriagens();
		}
		//location.reload();
	}, 20000);

});



$("#pesquisarAssinaturas").click(function (event) {



	$("#loading").dialog("open");
	//$(this).prop("disabled", true);
	ajaxAssinaturas();

	const assianturaInterval = window.setInterval(function () {
		if ($('#modal_detalhe').hasClass('in') == false) {
			ajaxAssinaturas();
		}
		//location.reload();
	}, 20000);

});




function f_busca_exame_coleta(codigo, tipo, setor) {
	$.ajax({
		url: 'buscaExamesColetas',
		type: 'POST',
		data: {
			'pCodigo': codigo,
			'pTipo': tipo,
			'pSetor': setor
		},
		success: function (data) {
			//alert(data);
			$("#modal-titulo").html("Exames Solicitados");
			$("#mensagem_detalhe").html(data);
			$("#modal_detalhe").modal("show");

		}
	});


}

function f_busca_exame_assinatura(codigo, tipo, setor) {
	$.ajax({
		url: 'buscaExamesAssinaturas',
		type: 'POST',
		data: {
			'pCodigo': codigo,
			'pTipo': tipo,
			'pSetor': setor
		},
		success: function (data) {
			//alert(data);
			$("#modal-titulo").html("Exames Solicitados");
			$("#mensagem_detalhe").html(data);
			$("#modal_detalhe").modal("show");

		}
	});


}

function f_busca_exame_triagem(codigo, tipo, setor) {
	$.ajax({
		url: 'buscaExamesTriagens',
		type: 'POST',
		data: {
			'pCodigo': codigo,
			'pTipo': tipo,
			'pSetor': setor
		},
		success: function (data) {
			//alert(data);
			$("#modal-titulo").html("Exames Solicitados");
			$("#mensagem_detalhe").html(data);
			$("#modal_detalhe").modal("show");

		}
	});


}

$("#filtro").chosen().change(function (event) {

	//zera o valor 
	$("#valor").val('');
	//$("#valor").focus();

	var filtro = $(this).val();

	switch (filtro) {
		case "data":
			$("#linha_valor").show();

			var dia = new Date().getDate();

			if (dia < 10) {
				dia = "0" + dia;
			}
			var mes = new Date().getMonth() + 1;
			if (mes < 10) {
				mes = "0" + mes;
			}
			var ano = new Date().getFullYear();


			$("#valor").val(dia + "/" + mes + "/" + ano);

			$("#valor").addClass('data-panel');
			$(".data-panel").datepicker({
				monthNames: ["Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
				dateFormat: "dd/mm/yy",
				dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"]
			});

			break;



		default:
			//$("#valor").removeClass('data-panel hasDatepicker');
			$("#linha_valor").show();
			$("#valor").val('');
			$(".data-panel").datepicker("destroy");
			break;

		// case "paciente":
		// 			//$("#valor").removeClass('data-panel hasDatepicker');
		// 			$("#valor").val('');
		// 			$(".data-panel").datepicker("destroy");
		// 			break;

		// case "medico":
		// 			//$("#valor").removeClass('data-panel hasDatepicker');
		// 			$("#valor").val('');
		// 			$(".data-panel").datepicker("destroy");
		// 			break;


	}

});





// CONFIG




var Nofication = function () {
	var handlePermissao = function () {
		document.addEventListener('DOMContentLoaded', function () {
			if (Notification.permission !== "granted")
				Notification.requestPermission();
		});


	}

	var handleNotificacao = function () {

		$.get('../ocorrencias/listarOcorrenciasPendentes', function (data) {
			$.each($.parseJSON(data), function (i, item) {
				$('#ocorrencias_pendentes').append('<li><a href="../ocorrencias/visualizar?codigo=' + item.CODIGO + '"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-bell-o"></i></span>' +
					"Ocorrência: " + item.CODIGO + ' aguardando sua ação.</span></a> </li>');
				//alert(item.CODIGO);
			});
			$("#total_pedentes_acoes").append($.parseJSON(data).length + ($.parseJSON(data).length == 1 ? " ação pendente" : " ações pendentes"));
			$("#total_pedentes_badge").append($.parseJSON(data).length);
			if ($.parseJSON(data).length == 0) {
				$("#total_pedentes_badge").hide();
			}
		});
	}

	return {
		//main function to initiate the module
		init: function () {

			handlePermissao();
			handleNotificacao();

		}

	}
}();
