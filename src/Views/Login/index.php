<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
	<base href="../../../">
	<title><?= $data["unidade"]["NOME"]; ?> - CONTROLAB</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<link rel="shortcut icon" href="<?= $GLOBALS['base_dir']; ?>/Assets/global/media/logos/favicon.ico" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="<?= $GLOBALS['base_dir']; ?>/Assets/global/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= $GLOBALS['base_dir']; ?>/Assets/global/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-dark">
	<!--begin::Main-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= $GLOBALS['base_dir']; ?>/Assets/global/media/illustrations/sigma-1/14-dark.png">
			<!--begin::Content-->
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<!--begin::Logo-->
				<a class="mb-12">
					<img src="<?= $GLOBALS['base_dir']; ?>Uploads/<?= $data["unidade"]["LOGO"]; ?>" class="h-70px" />
				</a>
				<!--end::Logo-->
				<!--begin::Wrapper-->
				<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<!--begin::Form-->
					<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="<?=$data['unidade']['URL']?>/login/autenticar">
						<!--begin::Heading-->
						<div class="text-center mb-10">
							<!--begin::Title-->
							<h1 class="text-dark mb-3 p-5">Sistema CONTROLAB</h1>
						</div>
						<!--begin::Heading-->
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Label-->
							<label class="form-label fs-6 fw-bolder text-dark">Usuario</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="text" name="usuario" autocomplete="off" />
							<!--end::Input-->
						</div>
						<div class="fv-row mb-10">
							<div class="d-flex flex-stack mb-2">
								<label class="form-label fw-bolder text-dark fs-6 mb-0">Senha</label>
							</div>
							<!--end::Wrapper-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="password" name="senha" autocomplete="off" />
							<!--end::Input-->
						</div>

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
				        ?>

						<!--end::Input group-->
						<!--begin::Actions-->
						<div class="text-center">
							<!--begin::Submit button-->
							<button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
								<span class="indicator-label">Continue</span>
								<span class="indicator-progress">Autenticando...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
						</div>
						<!--end::Actions-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
			<!--begin::Footer-->
			<div class="d-flex flex-center flex-column-auto p-10">
				<!--begin::Links-->
				<div class="d-flex align-items-center fw-bold fs-6">
					<a href="#" class="text-muted text-hover-primary px-2">CONTROLAB &copy; <?= date('Y') ?></a>
				</div>
				<!--end::Links-->
			</div>
			<!--end::Footer-->
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Root-->
	<!--end::Main-->
	<!--begin::Javascript-->
	<script>
		var hostUrl = "<?= $GLOBALS['base_dir']; ?>/Assets/global/";
	</script>
	<!--begin::Global Javascript Bundle(used by all pages)-->
	<script src="<?= $GLOBALS['base_dir']; ?>/Assets/global/plugins/global/plugins.bundle.js"></script>
	<script src="<?= $GLOBALS['base_dir']; ?>/Assets/global/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Page Custom Javascript(used by this page)-->
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
	<script>
		"use strict";
		var KTSigninGeneral = function() {
			var handleLogin = function() {
				var t, e, i;

				t = document.querySelector("#kt_sign_in_form"),
					e = document.querySelector("#kt_sign_in_submit"),
					i = FormValidation.formValidation(t, {
						fields: {
							usuario: {
								validators: {
									notEmpty: {
										message: "Email é necessário."
									}
								}
							},
							password: {
								validators: {
									notEmpty: {
										message: "Por favor, preencha sua senha"
									}
								}
							}
						},
						plugins: {
							trigger: new FormValidation.plugins.Trigger,
							bootstrap: new FormValidation.plugins.Bootstrap5({
								rowSelector: ".fv-row"
							})
						}
					}),
					e.addEventListener("click", (function(n) {
						n.preventDefault(), i.validate().then((function(i) {
							"Valid" == i ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, time()) : Swal.fire({
							
							})
						}))
					}))
					function time()
					{
						setTimeout(function()
						{
							$("#kt_sign_in_form").submit();
						},2000)

						
						
						setTimeout(function()
						{
							$("#kt_sign_in_form").submit();

							e.removeAttribute("data-kt-indicator");
						},4000)
						
					}
				

			}

			return {
				init: function() {
					handleLogin();
				}
			}
		}();

		KTUtil.onDOMContentLoaded((function() {
			KTSigninGeneral.init()
		}));
	</script>
</body>
<!--end::Body-->

</html>