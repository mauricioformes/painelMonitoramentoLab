<?php

namespace Api\Controllers;

use Api\Rest\Rest as Rest;
use Api\Services\UsuarioService;

class UsuarioController extends Rest
{
	private $service;
	public function __construct()
	{
		$this->openSession();
		$this->service = new UsuarioService();
	}

	function ajaxBuscaAplicacoesUsuario(){
		$this->service->buscaAplicacoesUsuario();
	}

	function ajaxBuscaAplicacaoUsuario(){
		$this->validate_request('POST');
		
		$nomeAplicacao = $_POST['nomeAplicacao'];
		
		echo json_encode($this->service->buscaAplicacaoUsuario($nomeAplicacao));
	}

}

$controller = new UsuarioController();
$controller->processApi();