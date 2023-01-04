<?php
namespace Api\Controllers;

use Api\Rest\Rest as Rest;
use Api\Services\ProtocoloService;
use Api\Services\CidService;

class ProtocoloController extends Rest
{
	private $service;
	private $cidService;

	public function __construct(){
		$this->openSession();
		$this->service = new ProtocoloService();
		$this->cidService = new CidService();
		
		$_SESSION['title'] = "Protocolo";

	}

	public function index(){
		$this->validate_request('GET');
		
		$_SESSION['pageTitle'] = "Protocolos";

		$this->view_with_masterpage("Shared/master","Protocolo/index", $solicitacoes);	
	}

	public function ajaxSalvarCidAltaProtocolo(){
		$this->validate_request('POST');
		
		$codigoCid = $_POST['codigoCid'];
		$codigoProtocolo = $_POST['codigoProtocolo'];

		$cidAltaCadastrado = $this->service->verificaCidAltaCadastrado($codigoCid, $codigoProtocolo);

		if(!$cidAltaCadastrado){
			if($this->service->salvarCidAltaProtocolo($codigoCid, $codigoProtocolo)){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
		else{
			echo json_encode(2);
		}

	}

	public function ajaxBuscarCids(){
		$this->validate_request('GET');
		
		$search = $_GET['search'];
		$resposta = $this->cidService->buscarCids($search);

		echo json_encode($resposta);
	}

	public function ajaxBuscarCidsAltaProtocolo(){
		$this->validate_request('GET');

		echo json_encode($this->service->buscarCidsAltaProtocolo());
	}

	public function ajaxBuscarDescricaoCid(){
		$this->validate_request('POST');

		$codigoCid = $_POST['codigoCid'];
		
		echo json_encode($this->cidService->buscarDescricaoCid($codigoCid));
	}

	public function ajaxAtualizarCidAltaProtocolo(){
		$this->validate_request('POST');

		$codigo = $_POST['codigo'];
		$codigoCid = $_POST['codigoCid'];
		$codigoProtocolo = $_POST['codigoProtocolo'];

		$cidAltaCadastrado = $this->service->verificaCidAltaCadastrado($codigoCid, $codigoProtocolo);

		if(!$cidAltaCadastrado){
			if($this->service->atualizarCidAltaProtocolo($codigo, $codigoCid, $codigoProtocolo)){
				echo json_encode(1);
			}
			else{
				echo json_encode(0);	
			}
		}
		else{
			echo json_encode(2); 
		}
	}

	public function ajaxBuscarCidAltaProtocolo(){
		$this->validate_request('POST');

		$codigo = $_POST['codigo'];

		echo json_encode($this->service->buscarCidAltaProtocolo($codigo));
	}

	public function ajaxExcluirCidAltaProtocolo(){
		$this->validate_request('POST');

		$codigo = $_POST['codigo'];
		
		echo json_encode($this->service->excluirCidAltaProtocolo($codigo));
	}
}

$controller = new ProtocoloController();
$controller->processApi();