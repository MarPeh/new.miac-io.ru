<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
global $APPLICATION;
	$arNew = array();
	$arNew[] = Array(
		"Реестр заказов",
		"#SITE_DIR#mun-order/index.php",
		array(),
		array(),
		""
	);

	CModule::IncludeModule('iblock');
	$db = CIBlockSection::GetList(
		array("NAME"=>"ASC"),
		array(
			"ACTIVE"=>"Y",
			"DEPTH_LEVEL"=>1,
			"IBLOCK_CODE"=>"orders"
		)
	);
	while ($ar = $db->GetNext()) {
		$arNew[]=array(
			$ar["NAME"],
			$ar["SECTION_PAGE_URL"],
			array(),
			array(),
			""
		);
	}
	global $APPLICATION;
	$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");	
	$munOrderSelectedAr=explode(";",$munOrderSelected);
	$count=count($munOrderSelectedAr)-1;
	$arNew[] = Array(
		"Избранное (".$count.")", 
		"#SITE_DIR#mun-order/selected/", 
		Array(), 
		Array("HTML_ID"=>"munOrderSelectedMenu"),
		"siteType!='pda'"
	);	
	$aMenuLinks = array_merge($arNew, $aMenuLinks); 
?>