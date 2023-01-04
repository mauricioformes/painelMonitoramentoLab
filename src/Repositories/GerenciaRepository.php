<?php

namespace Api\Repositories;

class GerenciaRepository extends ConexaoShift
{
	public function geraNovoID()
	{
		$sql = "SELECT  shift_painel_gestao_os_seq.NEXTVAL codigo
  					 from dual";

		$rows = $this->executeQuery($sql);

		return $rows[0]['CODIGO'];
	}

	public function listaOSCanceladas()
	{
		$sql = "SELECT  *
  					 from shift_painel_gestao_os";

		$rows = $this->executeQuery($sql);

		return $rows;
	}


	public function salvarParametro($dados)
	{

		$dados['fid'] = $this->geraNovoID();

		$sql = "INSERT into shift_painel_gestao_os(id,
			ordemservico,
			usuario,
			data)
	  	values(:id,
			 :ordemservico,
			 :usuario,
			 sysdate)";

		$bind = array(
			':id' 				=> $dados['fid'],
			':ordemservico' 				=> $dados['fcodigoos'],
			':usuario' 				=> $dados['fusuario']
		);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}

	public function buscaCodOS()
	{
		$sql = "SELECT distinct h.ordemservico,
		h.paciente_nome
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
				   and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h

		 WHERE h.ordemservico not in
			 (select ab.ordemservico
			  from shift_painel_gestao_os ab
			 where ab.ordemservico = h.ordemservico)
			 and h.data_coleta <= (sysdate) + 4 / 1400
		union all
		SELECT distinct h.ordemservico,
		h.paciente_nome
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
		   and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h
		WHERE h.ordemservico not in
		(select ab.ordemservico from shift_painel_gestao_os ab)
		--and trunc(h.data_liberou_triagem) = trunc(sysdate)
					--and h.ordemservico = '013-66298-403'

					UNION ALL

					SELECT distinct h.ordemservico,
					h.paciente_nome
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
							   and spp.setor_lab in ('U', 'B', 'H')) z) a) b) h
 				WHERE h.ordemservico not in
				 (select ab.ordemservico from shift_painel_gestao_os ab)";

		$rows = $this->executeQuery($sql);

		return $rows;
	}

	public function verificaOS($codigoOS)
	{
		$sql = "SELECT count(*) qtd from shift_painel_gestao_os where ordemservico = :codigo";

		
		$bind = array(
			':codigo' 				=> $codigoOS
		);

		$rows = $this->executeQuery($sql, $bind);

		return $rows;
	}
}
