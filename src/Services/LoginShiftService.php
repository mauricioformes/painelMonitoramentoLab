<?php

namespace Api\Services;

use Api\Repositories\LoginShiftRepository as LoginShiftRepository;



class LoginShiftService
{
    private $repo;

    function __construct()
    {
        $this->repo = new LoginShiftRepository();
    }

    public function autenticar($dados)
    {

        $usuario = $this->repo->verificarAcesso(strtoupper($dados['usuario']),$dados['senha']);

        
        if(isset($usuario))
        {
        //     echo "<pre>";
        // print_r($usuario);
        // echo "</pre>";
        // exit;
            session_cache_expire(1720);
            session_start();
            //$aplicacoes = $this->repo->buscarAplicacoes($usuario[0]['CODIGO']);


            $_SESSION["usuario"] = array("usuario"    => $usuario[0]);
        }
        else
        {
            throw new \Exception("Usuario ou senha incorreta.");
            
        }
    }

}
