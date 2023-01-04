<?php

namespace Api\Controllers;

use Api\Rest\Rest as Rest;
use Api\Services\AppService;

class AppController extends Rest
{
	private $service;
	public function __construct()
	{
		$this->openSession();
		$this->service = new AppService();
	}

	public function index()
	{
		$data['agendamentos'] = $this->service->listarNotificacoes();
		
		$this->view_with_masterpage("Shared/master","App/index", $data);
	}
	public function salvarAgendamentoNotificacao()
	{

		$retorno = $this->service->salvarAgendamentoNotificacao($_POST);

		if($retorno)
		{
			$_SESSION['sucesso'] = 'Agendamento realizado com sucesso!';
		}
		else
		{
			$_SESSION['erro'] = 'Erro ao realizar o agendamento!';
		}

		$this->redirect("app","index");
	}
}

$controller = new AppController();
$controller->processApi();