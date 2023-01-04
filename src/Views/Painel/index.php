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