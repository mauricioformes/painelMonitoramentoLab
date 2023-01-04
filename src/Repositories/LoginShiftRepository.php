<?php
namespace Api\Repositories;

	class LoginShiftRepository extends ConexaoShift
	{

		public function verificarAcesso($usuario,$senha)
		{
			$sql ="SELECT * FROM usuarios
   					where USUARIO = :usuario AND SENHA = :senha";


			$bind = array(':usuario' => $usuario,
						  ':senha'	 => $senha);

			$rows=$this->executeQuery($sql, $bind);
		
			return $rows;
		}
	}
