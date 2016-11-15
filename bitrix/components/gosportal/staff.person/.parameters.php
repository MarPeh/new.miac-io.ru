<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
if (!CModule::IncludeModule("iblock"))
    return;
$db_iblock = CIBlock::GetList(Array("SORT" => "ASC"), Array("SITE_ID" => $_REQUEST["site"], "TYPE" => ("medservices")));
while ($arRes = $db_iblock->Fetch())
    $arIBlocksServ[$arRes["ID"]] = $arRes["NAME"];
$arUserFieldNames = array('PERSONAL_PHOTO', 'FULL_NAME', 'ID', 'LOGIN', 'NAME', 'SECOND_NAME', 'LAST_NAME', 'EMAIL', 'DATE_REGISTER', 'PERSONAL_PROFESSION', 'PERSONAL_WWW', 'PERSONAL_BIRTHDAY', 'PERSONAL_ICQ', 'PERSONAL_GENDER', 'PERSONAL_PHONE', 'PERSONAL_FAX', 'PERSONAL_MOBILE', 'PERSONAL_PAGER', 'PERSONAL_STREET', 'PERSONAL_MAILBOX', 'PERSONAL_CITY', 'PERSONAL_STATE', 'PERSONAL_ZIP', 'PERSONAL_COUNTRY', 'PERSONAL_NOTES', 'WORK_POSITION', 'WORK_COMPANY', 'WORK_PHONE', 'ADMIN_NOTES', 'XML_ID');
$userProp = array();
foreach ($arUserFieldNames as $name)
    $userProp[$name] = GetMessage('ISL_'.$name);
$arRes = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", 0, LANGUAGE_ID);
if (!empty($arRes)) {
    foreach ($arRes as $key => $val) {
        $userProp[$val["FIELD_NAME"]] = '* '.(strlen($val["EDIT_FORM_LABEL"]) > 0 ? $val["EDIT_FORM_LABEL"] : $val["FIELD_NAME"]);
    }
}
$SHEDULES_BLOCK = array(
    'TYPE'     => 'STRING',
    'MULTIPLE' => 'N',
    'DEFAULT'  => '',
    'NAME'     => GetMessage('SHEDULES_BLOCK'),
    'PARENT'   => 'BASE'
);
if (!class_exists('MedML') || !MedML::$useOldInterface)
    $SHEDULES_BLOCK['HIDDEN'] = true;
$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_ID"      => Array(
            "PARENT"            => "ADDITIONAL_SETTINGS",
            "NAME"              => GetMessage("T_MEDSITE_DESC_SERV_ID"),
            "TYPE"              => "LIST",
            "VALUES"            => $arIBlocksServ,
            "DEFAULT"           => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH"           => "Y",
        ),
        "SHOW_SERVICES"  => array(
            "PARENT"  => "ADDITIONAL_SETTINGS",
            "NAME"    => GetMessage("MC_SHOW_SERVICES"),
            "TYPE"    => "CHECKBOX",
            "DEFAULT" => '/employees/personal_info.php',
        ),
        'SHEDULES_BLOCK' => $SHEDULES_BLOCK,
        "USER_INFO_LINK" => array(
            "PARENT"  => "ADDITIONAL_SETTINGS",
            "NAME"    => GetMessage("MC_USER_INFO_LINK"),
            "TYPE"    => "STRING",
            "DEFAULT" => '/employees/personal_info.php',
        ),
		"SCHEDULE_LINK" => array(
			"PARENT"  => "ADDITIONAL_SETTINGS",
			"NAME"    => GetMessage("MC_SCHEDULES_LINK"),
			"TYPE"    => "STRING",
			"DEFAULT" => '',
		),
        "USER"           => array(
            "PARENT"  => "BASE",
            "NAME"    => GetMessage("MC_USER"),
            "TYPE"    => "STRING",
            "DEFAULT" => '/employees/personal_info.php',
        ),
        "USER_PROPERTY"  => array(
            "NAME"     => GetMessage('MC_USER_PROPERTY_SHOW'),
            "TYPE"     => "LIST",
            "VALUES"   => $userProp,
            "MULTIPLE" => "Y",
            "DEFAULT"  => array('FULL_NAME', 'PERSONAL_PHONE', 'EMAIL', 'WORK_POSITION', 'UF_DEPARTMENT'),
        ),
		'NAME_TEMPLATE'              => array(
			'TYPE'              => 'LIST',
			'NAME'              => GetMessage('INTR_ISL_PARAM_NAME_TEMPLATE'),
			'VALUES'            => CComponentUtil::GetDefaultNameTemplates(),
			'MULTIPLE'          => 'N',
			'ADDITIONAL_VALUES' => 'Y',
			'DEFAULT'           => GetMessage('INTR_ISL_PARAM_NAME_TEMPLATE_DEFAULT'),
			'PARENT'            => 'BASE',
		),
	),
);
?>