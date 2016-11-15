<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?$ElementID = $APPLICATION->IncludeComponent(
	"gosportal:staff.person",
	"",
	Array(
		'USER'=> $arResult["VARIABLES"]["ELEMENT_ID"],
		'USER_PROPERTY' => array(
			"EMAIL",
			"PERSONAL_PROFESSION",
			"PERSONAL_WWW",
			"PERSONAL_BIRTHDAY",
			"PERSONAL_PHONE",
			"PERSONAL_FAX",
			"PERSONAL_MOBILE",
			"PERSONAL_STREET",
			"PERSONAL_MAILBOX",
			"PERSONAL_CITY",
			"PERSONAL_STATE",
			"PERSONAL_ZIP",
			"PERSONAL_NOTES",
			"ADMIN_NOTES",
			"WORK_POSITION",
			"WORK_PHONE",
		),

	),
	$component
);?>