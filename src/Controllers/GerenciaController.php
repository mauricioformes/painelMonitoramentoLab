<?php

namespace Api\Controllers;

use Api\Rest\Rest as Rest;
use Api\Services\GerenciaService;
//use Api\Services\CidService;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class GerenciaController extends Rest
{
	private $service;
	private $cidService;

	public function __construct()
	{
		$this->openSession();
		$this->service = new GerenciaService();
		//$this->cidService = new CidService();

		$_SESSION['title'] = "GerenciaOS";
	}

	public function index()
	{
		$this->validate_request('GET');

		$_SESSION['pageTitle'] = "GerenciaOS";

		$this->view_with_masterpage("Shared/masterOld", "GerenciaOS/index");
	}

	public function salvar()
	{
		// var_dump($_POST['fcodigoos']);
		// exit;
		if (isset($_POST)) {

			$verificaOS = $this->service->verificaOS($_POST['fcodigoos']);

			// var_dump($verificaOS[0]['QTD']);
			// 	exit;
			if ($verificaOS[0]['QTD'] == 0) {
				
				$retorno = $this->service->salvar($_POST);

				if ($retorno) {
					$msg = "Parâmetro salvo com sucesso!";
				} else {
					$msg = "Erro ao salvar parâmetro!";
				}
			} else {
				$msg = "OS já cancelada!";
			}


			$_SESSION['msg'] = $msg;

			// $_SESSION['class'] = "success";
			$this->redirect('gerenciaOS', 'gerencia');
		}
	}

	public function Gerencia()
	{
		
		$dados['lista'] = $this->service->listaOSCanceladas();
		$dados['codigoOS'] = $this->service->buscaCodOS();

		

		$this->view_with_masterpage("Shared/masterOld", "GerenciaOS/gerenciar", $dados);
	}
}

$controller = new GerenciaController();
$controller->processApi();
