<?php
$title="Painel";
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
<div class="row">
    <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
       <div class="portlet box grey-cascade">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet box blue" id="form_wizard_1">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-university"></i> Troca de Senha -<span class="step-title">
                                Etapa 1 de 1 </span>
                            </div>
                        </div>
                        <div class="portlet-body form">                       
                            <form action="painel/atualizarSenha" class="form-horizontal" method="POST">
                                <input type="hidden" name="codigoUsuario" value="<?=$_SESSION['usuario']['usuario']['CODIGO']?>">
                                <div class="form-wizard">
                                    <div class="form-body">
                                        <ul class="nav nav-pills nav-justified steps">
                                            <li>
                                                <a href="#tab1" data-toggle="tab" class="step">
                                                <span class="number">
                                                1 </span>
                                                <span class="desc">
                                                <i class="fa fa-check"></i> Troca de Senha</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="bar" class="progress progress-striped" role="progressbar">
                                            <div class="progress-bar progress-bar-success">
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="alert alert-danger display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                Verifique o formulario.
                                            </div>
                                            <div class="alert alert-success display-none">
                                                <button class="close" data-dismiss="alert"></button>
                                                Documento Cadastrada com sucesso
                                            </div>
                                            <div class="tab-pane active" id="tab1">
                                                <div class="form-group">    
                                                    <label class="control-label col-md-3">Senha antiga
                                                        <span class="required">* </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="password" name="senhaAntiga" required>
                                                        <span class="help-block"> Informe a senha antiga</span>
                                                    </div>
                                                </div>
                                                <div class="form-group">    
                                                    <label class="control-label col-md-3">Nova Senha
                                                        <span class="required">* </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="password" name="senhaNova" id="senhaNova" minlength="8" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3" style="text-align: center;">   
                                                        <div id="forcaSenha">
                                                            <label id="labelForcaSenha" style="color:white"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <p><b>Recomendações para criar uma senha forte:</b></p>
                                                        <ul>
                                                           <li> Possua pelo menos 8 caracteres </li>
                                                           <li> Possua pelo menos 1 caracter especial ex.:('#' , '@' , '.', '!') </li>
                                                           <li> Não utilize numeros sequenciais ex.:(123456) </li>
                                                           <li> Não utilize dados pessoais ex.: (Nome, Data de Nascimento)</li>
                                                            
                                                        </ul> 
                                                    </div>
                                                </div>
                                                <div class="form-group">    
                                                    <label class="control-label col-md-3">Confimação Senha
                                                        <span class="required">* </span>
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" type="password" id="redigitacao" required>
                                                        <span class="help-block"> Re-digite a nova senha</span>
                                                        <span class="help-block" id="avisoSenha"></span>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                               
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn green" id="atualizar">Atualizar
                                                    <i class="m-icon-swapright m-icon-white"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
  #progressbar .ui-progressbar-value 
  {
    background-color: #ccc;
  }
  </style>
<script>
    var Inside = function () 
    {
        var handleSenha = function()
        {
             $("#senhaNova").complexify({}, function (valid, complexity) 
             {
                var color="FF0000";
                var label ="Preencha a nova senha";
                console.log(complexity);
                if(complexity < 35)
                {
                    console.log('senha muito fraca');
                    color='#FF0000';
                    label = 'Senha Fraca';
                    $("#atualizar").attr('disabled','true');
                }
                else
                {
                    color='#008000';
                    label = 'Senha Forte'
                    $("#atualizar").removeAttr('disabled');
                }
                $("#forcaSenha").css(
                {
                    'width':complexity+'%',
                    'background' : color,
                    'height' :20,
                    'border-radius' :20,
                    'text-align':'center'   
                });
                $("#labelForcaSenha").html(label);

            });
            $("#redigitacao,#senhaNova").keyup(function()
            {
                if($(this).val() != $("#senhaNova").val())
                {
                    $('#avisoSenha').html('<p><i class="fa fa-times" style="color:red"></i>Ops, a senha está divergente da anterior</p>');
                }
                else
                {
                    $('#avisoSenha').html('<p><i class="fa fa-check" style="color:green"></i>Tudo certo</p>');
                }
            })

        }
     
        return {
            init: function () 
            {
                handleSenha();
            }
        };
  }();
</script>