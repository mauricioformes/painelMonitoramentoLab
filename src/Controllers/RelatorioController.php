<?php

namespace Api\Controllers;

use Api\Rest\Rest as Rest;
use Api\Services\RelatorioService;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class RelatorioController extends Rest
{
	private $service;
	private $cidService;

	public function __construct()
	{
		$this->openSession();
		$this->service = new RelatorioService();
		//$this->cidService = new CidService();

		$_SESSION['title'] = "GerenciaOS";
	}

	public function index()
	{
		$this->validate_request('GET');

		$_SESSION['pageTitle'] = "GerenciaOS";

		$this->view_with_masterpage("Shared/masterOld", "Relatorios/index");
	}

	public function Coletas()
	{
		//var_dump($_GET);
		//$dados['coletas'] = $this->service->listaColetas();

		if ($_GET) {
			$dados['coletas'] = $this->service->listaRelatorioColetas($_GET['dataInicial'], $_GET['dataFinal']);
		}
		//var_dump($dados);
		$this->view_with_masterpage("Shared/masterOld", "Relatorios/coletas", $dados);
	}

	public function Triagens()
	{
		if ($_GET) {
			$dados['coletas'] = $this->service->listaRelatorioTriagens($_GET['dataInicial'], $_GET['dataFinal']);
		}

		$this->view_with_masterpage("Shared/masterOld", "Relatorios/triagens", $dados);
	}

	public function Assinaturas()
	{
		if ($_GET) {
			$dados['coletas'] = $this->service->listaRelatorioAssinaturas($_GET['dataInicial'], $_GET['dataFinal']);
		}

		$this->view_with_masterpage("Shared/masterOld", "Relatorios/assinaturas", $dados);
	}

	public function ajaxColetas()
	{
		//var_dump($data);
		//$dados['coletas'] = $this->service->listaColetas();

		if ($_GET) {
			$dados['coletas'] = $this->service->listaRelatorioColetas($_GET['dataInicial'], $_GET['dataFinal']);
		}
		//var_dump($dados);
		//$this->view_with_masterpage("Shared/masterOld", "Relatorios/coletas", $dados);
		echo json_encode($dados['coletas']);
	}

	public function ajaxTriagens()
	{
		//var_dump($data);
		//$dados['coletas'] = $this->service->listaColetas();

		if ($_GET) {
			$dados['triagens'] = $this->service->listaRelatorioTriagens($_GET['dataInicial'], $_GET['dataFinal']);
		}
		//var_dump($dados);
		//$this->view_with_masterpage("Shared/masterOld", "Relatorios/coletas", $dados);
		echo json_encode($dados['triagens']);
	}

	public function ajaxAssinaturas()
	{
		//var_dump($data);
		//$dados['coletas'] = $this->service->listaColetas();

		if ($_GET) {
			$dados['assinaturas'] = $this->service->listaRelatorioAssinaturas($_GET['dataInicial'], $_GET['dataFinal']);
		}
		//var_dump($dados);
		//$this->view_with_masterpage("Shared/masterOld", "Relatorios/coletas", $dados);
		echo json_encode($dados['assinaturas']);
	}
}

$controller = new RelatorioController();
$controller->processApi();
