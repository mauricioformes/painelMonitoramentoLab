<?php
/**
 * Created by PhpStorm.
 * User: ghenrique
 * Date: 04/08/2015
 * Time: 08:00
 */

namespace Api\Controllers;


use Api\Rest\Rest as Rest;
use Api\Services\ParametrizacaoService;

class ParametrizacaoController extends Rest
{
    private $service;

    public function __construct()
    {
        $this->openSession();
        $this->service = new ParametrizacaoService();
    }

    public function exames(){
        $dados['exames'] = $this->service->listaExames();
        // echo "<pre>";
        // print_r($dados);
        // exit;
        $this->view_with_masterpage("Shared/masterOld","Parametrizacao/exames", $dados);
        $_SESSION['msg'] = "";
    }

    public function parametriza_exame(){
        $dados['dadosExames'] = $this->service->parametrizaExames();
        $dados['areas'] = $this->service->buscaAreas();
        $dados['historico'] = $this->service->buscaHistorico();

        $this->view_with_masterpage("Shared/masterOld","Parametrizacao/parametriza_exame", $dados);
    }

    public function  salvar(){
        if(isset($_POST)){
           
            // var_dump($_POST);
            // exit;
          
            $retorno = $this->service->salvar($_POST);

            if($retorno){
                $msg = "Parâmetro salvo com sucesso!";
            } else {
                $msg = "Erro ao salvar parâmetro!";
            }

            $_SESSION['msg'] = $msg;
           // $_SESSION['class'] = "success";
            $this->redirect('parametrizacao','parametriza_exame?nExame='.$_POST['fcodexame']); 
        }
    }

    public function  excluir(){
        if(isset($_GET)){
            // var_dump($_GET);
            // exit;
          
            $retorno = $this->service->excluir($_GET);

            if($retorno){
                $msg = "Parâmetro excluído com sucesso!";
            } else {
                $msg = "Erro ao excluir parâmetro!";
            }

            $_SESSION['msg'] = $msg;
           
            $this->redirect('parametrizacao','parametriza_exame?nExame='.$_GET['fcodexame']); 
        }
    }


}

$controller = new ParametrizacaoController();
$controller->processApi();