-- Create table
create table SHIFT_PAINEL_GESTAO (
    ordemservico VARCHAR(255) not null,
    paciente_codigo VARCHAR(255) not null,
    paciente_nome VARCHAR(255),
    paciente_nomesocial VARCHAR(255),
    paciente_datanascimento VARCHAR(255) not null,
    paciente_sexo VARCHAR(255),
    unidadecoleta VARCHAR(255) not null,
    dataos VARCHAR(255),
    id_remessa VARCHAR(255),
    id INT not null,
    data_envio DATE
);
-- Create/Recreate indexes 
create index IDX_ID_REMESSA_01 on SHIFT_PAINEL_GESTAO (ID_REMESSA);
create index IDX_ORDEM_SERVICO on SHIFT_PAINEL_GESTAO (ORDEMSERVICO);
-- Create/Recreate primary, unique and foreign key constraints 
alter table SHIFT_PAINEL_GESTAO
add constraint CODIGO primary key (ID);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table SHIFT_PAINEL_GESTAO_AMOSTRAS (
    amostra_codigoamostra VARCHAR(255),
    amostra_usuariocoletador VARCHAR(255),
    amostra_datacoleta DATE,
    amostra_horacoleta VARCHAR(255),
    id_remessa VARCHAR(255),
    id INT,
    data_envio DATE,
    unidadecoleta VARCHAR(255)
);
-- Create/Recreate primary, unique and foreign key constraints 
alter table SHIFT_PAINEL_GESTAO_AMOSTRAS
add constraint COD_SOLIC foreign key (ID) references SHIFT_PAINEL_GESTAO (ID);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table SHIFT_PAINEL_GESTAO_EXAME (
    exame_codigo VARCHAR(255) not null,
    exame_descricaoexame VARCHAR(255) not null,
    exame_materialexame VARCHAR(255),
    exame_setorexecucaoexame VARCHAR(255) not null,
    exame_dataassinatura VARCHAR(255),
    exame_datapromessa VARCHAR(255),
    exame_horapromessa VARCHAR(255),
    exame_tipoatendimento VARCHAR(255),
    exame_datacoletaprogramada VARCHAR(255),
    exame_horacoletaprogramada VARCHAR(255),
    id_remessa VARCHAR(255),
    id INT,
    data_envio DATE,
    unidadecoleta VARCHAR(255)
);
-- Create/Recreate indexes 
create index IDX_COD_EXAME_02 on SHIFT_PAINEL_GESTAO_EXAME (EXAME_CODIGO);
create index IDX_ID_REMESSA_02 on SHIFT_PAINEL_GESTAO_EXAME (ID_REMESSA);
-- Create/Recreate primary, unique and foreign key constraints 
alter table SHIFT_PAINEL_GESTAO_EXAME
add constraint CODIGO_SOLIC foreign key (ID) references SHIFT_PAINEL_GESTAO (ID);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table SHIFT_PAINEL_GESTAO_OPERACOES (
    operacoes_codigooperacao VARCHAR(255),
    operacoes_descricaooperacao VARCHAR(255),
    dataoperacao VARCHAR(255),
    horaoperacao VARCHAR(255),
    usuariooperacao VARCHAR(255),
    id_remessa VARCHAR(255),
    id INT,
    data_envio DATE,
    cod_exame VARCHAR(255),
    unidadecoleta VARCHAR(255)
);
-- Create/Recreate indexes 
create index ID_DATAOPERACAO on SHIFT_PAINEL_GESTAO_OPERACOES (DATAOPERACAO);
create index ID_HORAOPERACAO on SHIFT_PAINEL_GESTAO_OPERACOES (HORAOPERACAO);
create index IDX_COD_EXAME on SHIFT_PAINEL_GESTAO_OPERACOES (COD_EXAME);
create index IDX_ID on SHIFT_PAINEL_GESTAO_OPERACOES (ID);
create index IDX_ID_REMESSA on SHIFT_PAINEL_GESTAO_OPERACOES (ID_REMESSA);
-- Create/Recreate primary, unique and foreign key constraints 
alter table SHIFT_PAINEL_GESTAO_OPERACOES
add constraint COD_SOLICITACAO foreign key (ID) references SHIFT_PAINEL_GESTAO (ID);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table SHIFT_PAINEL_GESTAO_OS (
    id INT(20) not null,
    ordemservico VARCHAR(2000),
    usuario VARCHAR(2000),
    data DATE not null
);
-- Create/Recreate indexes 
create index IDX_ID_REMESSA_03 on SHIFT_PAINEL_GESTAO_OS (ORDEMSERVICO);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table SHIFT_PAINEL_PARAMETRIZA_EXAME (
    id VARCHAR(255),
    area VARCHAR(255),
    cod_exame VARCHAR(255),
    meta_tempo_coleta VARCHAR(255),
    meta_tempo_triagem VARCHAR(255),
    meta_tempo_assinatura VARCHAR(255),
    usuario VARCHAR(255),
    tat VARCHAR(255),
    tipo VARCHAR(255),
    setor_lab VARCHAR(255)
);
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-- Create table
create table USUARIOS (
    id VARCHAR(255),
    USUARIO VARCHAR(255),
    SENHA VARCHAR(255),
    DATA DATE
);