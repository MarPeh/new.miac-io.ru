<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
	
$filter = Array
		(
			"STRING_ID"=>"SCHEDULE_ADMIN"
		);
	
$rsGroups = CGroup::GetList(($by="c_sort"), ($order="desc"), $filter);
$res_ar2=$rsGroups->Fetch();

$arFilter = array(
	'ID'=>1
);

$dbRes = CUser::GetList($by = 'ID', $order = 'ASC', $arFilter);
$user = new CUser;
if ($ar_user=$dbRes->GetNext())
{
	$arGroups = CUser::GetUserGroup($ar_user['ID']);
	$arGroups[]=$res_ar2['ID'];

	$fields = Array(
	  "GROUP_ID"          => $arGroups,
	  );
	$user->Update($ar_user['ID'], $fields);	
}

unset($_SESSION["WIZARD_USER_IMPORT_POSITION"]);
?>