<?php
namespace Api\Controllers;

use Api\Rest as Rest;
use Api\Services\LoginShiftService;
use Api\Util\ETipoAcesso;
use PDO;


class LoginShiftController extends Rest\Rest
{
	private $service;

	function __construct()
	{
		$this->service = new LoginShiftService();
	}

	function index()
	{
		// var_dump($_SESSION["usuario"]);
		// exit;
		$this->validate_request("GET");
		
		if (isset($_SESSION["usuario"]))
		{
			$this->redirect("painel", "index");
		}

		$this->view("Login/indexShift");
	}

	public function autenticar()
	{
		$this->validate_request('POST');
		try
		{
			$this->service->autenticar($_POST);
			// var_dump($this->service->autenticar($_POST));
			// exit;
			
			$this->redirect("painel", "index");
		} catch (\Exception $e) 
		{
			$data = array("usuario" => $_POST["usuario"], "erro" => $e->getMessage());

			$_SESSION['erro'] = $e->getMessage();

			$this->view("Login/indexShift", $data);
		}
	}
	public function sair()
	{
		// var_dump("entrou");
		// exit;
		$this->changeCookie("off");
		session_cache_expire(720);
		session_start();

		unset($_SESSION);
		unset($_COOKIE);
		
		session_destroy();
		$this->redirect("loginShift", "index");
	}
}

$controller=new LoginShiftController();
$controller->processApi();
