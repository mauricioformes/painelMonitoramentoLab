<?php
session_start();
$title = "Relatórios";

//var_dump($data);

?>
<h3 class="page-title">
    Relatórios <small>/ Coletas</small>
</h3>

<div id="resultado-teste" name="resultado-teste">

    <div class="contentpanel">
        <div class="panel panel-default">
            <br>
            <form name='form_relatorio_coletas' id="form_relatorio_coletas" action='coletas' class="form-horizontal" method='GET'>
                <div class=" form-group" id="linha_processo">
                    <input type="hidden" name="dataIni" id="dataIni" value="<?php echo $_GET['dataInicial']; ?>">
                    <input type="hidden" name="dataFim" id="dataFim" value="<?php echo $_GET['dataFinal']; ?>">

                    <label class="col-md-1 col-sm-1 col-md-offset-1 control-label">Data Inicial:</label>
                    <div class="col-md-1 col-sm-1">
                        <input type="date" id="dataInicial" name="dataInicial" class="form-control" style="width:150px;" value="<?php echo date("Y-m-d"); ?>">
                    </div>

                    <label class="col-md-1 col-sm-1 col-md-offset-1 control-label">Data Final:</label>
                    <div class="col-md-1 col-sm-1">
                        <input type="date" id="dataFinal" name="dataFinal" class="form-control" style="width:150px;" value="<?php echo date("Y-m-d"); ?>">
                    </div>

                    <div class="col-md-2 col-sm-2 text-center ">
                        <button type='submit' name='pesquisarRelatorioColetas' id="pesquisarRelatorioColetas" class='btn btn-primary' value='Comunicar'><i class="glyphicon glyphicon-search"></i>Pesquisar</button>
                        <!-- <button name='geraExcelColeta' id="geraExcelColeta" onclick="f_Excel();" class='btn btn-primary' value='Comunicar'><i class="glyphicon glyphicon-plus"></i>Excel</button> -->
                        <button type="button" class="btn btn-primary" id="btnGerarExcelColetas"><i class="glyphicon glyphicon-plus"></i>
                            Excel
                        </button>
                    </div>

                </div>
            </form>
            <br>
        </div>
    </div>


    <div class="contentpanel" id="exibeTabelaRelatorioColeta">

        <div class="panel panel-default">

            <div class="panel-body">

                <div class=" row mb30"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table class="table parametrizacao table-bordered table-striped table-dark">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">OS</th>
                                        <th style="text-align: center">Nome</th>
                                        <th style="text-align: center">Nascimento</th>
                                        <th style="text-align: center">Exame</th>
                                        <th style="text-align: center">Coleta Programada</th>
                                        <th style="text-align: center">Data Colheu</th>
                                        <th style="text-align: center">Usuário da Operação</th>
                                        <th style="text-align: center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    if ($data != null) {
                                        //var_dump($data["coletas"]);
                                        foreach ($data["coletas"] as $exames) :
                                    ?>
                                            <tr>

                                                <td style="text-align:center"><?php echo $exames["ORDEMSERVICO"]; ?></td>
                                                <td style="text-align:center"><?php echo $exames["PACIENTE_NOME"]; ?></td>
                                                <td style="text-align:center"><b><?php echo $exames["PACIENTE_DATANASCIMENTO"]; ?></b></td>
                                                <td style="text-align:center"><?php echo $exames["EXAME_DESCRICAO"]; ?></td>
                                                <td style="text-align:center"><?php echo $exames["DATA_COLETA_PROGRAMADA"]; ?></td>
                                                <td style="text-align:center"><?php echo $exames["DATA_COLHEU"]; ?></td>
                                                <td style="text-align:center"><?php echo $exames["USUARIOOPERACAO"]; ?></td>
                                                <td style="text-align:center"><?php echo $exames["STATUS"]; ?></td>
                                            </tr>
                                    <?php
                                        endforeach;
                                    }  ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
    <div id="tableColetas" style="display:none;">

    </div>

</div>

<div class="modal fade" id="modal_detalhe" tabindex="-1" aria-labelledby="modal_detalhe_procedLabel" data-backdrop="static" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal_detalhe_procedLabel"><span class="glyphicon glyphicon-pencil  text-info"></span> <span id="modal-titulo" class=" text-info">Detalhes</span></h4>
            </div>
            <div class="modal-body">
                <div id="mensagem_detalhe" style="overflow-y:none"> </div>
            </div>

        </div>
    </div>
</div>
<div id="loading" class="selector" style="height: 60px !important; min-height: 60px !important;">
    <div style="background-image: url(<?= $GLOBALS['base_dir']; ?>/Assets/img/loading.gif); width: 60px; height: 60px; margin-left: 30px;"></div>
</div>
<iframe name='iframe' style='display:none;'></iframe>