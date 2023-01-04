<?php
//funcoes php

function f_convertDate($date,$format)
{
    $newDate='';
    switch ($format) {
        case 'BR': $newDate=date("d/m/Y H:i:s", strtotime($date));
            break;
        case 'US': $newDate=date("Y/m/d H:i:s", strtotime($date));
            break;
        
        default:
            $newDate=$date;
            break;
    }
    return $newDate;
}


function f_interacaoDemanda($codigo)
{
    $retorno="";
    switch ($codigo){
        case 1: $retorno="CADASTROU NIP";
                break;
        case 2: $retorno="RESPONDEU NIP";
                break;
        case 3: $retorno="RECEBEU REQUISI플O DE INFRA플O";
                break;
        case 4: $retorno="RESPONDEU REQUISI플O DE INFRA플O";
                break;
        case 5: $retorno="RECEBEU AUTO DE INFRA플O";
                break;
        case 6: $retorno="RECEBEU ARQUIVAMENTO DE DEMANDA";
                break;
        default: $retorno="NOVA INTERA플O";
                break;
    }
    return $retorno;
}

function f_adicionarDias($data,$dias)
{
    echo $data;
    echo $dias;
    exit();
    return date('d/m/Y', strtotime("+".$dias." days",strtotime(f_convertDate($data,"US"))));
}

function converterMoeda($valor,$formato='SYS'){

    switch($formato){
        case "SYS": $retorno = str_replace(".","",$valor);
                    $retorno = str_replace(",",".",$retorno);
                    $retorno = number_format($retorno,2,'.','');
            break;
        case "BR":  //$retorno = str_replace(",","",$valor);
                    //$retorno = str_replace(".",",",$retorno);
                    $retorno = number_format($valor,2,',','.');
            break;
        default:    $retorno=$valor;
            break;
    }
    return $retorno;
}


function f_dataOnly($data){
    $aux=explode(" ",$data);
    return $aux[0];
}

function f_abreviarNome($nomeCompleto){
    $nomeAux = explode(" ", $nomeCompleto);
    $nomeFinal = "";
    $quantidadeNomes = count($nomeAux);

    $nomeFinal=$nomeAux[0].' ';

    for ($i=1; $i <($quantidadeNomes-1) ; $i++) { 
        $nomeFinal.=substr($nomeAux[$i],0,1).". ";
    }

    $nomeFinal.=$nomeAux[($quantidadeNomes-1)];
    
    return $nomeFinal;
}