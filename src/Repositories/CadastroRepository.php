<?php

namespace Api\Repositories;

class CadastroRepository extends ConexaoShift
{

	public function listaColetas($filtro)
	{

		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}

		$sql = "SELECT distinct h.ordemservico,
		h.paciente_nome,
		h.paciente_datanascimento,
		h.unidadecoleta,
		h.tipo,
		case when h.setor = 'B' then 'Bioquímica'
when h.setor = 'U' then 'Urinálise'
when h.setor = 'H' then 'Hematologia'
  end setor,
  h.setor setor_parametro,
		h.exame_tipoatendimento,
		h.meta,
		h.data_coleta,
		h.data_meta,
		case
		  when h.porcentagem_tempo_meta < -70 then
		   'VERDE'
		  when h.porcentagem_tempo_meta > -70 and
			   h.porcentagem_tempo_meta < -40 then
		   'AMARELO'
		  when h.porcentagem_tempo_meta > -40 and
			   h.porcentagem_tempo_meta < -6 then
		   'VERMELHO'
		  when h.porcentagem_tempo_meta > 0 then
		   'PRETO'
		end statusa,
		h.porcentagem_tempo_meta
FROM (SELECT b.ordemservico,
	   b.paciente_nome,
	   b.paciente_datanascimento,
	   b.unidadecoleta,
	   b.tipo,
	   b.tipo_codigo,
	   b.setor,
	   b.exame,
	   b.exame_descricao,
	   b.exame_tipoatendimento,
	   b.meta,
	   b.data_coleta,
	   b.data_meta,
	   (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
  FROM (SELECT a.ordemservico,
			   a.paciente_nome,
			   a.paciente_datanascimento,
			   a.unidadecoleta,
			   a.tipo,
			   a.tipo_codigo,
			   a.setor,
			   a.exame,
			   a.exame_descricao,
			   a.exame_tipoatendimento,
			   a.meta,
			   a.data_coleta,
			   a.data_meta,
			   (sysdate() - a.data_coleta) * 24 * 60 tempo_atual,
			   a.tempo_meta
		  FROM (SELECT z.ordemservico,
					   z.paciente_nome,
					   z.paciente_datanascimento,
					   z.unidadecoleta,
					   z.tipo,
					   z.tipo_codigo,
					   z.setor,
					   z.exame,
					   z.exame_descricao,
					   z.exame_tipoatendimento,
					   z.meta,
					   z.data_coleta,
					   z.data_coleta +
					   z.meta DATA_META,
					   z.meta tempo_meta
				  FROM (SELECT y.ordemservico,
							   y.paciente_nome,
							   y.paciente_datanascimento,
							   y.unidadecoleta,
							   y.exame,
							   y.exame_descricao,
							   y.exame_tipoatendimento,
							   case
								 when y.exame in
									  (select pe.cod_exame
										 from shift_painel_parametriza_exame pe
										where pe.tipo = 1) then
								  'Protocolo'
								 when y.exame_tipoatendimento = 'R' then
								  'Rotina'
								 when y.exame_tipoatendimento = 'U' then
								  'Urgente'
							   end tipo,
							   spp.setor_lab setor,
							   spp.tipo tipo_codigo,
							   (select max(ae.meta_tempo_coleta)
								  from shift_painel_parametriza_exame ae
								 where ae.cod_exame = y.exame
								   and ae.tipo = y.exame_tipo_codigo
								   and ae.area =
									   (select ar.cod_area
										  from areas ar
										 where ar.descricao_area =
											   y.unidadecoleta)
								   and ae.tipo = y.exame_tipo_codigo) meta,
							   y.data_coleta
						
						  from (select x.ordemservico,
									   x.paciente_nome,
									   x.paciente_datanascimento,
									   x.unidadecoleta,
									   x.exame_codigo exame,
									   x.exame_descricaoexame exame_descricao,
									   x.exame_tipoatendimento,
									   case
										 when x.exame_codigo in
											  (select pe.cod_exame
												 from shift_painel_parametriza_exame pe
												where pe.tipo = 1) then
										  1
										 when x.exame_tipoatendimento = 'R' then
										  2
										 when x.exame_tipoatendimento = 'U' then
										  3
									   end exame_tipo_codigo,
									   x.data_coleta,
									   x.data_operacao
								  from (select distinct a.ordemservico,
														a.paciente_nome,
														a.paciente_datanascimento,
														a.unidadecoleta,
														se.exame_datacoletaprogramada || ' ' ||
														se.exame_horacoletaprogramada data_coleta,
														e.dataoperacao || ' ' || e.horaoperacao data_operacao,
														se.exame_codigo,
														se.exame_descricaoexame,
														case
														  when se.exame_codigo in
															   (select pe.cod_exame
																  from shift_painel_parametriza_exame pe
																 where pe.tipo = 1) then
														   'P'
														  when se.exame_tipoatendimento = 'R' then
														   se.exame_tipoatendimento
														  when se.exame_tipoatendimento = 'U' then
														   se.exame_tipoatendimento
														end exame_tipoatendimento
										  FROM shift_painel_gestao           a,
											   shift_painel_gestao_operacoes e,
											   shift_painel_gestao_exame     se
										 where e.cod_exame =
											   se.exame_codigo
										   and a.id_remessa =
											   e.id_remessa
										   and se.id_remessa =
											   a.id_remessa
										   and se.id_remessa =
											   e.id_remessa
										   and se.exame_tipoatendimento is not null
										   and se.exame_datacoletaprogramada is not null
										   and e.operacoes_codigooperacao =
											   '111'
										   and e.dataoperacao || ' ' || e.horaoperacao =
											   (select f.dataoperacao || ' ' ||
																   f.horaoperacao
												  from shift_painel_gestao_operacoes f
												 where f.id_remessa =
													   a.id_remessa
												   and f.id_remessa =
													   e.id_remessa
													   and f.cod_exame = se.exame_codigo)
										
										) x) y,
							   shift_painel_parametriza_exame spp
						 where 1 = 1
						   and y.exame = spp.cod_exame
						   and spp.area =
							   (select ar.cod_area
								  from areas ar
								 where ar.descricao_area =
									   y.unidadecoleta)
						   and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h

WHERE h.ordemservico not in
(select ab.ordemservico
  from shift_painel_gestao_os ab
 where ab.ordemservico = h.ordemservico)
 and h.data_coleta <= (sysdate()) + 4 / 1400

order by tipo,
  data_coleta
		";



		$rows = $this->executeQuery($sql);
		// echo "<pre>";
		// print_r($rows);
		// echo "</pre>";
		// exit;

		return $rows;
	}

	public function listaTriagens($filtro)
	{

		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}



		$sql = "SELECT distinct h.ordemservico,
		h.paciente_nome,
		h.paciente_datanascimento,
		h.unidadecoleta,
		h.tipo,
		case when h.setor = 'B' then 'Bioquímica'
              when h.setor = 'U' then 'Urinálise'
                when h.setor = 'H' then 'Hematologia'
                  end setor,
				  h.setor setor_parametro,
		h.exame_tipoatendimento,
		H.meta_COLETA,
		h.meta_triagem meta,
		h.meta meta_assinatura,
		h.tat,
		--(h.data_liberou_triagem - h.data_liberou_assinatura) * 24 * 60 deflator,
		--(h.data_liberou_triagem - h.data_meta_assinatura) * 24 * 60 deflator_meta_assinatura,    
		
		(((h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60) -
		((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60)) deflator,
		h.data_liberou_triagem data_coleta,
		h.data_liberou_coleta,
		h.data_liberou_triagem,
		h.data_liberou_assinatura,
		h.DATA_META_COLETA,
		h.DATA_META_TRIAGEM,
		h.DATA_META_ASSINATURA,
		/*((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60) - 
		((h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60) deflator,*/
		(h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60 deflator_coleta,
		(h.data_liberou_assinatura - h.data_liberou_triagem) * 24 * 60 deflator_triagem,
		(h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60 deflator_meta_coleta,
		(h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60 deflator_meta_triagem,
		
		case
		  when h.porcentagem_tempo_meta < -70 then
		   'VERDE'
		  when h.porcentagem_tempo_meta > -70 and
			   h.porcentagem_tempo_meta < -40 then
		   'AMARELO'
		  when h.porcentagem_tempo_meta > -40 and
			   h.porcentagem_tempo_meta < -6 then
		   'VERMELHO'
		  when h.porcentagem_tempo_meta > 0 then
		   'PRETO'
		end status,
		h.porcentagem_tempo_meta
			FROM (SELECT b.ordemservico,
				   b.paciente_nome,
				   b.paciente_datanascimento,
				   b.unidadecoleta,
				   b.tipo,
				   b.tipo_codigo,
				   b.setor,
				   b.exame,
				   b.exame_descricao,
				   b.exame_tipoatendimento,
				   b.meta,
				   b.meta_triagem,
				   B.meta_COLETA,
				   b.tat,
				   b.data_liberou_assinatura,
				   b.data_liberou_coleta,
				   b.data_liberou_triagem,
				   (b.data_liberou_assinatura - b.data_liberou_coleta) * 24 * 60 deflator,
				   b.DATA_META_COLETA,
				   b.DATA_META_ASSINATURA,
				   b.DATA_META_TRIAGEM,
				   (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
			  FROM (SELECT a.ordemservico,
			   a.paciente_nome,
			   a.paciente_datanascimento,
			   a.unidadecoleta,
			   a.tipo,
			   a.tipo_codigo,
			   a.setor,
			   a.exame,
			   a.exame_descricao,
			   a.exame_tipoatendimento,
			   a.meta,
			   a.meta_triagem,
			   A.meta_COLETA,
			   a.tat,
			   a.data_liberou_assinatura,
			   a.DATA_META_COLETA,
			   a.DATA_META_ASSINATURA,
			   a.DATA_META_TRIAGEM,
			   a.data_liberou_coleta,
			   a.data_liberou_triagem,
			   (sysdate - a.data_liberou_assinatura) * 24 * 60 tempo_atual,
			   a.tempo_meta
		  FROM (SELECT z.ordemservico,
					   z.paciente_nome,
					   z.paciente_datanascimento,
					   z.unidadecoleta,
					   z.tipo,
					   z.tipo_codigo,
					   z.setor,
					   z.exame,
					   z.exame_descricao,
					   z.exame_tipoatendimento,
					   z.meta,
					   z.meta_triagem,
					   Z.meta_COLETA,
					   z.tat,
					   z.data_liberou_assinatura,
					   z.data_liberou_coleta,
					   z.data_liberou_triagem,
					   z.data_liberou_coleta +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
												 'HH24:MI'),
										 'HH24') * 60) / (24 * 60) +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
												 'HH24:MI'),
										 'MI')) / (24 * 60) DATA_META_COLETA,
					   z.data_liberou_assinatura +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
										 'HH24') * 60) / (24 * 60) +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
										 'MI')) / (24 * 60) DATA_META_ASSINATURA,
					   
					   z.data_liberou_triagem +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
												 'HH24:MI'),
										 'HH24') * 60) / (24 * 60) +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
												 'HH24:MI'),
										 'MI')) / (24 * 60) DATA_META_TRIAGEM,
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem, 'HH24:MI'),
										 'HH24') * 60) +
					   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem, 'HH24:MI'),
										 'MI')) tempo_meta
				  FROM (SELECT y.ordemservico,
							   y.paciente_nome,
							   y.paciente_datanascimento,
							   y.unidadecoleta,
							   y.exame,
							   y.exame_descricao,
							   y.exame_tipoatendimento,
							   case
								 when y.exame in
									  (select pe.cod_exame
										 from shift_painel_parametriza_exame pe
										where pe.tipo = 1) then
								  'Protocolo'
								 when y.exame_tipoatendimento = 'R' then
								  'Rotina'
								 when y.exame_tipoatendimento = 'U' then
								  'Urgente'
							   end tipo,
							   spp.setor_lab setor,
							   spp.tipo tipo_codigo,
							   (select max(ae.meta_tempo_COLETA)
								  from shift_painel_parametriza_exame ae
								 where ae.cod_exame = y.exame
								   and ae.tipo = y.exame_tipo_codigo
								   and ae.area =
									   (select ar.cod_area
										  from areas ar
										 where ar.descricao_area =
											   y.unidadecoleta)
								   and ae.tipo = y.exame_tipo_codigo) meta_COLETA,
							   (select max(ae.meta_tempo_assinatura)
								  from shift_painel_parametriza_exame ae
								 where ae.cod_exame = y.exame
								   and ae.tipo = y.exame_tipo_codigo
								   and ae.area =
									   (select ar.cod_area
										  from areas ar
										 where ar.descricao_area =
											   y.unidadecoleta)
								   and ae.tipo = y.exame_tipo_codigo) meta,
							   (select max(ae.meta_tempo_triagem)
								  from shift_painel_parametriza_exame ae
								 where ae.cod_exame = y.exame
								   and ae.tipo = y.exame_tipo_codigo
								   and ae.area =
									   (select ar.cod_area
										  from areas ar
										 where ar.descricao_area =
											   y.unidadecoleta)
								   and ae.tipo = y.exame_tipo_codigo) meta_triagem,
							   (select max(ae.tat)
								  from shift_painel_parametriza_exame ae
								 where ae.cod_exame = y.exame
								   and ae.tipo = y.exame_tipo_codigo
								   and ae.area =
									   (select ar.cod_area
										  from areas ar
										 where ar.descricao_area =
											   y.unidadecoleta)
								   and ae.tipo = y.exame_tipo_codigo) tat,
							   y.data_liberou_assinatura,
							   y.data_liberou_coleta,
							   y.data_liberou_triagem
						
						  from (select x.ordemservico,
									   x.paciente_nome,
									   x.paciente_datanascimento,
									   x.unidadecoleta,
									   x.exame_codigo exame,
									   x.exame_descricaoexame exame_descricao,
									   x.exame_tipoatendimento,
									   case
										 when x.exame_codigo in
											  (select pe.cod_exame
												 from shift_painel_parametriza_exame pe
												where pe.tipo = 1) then
										  1
										 when x.exame_tipoatendimento = 'R' then
										  2
										 when x.exame_tipoatendimento = 'U' then
										  3
									   end exame_tipo_codigo,
									   to_date(x.data_liberou_assinatura,
											   'DD/MM/RRRR HH24:MI:SS') data_liberou_assinatura,
									   X.data_liberou_coleta,
									   to_date(x.data_liberou_triagem,
											   'DD/MM/RRRR HH24:MI:SS') data_liberou_triagem
								  from (select distinct a.ordemservico,
														a.paciente_nome,
														a.paciente_datanascimento,
														REPLACE(CONVERT(upper(a.unidadecoleta),
																		'US7ASCII'),
																'- ') unidadecoleta,
														to_char(to_date(e.dataoperacao,
																		'DD/MM/RRRR HH24:MI:SS'),
																'DD/MM/RRRR') || ' ' ||
														e.horaoperacao data_liberou_assinatura,
														to_date(to_char(to_date(se.exame_datacoletaprogramada,
																				'DD/MM/RRRR HH24:MI:SS'),
																		'DD/MM/RRRR') || ' ' ||
																se.exame_horacoletaprogramada,
																'DD/MM/RRRR HH24:MI:SS') data_liberou_coleta,
														(select to_char(to_date(max(ef.dataoperacao),
																				'DD/MM/RRRR HH24:MI:SS'),
																		'DD/MM/RRRR') || ' ' ||
																max(ef.horaoperacao)
														   from shift_painel_gestao_operacoes ef
														  where ef.id_remessa =
																a.id_remessa
															and se.exame_codigo =
																ef.cod_exame
															and ef.operacoes_codigooperacao =
																'060') data_liberou_triagem,
														se.exame_codigo,
														se.exame_descricaoexame,
														case
														  when se.exame_codigo in
															   (select pe.cod_exame
																  from shift_painel_parametriza_exame pe
																 where pe.tipo = 1) then
														   'P'
														  when se.exame_tipoatendimento = 'R' then
														   se.exame_tipoatendimento
														  when se.exame_tipoatendimento = 'U' then
														   se.exame_tipoatendimento
														end exame_tipoatendimento
										  FROM shift_painel_gestao           a,
											   shift_painel_gestao_operacoes e,
											   shift_painel_gestao_exame     se
										 where e.cod_exame =
											   se.exame_codigo
										   and a.id_remessa =
											   e.id_remessa
										   and se.id_remessa =
											   a.id_remessa
										   and se.id_remessa =
											   e.id_remessa
										   and se.exame_tipoatendimento is not null
										   and se.exame_datacoletaprogramada is not null
											  and e.operacoes_codigooperacao =
											  '060'
										   and to_date(to_char(to_date(e.dataoperacao,
																	   'DD/MM/RRRR HH24:MI:SS'),
															   'DD/MM/RRRR') || ' ' ||
													   e.horaoperacao,
													   'DD/MM/RRRR HH24:MI:SS') =
											   (select max(to_date(to_char(to_date(f.dataoperacao,
																				   'DD/MM/RRRR HH24:MI:SS'),
																		   'DD/MM/RRRR') || ' ' ||
																   f.horaoperacao,
																   'DD/MM/RRRR HH24:MI:SS'))
												  from shift_painel_gestao_operacoes f
												 where f.id_remessa =
													   a.id_remessa
												   and f.id_remessa =
													   e.id_remessa
												   and f.cod_exame =
													   se.exame_codigo)) x where x.data_liberou_triagem <> ' ') y,
							   shift_painel_parametriza_exame spp
						 where 1 = 1
						   and y.exame = spp.cod_exame
						   and spp.area =
							   (select ar.cod_area
								  from areas ar
								 where ar.descricao_area =
									   y.unidadecoleta)
						   and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h
						WHERE h.ordemservico not in
						(select ab.ordemservico from shift_painel_gestao_os ab)
						--and trunc(h.data_liberou_triagem) = trunc(sysdate)
						--and h.ordemservico = '013-66298-403'
						order by decode(tipo,
								 'Protocolo',
								 1,
								 'Urgente',
								 2,
								 'Rotina',
								 3,
								 'Não Parametrizado',
								 4),
						  data_liberou_assinatura";

		//exit;

		$rows = $this->executeQuery($sql);


		return $rows;
	}

	public function listaAssinaturas($filtro)
	{
		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}



		$sql = "SELECT distinct h.ordemservico,
						h.paciente_nome,
						h.paciente_datanascimento,
						h.unidadecoleta,
						h.tipo,
						case when h.setor = 'B' then 'Bioquímica'
              when h.setor = 'U' then 'Urinálise'
                when h.setor = 'H' then 'Hematologia'
                  end setor,
				  h.setor setor_parametro,
						h.exame_tipoatendimento,
						H.meta_COLETA,
						h.meta_triagem,
						h.meta,
						h.tat,
						--(h.data_liberou_triagem - h.data_liberou_assinatura) * 24 * 60 deflator,
						--(h.data_liberou_triagem - h.data_meta_assinatura) * 24 * 60 deflator_meta_assinatura,    
						
						(((h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60) -
						((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60)) +
						(((h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60) -
						((h.data_liberou_assinatura - h.data_liberou_triagem) * 24 * 60)) deflator,
						h.data_liberou_assinatura data_coleta,
						h.data_liberou_coleta,
						h.data_liberou_triagem,
						h.data_liberou_assinatura,
						h.DATA_META_COLETA,
						h.DATA_META_TRIAGEM,
						h.DATA_META_ASSINATURA,
						/*((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60) - 
						((h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60) deflator,*/
						(h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60 deflator_coleta,
						(h.data_liberou_assinatura - h.data_liberou_triagem) * 24 * 60 deflator_triagem,
						(h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60 deflator_meta_coleta,
						(h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60 deflator_meta_triagem,
						
						case
						  when h.porcentagem_tempo_meta < -70 then
						   'VERDE'
						  when h.porcentagem_tempo_meta > -70 and
							   h.porcentagem_tempo_meta < -40 then
						   'AMARELO'
						  when h.porcentagem_tempo_meta > -40 and
							   h.porcentagem_tempo_meta < -6 then
						   'VERMELHO'
						  when h.porcentagem_tempo_meta > 0 then
						   'PRETO'
						end status,
						h.porcentagem_tempo_meta
		  FROM (SELECT b.ordemservico,
					   b.paciente_nome,
					   b.paciente_datanascimento,
					   b.unidadecoleta,
					   b.tipo,
					   b.tipo_codigo,
					   b.setor,
					   b.exame,
					   b.exame_descricao,
					   b.exame_tipoatendimento,
					   b.meta,
					   b.meta_triagem,
					   B.meta_COLETA,
					   b.tat,
					   b.data_liberou_assinatura,
					   b.data_liberou_coleta,
					   b.data_liberou_triagem,
					   (b.data_liberou_assinatura - b.data_liberou_coleta) * 24 * 60 deflator,
					   b.DATA_META_COLETA,
					   b.DATA_META_ASSINATURA,
					   b.DATA_META_TRIAGEM,
					   (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
				  FROM (SELECT a.ordemservico,
							   a.paciente_nome,
							   a.paciente_datanascimento,
							   a.unidadecoleta,
							   a.tipo,
							   a.tipo_codigo,
							   a.setor,
							   a.exame,
							   a.exame_descricao,
							   a.exame_tipoatendimento,
							   a.meta,
							   a.meta_triagem,
							   A.meta_COLETA,
							   a.tat,
							   a.data_liberou_assinatura,
							   a.DATA_META_COLETA,
							   a.DATA_META_ASSINATURA,
							   a.DATA_META_TRIAGEM,
							   a.data_liberou_coleta,
							   a.data_liberou_triagem,
							   (sysdate - a.data_liberou_assinatura) * 24 * 60 tempo_atual,
							   a.tempo_meta
						  FROM (SELECT z.ordemservico,
									   z.paciente_nome,
									   z.paciente_datanascimento,
									   z.unidadecoleta,
									   z.tipo,
									   z.tipo_codigo,
									   z.setor,
									   z.exame,
									   z.exame_descricao,
									   z.exame_tipoatendimento,
									   z.meta,
									   z.meta_triagem,
									   Z.meta_COLETA,
									   z.tat,
									   z.data_liberou_assinatura,
									   z.data_liberou_coleta,
									   z.data_liberou_triagem,
									   z.data_liberou_coleta +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																 'HH24:MI'),
														 'HH24') * 60) / (24 * 60) +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																 'HH24:MI'),
														 'MI')) / (24 * 60) DATA_META_COLETA,
									   z.data_liberou_assinatura +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
														 'HH24') * 60) / (24 * 60) +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
														 'MI')) / (24 * 60) DATA_META_ASSINATURA,
									   
									   z.data_liberou_triagem +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																 'HH24:MI'),
														 'HH24') * 60) / (24 * 60) +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																 'HH24:MI'),
														 'MI')) / (24 * 60) DATA_META_TRIAGEM,
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
														 'HH24') * 60) +
									   TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
														 'MI')) tempo_meta
								  FROM (SELECT y.ordemservico,
											   y.paciente_nome,
											   y.paciente_datanascimento,
											   y.unidadecoleta,
											   y.exame,
											   y.exame_descricao,
											   y.exame_tipoatendimento,
											   case
												 when y.exame in
													  (select pe.cod_exame
														 from shift_painel_parametriza_exame pe
														where pe.tipo = 1) then
												  'Protocolo'
												 when y.exame_tipoatendimento = 'R' then
												  'Rotina'
												 when y.exame_tipoatendimento = 'U' then
												  'Urgente'
											   end tipo,
											   spp.setor_lab setor,
											   spp.tipo tipo_codigo,
											   (select max(ae.meta_tempo_COLETA)
												  from shift_painel_parametriza_exame ae
												 where ae.cod_exame = y.exame
												   and ae.tipo = y.exame_tipo_codigo
												   and ae.area =
													   (select ar.cod_area
														  from areas ar
														 where ar.descricao_area =
															   y.unidadecoleta)
												   and ae.tipo = y.exame_tipo_codigo) meta_COLETA,
											   (select max(ae.meta_tempo_assinatura)
												  from shift_painel_parametriza_exame ae
												 where ae.cod_exame = y.exame
												   and ae.tipo = y.exame_tipo_codigo
												   and ae.area =
													   (select ar.cod_area
														  from areas ar
														 where ar.descricao_area =
															   y.unidadecoleta)
												   and ae.tipo = y.exame_tipo_codigo) meta,
											   (select max(ae.meta_tempo_triagem)
												  from shift_painel_parametriza_exame ae
												 where ae.cod_exame = y.exame
												   and ae.tipo = y.exame_tipo_codigo
												   and ae.area =
													   (select ar.cod_area
														  from areas ar
														 where ar.descricao_area =
															   y.unidadecoleta)
												   and ae.tipo = y.exame_tipo_codigo) meta_triagem,
											   (select max(ae.tat)
												  from shift_painel_parametriza_exame ae
												 where ae.cod_exame = y.exame
												   and ae.tipo = y.exame_tipo_codigo
												   and ae.area =
													   (select ar.cod_area
														  from areas ar
														 where ar.descricao_area =
															   y.unidadecoleta)
												   and ae.tipo = y.exame_tipo_codigo) tat,
											   y.data_liberou_assinatura,
											   y.data_liberou_coleta,
											   y.data_liberou_triagem
										
										  from (select x.ordemservico,
													   x.paciente_nome,
													   x.paciente_datanascimento,
													   x.unidadecoleta,
													   x.exame_codigo exame,
													   x.exame_descricaoexame exame_descricao,
													   x.exame_tipoatendimento,
													   case
														 when x.exame_codigo in
															  (select pe.cod_exame
																 from shift_painel_parametriza_exame pe
																where pe.tipo = 1) then
														  1
														 when x.exame_tipoatendimento = 'R' then
														  2
														 when x.exame_tipoatendimento = 'U' then
														  3
													   end exame_tipo_codigo,
													   to_date(x.data_liberou_assinatura,
															   'DD/MM/RRRR HH24:MI:SS') data_liberou_assinatura,
													   X.data_liberou_coleta,
													   to_date(x.data_liberou_triagem,
															   'DD/MM/RRRR HH24:MI:SS') data_liberou_triagem
												  from (select distinct a.ordemservico,
																		a.paciente_nome,
																		a.paciente_datanascimento,
																		REPLACE(CONVERT(upper(a.unidadecoleta),
																						'US7ASCII'),
																				'- ') unidadecoleta,
																		to_char(to_date(e.dataoperacao,
																						'DD/MM/RRRR HH24:MI:SS'),
																				'DD/MM/RRRR') || ' ' ||
																		e.horaoperacao data_liberou_assinatura,
																		to_date(to_char(to_date(se.exame_datacoletaprogramada,
																								'DD/MM/RRRR HH24:MI:SS'),
																						'DD/MM/RRRR') || ' ' ||
																				se.exame_horacoletaprogramada,
																				'DD/MM/RRRR HH24:MI:SS') data_liberou_coleta,
																		(select to_char(to_date(max(ef.dataoperacao),
																								'DD/MM/RRRR HH24:MI:SS'),
																						'DD/MM/RRRR') || ' ' ||
																				max(ef.horaoperacao)
																		   from shift_painel_gestao_operacoes ef
																		  where ef.id_remessa =
																				a.id_remessa
																			and se.exame_codigo =
																				ef.cod_exame
																			and ef.operacoes_codigooperacao =
																				'060') data_liberou_triagem,
																		se.exame_codigo,
																		se.exame_descricaoexame,
																		case
																		  when se.exame_codigo in
																			   (select pe.cod_exame
																				  from shift_painel_parametriza_exame pe
																				 where pe.tipo = 1) then
																		   'P'
																		  when se.exame_tipoatendimento = 'R' then
																		   se.exame_tipoatendimento
																		  when se.exame_tipoatendimento = 'U' then
																		   se.exame_tipoatendimento
																		end exame_tipoatendimento
														  FROM shift_painel_gestao           a,
															   shift_painel_gestao_operacoes e,
															   shift_painel_gestao_exame     se
														 where e.cod_exame =
															   se.exame_codigo
														   and a.id_remessa =
															   e.id_remessa
														   and se.id_remessa =
															   a.id_remessa
														   and se.id_remessa =
															   e.id_remessa
														   and se.exame_tipoatendimento is not null
														   and se.exame_datacoletaprogramada is not null
															  and e.operacoes_codigooperacao =
															  '055'
														   and to_date(to_char(to_date(e.dataoperacao,
																					   'DD/MM/RRRR HH24:MI:SS'),
																			   'DD/MM/RRRR') || ' ' ||
																	   e.horaoperacao,
																	   'DD/MM/RRRR HH24:MI:SS') =
															   (select max(to_date(to_char(to_date(f.dataoperacao,
																								   'DD/MM/RRRR HH24:MI:SS'),
																						   'DD/MM/RRRR') || ' ' ||
																				   f.horaoperacao,
																				   'DD/MM/RRRR HH24:MI:SS'))
																  from shift_painel_gestao_operacoes f
																 where f.id_remessa =
																	   a.id_remessa
																   and f.id_remessa =
																	   e.id_remessa
																   and f.cod_exame =
																	   se.exame_codigo)) x where x.data_liberou_triagem <> ' ') y,
											   shift_painel_parametriza_exame spp
										 where 1 = 1
										   and y.exame = spp.cod_exame
										   and spp.area =
											   (select ar.cod_area
												  from areas ar
												 where ar.descricao_area =
													   y.unidadecoleta)
										   and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h
		 WHERE h.ordemservico not in
			   (select ab.ordemservico from shift_painel_gestao_os ab)
			   --and trunc(h.data_liberou_assinatura) = trunc(sysdate)
		   --and h.ordemservico = '013-66298-403'
		 order by decode(tipo,
						 'Protocolo',
						 1,
						 'Urgente',
						 2,
						 'Rotina',
						 3,
						 'Não Parametrizado',
						 4),
				  data_liberou_assinatura
		";



		$rows = $this->executeQuery($sql);

		// echo "<pre>";
		// print_r($sql);
		// echo "</pre>";
		// exit;
		return $rows;
	}


	public function painelColetas($filtro) // FUNÇÃO PARA TRAZER VALORES DO PAINEL DA TV - NECESSÁRIO CORRIGIR SELECT
	{

		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}

		$sql = "SELECT j.status, count(j.status) quantidade
		from (SELECT distinct h.ordemservico,
					  h.paciente_nome,
					  h.paciente_datanascimento,
					  h.unidadecoleta,
					  h.tipo,
					  h.setor,
					  h.exame_tipoatendimento,
					  h.meta,
					  h.data_coleta,
					  h.data_meta,
					  h.data_operacao,
					  case
						when h.porcentagem_tempo_meta < -70 then
						 'VERDE'
						when h.porcentagem_tempo_meta > -70 and
							 h.porcentagem_tempo_meta < -40 then
						 'AMARELO'
						when h.porcentagem_tempo_meta > -40 and
							 h.porcentagem_tempo_meta < -6 then
						 'VERMELHO'
						when h.porcentagem_tempo_meta > 0 then
						 'PRETO'
					  end status,
					  h.porcentagem_tempo_meta
		FROM (SELECT b.ordemservico,
					 b.paciente_nome,
					 b.paciente_datanascimento,
					 b.unidadecoleta,
					 b.tipo,
					 b.tipo_codigo,
					 b.setor,
					 b.exame,
					 b.exame_descricao,
					 b.exame_tipoatendimento,
					 b.meta,
					 b.data_coleta,
					 b.data_meta,
					 b.data_operacao,
					 (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
				FROM (SELECT a.ordemservico,
							 a.paciente_nome,
							 a.paciente_datanascimento,
							 a.unidadecoleta,
							 a.tipo,
							 a.tipo_codigo,
							 a.setor,
							 a.exame,
							 a.exame_descricao,
							 a.exame_tipoatendimento,
							 a.meta,
							 a.data_coleta,
							 a.data_operacao,
							 a.data_meta,
							 (a.data_operacao - a.data_coleta) * 24 * 60 tempo_atual,
							 a.tempo_meta
						FROM (SELECT z.ordemservico,
									 z.paciente_nome,
									 z.paciente_datanascimento,
									 z.unidadecoleta,
									 z.tipo,
									 z.tipo_codigo,
									 z.setor,
									 z.exame,
									 z.exame_descricao,
									 z.exame_tipoatendimento,
									 z.meta,
									 z.data_coleta,
									 z.data_operacao,
									 z.data_coleta +
									 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
													   'HH24') * 60) / (24 * 60) +
									 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
													   'MI')) / (24 * 60) DATA_META,
									 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
													   'HH24') * 60) +
									 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
													   'MI')) tempo_meta
								FROM (SELECT y.ordemservico,
											 y.paciente_nome,
											 y.paciente_datanascimento,
											 y.unidadecoleta,
											 y.exame,
											 y.exame_descricao,
											 y.exame_tipoatendimento,
											 case
											   when y.exame in
													(select pe.cod_exame
													   from shift_painel_parametriza_exame pe
													  where pe.tipo = 1) then
												'Protocolo'
											   when y.exame_tipoatendimento = 'R' then
												'Rotina'
											   when y.exame_tipoatendimento = 'U' then
												'Urgente'
											 end tipo,
											 spp.setor_lab setor,
											 spp.tipo tipo_codigo,
											 (select max(ae.meta_tempo_coleta)
												from shift_painel_parametriza_exame ae
											   where ae.cod_exame = y.exame
												 and ae.tipo = y.exame_tipo_codigo
												 and ae.area =
													 (select ar.cod_area
														from areas ar
													   where ar.descricao_area =
															 y.unidadecoleta)
												 and ae.tipo = y.exame_tipo_codigo) meta,
											 y.data_coleta,
											 y.data_operacao
										from (select x.ordemservico,
													 x.paciente_nome,
													 x.paciente_datanascimento,
													 x.unidadecoleta,
													 x.exame_codigo exame,
													 x.exame_descricaoexame exame_descricao,
													 x.exame_tipoatendimento,
													 case
													   when x.exame_codigo in
															(select pe.cod_exame
															   from shift_painel_parametriza_exame pe
															  where pe.tipo = 1) then
														1
													   when x.exame_tipoatendimento = 'R' then
														2
													   when x.exame_tipoatendimento = 'U' then
														3
													 end exame_tipo_codigo,
													 to_date(x.data_coleta,
															 'DD/MM/RRRR HH24:MI:SS') data_coleta,
													 to_date(x.data_operacao,
															 'DD/MM/RRRR HH24:MI:SS') data_operacao
											  
												from (select distinct a.ordemservico,
																	  a.paciente_nome,
																	  a.paciente_datanascimento,
																	  REPLACE(CONVERT(upper(a.unidadecoleta),
																					  'US7ASCII'),
																			  '- ') unidadecoleta,
																	  to_char(to_date(se.exame_datacoletaprogramada,
																					  'DD/MM/RRRR HH24:MI:SS'),
																			  'DD/MM/RRRR') || ' ' ||
																	  se.exame_horacoletaprogramada data_coleta,
																	  to_char(to_date(e.dataoperacao,
																					  'DD/MM/RRRR HH24:MI:SS'),
																			  'DD/MM/RRRR') || ' ' ||
																	  e.horaoperacao data_operacao,
																	  se.exame_codigo,
																	  se.exame_descricaoexame,
																	  case
																		when se.exame_codigo in
																			 (select pe.cod_exame
																				from shift_painel_parametriza_exame pe
																			   where pe.tipo = 1) then
																		 'P'
																		when se.exame_tipoatendimento = 'R' then
																		 se.exame_tipoatendimento
																		when se.exame_tipoatendimento = 'U' then
																		 se.exame_tipoatendimento
																	  end exame_tipoatendimento
														FROM shift_painel_gestao           a,
															 shift_painel_gestao_operacoes e,
															 shift_painel_gestao_exame     se
													   where e.cod_exame =
															 se.exame_codigo
														 and a.id_remessa =
															 e.id_remessa
														 and se.id_remessa =
															 a.id_remessa
														 and se.id_remessa =
															 e.id_remessa
														 and se.exame_tipoatendimento is not null
														 and se.exame_datacoletaprogramada is not null
														 and e.operacoes_codigooperacao =
															 '060'
													  /*and to_date(to_char(to_date(e.dataoperacao,
																			  'DD/MM/RRRR HH24:MI:SS'),
																	  'DD/MM/RRRR') || ' ' ||
															  e.horaoperacao,
															  'DD/MM/RRRR HH24:MI:SS') =
													  (select max(to_date(to_char(to_date(f.dataoperacao,
																						  'DD/MM/RRRR HH24:MI:SS'),
																				  'DD/MM/RRRR') || ' ' ||
																		  f.horaoperacao,
																		  'DD/MM/RRRR HH24:MI:SS'))
														 from shift_painel_gestao_operacoes f
														where f.id_remessa =
															  a.id_remessa
														  and f.id_remessa =
															  e.id_remessa
														  and f.cod_exame =
															  se.exame_codigo)*/
													  
													  ) x) y,
											 shift_painel_parametriza_exame spp
									   where 1 = 1
										 and y.exame = spp.cod_exame
										 and spp.area =
											 (select ar.cod_area
												from areas ar
											   where ar.descricao_area =
													 y.unidadecoleta)
										 and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h
	  
	   WHERE h.ordemservico not in
			 (select ab.ordemservico
				from shift_painel_gestao_os ab
			   where ab.ordemservico = h.ordemservico)
		 and trunc(h.data_coleta) = trunc(sysdate)
	  
	   order by decode(tipo,
					   'Protocolo',
					   1,
					   'Urgente',
					   2,
					   'Rotina',
					   3,
					   'Não Parametrizado',
					   4),
				data_coleta) j
						where  status is not null
						group by j.status
			 order by j.status";

		//   var_dump($sql);
		//   exit;

		$rows = $this->executeQuery($sql);


		return $rows;
	}
	// ""
	public function painelTriagens($filtro)
	{

		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}

		$sql = "SELECT j.status, count(j.status) quantidade
		from (SELECT distinct h.ordemservico,
							  h.paciente_nome,
							  h.paciente_datanascimento,
							  h.unidadecoleta,
							  h.tipo,
							  h.setor,
							  h.exame_tipoatendimento,
							  h.meta,
							  h.data_coleta,
							  h.data_meta,
							  h.data_operacao,
							  h.data_liberou_triagem,
							  case
								when h.porcentagem_tempo_meta < -70 then
								 'VERDE'
								when h.porcentagem_tempo_meta > -70 and
									 h.porcentagem_tempo_meta < -40 then
								 'AMARELO'
								when h.porcentagem_tempo_meta > -40 and
									 h.porcentagem_tempo_meta < -6 then
								 'VERMELHO'
								when h.porcentagem_tempo_meta > 0 then
								 'PRETO'
							  end status,
							  h.porcentagem_tempo_meta
				FROM (SELECT b.ordemservico,
							 b.paciente_nome,
							 b.paciente_datanascimento,
							 b.unidadecoleta,
							 b.tipo,
							 b.tipo_codigo,
							 b.setor,
							 b.exame,
							 b.exame_descricao,
							 b.exame_tipoatendimento,
							 b.meta,
							 b.data_coleta,
							 b.data_meta,
							 b.data_liberou_triagem,
							 b.data_operacao,
							 (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
						FROM (SELECT a.ordemservico,
									 a.paciente_nome,
									 a.paciente_datanascimento,
									 a.unidadecoleta,
									 a.tipo,
									 a.tipo_codigo,
									 a.setor,
									 a.exame,
									 a.exame_descricao,
									 a.exame_tipoatendimento,
									 a.meta,
									 a.data_coleta,
									 a.data_operacao,
									 a.data_liberou_triagem,
									 a.data_meta,
									 (a.data_operacao - a.data_liberou_triagem) * 24 * 60 tempo_atual,
									 a.tempo_meta
								FROM (SELECT z.ordemservico,
											 z.paciente_nome,
											 z.paciente_datanascimento,
											 z.unidadecoleta,
											 z.tipo,
											 z.tipo_codigo,
											 z.setor,
											 z.exame,
											 z.exame_descricao,
											 z.exame_tipoatendimento,
											 z.meta,
											 z.data_coleta,
											 z.data_operacao,
											 z.data_liberou_triagem,
											 z.data_coleta + TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																					   'HH24:MI'),
																			   'HH24') * 60) /
											 (24 * 60) +
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'MI')) / (24 * 60) DATA_META,
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'HH24') * 60) +
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'MI')) tempo_meta
										FROM (SELECT y.ordemservico,
													 y.paciente_nome,
													 y.paciente_datanascimento,
													 y.unidadecoleta,
													 y.exame,
													 y.exame_descricao,
													 y.exame_tipoatendimento,
													 case
													   when y.exame in
															(select pe.cod_exame
															   from shift_painel_parametriza_exame pe
															  where pe.tipo = 1) then
														'Protocolo'
													   when y.exame_tipoatendimento = 'R' then
														'Rotina'
													   when y.exame_tipoatendimento = 'U' then
														'Urgente'
													 end tipo,
													 spp.setor_lab setor,
													 spp.tipo tipo_codigo,
													 (select max(ae.meta_tempo_coleta)
														from shift_painel_parametriza_exame ae
													   where ae.cod_exame = y.exame
														 and ae.tipo =
															 y.exame_tipo_codigo
														 and ae.area =
															 (select ar.cod_area
																from areas ar
															   where ar.descricao_area =
																	 y.unidadecoleta)
														 and ae.tipo =
															 y.exame_tipo_codigo) meta,
													 y.data_coleta,
													 y.data_operacao,
													 y.data_liberou_triagem
												from (select x.ordemservico,
															 x.paciente_nome,
															 x.paciente_datanascimento,
															 x.unidadecoleta,
															 x.exame_codigo exame,
															 x.exame_descricaoexame exame_descricao,
															 x.exame_tipoatendimento,
															 case
															   when x.exame_codigo in
																	(select pe.cod_exame
																	   from shift_painel_parametriza_exame pe
																	  where pe.tipo = 1) then
																1
															   when x.exame_tipoatendimento = 'R' then
																2
															   when x.exame_tipoatendimento = 'U' then
																3
															 end exame_tipo_codigo,
															 to_date(x.data_coleta,
																	 'DD/MM/RRRR HH24:MI:SS') data_coleta,
															 to_date(x.data_operacao,
																	 'DD/MM/RRRR HH24:MI:SS') data_operacao,
															 to_date(x.data_liberou_triagem,
																	 'DD/MM/RRRR HH24:MI:SS') data_liberou_triagem
													  
														from (select distinct a.ordemservico,
																			  a.paciente_nome,
																			  a.paciente_datanascimento,
																			  REPLACE(CONVERT(upper(a.unidadecoleta),
																							  'US7ASCII'),
																					  '- ') unidadecoleta,
																			  (select max(to_char(to_date(ef.dataoperacao,
																									  'DD/MM/RRRR HH24:MI:SS'),
																							  'DD/MM/RRRR') || ' ' ||
																					  ef.horaoperacao)
																				 from shift_painel_gestao_operacoes ef
																				where ef.id_remessa =
																					  a.id_remessa
																				  and se.exame_codigo =
																					  ef.cod_exame
																				  and ef.operacoes_codigooperacao =
																					  '060') data_liberou_triagem,
																			  to_char(to_date(se.exame_datacoletaprogramada,
																							  'DD/MM/RRRR HH24:MI:SS'),
																					  'DD/MM/RRRR') || ' ' ||
																			  se.exame_horacoletaprogramada data_coleta,
																			  to_char(to_date(e.dataoperacao,
																							  'DD/MM/RRRR HH24:MI:SS'),
																					  'DD/MM/RRRR') || ' ' ||
																			  e.horaoperacao data_operacao,
																			  se.exame_codigo,
																			  se.exame_descricaoexame,
																			  case
																				when se.exame_codigo in
																					 (select pe.cod_exame
																						from shift_painel_parametriza_exame pe
																					   where pe.tipo = 1) then
																				 'P'
																				when se.exame_tipoatendimento = 'R' then
																				 se.exame_tipoatendimento
																				when se.exame_tipoatendimento = 'U' then
																				 se.exame_tipoatendimento
																			  end exame_tipoatendimento
																FROM shift_painel_gestao           a,
																	 shift_painel_gestao_operacoes e,
																	 shift_painel_gestao_exame     se
															   where e.cod_exame =
																	 se.exame_codigo
																 and a.id_remessa =
																	 e.id_remessa
																 and se.id_remessa =
																	 a.id_remessa
																 and se.id_remessa =
																	 e.id_remessa
																 and se.exame_tipoatendimento is not null
																 and se.exame_datacoletaprogramada is not null
																 and e.operacoes_codigooperacao =
																	 '055'
															  /*and to_date(to_char(to_date(e.dataoperacao,
																		  'DD/MM/RRRR HH24:MI:SS'),
																	  'DD/MM/RRRR') || ' ' ||
																  e.horaoperacao,
																  'DD/MM/RRRR HH24:MI:SS') =
															  (select max(to_date(to_char(to_date(f.dataoperacao,
																				'DD/MM/RRRR HH24:MI:SS'),
																			'DD/MM/RRRR') || ' ' ||
																		f.horaoperacao,
																		'DD/MM/RRRR HH24:MI:SS'))
															   from shift_painel_gestao_operacoes f
															  where f.id_remessa =
																  a.id_remessa
																and f.id_remessa =
																  e.id_remessa
																and f.cod_exame =
																  se.exame_codigo)*/
															  
															  ) x) y,
													 shift_painel_parametriza_exame spp
											   where 1 = 1
												 and y.exame = spp.cod_exame
												 and spp.area =
													 (select ar.cod_area
														from areas ar
													   where ar.descricao_area =
															 y.unidadecoleta)
												 and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h
			  
			   WHERE h.ordemservico not in
					 (select ab.ordemservico
						from shift_painel_gestao_os ab
					   where ab.ordemservico = h.ordemservico)
				 and trunc(h.data_liberou_triagem) = trunc(sysdate)
			  
			   order by decode(tipo,
							   'Protocolo',
							   1,
							   'Urgente',
							   2,
							   'Rotina',
							   3,
							   'Não Parametrizado',
							   4),
						data_coleta) j
	   where status is not null
	   group by j.status
	   order by j.status
	  ";

		//   var_dump($sql);
		//   exit;

		$rows = $this->executeQuery($sql);


		return $rows;
	}
	// ""
	public function painelAssinaturas($filtro)
	{

		$filtro_concatenado = "";
		foreach ($filtro as $id => $data) {
			if ($id == count($filtro) - 1) {
				$filtro_concatenado .= "'" . $data . "'";
			} else {
				$filtro_concatenado .= "'" . $data . "'" . ',';
			}
			//var_dump($id);

		}

		$sql = "SELECT j.status, count(j.status) quantidade
		from (SELECT distinct h.ordemservico,
							  h.paciente_nome,
							  h.paciente_datanascimento,
							  h.unidadecoleta,
							  h.tipo,
							  h.setor,
							  h.exame_tipoatendimento,
							  h.meta,
							  h.data_coleta,
							  h.data_meta,
							  h.data_operacao,
							  h.data_liberou_assinatura,
							  case
								when h.porcentagem_tempo_meta < -70 then
								 'VERDE'
								when h.porcentagem_tempo_meta > -70 and
									 h.porcentagem_tempo_meta < -40 then
								 'AMARELO'
								when h.porcentagem_tempo_meta > -40 and
									 h.porcentagem_tempo_meta < -6 then
								 'VERMELHO'
								when h.porcentagem_tempo_meta > 0 then
								 'PRETO'
							  end status,
							  h.porcentagem_tempo_meta
				FROM (SELECT b.ordemservico,
							 b.paciente_nome,
							 b.paciente_datanascimento,
							 b.unidadecoleta,
							 b.tipo,
							 b.tipo_codigo,
							 b.setor,
							 b.exame,
							 b.exame_descricao,
							 b.exame_tipoatendimento,
							 b.meta,
							 b.data_coleta,
							 b.data_meta,
							 b.data_liberou_assinatura,
							 b.data_operacao,
							 (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
						FROM (SELECT a.ordemservico,
									 a.paciente_nome,
									 a.paciente_datanascimento,
									 a.unidadecoleta,
									 a.tipo,
									 a.tipo_codigo,
									 a.setor,
									 a.exame,
									 a.exame_descricao,
									 a.exame_tipoatendimento,
									 a.meta,
									 a.data_coleta,
									 a.data_operacao,
									 a.data_liberou_assinatura,
									 a.data_meta,
									 (a.data_operacao - a.data_liberou_assinatura) * 24 * 60 tempo_atual,
									 a.tempo_meta
								FROM (SELECT z.ordemservico,
											 z.paciente_nome,
											 z.paciente_datanascimento,
											 z.unidadecoleta,
											 z.tipo,
											 z.tipo_codigo,
											 z.setor,
											 z.exame,
											 z.exame_descricao,
											 z.exame_tipoatendimento,
											 z.meta,
											 z.data_coleta,
											 z.data_operacao,
											 z.data_liberou_assinatura,
											 z.data_coleta + TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																					   'HH24:MI'),
																			   'HH24') * 60) /
											 (24 * 60) +
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'MI')) / (24 * 60) DATA_META,
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'HH24') * 60) +
											 TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																	   'HH24:MI'),
															   'MI')) tempo_meta
										FROM (SELECT y.ordemservico,
													 y.paciente_nome,
													 y.paciente_datanascimento,
													 y.unidadecoleta,
													 y.exame,
													 y.exame_descricao,
													 y.exame_tipoatendimento,
													 case
													   when y.exame in
															(select pe.cod_exame
															   from shift_painel_parametriza_exame pe
															  where pe.tipo = 1) then
														'Protocolo'
													   when y.exame_tipoatendimento = 'R' then
														'Rotina'
													   when y.exame_tipoatendimento = 'U' then
														'Urgente'
													 end tipo,
													 spp.setor_lab setor,
													 spp.tipo tipo_codigo,
													 (select max(ae.meta_tempo_coleta)
														from shift_painel_parametriza_exame ae
													   where ae.cod_exame = y.exame
														 and ae.tipo =
															 y.exame_tipo_codigo
														 and ae.area =
															 (select ar.cod_area
																from areas ar
															   where ar.descricao_area =
																	 y.unidadecoleta)
														 and ae.tipo =
															 y.exame_tipo_codigo) meta,
													 y.data_coleta,
													 y.data_operacao,
													 y.data_liberou_assinatura
												from (select x.ordemservico,
															 x.paciente_nome,
															 x.paciente_datanascimento,
															 x.unidadecoleta,
															 x.exame_codigo exame,
															 x.exame_descricaoexame exame_descricao,
															 x.exame_tipoatendimento,
															 case
															   when x.exame_codigo in
																	(select pe.cod_exame
																	   from shift_painel_parametriza_exame pe
																	  where pe.tipo = 1) then
																1
															   when x.exame_tipoatendimento = 'R' then
																2
															   when x.exame_tipoatendimento = 'U' then
																3
															 end exame_tipo_codigo,
															 to_date(x.data_coleta,
																	 'DD/MM/RRRR HH24:MI:SS') data_coleta,
															 to_date(x.data_operacao,
																	 'DD/MM/RRRR HH24:MI:SS') data_operacao,
															 to_date(x.data_liberou_assinatura,
																	 'DD/MM/RRRR HH24:MI:SS') data_liberou_assinatura
													  
														from (select distinct a.ordemservico,
																			  a.paciente_nome,
																			  a.paciente_datanascimento,
																			  REPLACE(CONVERT(upper(a.unidadecoleta),
																							  'US7ASCII'),
																					  '- ') unidadecoleta,
																			  (select max(to_char(to_date(ef.dataoperacao,
																									  'DD/MM/RRRR HH24:MI:SS'),
																							  'DD/MM/RRRR') || ' ' ||
																					  ef.horaoperacao)
																				 from shift_painel_gestao_operacoes ef
																				where ef.id_remessa =
																					  a.id_remessa
																				  and se.exame_codigo =
																					  ef.cod_exame
																				  and ef.operacoes_codigooperacao =
																					  '055') data_liberou_assinatura,
																			  to_char(to_date(se.exame_datacoletaprogramada,
																							  'DD/MM/RRRR HH24:MI:SS'),
																					  'DD/MM/RRRR') || ' ' ||
																			  se.exame_horacoletaprogramada data_coleta,
																			  to_char(to_date(e.dataoperacao,
																							  'DD/MM/RRRR HH24:MI:SS'),
																					  'DD/MM/RRRR') || ' ' ||
																			  e.horaoperacao data_operacao,
																			  se.exame_codigo,
																			  se.exame_descricaoexame,
																			  case
																				when se.exame_codigo in
																					 (select pe.cod_exame
																						from shift_painel_parametriza_exame pe
																					   where pe.tipo = 1) then
																				 'P'
																				when se.exame_tipoatendimento = 'R' then
																				 se.exame_tipoatendimento
																				when se.exame_tipoatendimento = 'U' then
																				 se.exame_tipoatendimento
																			  end exame_tipoatendimento
																FROM shift_painel_gestao           a,
																	 shift_painel_gestao_operacoes e,
																	 shift_painel_gestao_exame     se
															   where e.cod_exame =
																	 se.exame_codigo
																 and a.id_remessa =
																	 e.id_remessa
																 and se.id_remessa =
																	 a.id_remessa
																 and se.id_remessa =
																	 e.id_remessa
																 and se.exame_tipoatendimento is not null
																 and se.exame_datacoletaprogramada is not null
																 and e.operacoes_codigooperacao in ('013', '051')
															  /*and to_date(to_char(to_date(e.dataoperacao,
																		  'DD/MM/RRRR HH24:MI:SS'),
																	  'DD/MM/RRRR') || ' ' ||
																  e.horaoperacao,
																  'DD/MM/RRRR HH24:MI:SS') =
															  (select max(to_date(to_char(to_date(f.dataoperacao,
																				'DD/MM/RRRR HH24:MI:SS'),
																			'DD/MM/RRRR') || ' ' ||
																		f.horaoperacao,
																		'DD/MM/RRRR HH24:MI:SS'))
															   from shift_painel_gestao_operacoes f
															  where f.id_remessa =
																  a.id_remessa
																and f.id_remessa =
																  e.id_remessa
																and f.cod_exame =
																  se.exame_codigo)*/
															  
															  ) x) y,
													 shift_painel_parametriza_exame spp
											   where 1 = 1
												 and y.exame = spp.cod_exame
												 and spp.area =
													 (select ar.cod_area
														from areas ar
													   where ar.descricao_area =
															 y.unidadecoleta)
												 and spp.setor_lab in (" . $filtro_concatenado . ")) z) a) b) h
			  
			   WHERE h.ordemservico not in
					 (select ab.ordemservico
						from shift_painel_gestao_os ab
					   where ab.ordemservico = h.ordemservico)
				 and trunc(h.data_liberou_assinatura) = trunc(sysdate)
			  
			   order by decode(tipo,
							   'Protocolo',
							   1,
							   'Urgente',
							   2,
							   'Rotina',
							   3,
							   'Não Parametrizado',
							   4),
						data_coleta) j
	   where status is not null
	   group by j.status
	   order by j.status
	  ";

		//   var_dump($sql);
		//   exit;

		$rows = $this->executeQuery($sql);


		return $rows;
	}


	public function buscaTodosExamesColetas($codigo, $tipo, $setor) // FUNÇÃO QUE LISTA EXAMES DA OS DO PACIENTE / USADA NO MODAL DE DETALHES
	{
		//var_dump($tipo);
		$sql = "SELECT distinct case
		when h.exame in (select pe.cod_exame
						   from shift_painel_parametriza_exame pe
						  where pe.tipo = 1) then
		 'Protocolo'
		when h.exame_tipoatendimento = 'R' then
		 'Rotina'
		when h.exame_tipoatendimento = 'U' then
		 'Urgente'
	  end exame_tipoatendimento,
	  h.exame_tipoatendimento tipo_codigo,
	  h.ordemservico,
	  h.paciente_nome,
	  h.exame_descricao exame_descricaoexame,
	  h.exame exame_codigo,
	  h.exame_tipo_codigo,
	  h.data_coleta,
	  h.unidadecoleta,
	  case
		when h.meta is not null then
		 h.meta
		else
		 'NÃO PARAMETRIZADO'
	  end meta,
	  case
		when h.setor is not null then
		 h.setor
		else
		 'NÃO PARAMETRIZADO'
	  end setor
		FROM (SELECT b.ordemservico,
			 b.paciente_nome,
			 b.paciente_datanascimento,
			 b.unidadecoleta,
			 b.tipo,
			 b.tipo_codigo,
			 b.setor,
			 b.exame,
			 b.exame_descricao,
			 b.exame_tipo_codigo,
			 b.exame_tipoatendimento,
			 b.meta,
			 b.data_coleta,
			 b.data_meta,
			 (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
		FROM (SELECT a.ordemservico,
			 a.paciente_nome,
			 a.paciente_datanascimento,
			 a.unidadecoleta,
			 a.tipo,
			 a.tipo_codigo,
			 a.setor,
			 a.exame,
			 a.exame_descricao,
			 a.exame_tipoatendimento,
			 a.exame_tipo_codigo,
			 a.meta,
			 a.data_coleta,
			 a.data_meta,
			 (sysdate - a.data_coleta) * 24 * 60 tempo_atual,
			 a.tempo_meta
		FROM (SELECT z.ordemservico,
					 z.paciente_nome,
					 z.paciente_datanascimento,
					 z.unidadecoleta,
					 z.tipo,
					 z.tipo_codigo,
					 z.setor,
					 z.exame,
					 z.exame_descricao,
					 z.exame_tipoatendimento,
					 z.meta,
					 z.data_coleta,
					 z.exame_tipo_codigo,
					 z.data_coleta +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'HH24') * 60) / (24 * 60) +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'MI')) / (24 * 60) DATA_META,
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'HH24') * 60) +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'MI')) tempo_meta
				FROM (SELECT y.ordemservico,
							 y.paciente_nome,
							 y.paciente_datanascimento,
							 y.unidadecoleta,
							 y.exame,
							 y.exame_descricao,
							 y.exame_tipoatendimento,
							 case
							   when y.exame in
									(select pe.cod_exame
									   from shift_painel_parametriza_exame pe
									  where pe.tipo = 1) then
								'Protocolo'
							   when y.exame_tipoatendimento = 'R' then
								'Rotina'
							   when y.exame_tipoatendimento = 'U' then
								'Urgente'
							 end tipo,
							 spp.setor_lab setor,
							 spp.tipo tipo_codigo,
							 (select max(ae.meta_tempo_coleta)
								from shift_painel_parametriza_exame ae
							   where ae.cod_exame = y.exame
								 and ae.tipo = y.exame_tipo_codigo
								 and ae.area =
									 (select ar.cod_area
										from areas ar
									   where ar.descricao_area =
											 y.unidadecoleta)
								 and ae.tipo = y.exame_tipo_codigo) meta,
							 y.data_coleta,
							 y.exame_tipo_codigo
					  
						from (select x.ordemservico,
									 x.paciente_nome,
									 x.paciente_datanascimento,
									 x.unidadecoleta,
									 x.exame_codigo exame,
									 x.exame_descricaoexame exame_descricao,
									 x.exame_tipoatendimento,
									 case
									   when x.exame_codigo in
											(select pe.cod_exame
											   from shift_painel_parametriza_exame pe
											  where pe.tipo = 1) then
										1
									   when x.exame_tipoatendimento = 'R' then
										2
									   when x.exame_tipoatendimento = 'U' then
										3
									 end exame_tipo_codigo,
									 to_date(x.data_coleta,
											 'DD/MM/RRRR HH24:MI:SS') data_coleta,
									 x.data_operacao
								from (select distinct a.ordemservico,
													  a.paciente_nome,
													  a.paciente_datanascimento,
													  REPLACE(CONVERT(upper(a.unidadecoleta),
																	  'US7ASCII'),
															  '- ') unidadecoleta,
													  to_char(to_date(se.exame_datacoletaprogramada,
																	  'DD/MM/RRRR HH24:MI:SS'),
															  'DD/MM/RRRR') || ' ' ||
													  se.exame_horacoletaprogramada data_coleta,
													  to_char(to_date(e.dataoperacao,
																	  'DD/MM/RRRR HH24:MI:SS'),
															  'DD/MM/RRRR') || ' ' ||
													  e.horaoperacao data_operacao,
													  se.exame_codigo,
													  se.exame_descricaoexame,
													  case
														when se.exame_codigo in
															 (select pe.cod_exame
																from shift_painel_parametriza_exame pe
															   where pe.tipo = 1) then
														 'P'
														when se.exame_tipoatendimento = 'R' then
														 se.exame_tipoatendimento
														when se.exame_tipoatendimento = 'U' then
														 se.exame_tipoatendimento
													  end exame_tipoatendimento
										FROM shift_painel_gestao           a,
											 shift_painel_gestao_operacoes e,
											 shift_painel_gestao_exame     se
									   where e.cod_exame =
											 se.exame_codigo
										 and a.id_remessa =
											 e.id_remessa
										 and se.id_remessa =
											 a.id_remessa
										 and se.id_remessa =
											 e.id_remessa
										 and se.exame_tipoatendimento is not null
										 and se.exame_datacoletaprogramada is not null
										 
										 and e.operacoes_codigooperacao =
											 '111'
										 and to_date(to_char(to_date(e.dataoperacao,
																	 'DD/MM/RRRR HH24:MI:SS'),
															 'DD/MM/RRRR') || ' ' ||
													 e.horaoperacao,
													 'DD/MM/RRRR HH24:MI:SS') =
											 (select max(to_date(to_char(to_date(f.dataoperacao,
																				 'DD/MM/RRRR HH24:MI:SS'),
																		 'DD/MM/RRRR') || ' ' ||
																 f.horaoperacao,
																 'DD/MM/RRRR HH24:MI:SS'))
												from shift_painel_gestao_operacoes f
											   where f.id_remessa =
													 a.id_remessa
												 and f.id_remessa =
													 e.id_remessa
												 and f.cod_exame =
													 se.exame_codigo)
									  
									  ) x) y,
							 shift_painel_parametriza_exame spp
					   where 1 = 1
						 and y.exame = spp.cod_exame
						 and spp.area =
							 (select ar.cod_area
								from areas ar
							   where ar.descricao_area =
									 y.unidadecoleta)
						 and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h

			WHERE h.ordemservico not in
			(select ab.ordemservico
			from shift_painel_gestao_os ab
			where ab.ordemservico = h.ordemservico)

			--and trunc(h.data_coleta) = trunc(sysdate)
			and h.ordemservico = :codigo
			and h.setor = :setor
			and h.exame_tipoatendimento = :tipo

			order by decode(tipo,
				   'Protocolo',
				   1,
				   'Urgente',
				   2,
				   'Rotina',
				   3,
				   'Não Parametrizado',
				   4),
			data_coleta
			";



		$bind = array(
			':codigo' => $codigo,
			':tipo'	=> $tipo,
			':setor'	=> $setor
		);

		//var_dump($sql);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}

	// ""
	public function buscaTodosExamesTriagens($codigo, $tipo, $setor)
	{
		//var_dump($tipo);
		$sql = "SELECT distinct case
                  when h.exame in (select pe.cod_exame
                                     from shift_painel_parametriza_exame pe
                                    where pe.tipo = 1) then
                   'Protocolo'
                  when h.exame_tipoatendimento = 'R' then
                   'Rotina'
                  when h.exame_tipoatendimento = 'U' then
                   'Urgente'
                end exame_tipoatendimento,
                h.exame_tipoatendimento tipo_codigo,
                h.ordemservico,
                h.paciente_nome,
                h.exame_descricao exame_descricaoexame,
                h.exame exame_codigo,
                h.exame_tipo_codigo,
                h.data_coleta,
                h.unidadecoleta,
                case
                  when h.meta is not null then
                   h.meta
                  else
                   'NÃO PARAMETRIZADO'
                end meta,
                case
                  when h.setor is not null then
                   h.setor
                  else
                   'NÃO PARAMETRIZADO'
                end setor
  		FROM (SELECT b.ordemservico,
               b.paciente_nome,
               b.paciente_datanascimento,
               b.unidadecoleta,
               b.tipo,
               b.tipo_codigo,
               b.setor,
               b.exame,
               b.exame_descricao,
               b.exame_tipo_codigo,
               b.exame_tipoatendimento,
               b.meta,
               b.data_coleta,
               b.data_meta,
               (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
          FROM (SELECT a.ordemservico,
                       a.paciente_nome,
                       a.paciente_datanascimento,
                       a.unidadecoleta,
                       a.tipo,
                       a.tipo_codigo,
                       a.setor,
                       a.exame,
                       a.exame_descricao,
                       a.exame_tipoatendimento,
                       a.exame_tipo_codigo,
                       a.meta,
                       a.data_coleta,
                       a.data_meta,
                       (sysdate - a.data_coleta) * 24 * 60 tempo_atual,
                       a.tempo_meta
                  FROM (SELECT z.ordemservico,
                               z.paciente_nome,
                               z.paciente_datanascimento,
                               z.unidadecoleta,
                               z.tipo,
                               z.tipo_codigo,
                               z.setor,
                               z.exame,
                               z.exame_descricao,
                               z.exame_tipoatendimento,
                               z.meta,
                               z.data_coleta,
                               z.exame_tipo_codigo,
                               z.data_coleta +
                               TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
                                                 'HH24') * 60) / (24 * 60) +
                               TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
                                                 'MI')) / (24 * 60) DATA_META,
                               TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
                                                 'HH24') * 60) +
                               TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
                                                 'MI')) tempo_meta
                          FROM (SELECT y.ordemservico,
                                       y.paciente_nome,
                                       y.paciente_datanascimento,
                                       y.unidadecoleta,
                                       y.exame,
                                       y.exame_descricao,
                                       y.exame_tipoatendimento,
                                       case
                                         when y.exame in
                                              (select pe.cod_exame
                                                 from shift_painel_parametriza_exame pe
                                                where pe.tipo = 1) then
                                          'Protocolo'
                                         when y.exame_tipoatendimento = 'R' then
                                          'Rotina'
                                         when y.exame_tipoatendimento = 'U' then
                                          'Urgente'
                                       end tipo,
                                       spp.setor_lab setor,
                                       spp.tipo tipo_codigo,
                                       (select max(ae.meta_tempo_coleta)
                                          from shift_painel_parametriza_exame ae
                                         where ae.cod_exame = y.exame
                                           and ae.tipo = y.exame_tipo_codigo
                                           and ae.area =
                                               (select ar.cod_area
                                                  from areas ar
                                                 where ar.descricao_area =
                                                       y.unidadecoleta)
                                           and ae.tipo = y.exame_tipo_codigo) meta,
                                       y.data_coleta,
                                       y.exame_tipo_codigo
                                
                                  from (select x.ordemservico,
                                               x.paciente_nome,
                                               x.paciente_datanascimento,
                                               x.unidadecoleta,
                                               x.exame_codigo exame,
                                               x.exame_descricaoexame exame_descricao,
                                               x.exame_tipoatendimento,
                                               case
                                                 when x.exame_codigo in
                                                      (select pe.cod_exame
                                                         from shift_painel_parametriza_exame pe
                                                        where pe.tipo = 1) then
                                                  1
                                                 when x.exame_tipoatendimento = 'R' then
                                                  2
                                                 when x.exame_tipoatendimento = 'U' then
                                                  3
                                               end exame_tipo_codigo,
                                               to_date(x.data_coleta,
                                                       'DD/MM/RRRR HH24:MI:SS') data_coleta,
                                               x.data_operacao
                                          from (select distinct a.ordemservico,
                                                                a.paciente_nome,
                                                                a.paciente_datanascimento,
                                                                REPLACE(CONVERT(upper(a.unidadecoleta),
                                                                                'US7ASCII'),
                                                                        '- ') unidadecoleta,
                                                                to_char(to_date(se.exame_datacoletaprogramada,
                                                                                'DD/MM/RRRR HH24:MI:SS'),
                                                                        'DD/MM/RRRR') || ' ' ||
                                                                se.exame_horacoletaprogramada data_coleta,
                                                                to_char(to_date(e.dataoperacao,
                                                                                'DD/MM/RRRR HH24:MI:SS'),
                                                                        'DD/MM/RRRR') || ' ' ||
                                                                e.horaoperacao data_operacao,
                                                                se.exame_codigo,
                                                                se.exame_descricaoexame,
                                                                case
                                                                  when se.exame_codigo in
                                                                       (select pe.cod_exame
                                                                          from shift_painel_parametriza_exame pe
                                                                         where pe.tipo = 1) then
                                                                   'P'
                                                                  when se.exame_tipoatendimento = 'R' then
                                                                   se.exame_tipoatendimento
                                                                  when se.exame_tipoatendimento = 'U' then
                                                                   se.exame_tipoatendimento
                                                                end exame_tipoatendimento
                                                  FROM shift_painel_gestao           a,
                                                       shift_painel_gestao_operacoes e,
                                                       shift_painel_gestao_exame     se
                                                 where e.cod_exame =
                                                       se.exame_codigo
                                                   and a.id_remessa =
                                                       e.id_remessa
                                                   and se.id_remessa =
                                                       a.id_remessa
                                                   and se.id_remessa =
                                                       e.id_remessa
                                                   and se.exame_tipoatendimento is not null
                                                   and se.exame_datacoletaprogramada is not null
                                                      
                                                   and e.operacoes_codigooperacao =
                                                       '060'
                                                   and to_date(to_char(to_date(e.dataoperacao,
                                                                               'DD/MM/RRRR HH24:MI:SS'),
                                                                       'DD/MM/RRRR') || ' ' ||
                                                               e.horaoperacao,
                                                               'DD/MM/RRRR HH24:MI:SS') =
                                                       (select max(to_date(to_char(to_date(f.dataoperacao,
                                                                                           'DD/MM/RRRR HH24:MI:SS'),
                                                                                   'DD/MM/RRRR') || ' ' ||
                                                                           f.horaoperacao,
                                                                           'DD/MM/RRRR HH24:MI:SS'))
                                                          from shift_painel_gestao_operacoes f
                                                         where f.id_remessa =
                                                               a.id_remessa
                                                           and f.id_remessa =
                                                               e.id_remessa
                                                           and f.cod_exame =
                                                               se.exame_codigo)
                                                
                                                ) x) y,
                                       shift_painel_parametriza_exame spp
                                 where 1 = 1
                                   and y.exame = spp.cod_exame
                                   and spp.area =
                                       (select ar.cod_area
                                          from areas ar
                                         where ar.descricao_area =
                                               y.unidadecoleta)
                                   and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h

 		WHERE h.ordemservico not in
 		      (select ab.ordemservico
 		         from shift_painel_gestao_os ab
 		        where ab.ordemservico = h.ordemservico)
			
 		  --and trunc(h.data_coleta) = trunc(sysdate)
 		  and h.ordemservico = :codigo
 		  and h.setor = :setor
 		  and h.exame_tipoatendimento = :tipo
			
 		order by decode(tipo,
                 'Protocolo',
                 1,
                 'Urgente',
                 2,
                 'Rotina',
                 3,
                 'Não Parametrizado',
                 4),
          data_coleta";

		$bind = array(
			':codigo' => $codigo,
			':tipo'	=> $tipo,
			':setor'	=> $setor
		);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}

	// ""
	public function buscaTodosExamesAssinaturas($codigo, $tipo, $setor)
	{
		//var_dump($tipo);
		$sql = "SELECT distinct case
		when h.exame in (select pe.cod_exame
						   from shift_painel_parametriza_exame pe
						  where pe.tipo = 1) then
		 'Protocolo'
		when h.exame_tipoatendimento = 'R' then
		 'Rotina'
		when h.exame_tipoatendimento = 'U' then
		 'Urgente'
	  end exame_tipoatendimento,
	  h.exame_tipoatendimento tipo_codigo,
	  h.ordemservico,
	  h.paciente_nome,
	  h.exame_descricao exame_descricaoexame,
	  h.exame exame_codigo,
	  h.exame_tipo_codigo,
	  h.data_coleta,
	  h.unidadecoleta,
	  case
		when h.meta is not null then
		 h.meta
		else
		 'NÃO PARAMETRIZADO'
	  end meta,
	  case
		when h.setor is not null then
		 h.setor
		else
		 'NÃO PARAMETRIZADO'
	  end setor
		FROM (SELECT b.ordemservico,
			 b.paciente_nome,
			 b.paciente_datanascimento,
			 b.unidadecoleta,
			 b.tipo,
			 b.tipo_codigo,
			 b.setor,
			 b.exame,
			 b.exame_descricao,
			 b.exame_tipo_codigo,
			 b.exame_tipoatendimento,
			 b.meta,
			 b.data_coleta,
			 b.data_meta,
			 (((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta
		FROM (SELECT a.ordemservico,
			 a.paciente_nome,
			 a.paciente_datanascimento,
			 a.unidadecoleta,
			 a.tipo,
			 a.tipo_codigo,
			 a.setor,
			 a.exame,
			 a.exame_descricao,
			 a.exame_tipoatendimento,
			 a.exame_tipo_codigo,
			 a.meta,
			 a.data_coleta,
			 a.data_meta,
			 (sysdate - a.data_coleta) * 24 * 60 tempo_atual,
			 a.tempo_meta
		FROM (SELECT z.ordemservico,
					 z.paciente_nome,
					 z.paciente_datanascimento,
					 z.unidadecoleta,
					 z.tipo,
					 z.tipo_codigo,
					 z.setor,
					 z.exame,
					 z.exame_descricao,
					 z.exame_tipoatendimento,
					 z.meta,
					 z.data_coleta,
					 z.exame_tipo_codigo,
					 z.data_coleta +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'HH24') * 60) / (24 * 60) +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'MI')) / (24 * 60) DATA_META,
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'HH24') * 60) +
					 TO_NUMBER(TO_CHAR(TO_DATE(z.meta, 'HH24:MI'),
									   'MI')) tempo_meta
				FROM (SELECT y.ordemservico,
							 y.paciente_nome,
							 y.paciente_datanascimento,
							 y.unidadecoleta,
							 y.exame,
							 y.exame_descricao,
							 y.exame_tipoatendimento,
							 case
							   when y.exame in
									(select pe.cod_exame
									   from shift_painel_parametriza_exame pe
									  where pe.tipo = 1) then
								'Protocolo'
							   when y.exame_tipoatendimento = 'R' then
								'Rotina'
							   when y.exame_tipoatendimento = 'U' then
								'Urgente'
							 end tipo,
							 spp.setor_lab setor,
							 spp.tipo tipo_codigo,
							 (select max(ae.meta_tempo_coleta)
								from shift_painel_parametriza_exame ae
							   where ae.cod_exame = y.exame
								 and ae.tipo = y.exame_tipo_codigo
								 and ae.area =
									 (select ar.cod_area
										from areas ar
									   where ar.descricao_area =
											 y.unidadecoleta)
								 and ae.tipo = y.exame_tipo_codigo) meta,
							 y.data_coleta,
							 y.exame_tipo_codigo
					  
						from (select x.ordemservico,
									 x.paciente_nome,
									 x.paciente_datanascimento,
									 x.unidadecoleta,
									 x.exame_codigo exame,
									 x.exame_descricaoexame exame_descricao,
									 x.exame_tipoatendimento,
									 case
									   when x.exame_codigo in
											(select pe.cod_exame
											   from shift_painel_parametriza_exame pe
											  where pe.tipo = 1) then
										1
									   when x.exame_tipoatendimento = 'R' then
										2
									   when x.exame_tipoatendimento = 'U' then
										3
									 end exame_tipo_codigo,
									 to_date(x.data_coleta,
											 'DD/MM/RRRR HH24:MI:SS') data_coleta,
									 x.data_operacao
								from (select distinct a.ordemservico,
													  a.paciente_nome,
													  a.paciente_datanascimento,
													  REPLACE(CONVERT(upper(a.unidadecoleta),
																	  'US7ASCII'),
															  '- ') unidadecoleta,
													  to_char(to_date(se.exame_datacoletaprogramada,
																	  'DD/MM/RRRR HH24:MI:SS'),
															  'DD/MM/RRRR') || ' ' ||
													  se.exame_horacoletaprogramada data_coleta,
													  to_char(to_date(e.dataoperacao,
																	  'DD/MM/RRRR HH24:MI:SS'),
															  'DD/MM/RRRR') || ' ' ||
													  e.horaoperacao data_operacao,
													  se.exame_codigo,
													  se.exame_descricaoexame,
													  case
														when se.exame_codigo in
															 (select pe.cod_exame
																from shift_painel_parametriza_exame pe
															   where pe.tipo = 1) then
														 'P'
														when se.exame_tipoatendimento = 'R' then
														 se.exame_tipoatendimento
														when se.exame_tipoatendimento = 'U' then
														 se.exame_tipoatendimento
													  end exame_tipoatendimento
										FROM shift_painel_gestao           a,
											 shift_painel_gestao_operacoes e,
											 shift_painel_gestao_exame     se
									   where e.cod_exame =
											 se.exame_codigo
										 and a.id_remessa =
											 e.id_remessa
										 and se.id_remessa =
											 a.id_remessa
										 and se.id_remessa =
											 e.id_remessa
										 and se.exame_tipoatendimento is not null
										 and se.exame_datacoletaprogramada is not null
											
										 and e.operacoes_codigooperacao =
											 '055'
										 and to_date(to_char(to_date(e.dataoperacao,
																	 'DD/MM/RRRR HH24:MI:SS'),
															 'DD/MM/RRRR') || ' ' ||
													 e.horaoperacao,
													 'DD/MM/RRRR HH24:MI:SS') =
											 (select max(to_date(to_char(to_date(f.dataoperacao,
																				 'DD/MM/RRRR HH24:MI:SS'),
																		 'DD/MM/RRRR') || ' ' ||
																 f.horaoperacao,
																 'DD/MM/RRRR HH24:MI:SS'))
												from shift_painel_gestao_operacoes f
											   where f.id_remessa =
													 a.id_remessa
												 and f.id_remessa =
													 e.id_remessa
												 and f.cod_exame =
													 se.exame_codigo)
									  
									  ) x) y,
							 shift_painel_parametriza_exame spp
					   where 1 = 1
						 and y.exame = spp.cod_exame
						 and spp.area =
							 (select ar.cod_area
								from areas ar
							   where ar.descricao_area =
									 y.unidadecoleta)
						 and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h

					WHERE h.ordemservico not in
					(select ab.ordemservico
					from shift_painel_gestao_os ab
					where ab.ordemservico = h.ordemservico)

					--and trunc(h.data_coleta) = trunc(sysdate)
					and h.ordemservico = :codigo
					and h.setor = :setor
					and h.exame_tipoatendimento = :tipo

					order by decode(tipo,
						   'Protocolo',
						   1,
						   'Urgente',
						   2,
						   'Rotina',
						   3,
						   'Não Parametrizado',
						   4),
					data_coleta";

		$bind = array(
			':codigo' => $codigo,
			':tipo'	=> $tipo,
			':setor'	=> $setor
		);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}
}
