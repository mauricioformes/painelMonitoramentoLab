<?php

namespace Api\Repositories;

class RelatorioRepository extends ConexaoShift
{
	public function listaColetas($dataInicial, $dataFinal)
	{
		$sql = "SELECT fa.ordemservico,
		fa.paciente_nome,
		fa.paciente_datanascimento,
		fa.exame_descricao,
		fa.data_coleta_programada,
		fa.data_colheu,
		fa.usuariooperacao,
		fa.status
   		from (SELECT distinct h.ordemservico,
						 h.paciente_nome,
						 h.paciente_datanascimento,
						 --h.unidadecoleta,
						 --h.tipo,
						 --h.setor,
						 h.exame,
						 h.exame_descricao,
						 h.exame_tipoatendimento,
						 --h.meta,
						 h.data_coleta_programada,
						 h.data_colheu,
						 --h.data_meta,
						 case
                          when h.tempo_atual <= h.half then
                           'VERDE'
                          when h.tempo_atual <= (h.half * 2) then
                           'AMARELO'
                          when h.tempo_atual <= (h.half * 3) then
                           'VERMELHO'
                          when h.tempo_atual > (h.half * 3) then
                           'PRETO'
                        end status,
						 h.usuariooperacao
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
						b.data_coleta_programada,
						b.data_meta,
						b.data_colheu,
						(((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta,
						b.usuariooperacao,
						b.tempo_atual,
                       b.half
				   FROM (SELECT distinct a.ordemservico,
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
										 a.data_coleta_programada,
										 a.data_colheu,
										 a.data_meta,
										 (a.data_colheu -
										 a.data_coleta_programada) * 24 * 60 tempo_atual,
										 a.tempo_meta,
										 (a.tempo_meta / 3) half,
										 a.usuariooperacao
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
										z.data_coleta_programada,
										z.data_colheu,
										z.data_coleta_programada + TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
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
														  'MI')) tempo_meta,
														  z.usuariooperacao
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
												y.data_coleta_programada,
												y.data_colheu,
												y.usuariooperacao
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
														to_date(x.data_coleta_programada,
																'DD/MM/RRRR HH24:MI:SS') data_coleta_programada,
														to_date(x.data_colheu,
																'DD/MM/RRRR HH24:MI:SS') data_colheu,
																x.usuariooperacao
												 
												   from (select a.ordemservico,
																a.paciente_nome,
																a.paciente_datanascimento,
																REPLACE(CONVERT(upper(a.unidadecoleta),
																				'US7ASCII'),
																		'- ') unidadecoleta,
																to_char(to_date(se.exame_datacoletaprogramada,
																				'DD/MM/RRRR HH24:MI:SS'),
																		'DD/MM/RRRR') || ' ' ||
																se.exame_horacoletaprogramada data_coleta_programada,
																to_char(to_date(e.dataoperacao,
																				'DD/MM/RRRR HH24:MI:SS'),
																		'DD/MM/RRRR') || ' ' ||
																e.horaoperacao data_colheu,
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
																end exame_tipoatendimento,
																e.usuariooperacao
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
											and spp.setor_lab in ('U', 'B', 'H')) z) a
									where trunc(a.data_coleta_programada) >=
								to_char(to_date('".$dataInicial."', 'yyyy-mm-dd'), 'DD/MM/RRRR')
								and trunc(a.data_coleta_programada) <
								 to_char(to_date('".$dataFinal."', 'yyyy-mm-dd')+1, 'DD/MM/RRRR')
								 ) b) h
		 
		  WHERE h.ordemservico not in
				(select ab.ordemservico
				   from shift_painel_gestao_os ab
				  where ab.ordemservico = h.ordemservico)
		  order by decode(tipo,
						  'Protocolo',
						  1,
						  'Urgente',
						  2,
						  'Rotina',
						  3,
						  'Não Parametrizado',
						  4),
				   data_coleta_programada) fa
		";

		  

		$rows = $this->executeQuery($sql);

		

		return $rows;
	}

	public function listaTriagens($dataInicial, $dataFinal)
	{

		$sql = "SELECT fa.ordemservico,
		fa.paciente_nome,
		fa.paciente_datanascimento,
		fa.exame_descricao,
		fa.data_liberou_triagem,
		fa.data_liberou_assinatura data_triou,
		fa.usuariooperacao,
		fa.status
   		FROM (SELECT distinct h.ordemservico,
						 h.paciente_nome,
						 h.paciente_datanascimento,
						 h.unidadecoleta,
						 h.tipo,
						 case
						   when h.setor = 'B' then
							'Bioquímica'
						   when h.setor = 'U' then
							'Urinálise'
						   when h.setor = 'H' then
							'Hematologia'
						 end setor,
						 h.exame,
						 h.exame_descricao,
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
						 
						 /*case
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
						 end status,*/
						 case
						   when h.tempo_atual <= h.half then
							'VERDE'
						   when h.tempo_atual <= (h.half * 2) then
							'AMARELO'
						   when h.tempo_atual <= (h.half * 3) then
							'VERMELHO'
						   when h.tempo_atual > (h.half * 3) then
							'PRETO'
						 end status,
						 h.porcentagem_tempo_meta,
						 h.tempo_atual,
						 h.tempo_meta,
						 h.half,
						 h.usuariooperacao
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
						(((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta,
						b.tempo_atual,
						b.tempo_meta,
						b.half,
						b.usuariooperacao
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
								(a.data_liberou_assinatura -
								a.data_liberou_triagem) * 24 * 60 tempo_atual,
								a.tempo_meta,
								(a.tempo_meta / 3) half,
								a.usuariooperacao
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
										z.data_liberou_coleta + TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																						  'HH24:MI'),
																				  'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_COLETA,
										z.data_liberou_assinatura + TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																							  'HH24:MI'),
																					  'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_ASSINATURA,
										
										z.data_liberou_triagem + TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																						   'HH24:MI'),
																				   'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_TRIAGEM,
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																  'HH24:MI'),
														  'HH24') * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																  'HH24:MI'),
														  'MI')) tempo_meta,
														  z.usuariooperacao
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
													and ae.tipo =
														y.exame_tipo_codigo
													and ae.area =
														(select ar.cod_area
														   from areas ar
														  where ar.descricao_area =
																y.unidadecoleta)
													and ae.tipo =
														y.exame_tipo_codigo) meta_COLETA,
												(select max(ae.meta_tempo_assinatura)
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
												(select max(ae.meta_tempo_triagem)
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
														y.exame_tipo_codigo) meta_triagem,
												(select max(ae.tat)
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
														y.exame_tipo_codigo) tat,
												y.data_liberou_assinatura,
												y.data_liberou_coleta,
												y.data_liberou_triagem,
												y.usuariooperacao
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
																'DD/MM/RRRR HH24:MI:SS') data_liberou_triagem,
																x.usuariooperacao
												   from (select distinct a.ordemservico,
																		 a.paciente_nome,
																		 a.paciente_datanascimento,
																		 REPLACE(CONVERT(upper(a.unidadecoleta),
																						 'US7ASCII'),
																				 '- ') unidadecoleta,
																		 to_char(to_date(e.dataoperacao,
																						 'DD/MM/RRRR HH24:MI:SS'),
																				 'DD/MM/RRRR') || ' ' ||
																		 e.horaoperacao data_liberou_triagem,
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
																				 '055') data_liberou_assinatura,
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
																		 end exame_tipoatendimento,
																		 (select max(ef.usuariooperacao)
																			from shift_painel_gestao_operacoes ef
																		   where ef.id_remessa =
																				 a.id_remessa
																			 and se.exame_codigo =
																				 ef.cod_exame
																			 and ef.operacoes_codigooperacao =
																				 '055') usuariooperacao
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
														 ) x
												  where x.data_liberou_assinatura <> ' ') y,
												shift_painel_parametriza_exame spp
										  where 1 = 1
											and y.exame = spp.cod_exame
											and spp.area =
												(select ar.cod_area
												   from areas ar
												  where ar.descricao_area =
														y.unidadecoleta)
											and spp.setor_lab in ('U', 'B', 'H')) z) a
											where trunc(a.data_liberou_triagem) >=
								to_char(to_date('".$dataInicial."', 'yyyy-mm-dd'), 'DD/MM/RRRR')
								and trunc(a.data_liberou_triagem) <
								 to_char(to_date('".$dataFinal."', 'yyyy-mm-dd')+1, 'DD/MM/RRRR')
								 ) b) h
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
				   data_liberou_assinatura) fa";

		//exit;

		$rows = $this->executeQuery($sql);


		return $rows;
	}

	public function listaAssinaturas($dataInicial, $dataFinal)
	{
		
		$sql = "SELECT fa.ordemservico,
		fa.paciente_nome,
		fa.paciente_datanascimento,
		fa.exame,
		fa.exame_descricao,
		fa.data_liberou_assinatura,
		fa.data_operacao data_assinou,
		fa.usuariooperacao,
		fa.status
   		FROM (SELECT distinct h.ordemservico,
						 h.paciente_nome,
						 h.paciente_datanascimento,
						 h.unidadecoleta,
						 h.tipo,
						 case
						   when h.setor = 'B' then
							'Bioquímica'
						   when h.setor = 'U' then
							'Urinálise'
						   when h.setor = 'H' then
							'Hematologia'
						 end setor,
						 h.setor setor_parametro,
						 h.exame_tipoatendimento,
						 h.exame,
						 h.exame_descricao,
						 h.meta_COLETA,
						 h.meta_triagem,
						 h.meta,
						 h.tat,
						 --(h.data_liberou_triagem - h.data_liberou_assinatura) * 24 * 60 deflator,
						 --(h.data_liberou_triagem - h.data_meta_assinatura) * 24 * 60 deflator_meta_assinatura,    
						 
						 (((h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60) -
						 ((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60)) +
						 (((h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60) -
						 ((h.data_liberou_assinatura -
						 h.data_liberou_triagem) * 24 * 60)) deflator,
						 h.data_liberou_assinatura data_coleta,
						 h.data_liberou_coleta,
						 h.data_liberou_triagem,
						 h.data_liberou_assinatura,
						 h.data_operacao,
						 h.DATA_META_COLETA,
						 h.DATA_META_TRIAGEM,
						 h.DATA_META_ASSINATURA,
						 /*((h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60) - 
						 ((h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60) deflator,*/
						 (h.data_liberou_triagem - h.data_liberou_coleta) * 24 * 60 deflator_coleta,
						 (h.data_liberou_assinatura - h.data_liberou_triagem) * 24 * 60 deflator_triagem,
						 (h.DATA_META_COLETA - h.data_liberou_coleta) * 24 * 60 deflator_meta_coleta,
						 (h.DATA_META_TRIAGEM - h.data_liberou_triagem) * 24 * 60 deflator_meta_triagem,
						 
						 /*case
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
						 end status,*/
						 case
						   when h.tempo_atual <= h.half then
							'VERDE'
						   when h.tempo_atual <= (h.half * 2) then
							'AMARELO'
						   when h.tempo_atual <= (h.half * 3) then
							'VERMELHO'
						   when h.tempo_atual > (h.half * 3) then
							'PRETO'
						 end status,
						 h.porcentagem_tempo_meta,
						 h.usuariooperacao
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
						b.data_operacao,
						b.data_liberou_coleta,
						b.data_liberou_triagem,
						(b.data_liberou_assinatura - b.data_liberou_coleta) * 24 * 60 deflator,
						b.DATA_META_COLETA,
						b.DATA_META_ASSINATURA,
						b.DATA_META_TRIAGEM,
						(((b.tempo_atual / b.tempo_meta) - 1) * 100) porcentagem_tempo_meta,
						b.tempo_atual,
						b.tempo_meta,
						b.half,
						b.usuariooperacao
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
								a.data_operacao,
								a.DATA_META_COLETA,
								a.DATA_META_ASSINATURA,
								a.DATA_META_TRIAGEM,
								a.data_liberou_coleta,
								a.data_liberou_triagem,
								(a.data_operacao - a.data_liberou_assinatura) * 24 * 60 tempo_atual,
								a.tempo_meta,
								(a.tempo_meta / 3) half,
								a.usuariooperacao
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
										z.data_operacao,
										z.data_liberou_coleta + TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																						  'HH24:MI'),
																				  'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_coleta,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_COLETA,
										z.data_liberou_assinatura + TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																							  'HH24:MI'),
																					  'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_ASSINATURA,
										
										z.data_liberou_triagem + TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																						   'HH24:MI'),
																				   'HH24') * 60) /
										(24 * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta_triagem,
																  'HH24:MI'),
														  'MI')) / (24 * 60) DATA_META_TRIAGEM,
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																  'HH24:MI'),
														  'HH24') * 60) +
										TO_NUMBER(TO_CHAR(TO_DATE(z.meta,
																  'HH24:MI'),
														  'MI')) tempo_meta,
														  z.usuariooperacao
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
													and ae.tipo =
														y.exame_tipo_codigo
													and ae.area =
														(select ar.cod_area
														   from areas ar
														  where ar.descricao_area =
																y.unidadecoleta)
													and ae.tipo =
														y.exame_tipo_codigo) meta_COLETA,
												(select max(ae.meta_tempo_assinatura)
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
												(select max(ae.meta_tempo_triagem)
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
														y.exame_tipo_codigo) meta_triagem,
												(select max(ae.tat)
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
														y.exame_tipo_codigo) tat,
												y.data_liberou_assinatura,
												y.data_liberou_coleta,
												y.data_liberou_triagem,
												y.data_operacao,
												y.usuariooperacao
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
																'DD/MM/RRRR HH24:MI:SS') data_liberou_triagem,
																to_date(x.data_operacao,
																'DD/MM/RRRR HH24:MI:SS') data_operacao,
																x.usuariooperacao
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
																				 (select max(to_char(to_date(ef.dataoperacao,
																								 'DD/MM/RRRR HH24:MI:SS'),
																						 'DD/MM/RRRR') || ' ' ||
																				 ef.horaoperacao)
																			from shift_painel_gestao_operacoes ef
																		   where ef.id_remessa =
																				 a.id_remessa
																			 and se.exame_codigo =
																				 ef.cod_exame
																			 and ef.operacoes_codigooperacao in
																				 ('013', '051', '011')) data_operacao,
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
																		 end exame_tipoatendimento,
																		 (select max(ef.usuariooperacao)
																			from shift_painel_gestao_operacoes ef
																		   where ef.id_remessa =
																				 a.id_remessa
																			 and se.exame_codigo =
																				 ef.cod_exame
																			 and ef.operacoes_codigooperacao in
																				 ('013', '051')) usuariooperacao
																		
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
																		se.exame_codigo)*/) x
												  where x.data_liberou_triagem <> ' ') y,
												shift_painel_parametriza_exame spp
										  where 1 = 1
											and y.exame = spp.cod_exame
											and spp.area =
												(select ar.cod_area
												   from areas ar
												  where ar.descricao_area =
														y.unidadecoleta)
											and spp.setor_lab in ('B', 'H', 'U')) z) a
											where trunc(a.data_liberou_assinatura) >=
								to_char(to_date('".$dataInicial."', 'yyyy-mm-dd'), 'DD/MM/RRRR')
								and trunc(a.data_liberou_assinatura) <
								 to_char(to_date('".$dataFinal."', 'yyyy-mm-dd')+1, 'DD/MM/RRRR')
								 ) b) h
		  WHERE h.ordemservico not in
				(select ab.ordemservico from shift_painel_gestao_os ab)
		 --and trunc(h.data_liberou_assinatura) = trunc(sysdate)
		 --and h.ordemservico = '013-66325-154'
		  order by decode(tipo,
						  'Protocolo',
						  1,
						  'Urgente',
						  2,
						  'Rotina',
						  3,
						  'Não Parametrizado',
						  4),
				   data_liberou_assinatura) fa";



		$rows = $this->executeQuery($sql);

		// echo "<pre>";
		// print_r($sql);
		// echo "</pre>";
		// exit;
		return $rows;
	}


}
