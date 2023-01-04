<?php
$title = "Painel";
$nCount = 0;
$nCount1 = 0;
// var_dump($data);

if ($_GET['filtro_setor']) {
    foreach ($_GET['filtro_setor'] as $key => $value) {
        //var_dump($key);
        if ($value == "B") {
            $filtro[$key] = "Bioquímica";
        } else if ($value == "H") {
            $filtro[$key] = "Hematologia";
        } else {
            $filtro[$key] = "Urinalise";
        }
        //$array[$key] = $value;
    }
    $filtro = join(', ', $filtro);
}

function formatarTempo($tempo)
{
    $aux = explode(':', $tempo);

    $horas = $aux[0];
    $minutos = $aux[1];

    $horasParaMinuto = 0;

    if ($horas > 0) {
        $horasParaMinuto = $horas * 60;
    }
    return $minutos + $horasParaMinuto;
}

function formatarTempoCompleto($minutos)
{


    $horas = floor($minutos / 60);
    $min = $minutos - (60 * $horas);
    $aux = explode('.', $min);

    if (is_array($aux)) {
        $seg = round((60 * (substr($aux[1], 0, 2) / 100)));
        $min = $aux[0];
    } else {
        $seg = 0;
    }

    if ($horas < 10) {
        $horas = '0' . $horas;
    }
    if ($min < 10) {
        $min = '0' . $min;
    }
    if ($seg < 10) {
        $seg = '0' . $seg;
    }

    return $horas . ":" . $min . ":" . $seg;
}

?>
<h3 class="page-title">
    Painel <small>/ Triagens</small>
</h3>

<!-- <div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
    </ul>
</div> -->

<style>
    .table th {
        background: #2D4B7D;
        color: #F3F3F3;
    }

    .alerts-border {
        background-color: #f8d7da;
        animation: blink 1s;
        animation-iteration-count: infinite;
    }

    @keyframes blink {
        50% {
            background-color: #fff;
        }
    }

    .protocolo {
        padding: 2%;
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        border-radius: 5%;
        width: 100%;
    }

    .urgencia {
        padding: 2%;
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
        border-radius: 5%;
    }

    .circle {
        border-radius: 50%;
        width: 20px;
        height: 20px;
    }

    .green {
        background: green;
    }

    .red {
        background: red;
    }

    .black {
        background: black;
    }

    .yellow {
        background: yellow;
    }
</style>
<div>

    <div class="contentpanel">
        <div class="panel panel-default">
            <br>
            <form name='form1' id="form_triagem" action='#' class="form-horizontal" method='POST'>
                <div class=" form-group" id="linha_processo">
                    <label class="col-md-1 col-sm-1 col-md-offset-1 control-label">Setor Lab.:</label>
                    <div class="col-md-3 col-sm-3">
                        <select name='filtro_setor[]' id="filtro_setor" class="form-control select2me select2-offscreen" required="true" multiple data-placeholder="Selecione...">
                            <option value='B'>Bioquímica</option>
                            <option value='H'>Hematologia</option>
                            <option value='U'>Urinalise</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-sm-2 text-center ">
                        <button type='button' name='pesquisarTriagens' id="pesquisarTriagens" class='btn btn-primary' value='Comunicar'><i class="glyphicon glyphicon-search"></i>Pesquisar</button>
                    </div>
                    <div class="col-md-2 col-sm-2 text-center ">
                        <a class='btn btn-primary' id="dashboardTriagem" target="_blank"><i class="glyphicon glyphicon-plus"></i>Dashboard TV</a>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>

    <div class="portlet" id="exibeTabelaTriagem" hidden>
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-comments"></i><b>Setor(es): </b><?= $filtro; ?>
            </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title="">
                </a>
                <a href="javascript:;" class="fullscreen" data-original-title="" title="">
                </a>

            </div>
        </div>
        <div class="portlet-body" style="display: block;">
            <div class="contentpanel">
                <div class="panel panel-default">


                    <div class="row">
                        <div class="col-md-12">

                            <table class="table" style="margin-top:1%; width: 100%; height: 100%; border: 1px solid !important;">
                                <thead>
                                    <tr>
                                        <th style="text-align:center">Tipo</th>
                                        <th style="text-align:center">OS</th>
                                        <th style="text-align:center">Nome Completo</th>
                                        <th style="text-align:center">Data Nascimento</th>
                                        <th style="text-align:center">Data Triagem</th>
                                        <th style="text-align:center">Unidade Coleta</th>
                                        <th style="text-align:center">Setor</th>
                                        <th style="text-align:center">Deflator</th>
                                        <th style="text-align:center">Meta</th>
                                        <th style="text-align:center">Tempo</th>
                                        <th style="text-align:center">Status</th>
                                        <th style="text-align:center"></th>
                                    </tr>
                                </thead>
                                <tbody id="resultado">
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Modal -->
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

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div id="loading" class="selector" style="height: 60px !important; min-height: 60px !important;">
    <div style="background-image: url(../../lib/img/loading.gif); width: 60px; height: 60px; margin-left: 30px;"></div>
</div>

<script>
    const options = {
        timeZone: 'America/Sao_Paulo',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
    };
    const date = new Intl.DateTimeFormat([], options);
</script>