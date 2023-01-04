<!DOCTYPE html>
<?php
if (!ini_get('date.timezone')) {
    date_default_timezone_set('America/Sao_Paulo');
}

if (isset($_SESSION["usuario"])) {
    // header("location:../painel");
}
?>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>CONTROLAB</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/font-awesome/css/font-awesome.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/simple-line-icons/simple-line-icons.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap/css/bootstrap.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/uniform/css/uniform.default.css"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/login.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/css/components-md.css" id="style_components"
          rel="stylesheet" type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/css/plugins-md.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/layout.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/themes/default.css" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/custom.css" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-md login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->

<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<style type="text/css">
    html
    {
        background-color: #00c3f7
    }
    .login
    {
        background-color: #00c3f7!important
    }
    .create-account 
    {
        background-color: #c5c5c5!important;
        
    }
    #register-btn
    {
        color:#00c3f7!important;
    }
    .login-btn
    {
        background-color: #00c3f7!important;
        color:white;
    }

</style>
<div class="content" style="margin: 0px auto 10px auto;margin-top:5% !important">
    <div class="col-md-12  col-xs-12 col-sm-12" style="text-align: center;padding: 20px">
        <img class="img-responsive" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/img/controlab.png" width="300"/>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12" style="text-align: center;">
    	<h4>Gestão de Performace - Laboratório</h4>
    </div>
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="autenticar" method="post">      
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>
            Entre com o seu usuario e senha. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Usuario</label>
            <input class="form-control form-control-solid placeholder-no-fix uppercase" type="text"
                   placeholder="Usuario" name="usuario" value=""/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Senha</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                   placeholder="SENHA" name="senha"/>
        </div>


        <div class="form-actions text-center" style="padding: 10px">
            <button type="submit" class="btn uppercase login-btn">Login</button>
        </div>

        <div class="form-group text-center">
            <?php
            if (isset($data['erro'])) {
                echo '<p class="alert alert-danger">' . $data['erro'] . '</p>';
            }
            ?>
        </div>

    </form>
    <!-- END LOGIN FORM -->


</div>
<div class="copyright">
    <?= date("Y"); ?> - CONTROLAB
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/respond.min.js"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-migrate.min.js"
        type="text/javascript"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.blockui.min.js"
        type="text/javascript"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.cokie.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-validation/js/jquery.validate.min.js"
        type="text/javascript"></script>
<script
    src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-validation/js/localization/messages_pt_BR.min.js"
    type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
