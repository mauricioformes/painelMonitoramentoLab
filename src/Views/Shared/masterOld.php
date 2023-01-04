<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <?php ob_start(); ?>
    <title>%TITLE%</title>
    <?php $buffer = ob_get_contents();
    ob_end_clean(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <!--<meta http-equiv="Content-type" content="text/html; charset=utf-8">-->
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"> -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/select2/select2.css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />
    <!-- BEGIN THEME STYLES -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/css/components-md.css" id="style_components" rel="stylesheet" type="text/css" />
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/css/plugins-md.css" rel="stylesheet" type="text/css" />
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/layout.css" rel="stylesheet" type="text/css" />
    <link id="style_color" href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/themes/grey.css" rel="stylesheet" type="text/css" />
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/chosen/chosen.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" />

    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-bar-rating/dist/themes/bars-square.css" />

    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/timeline.css" rel="stylesheet" type="text/css" />
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/css/timeline_blip.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />

    <!-- END THEME STYLES -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/img/favicon.ico" />



    <!--FULL CALLENTDAR -->
    <link href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/fullcalendar/fullcalendar.min.css?d=<?= date("YmdHis"); ?>" rel="stylesheet" />


    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css?d=<?= date("YmdHis"); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/icheck/skins/all.css?d=<?= date("YmdHis"); ?>" />


</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->

<body class="page-md page-header-fixed page-container-bg-solid page-sidebar-closed-hide-logo page-header-fixed-mobile page-footer-fixed1">
    <!-- BEGIN HEADER -->
    <div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="../painel/index">
                    <?php
                    switch (date("m")) {
                        case 10:
                            $logo = "controlab.png";
                            break;
                        case 11:
                            $logo = "controlab.png";
                            break;

                        default:
                            $logo = "controlab.png";
                            break;
                    }
                    ?>
                    <!-- <img src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/img/austa/<?= $logo; ?>" alt="logo" class="logo-default" style="margin:15px; !important" width="100px" /> -->
                    <h4  alt="logo" class="logo-default" width="100px"><b>CONTROLAB</b></h4>

                </a>

                <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN PAGE ACTIONS -->
            <!-- DOC: Remove "hide" class to enable the page header actions -->
            <div class="page-actions">

            </div>
            <!-- END PAGE ACTIONS -->
            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
                <!-- BEGIN HEADER SEARCH BOX -->
                <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->


                <!-- <form class="search-form search-form-expanded" action="extra_search.html" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." name="query">
                    <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                    </span>
                </div>
            </form> -->


                <!-- END HEADER SEARCH BOX -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="icon-bell"></i>
                                <span class="badge badge-default quatidadeDocsPendentes"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="external">
                                    <h3><span class="bold quatidadeDocsPendentes"></span> - Documentos</h3>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283" id="conteudoNotif">
                                    </ul>
                                </li>
                            </ul>

                        </li>
                        <li class="dropdown dropdown-user">

                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile">
                                    <?= $_SESSION["usuario"]["usuario"]['USUARIO'] ?>
                                </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="/painel/usuario">
                                        <i class="fa fa-key"></i> Trocar Senha
                                    </a>
                                </li>
                                <li>
                                    <a href="../login/sair">
                                        <i class="fa fa-sign-out"></i> Sair
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li>
                        <a href="#">
                            <i class="icon-eye"></i>
                            <span class="title">Monitoramento</span>
                        </a>
                        <ul class="sub-menu">
                            <li>

                                <a href="../painel/coletas">
                                    <i class="icon-folder"></i>
                                    Fase 1: Coleta
                                </a>
                            </li>
                            <li>

                                <a href="../painel/triagens">
                                    <i class="icon-folder"></i>
                                    Fase 2: Triagem
                                </a>
                            </li>

                            <li>

                                <a href="../painel/assinaturas">
                                    <i class="icon-folder"></i>
                                    Fase 3: Assinatura
                                </a>
                            </li>

                        </ul>


                    </li>

                    <li>
                        <a href="#">
                            <i class="icon-settings"></i>
                            <span class="title">Parametrização</span>
                        </a>
                        <ul class="sub-menu">
                            <li>

                                <a href="../parametrizacao/exames">
                                    <i class="icon-pencil"></i>
                                    Exames
                                </a>
                            </li>


                        </ul>


                    </li>

                    <li>
                        <a href="#">
                            <i class="icon-screen-desktop"></i>
                            <span class="title">Gerenciar OS</span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="../gerenciaOS/gerencia">
                                    <i class="icon-screen-desktop"></i>
                                    Retirar OS do painel
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-docs"></i>
                            <span class="title">Relatórios</span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="../relatorio/coletas">
                                    <i class="icon-docs"></i>
                                    Coletas
                                </a>
                            </li>
                            <li>
                                <a href="../relatorio/triagens">
                                    <i class="icon-docs"></i>
                                    Triagens
                                </a>
                            </li>
                            <li>
                                <a href="../relatorio/assinaturas">
                                    <i class="icon-docs"></i>
                                    Assinaturas
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="page-content">
                <?php if (isset($_SESSION["sucesso"])) : ?>
                    <p class="alert alert-success"><?= $_SESSION["sucesso"]; ?></p>
                <?php endif ?>

                <?php if (isset($_SESSION["erro"])) : ?>
                    <p class="alert alert-danger"><?= $_SESSION["erro"]; ?></p>
                <?php endif ?>

                <?php if (isset($_SESSION["alerta"])) : ?>
                    <p class="alert alert-warning"><?= $_SESSION["alerta"]; ?></p>
                <?php endif ?>

                <?php
                unset($_SESSION["sucesso"]);
                unset($_SESSION["erro"]);
                unset($_SESSION["alerta"]);

                include($page);

                $buffer = str_replace("%TITLE%", $title, $buffer);
                echo $buffer;
                ?>
            </div>
        </div>

    </div>
    <div class="page-footer">
        <div class="page-footer-inner" style="color:white !important">
            <?= date("Y"); ?> &copy; CONTROLAB
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>

    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/respond.min.js"></script>
<script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/excanvas.min.js"></script>
<![endif]-->
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.min.js" type="text/javascript"></script>

    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-validation/js/localization/messages_pt_BR.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min.js"></script>

    <!-- END CORE PLUGINS -->
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/scripts/metronic.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/layout2/scripts/layout.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-wysihtml5/locales/bootstrap-wysihtml5.pt-BR.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/chosen/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/scripts/notificacoes.js?version=1"></script>

    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/highcharts/js/adapters/standalone-framework.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/highcharts/js/highcharts.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/highcharts/js/generic.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/highcharts/js/highcharts-more.js?d=<?= date("YmdHis"); ?>"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/highcharts/js/data.js"></script>

    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-mask/jquery.mask.js"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/nouislider/nouislider.js"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>

    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" integrity="sha256-9wRM03dUw6ABCs+AU69WbK33oktrlXamEXMvxUaF+KU=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script> -->


    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/moment.min.js?d=<?= date("YmdHis"); ?>"></script>

    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/fullcalendar/fullcalendar.min.js?d=<?= date("YmdHis"); ?>"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/fullcalendar/lang/pt-br.js?d=<?= date("YmdHis"); ?>"></script>


    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?d=<?= date("YmdHis"); ?>"></script>
    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js?d=<?= date("YmdHis"); ?>"></script>


    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/adminOld/pages/scripts/form-wizard.js"></script>

    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/icheck/icheck.min.js"></script>

    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/jquery-complexify/jquery.complexify.js"></script>


    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/custom/excel/xlsx.core.min.js"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/custom/excel/Blob.js"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/custom/excel/FileSaver.js"></script>
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/custom/excel/Export2Excel.js"></script>
    <!-- <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/custom/table2excel/src/jquery.table2excel.js"></script> -->
    <script src="<?= $GLOBALS['base_dir']; ?>/Assets/globalOld/plugins/table2excel/src/jquery.table2excel.js?d=<?= date("YmdHis"); ?>"></script>



    <script>
        $(document).ready(function() {

            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            //Nofication.init();
            Inside.init();


        });
    </script>

    <script>
        var Inside = function() {
            return {
                init: function() {

                }
            };

        }();
    </script>
    <!-- END JAVASCRIPTS -->
</body><!-- END BODY -->

</html>