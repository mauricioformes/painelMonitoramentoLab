<?php


namespace Api\Controllers;


use Api\Rest\Rest as Rest;
use Api\Services\CadastroService;

class PainelController extends Rest
{
    private $service;

    public function __construct()
    {        
        $this->service = new CadastroService();
    }

    public function  index()
    {
        $this->openSession();
        $this->validate_request('GET');

        // if ($_SESSION['usuario']['usuario']['STATUS'] == 2) {
        //     $this->view_with_masterpage("Shared/masterOld", "Painel/usuario");
        // }

        $this->view_with_masterpage("Shared/masterOld", "Painel/index");
    }



    public function buscaExamesColetas()
    {
        $this->openSession();

        if ($_POST) {
            $dados['todosExames'] = $this->service->buscaTodosExamesColetas($_POST['pCodigo'], $_POST['pTipo'], $_POST['pSetor']);
        }
        $this->view("Painel/busca_exames", $dados);
    }

    public function buscaExamesTriagens()
    {
        $this->openSession();

        if ($_POST) {
            $dados['todosExames'] = $this->service->buscaTodosExamesTriagens($_POST['pCodigo'], $_POST['pTipo'], $_POST['pSetor']);
        }
        $this->view("Painel/busca_exames_triagem", $dados);
    }

    public function buscaExamesAssinaturas()
    {
        $this->openSession();

        if ($_POST) {
            $dados['todosExames'] = $this->service->buscaTodosExamesAssinaturas($_POST['pCodigo'], $_POST['pTipo'], $_POST['pSetor']);
        }
        $this->view("Painel/busca_exames_assinatura", $dados);
    }
    public function visualizacaoColetas()
    {
        //$this->openSession();
        //var_dump($_GET);
        $filtros = $_GET['filtro_setor'];

        if ($filtros) {
            $dados['coletas'] = $this->service->listaColetas($filtros);
            $dados['painel'] = $this->service->painelColetas($filtros);
        }

        $this->view_with_masterpage("Shared/masterCleanNovo", "Painel/visualizacaoColetas", $dados);
    }
    

    public function visualizacaoTriagens()
    {
        $filtros = $_GET['filtro_setor'];

        if ($filtros) {
            $dados['coletas'] = $this->service->listaTriagens($filtros);
            $dados['painel'] = $this->service->painelTriagens($filtros);
        }

        $this->view_with_masterpage("Shared/masterCleanNovo", "Painel/visualizacaoTriagens", $dados);
    }

    public function visualizacaoAssinaturas()
    {
        $filtros = $_GET['filtro_setor'];

        if ($filtros) {
            $dados['coletas'] = $this->service->listaAssinaturas($filtros);
            $dados['painel'] = $this->service->painelAssinaturas($filtros);
        }

        $this->view_with_masterpage("Shared/masterCleanNovo", "Painel/visualizacaoAssinaturas", $dados);
    }

    public function visualizacaoAssinaturas_testes()
    {
        $filtros = $_GET['filtro_setor'];

        if ($filtros) {
            $dados['coletas'] = $this->service->listaAssinaturas($filtros);
            $dados['painel'] = $this->service->painelAssinaturas($filtros);
        }

        $this->view_with_masterpage("Shared/masterCleanNovo", "Painel/visualizacaoAssinaturas_testes", $dados);
    }

    public function Coletas()
    {
        
        //$dados['coletas'] = $this->service->listaColetas();

        if ($_GET) {
            $dados['coletas'] = $this->service->listaColetas($_GET['filtro_setor']);
        }
        //var_dump($dados);
        $this->view_with_masterpage("Shared/masterOld", "Painel/coletas", $dados);
    }


    public function ajaxColetas()
    {
        //$dados['coletas'] = $this->service->listaColetas();

        if ($_GET) {
            $dados['coletas'] = $this->service->listaColetas($_GET['filtro_setor']);
        }

        // var_dump($dados['coletas']);
        // exit;
        //var_dump($dados);
        echo json_encode($dados);
    }

    public function ajaxTriagens()
    {
        //$dados['coletas'] = $this->service->listaColetas();

        if ($_GET) {
            $dados['triagens'] = $this->service->listaTriagens($_GET['filtro_setor']);
        }

        // var_dump($dados['coletas']);
        // exit;
        //var_dump($dados);
        echo json_encode($dados);
    }

    public function ajaxAssinaturas()
    {
        //$dados['coletas'] = $this->service->listaColetas();

        if ($_GET) {
            $dados['assinaturas'] = $this->service->listaAssinaturas($_GET['filtro_setor']);
        }

        // var_dump($dados['coletas']);
        // exit;
        //var_dump($dados);
        echo json_encode($dados);
    }

    public function Triagens()
    {
        if ($_GET) {
            $dados['coletas'] = $this->service->listaTriagens($_GET['filtro_setor']);
        }

        $this->view_with_masterpage("Shared/masterOld", "Painel/triagens", $dados);
    }

    public function Assinaturas()
    {
        if ($_GET) {
            $dados['coletas'] = $this->service->listaAssinaturas($_GET['filtro_setor']);
        }

        $this->view_with_masterpage("Shared/masterOld", "Painel/assinaturas", $dados);
    }
}

$controller = new PainelController();
$controller->processApi();
