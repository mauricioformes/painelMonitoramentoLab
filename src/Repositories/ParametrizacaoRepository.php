<?php

namespace Api\Repositories;

class ParametrizacaoRepository extends ConexaoShift
{
	public function novoCodigoParametros()
	{
		$sql = "SELECT  seq_painel_parametriza_exame.NEXTVAL codigo
  					 from dual";

		$rows = $this->executeQuery($sql);

		return $rows[0]['CODIGO'];
	}

	public function listaExames()
	{
		$sql = "select distinct id_shift, nvl(simbologia, simbologia_grupo) simbologia, case when ativo = 'A' then 'Ativo' else 'Inativo' end status
		from proc_serv_exames_shift
	   where id_shift is not null and simbologia is not null
	   and ativo = 'A'
	   order by 1 desc";

		$rows = $this->executeQuery($sql);

		return $rows;
	}

	public function parametrizaExames()
	{
		$sql = "SELECT distinct id_shift,
		nvl(simbologia, simbologia_grupo) simbologia,
		case when ativo = 'A' then 'Ativo' else 'Inativo' end status
		from proc_serv_exames_shift
		where id_shift is not null
		and simbologia is not null
		and kit_sepse is null
		and kit_avc is null
		and id_shift is not null
		and id_shift is not null
		and nvl(flg_protocolo, 'N') = 'N'
		and id_shift = " . $_GET['nExame'] . "
		order by 2";

		$rows = $this->executeQuery($sql);

		return $rows;
	}

	public function buscaAreas()
	{
		$sql = "SELECT TO_CHAR(COD_AREA) CODIGO, DESCRICAO_AREA
		FROM areas
	   WHERE cod_area IN (SELECT cod_area FROM locais WHERE tipo_leito <> 4)
	   ORDER BY 2";

		$rows = $this->executeQuery($sql);

		return $rows;
	}

	public function buscaHistorico()
	{
		$sql = "SELECT s.id,
		(select a.descricao_area from areas a where a.cod_area = s.area) area,       
		s.cod_exame,
		s.meta_tempo_coleta,
		s.meta_tempo_triagem,
		s.meta_tempo_assinatura,
		s.usuario,
		s.tat
   from shift_painel_parametriza_exame s
	   where s.cod_exame = " . $_GET['nExame'] . "
	order by 1";

		$rows = $this->executeQuery($sql);


		return $rows;
	}

	public function salvarParametro($dados)
	{
		for ($i = 0; $i < count($dados['fcodarea']); $i++) {

			$dados['fid'][$i] = $this->novoCodigoParametros();

			$sql = "INSERT into shift_painel_parametriza_exame(id,
			area,
			cod_exame,
			meta_tempo_coleta,
			meta_tempo_triagem,
			meta_tempo_assinatura,
			usuario,
			tat,
			tipo)
	  	values(:id,
			 :area,
			 :cod_exame,
			 :meta_tempo_coleta,			
			 :meta_tempo_triagem,
			 :meta_tempo_assinatura,
			 :usuario,
			 :tat,
			 :tipo)";

			$bind = array(
				':id' 				=> $dados['fid'][$i],
				':area' 				=> $dados['fcodarea'][$i],
				':cod_exame' 				=> $dados['fcodexame'],
				':meta_tempo_coleta' 			=> $dados['ftempometa_coleta'],				
				':meta_tempo_triagem' 			=> $dados['ftempometa_triagem'],
				':meta_tempo_assinatura' 			=> $dados['ftempometa_assinatura'],
				':usuario'	=> $dados['fusuario'],
				':tat'	=> $dados['ftat'],
				':tipo'	=> $dados['ftipo']
			);

			$rows = $this->executeQuery($sql, $bind);
		}



		return $rows;
	}

	public function excluirParametro($dados)
	{

		$sql = "DELETE FROM shift_painel_parametriza_exame WHERE ID = :id";

		// var_dump($dados['id']);
		// exit;

		$bind = array(':id' 				=> $dados['id']);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}
}
