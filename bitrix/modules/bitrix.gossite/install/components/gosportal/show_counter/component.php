<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}

$edit=false;

global $USER;
$arGroups = $USER->GetUserGroupArray();

$filter = Array(
    "STRING_ID" => "PORTAL_ADMINISTRATION",    
);
$rsGroups = CGroup::GetList(($by="c_sort"), ($order="desc"), $filter);
if($arGropusVio=$rsGroups->GetNext()){
    if(in_array($arGropusVio['ID'],$arGroups))
        $edit=true;
}


if(in_array(1,$arGroups)){
    $edit=true;
}

return $edit;