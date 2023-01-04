<?php

namespace Api\Services;

use Api\Repositories\GerenciaRepository;

class GerenciaService
{
	private $repo;

	public function  __construct()
	{
		$this->repo = new GerenciaRepository();
	}

	public function salvar($dados)
	{

		//$_POST['fid'] = $this->repo->novoCodigoParametros();

		$dados = $_POST;

		$retorno = $this->repo->salvarParametro($dados);


		return $retorno;
	}

	public function buscaCodOS()
	{
		return $this->repo->buscaCodOS();
	}

	public function listaOSCanceladas()
	{
		return $this->repo->listaOSCanceladas();
	}

	// FUNÇÃO PARA VERIFICAR SE A OS JA FOI CANCELADA NO SISTEMA
	public function verificaOS($codigoOS)
	{
		return $this->repo->verificaOS($codigoOS);
	}
}
