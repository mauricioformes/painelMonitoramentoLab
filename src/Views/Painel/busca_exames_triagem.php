<?php
$title = "Painel";

$nCount1 = 0;
$nCount = 0;

?>


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

    .yellow {
        background: yellow;
    }
</style>

<div>
    <div class="row">
        <div class="col-md-20">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center">Tipo</th>
                        <th style="text-align:center">OS</th>
                        <th style="text-align:center">Nome Completo</th>
                        <th style="text-align:center">Exame</th>
                        <th style="text-align:center">Meta</th>
                        <th style="text-align:center">Tempo</th>
                        <th style="text-align:center">Data Triagem</th>
                        <th style="text-align:center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['todosExames'] as $todosExames) :
                        if ($todosExames["EXAME_TIPOATENDIMENTO"] == "Protocolo") {
                            $class = "protocolo";
                            $class_tr = "alerts-border";
                        } else if ($todosExames["EXAME_TIPOATENDIMENTO"] == "Urgente") {
                            $class = "urgencia";
                            $class_tr = "";
                        } else {
                            $class = "";
                            $class_tr = "";
                        }

                        //var_dump($todosExames);
                    ?>
                        <tr class="<?php echo $class_tr; ?>">
                            <td style="text-align:center">
                                <div class="<?php echo $class; ?>"><?php echo $todosExames["EXAME_TIPOATENDIMENTO"]; ?></div>
                            </td>
                            <td style="text-align:center">
                                <div class="<?php echo $class; ?>"><?php echo $todosExames["ORDEMSERVICO"]; ?></div>
                            </td>
                            <td style="text-align:center">
                                <div class="<?php echo $class; ?>"><b><?php echo $todosExames["PACIENTE_NOME"]; ?></b></div>
                            </td>
                            <td style="text-align:center"><b><?php echo $todosExames["EXAME_DESCRICAOEXAME"]; ?></b></td>
                            <td style="text-align:center"><b><?php echo $todosExames["META"]; ?></b></td>
                            <td style="text-align:center"><b>
                                    <div id="data-hora-detalhes-<?php echo $todosExames['ORDEMSERVICO']; ?>-<?php echo $nCount1; ?>"></div>
                                </b></td>
                                <td style="text-align:center"><b><?php echo $todosExames["DATA_COLETA"]; ?></b></td>
                            <td style="text-align:center"></td>
                        </tr>
                    <?php $nCount1++;
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    const Interval = window.setInterval(function() {

        <?php foreach ($data['todosExames'] as $todosExames) : ?>

            var aux = '<?php echo $todosExames['DATA_COLETA']; ?>';


            var auxBarra = aux.split('/');
            var auxEspaco = auxBarra[2].split(' ');
            var auxPontos = auxEspaco[1].split(':');


            var ano = parseInt((auxEspaco[0]));
            var mes = parseInt(auxBarra[1]);
            var dia = parseInt(auxBarra[0]);
            var hora = parseInt(auxPontos[0]);
            var minuto = parseInt(auxPontos[1]);
            var segundo = parseInt(auxPontos[2]);

            //console.log(auxBarra);

            var dataInicio = new Date(ano, mes - 1, dia, hora, minuto, segundo, '');

            //console.log(dataInicio);

            //02/05/2022 13:31:00
            //new Date(ano, mês, dia, hora, minuto, segundo, milissegundo);
            //console.log('<?php echo $todosExames['DATA_ASSINATURA']; ?>');
            var dataInicioFormatada = new Date('<?php echo $todosExames['DATA_ASSINATURA']; ?>');
            //console.log(dataInicioFormatada);
            // Pega o horário atual
            var dataTermino = new Date();

            var dataTerminoFormatada = date.format(new Date());


            var diferencaTempo = dataTermino - dataInicio;

            //console.log(diferencaTempo);
            // console.log(dataInicio);
            // console.log(dataTermino);

            // var diferencaTempo = Math.abs(dataTermino - dataInicio);
            // console.log(diferencaTempo);
            // var hour = (Math.floor(diferencaTempo / 3600));
            // var min = (Math.floor(diferencaTempo / 60000));
            // var sec = ((diferencaTempo % 60000) / 1000).toFixed(0);

            var sec = Math.floor((diferencaTempo / 1000) % 60);
            var min = Math.floor((diferencaTempo / (1000 * 60)) % 60);
            var hour = Math.floor((diferencaTempo / (1000 * 60 * 60)) % 24);

            hour = (hour < 10) ? "0" + hour : hour;
            min = (min < 10) ? "0" + min : min;
            sec = (sec < 10) ? "0" + sec : sec;

            //console.log(<?php echo $nCount; ?>);
            // Formata a data conforme dd/mm/aaaa hh:ii:ss
            //const dataHora = zeroFill(dataInicio.getHours()) + ':' + zeroFill(dataInicio.getMinutes()) + ':' + zeroFill(dataInicio.getSeconds());
            // console.log('data-hora-<?php echo $todosExames['ID']; ?>-<?php echo $nCount; ?>');
            // Exibe na tela usando a div#data-hora
            document.getElementById('data-hora-detalhes-<?php echo $todosExames['ORDEMSERVICO']; ?>-<?php echo $nCount; ?>').innerHTML = hour + ":" + min + ":" + sec;

        <?php $nCount++;
        endforeach; ?>
        //console.log("FIM");
    }, 1000);
</script>