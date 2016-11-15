<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}


CModule::IncludeModule("iblock");
GLOBAL $USER;

if (isset($_GET['del_user']))
{
	CUser::Delete($_GET['del_user']);
	
	$param_str='';
	foreach ($_GET as $key=>$value)
	{
		if ($key!='del_user') $param_str=$param_str.$key.'='.$value.'&';
	}
	$URL= $_SERVER['PHP_SELF'].'?'.$param_str.'d=Y';	
	header ("Location: $URL");
}

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;

if(!isset($arParams["PM_URL"]))
	$arParams["PM_URL"] = "#SITE_DIR#rukovodstvo/user/#USER_ID#/";

if(!isset($arParams["EC_URL"]))
	$arParams["EC_URL"] = "#SITE_DIR#for_staff/edit_calendar.php?empl=#USER_ID#";

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);

if(strlen($arParams["IBLOCK_TYPE"])<=0)
 	$arParams["IBLOCK_TYPE"] = "foundations";
$arParams["STRUCTURE_IBLOCK_ID"] = trim($arParams["STRUCTURE_IBLOCK_ID"]);




if (!function_exists('get_sect')){
	function get_sect($ib,$depth,$org,$perent,$url_template,$url_template_edit)
	{

		$arFilterSec = Array(
				'IBLOCK_ID'=>$ib,
				'DEPTH_LEVEL'=>$depth,
				'SECTION_ID'=>$perent,
		);
		$db_list = CIBlockSection::GetList(false, $arFilterSec, true,array('UF_ORGANIZATION'));
		$tmp_sec=false;

		while($ar_result = $db_list->GetNext())
		{


				$arButtons2 = CIBlock::GetPanelButtons(
						$ar_result["IBLOCK_ID"],
						0,
						$ar_result["ID"],
						array("SESSID"=>false)
				);


				$ar_result['BUTTONS']['edit_section']=$arButtons2['edit']['edit_section'];
				$ar_result['BUTTONS']['delete_section']=$arButtons2['edit']['delete_section'];



				$filter = Array
				(
						"ACTIVE"              => "Y",
						"UF_STRUCTURE" => $ar_result['ID']

				);
				$arListParams = array('SELECT' => array('UF_*'));
				$rsUsers = CUser::GetList(($by="ID"), ($order="desc"), $filter,$arListParams); // выбираем пользователей

				$tmp_usr=false;
				while($ar_user=$rsUsers->GetNext())
				{
					$user_url = str_replace("#SITE_DIR#", SITE_DIR, $url_template_edit);
					$user_url = str_replace("#USER_ID#", $ar_user['ID'], $user_url);
					$ar_user['DETAIL_URL']=$user_url;
					$tmp_usr[]=$ar_user;
				}
				$ar_result['sub_struct']=get_sect($ib,$depth+1,$org,$ar_result['ID'],$url_template,$url_template_edit);
				$ar_result['users']=$tmp_usr;
				$tmp_sec[]=$ar_result;

		}
		return $tmp_sec;
	}
}

	$arFilterSec = Array(
			'IBLOCK_ID'=>$arParams["STRUCTURE_IBLOCK_ID"],
			'DEPTH_LEVEL'=>1,
	);
	
	
	$db_list = CIBlockSection::GetList(false, $arFilterSec, true);
	$tmp_sec=false;
	
	while($ar_result = $db_list->GetNext())
	{
		$filter = Array
		(
				"ACTIVE"              => "Y",
				"UF_STRUCTURE" => $ar_result['ID']			
		);
		$arListParams = array('SELECT' => array('UF_*'));
		$rsUsers = CUser::GetList(($by="ID"), ($order="desc"), $filter,$arListParams); // выбираем пользователей
		
		
		$arButtons2 = CIBlock::GetPanelButtons(
					$ar_result["IBLOCK_ID"],
					0,
					$ar_result["ID"],
					array("SESSID"=>false)
		);
			
			
		$ar_result['BUTTONS']['edit_section']=$arButtons2['edit']['edit_section'];
		$ar_result['BUTTONS']['delete_section']=$arButtons2['edit']['delete_section'];
		
		$tmp_usr=false;
		while($ar_user=$rsUsers->GetNext())
		{		
			
			$user_url = str_replace("#SITE_DIR#", SITE_DIR, $arParams["EC_URL"]);
			$user_url = str_replace("#USER_ID#", $ar_user['ID'], $user_url);
			$ar_user['DETAIL_URL']=$user_url;
			$tmp_usr[]=$ar_user;
		}
		$ar_result['users']=$tmp_usr;
		$ar_result['sub_struct']=get_sect($arParams["STRUCTURE_IBLOCK_ID"],2,$ob['ID'],$ar_result['ID'],$arParams['PM_URL'],$arParams['EC_URL']);
		$tmp_sec[]=$ar_result;
		
	}
	$tmp_res['PODR']=$tmp_sec;
	$arResult[]=$tmp_res;
		
$this->IncludeComponentTemplate($componentPage);

if($USER->IsAuthorized())
{
	if(
			$APPLICATION->GetShowIncludeAreas()
			|| (is_object($GLOBALS["INTRANET_TOOLBAR"]) && $arParams["INTRANET_TOOLBAR"]!=="N")
			|| $arParams["SET_TITLE"]
	)
	{
		if(CModule::IncludeModule("iblock"))
		{
			$arButtons = CIBlock::GetPanelButtons(
					$arParams["ORGANIZTION_IBLOCK_ID"],
					0,
					$arParams["PARENT_SECTION"],
					array("SECTION_BUTTONS"=>false)
			);
			
			$arButtons1 = CIBlock::GetPanelButtons(
					$arParams["STRUCTURE_IBLOCK_ID"],
					0,
					$arParams["PARENT_SECTION"],
					array("SECTION_BUTTONS"=>true)
			);

			$this->AddIncludeAreaIcon(
					array(
							'URL'   => $arButtons['edit']['add_element']['ACTION'],
							'SRC'   => $arButtons['edit']['add_element']['ICON'],
							'ICON'   => $arButtons['edit']['add_element']['ICON'],
							'TITLE' => $arButtons['edit']['add_element']['TITLE']
					)
			);
			
			$this->AddIncludeAreaIcon(
					array(
							'URL'   => $arButtons1['edit']['add_section']['ACTION'],
							'SRC'   => $arButtons1['edit']['add_section']['ICON'],
							'ICON'   => $arButtons1['edit']['add_section']['ICON'],
							'TITLE' => $arButtons1['edit']['add_section']['TITLE']
					)
			);
			$add_user_link=$APPLICATION->GetPopupLink(
						array(
							'URL' => '/bitrix/admin/user_edit.php?lang='.LANGUAGE_ID.'&bxpublic=Y&from_module=main', 
							"PARAMS"=>array("width"=>780, "height"=>500, "resize"=>false),
				));
			$this->AddIncludeAreaIcon(
					array(
							'URL'   => 'javascript:'.$add_user_link,
							'SRC'   => $arButtons1['edit']['add_section']['ICON'],
							'ICON'   => $arButtons1['edit']['add_section']['ICON'],
							'TITLE' => GetMessage("T_ADD_USER")
					)
			);
			

			if($arParams["SET_TITLE"])
			{
				$arTitleOptions = array(
						'ADMIN_EDIT_LINK' => array($arButtons["submenu"]["edit_iblock"]["ACTION"], ),
						'PUBLIC_EDIT_LINK' => "",
						'COMPONENT_NAME' => $this->GetName(),
				);
			}
		}
	}
}
?>



<script type="text/javascript">
	function showusers(blok_id)
	{
		var el=document.getElementById(blok_id);
			if (el.style.display=="none")
			{
				el.style.display="block"
			}
			else
			{
				el.style.display="none"
			}
	}
</script>