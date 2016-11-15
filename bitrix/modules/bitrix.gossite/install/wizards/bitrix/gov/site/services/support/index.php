<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(!CModule::IncludeModule("support"))
    return;

$APPLICATION->SetGroupRight("support", WIZARD_SUPPORT_GROUP, "W");
$APPLICATION->SetGroupRight("support", 2, "R");
COption::SetOptionString("support","SUPPORT_MAX_FILESIZE","10000");

$arExist=array();
$rsStatus = CTicketDictionary::GetList($by="s_id", $sort="asc", $arFilter=array("TYPE"=>"S"), $is_filtered);
while($arRes = $rsStatus->GetNext()) {
    $arExist[$arRes['SID']]=$arRes;
}
$arToAdds=array(
    array(
        'NAME'		=> GetMessage('CONSIDERATE'),
        'arrSITE'	=> Array(WIZARD_SITE_ID),
        'C_TYPE'  	=> 'S',
        'C_SORT'	=> 100,
        'SID'		=> 'considerate',
    ),
    array(
        'NAME'		=> GetMessage('PROCESSED'),
        'arrSITE'	=> Array(WIZARD_SITE_ID),
        'C_TYPE'  	=> 'S',
        'C_SORT'	=> 200,
        'SID'		=> 'processed',
    ),
    array(
        'NAME'		=> GetMessage('DENIED'),
        'arrSITE'	=> Array(WIZARD_SITE_ID),
        'C_TYPE'  	=> 'S',
        'C_SORT'	=> 300,
        'SID'		=> 'denied',
    )
);
foreach($arToAdds as $arToAdd)
{
    if(!$arExist[$arToAdd['SID']]) {
        $id = CTicketDictionary::Add($arToAdd);
    }
    else
    {
        $arSites = CTicketDictionary::GetSiteArray($arExist[$arToAdd['SID']]['ID']);
        if(!in_array(WIZARD_SITE_ID, $arSites))
        {
            $arSites[] = WIZARD_SITE_ID;
            $x = CTicketDictionary::Update($arExist[$arToAdd['SID']]['ID'], array(
                "SID"     => $arToAdd['SID'],
                "arrSITE" => $arSites
            ));
        }
        $id = $arExist[$arToAdd['SID']]['ID'];
    }

    if($arToAdd['SID'] == "considerate")
    {
        COption::SetOptionInt("bitrix.gossite", "internet_reception_support_statuse", $id, WIZARD_SITE_ID, WIZARD_SITE_ID);
        COption::SetOptionInt("bitrix.gossite", "request_information_support_statuse", $id, WIZARD_SITE_ID, WIZARD_SITE_ID);
    }
}

$arExist=array();
$rsStatus = CTicketDictionary::GetList($by="s_id", $sort="asc", $arFilter=array("TYPE"=>"C"), $is_filtered);
while($arRes = $rsStatus->GetNext()) {
    $arExist[$arRes['SID']]=$arRes;
}

$arToAdds=array(
    array(
        'NAME'		=> GetMessage('APPEAL'),
        'arrSITE'	=> Array(WIZARD_SITE_ID),
        'C_TYPE'  	=> 'C',
        'C_SORT'	=> 100,
        'SID'		=> 'appeal',
    ),
    array(
        'NAME'		=> GetMessage('REQUEST'),
        'arrSITE'	=> Array(WIZARD_SITE_ID),
        'C_TYPE'  	=> 'C',
        'C_SORT'	=> 200,
        'SID'		=> 'request',
    )
);

foreach($arToAdds as $arToAdd)
{
    if(!$arExist[$arToAdd['SID']])
        CTicketDictionary::Add($arToAdd);
    else
    {
        $arSites=CTicketDictionary::GetSiteArray($arExist[$arToAdd['SID']]['ID']);
        if(!in_array(WIZARD_SITE_ID, $arSites))
        {
            $arSites[]=WIZARD_SITE_ID;
            CTicketDictionary::Update($arExist[$arToAdd['SID']]['ID'], array("SID"=>$arToAdd['SID'],"arrSITE"=>$arSites));
        }
    }
}

COption::SetOptionString("support", 'SUPPORT_DIR', "#SITE_DIR#feedback/");
COption::SetOptionString("support", 'SUPPORT_EDIT', "list.php");

$arProperty = Array(
    'ENTITY_ID'     => 'SUPPORT',
    'FIELD_NAME'    => 'UF_FORM_RESULT',
    'USER_TYPE_ID'  => 'integer',
    'XML_ID'        => '',
    'SORT'          => 5,
    'MULTIPLE'      => 'N',
    'IS_SEARCHABLE' => 'N',
    'EDIT_IN_LIST' => 'N',
);
$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arProperty["ENTITY_ID"], "FIELD_NAME" => $arProperty["FIELD_NAME"]));
if (!$dbRes->Fetch()) {
    $arProperty["EDIT_FORM_LABEL"] = array('ru' => GetMessage('UF_FORM_RESULT'), 'en' => 'Form result ID');
    $arProperty["LIST_COLUMN_LABEL"] = array('ru' => GetMessage('UF_FORM_RESULT'), 'en' => 'Form result ID');
    $arProperty["LIST_FILTER_LABEL"] = array('ru' => GetMessage('UF_FORM_RESULT'), 'en' => 'Form result ID');
    $userType = new CUserTypeEntity();
    $success = (bool)$userType->Add($arProperty);
}
?>