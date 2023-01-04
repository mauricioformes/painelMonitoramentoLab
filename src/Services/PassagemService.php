<?php
	namespace Api\Services;
	use Api\Repositories\GerenciaRepository;

	class GerenciaService{
		private $repo;

		public function  __construct(){
			$this->repo = new GerenciaRepository();
		}

		public function salvarPassagemColeta($codigoCid, $codigoProtocolo){
			return $this->repo->salvarPassagemColeta($codigoCid, $codigoProtocolo);
		}
		
		public function salvarPassagemTriagem(){
			return $this->repo->salvarPassagemTriagem();
		}

		public function salvarPassagemAssinatura($codigoCid, $codigoProtocolo, $codigoTipoPaciente){
			return $this->repo->salvarPassagemAssinatura($codigoCid, $codigoProtocolo, $codigoTipoPaciente);
		}

	}
