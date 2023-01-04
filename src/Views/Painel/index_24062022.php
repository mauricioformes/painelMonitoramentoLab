<?php
$title = "Painel";
?>
<h3 class="page-title">
    Painel <small>detalhes</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="#">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
    </ul>
</div>
<?php if ($_SESSION['usuario']['usuario']['COD_PERFIL'] == 0) : ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i> Solicitações
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="container">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($data['qtd'] as $posicao => $ticket) {
        $dados[] = array('name' => $posicao, 'y' => count($ticket));
    } ?>
<?php endif ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i> Aplicações
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <?php foreach ($_SESSION['usuario']['aplicacoes'] as $aplicacao) : ?>
                        <?php if ($aplicacao['CODIGO_PAI'] != null) : ?>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <a class="dashboard-stat dashboard-stat-light" href="<?= $aplicacao['CAMINHO'] ?>">
                                    <div class="visual">
                                        <i class="fa <?= $aplicacao['ICONE'] ?>"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <?= $ticket['QUANTIDADE'] ?>
                                        </div>
                                        <div class="desc">
                                            <?= $aplicacao['DESCRICAO'] ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var Inside = function() {
        var handleGrafico = function() {
            var dados = $("#grafico").val();
            Highcharts.chart('container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Quantidade de Solicitações em Andamento'
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Quantidade',
                    data: [{
                            name: 'Coleta',
                            //color: '#00FF00',
                            y: 5
                        },
                        {
                            name: 'Triagem',
                            //color: '#00FF00',
                            y: 12
                        },
                        {
                            name: 'Assinatura',
                            //color: '#00FF00',
                            y: 9
                        }
                    ]
                }]
            });
        }
        return {
            init: function() {
                handleGrafico();
            }
        };
    }();
</script>