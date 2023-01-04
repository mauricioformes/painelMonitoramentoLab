<?php

namespace Api\Services;

use Api\Repositories\CadastroRepository as CadastroRepository;


class CadastroService
{
    private $repo;

    function __construct()
    {
        $this->repo = new CadastroRepository();

     
    }

    public function painelColetas($filtro)
    {
        
        $retorno = $this->repo->painelColetas($filtro);
        

       return $retorno;
    }

    public function painelTriagens($filtro)
    {
        
        $retorno = $this->repo->painelTriagens($filtro);
        

       return $retorno;
    }

    public function painelAssinaturas($filtro)
    {
        
        $retorno = $this->repo->painelAssinaturas($filtro);
        

       return $retorno;
    }

    public function listaColetas($filtro)
    {
        
        $retorno = $this->repo->listaColetas($filtro);
        

       return $retorno;
    }

    public function listaTriagens($filtro)
    {
        
        $retorno = $this->repo->listaTriagens($filtro);
        

       return $retorno;
    }

    public function listaAssinaturas($filtro)
    {
        
        $retorno = $this->repo->listaAssinaturas($filtro);
        

       return $retorno;
    }

    public function buscaTodosExamesColetas($codigo, $tipo, $setor)
    {
        
        $retorno = $this->repo->buscaTodosExamesColetas($codigo, $tipo, $setor);

       return $retorno;
    }

    public function buscaTodosExamesTriagens($codigo, $tipo, $setor)
    {
        
        $retorno = $this->repo->buscaTodosExamesTriagens($codigo, $tipo, $setor);

       return $retorno;
    }

    public function buscaTodosExamesAssinaturas($codigo, $tipo, $setor)
    {
        
        $retorno = $this->repo->buscaTodosExamesAssinaturas($codigo, $tipo, $setor);

       return $retorno;
    }
}
