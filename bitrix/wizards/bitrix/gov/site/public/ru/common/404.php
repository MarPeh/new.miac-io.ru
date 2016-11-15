<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty("keywords", "Страница не найдена");
$APPLICATION->SetPageProperty("description", "Страница не найдена");
?>
<!DOCTYPE html>
<html>
<head>
	<? $APPLICATION->ShowHead(); ?>
	<title><? $APPLICATION->ShowTitle() ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script data-skip-moving="true">
		/*! https://github.com/bdadam/OptimizedWebfontLoading */
		function loadFont(t,e,n,o){function a(){if(!window.FontFace)return!1;var t=new FontFace("t",'url("data:application/font-woff2,") format("woff2")',{}),e=t.load();try{e.then(null,function(){})}catch(n){}return"loading"===t.status}var r=navigator.userAgent,s=!window.addEventListener||r.match(/(Android (2|3|4.0|4.1|4.2|4.3))|(Opera (Mini|Mobi))/)&&!r.match(/Chrome/);if(!s){var i={};try{i=localStorage||{}}catch(c){}var d="x-font-"+t,l=d+"url",u=d+"css",f=i[l],h=i[u],p=document.createElement("style");if(p.rel="stylesheet",document.head.appendChild(p),!h||f!==e&&f!==n){var w=n&&a()?n:e,m=new XMLHttpRequest;m.open("GET",w),m.onload=function(){m.status>=200&&m.status<400&&(i[l]=w,i[u]=m.responseText,o||(p.textContent=m.responseText))},m.send()}else p.textContent=h}}

		loadFont('OpenSans', '<?= SITE_TEMPLATE_PATH ?>/opensans.css', '<?= SITE_TEMPLATE_PATH ?>/opensans-woff2.css');
	</script>

	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/template_styles.css">
	<link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/special_version.css">

	<!-- /styles -->
</head>
<body>
<div class="body-wrapper clearfix">

	<header>
		<div class="container container-white pt30">
			<div class="content">
				<div class="col col-mb-12 col-margin-bottom">
					<a href="/" class="logo">
						<img src="<?=COption::GetOptionString('bitrix.gossite', 'coat', '/upload/coats/unknown.png', SITE_ID)?>" />
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							".default",
							array(
								"AREA_FILE_SHOW" => "file",
								"AREA_FILE_SUFFIX" => "inc",
								"EDIT_TEMPLATE" => "",
								"PATH" => "#SITE_DIR#includes/title.php"
							),
							false
						);?>
					</a>
				</div> <!-- .col col-mb-12 col-margin-bottom -->
			</div> <!-- .content -->
		</div> <!-- .container container-white pt10 -->
	</header>

	<div class="container container-error-page">
		<div class="content">
			<div class="error-page-big-text">
				404
			</div>
			<div class="col col-mb-12 col-10 col-left-1 col-dt-6 col-dt-left-3 ta-center">
				<h1>Страница не найдена	</h1>

				<div class="white-box p20 pb10 col-margin">
					<form action="#SITE_DIR#search/">
						<div class="content">
							<div class="col col-mb-12 col-7 col-dt-8">
								<input class="input input-search input-block mb10" type="text" name="q" placeholder="Поиск по сайту">
							</div>
							<div class="col col-mb-12 col-5 col-dt-4 mb10">
								<button class="btn btn-search btn-block">Поиск</button>
							</div>
						</div>
					</form>
				</div>

				<p class="col-margin">
					<a href="#SITE_DIR#">Главная страница</a>
				</p>
				<p class="col-margin">
					<a href="#SITE_DIR#search/map.php">Карта сайта</a>
				</p>
			</div> <!-- .col col-mb-12 col-10 col-dt-6 col-ld-4 ta-center -->
		</div> <!-- .content -->
	</div> <!-- .container container-white container-error-page -->

</div> <!-- .body-wrapper clearfix -->


<script src="<?= SITE_TEMPLATE_PATH ?>/js/-jquery.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/js.cookie.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/special_version.js"></script>
</body>
</html>
<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php"); ?>