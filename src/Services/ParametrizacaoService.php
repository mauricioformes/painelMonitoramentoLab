<?php

namespace Api\Services;

use Api\Repositories\ParametrizacaoRepository as ParametrizacaoRepository;


class ParametrizacaoService
{
    private $repo;
    //private $serviceMail;

    function __construct()
    {
        $this->repo = new ParametrizacaoRepository();
    }

    public function listaExames()
    {
        
        $retorno = $this->repo->listaExames();

       return $retorno;
    }

    public function parametrizaExames()
    {
        
        $retorno = $this->repo->parametrizaExames();

       return $retorno;
    }

    public function buscaAreas()
    {
        
        $retorno = $this->repo->buscaAreas();

       return $retorno;
    }

    public function buscaHistorico()
    {
        
        $retorno = $this->repo->buscaHistorico();

       return $retorno;
    }
    public function salvar($dados)
    {

            //$_POST['fid'] = $this->repo->novoCodigoParametros();

            $dados = $_POST;

            $retorno = $this->repo->salvarParametro($dados);
        

        return $retorno;
    }

    public function excluir($dados)
    {
        $retorno = $this->repo->excluirParametro($dados);


        return $retorno;
    }
}
