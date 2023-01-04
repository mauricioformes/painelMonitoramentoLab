<?php

namespace Api\Services;

use Api\Repositories\RelatorioRepository;

class RelatorioService
{
	private $repo;

	public function  __construct()
	{
		$this->repo = new RelatorioRepository();
	}

	public function listaRelatorioColetas($dataInicial, $dataFinal)
    {

        $retorno = $this->repo->listaColetas($dataInicial, $dataFinal);


        return $retorno;
    }

    public function listaRelatorioTriagens($dataInicial, $dataFinal)
    {

        $retorno = $this->repo->listaTriagens($dataInicial, $dataFinal);


        return $retorno;
    }

    public function listaRelatorioAssinaturas($dataInicial, $dataFinal)
    {

        $retorno = $this->repo->listaAssinaturas($dataInicial, $dataFinal);


        return $retorno;
    }

}
