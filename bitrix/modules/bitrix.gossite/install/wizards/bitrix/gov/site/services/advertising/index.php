<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule('advertising'))
	return;

$dbResult = CAdvContract::GetByID(1);
if (!$dbResult->Fetch())
	return;
else
{
    $arSites=CAdvContract::GetSiteArray(1);
    if(!in_array(WIZARD_SITE_ID,$arSites))
    {
        $arSites[]=WIZARD_SITE_ID;
        $arFields=array("arrSITE"=>$arSites);
        CAdvContract::Set($arFields, 1);
    }
}

//Types
$arTypes = Array(
	Array(
		"SID" => "SIDEBAR_240_400",
		"ACTIVE" => "Y",
		"SORT" => 2,
		"NAME" => GetMessage("PORTAL_ADV_SIDEBAR_240_400"),
		"DESCRIPTION" => ""
	),
    Array(
        "SID" => "SIDEBAR_TEXT",
        "ACTIVE" => "Y",
        "SORT" => 2,
        "NAME" => GetMessage("PORTAL_ADV_SIDEBAR_TEXT"),
        "DESCRIPTION" => ""
    ),
);

foreach ($arTypes as $arFields)
{
	$dbResult = CAdvType::GetByID($arTypes["SID"], $CHECK_RIGHTS="N");
	if ($dbResult && $dbResult->Fetch())
		continue;

	CAdvType::Set($arFields, "", $CHECK_RIGHTS="N");
}

//Matrix
$arWeekday = Array(
	"SUNDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"MONDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"TUESDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"WEDNESDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"THURSDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"FRIDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
	"SATURDAY" => Array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23)
);


$wizard =& $this->GetWizard();
$suffix = substr($wizard->GetVar("typeID"), 5);

$mapGuidePath = '';
switch ($suffix) {
    case 'gd':
    case 'mo':
        $mapGuidePath = 'city';
        break;

    case 'po':
    case 'zso':
        $mapGuidePath = 'region';
        break;
}

$arBanners = array();

if (($mapGuidePath != "") && ($banner = CFile::MakeFileArray(WIZARD_SERVICE_ABSOLUTE_PATH."/banners/".LANGUAGE_ID."/1.png"))) {
	$banner["MODULE_ID"] = "advertising";

	$arBanners[] = Array(
        "CONTRACT_ID"  => 1,
        "TYPE_SID"     => "SIDEBAR_TEXT",
        "STATUS_SID"   => "PUBLISHED",
        "NAME"         => GetMessage("PORTAL_ADV_SIDEBAR_240_400_MAP"),
        "ACTIVE"       => "Y",
        "arrSITE"      => Array(WIZARD_SITE_ID),
        "WEIGHT"       => 100,
        "FIX_SHOW"     => "Y",
        "FIX_CLICK"    => "Y",
        "AD_TYPE"      => "image",
        "arrIMAGE_ID"  => $banner,
        "IMAGE_ALT"    => GetMessage("PORTAL_ADV_SIDEBAR_240_400_MAP"),
        "URL"          => WIZARD_SITE_DIR.$mapGuidePath."/turizm/",
        "URL_TARGET"   => "_blank",
        "STAT_EVENT_1" => "banner",
        "STAT_EVENT_2" => "click",
        "arrWEEKDAY"   => $arWeekday,
        "COMMENTS"     => GetMessage("PORTAL_ADV_SIDEBAR_240_400_MAP"),
	);
}

if ($banner = CFile::MakeFileArray(WIZARD_SERVICE_ABSOLUTE_PATH."/banners/".LANGUAGE_ID."/2.png")) {
    $banner["MODULE_ID"] = "advertising";

    $arBanners[] = Array(
        "CONTRACT_ID"  => 1,
        "TYPE_SID"     => "SIDEBAR_TEXT",
        "STATUS_SID"   => "PUBLISHED",
        "NAME"         => GetMessage("PORTAL_ADV_SIDEBAR_240_400_VACANCIES"),
        "ACTIVE"       => "Y",
        "arrSITE"      => Array(WIZARD_SITE_ID),
        "WEIGHT"       => 200,
        "FIX_SHOW"     => "Y",
        "FIX_CLICK"    => "Y",
        "AD_TYPE"      => "image",
        "arrIMAGE_ID"  => $banner,
        "IMAGE_ALT"    => GetMessage("PORTAL_ADV_SIDEBAR_240_400_VACANCIES"),
        "URL"          => WIZARD_SITE_DIR."about/vacancies/",
        "URL_TARGET"   => "_blank",
        "STAT_EVENT_1" => "banner",
        "STAT_EVENT_2" => "click",
        "arrWEEKDAY"   => $arWeekday,
        "COMMENTS"     => GetMessage("PORTAL_ADV_SIDEBAR_240_400_VACANCIES"),
    );
}

if ($banner = CFile::MakeFileArray(WIZARD_SERVICE_ABSOLUTE_PATH."/banners/".LANGUAGE_ID."/3.png")) {
    $banner["MODULE_ID"] = "advertising";

    $arBanners[] = Array(
        "CONTRACT_ID"  => 1,
        "TYPE_SID"     => "SIDEBAR_TEXT",
        "STATUS_SID"   => "PUBLISHED",
        "NAME"         => GetMessage("PORTAL_ADV_SIDEBAR_240_400_FEEDBACK"),
        "ACTIVE"       => "Y",
        "arrSITE"      => Array(WIZARD_SITE_ID),
        "WEIGHT"       => 300,
        "FIX_SHOW"     => "Y",
        "FIX_CLICK"    => "Y",
        "AD_TYPE"      => "image",
        "arrIMAGE_ID"  => $banner,
        "IMAGE_ALT"    => GetMessage("PORTAL_ADV_SIDEBAR_240_400_FEEDBACK"),
        "URL"          => WIZARD_SITE_DIR."feedback/new.php",
        "URL_TARGET"   => "_blank",
        "STAT_EVENT_1" => "banner",
        "STAT_EVENT_2" => "click",
        "arrWEEKDAY"   => $arWeekday,
        "COMMENTS"     => GetMessage("PORTAL_ADV_SIDEBAR_240_400_FEEDBACK"),
    );
}

foreach ($arBanners as $arFields)
{
	$dbResult = CAdvBanner::GetList($by, $order, Array("SITE" => WIZARD_SITE_ID, "COMMENTS" => $arFields["COMMENTS"], "COMMENTS_EXACT_MATCH" => "Y"), $is_filtered, "N");
	if ($dbResult->Fetch())
		continue;

	CAdvBanner::Set($arFields, "", $CHECK_RIGHTS="N");
}

if (!WIZARD_IS_RERUN)
{
	$APPLICATION->SetGroupRight("advertising", WIZARD_PORTAL_ADMINISTRATION_GROUP, "W");
}
?>
