<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

$wizard->GetVar("typeID");
$suffix = substr($wizard->GetVar("typeID"), 5);
	
require_once(WIZARD_SERVICE_ABSOLUTE_PATH.'/my_csv_user_import.php');
						
$wizard =&$this->GetWizard();
$add_path=$wizard->GetVar("install_data");
$csvImport = new CSVUserImport(WIZARD_SERVICE_ABSOLUTE_PATH.'/lang/'.LANGUAGE_ID.'/'.$suffix .'.csv', '*');
$csvImport->IgnoreDuplicate($ignoreDuplicate = true);

if ($csvImport->IsErrorOccured())
{
	return;
}

//Reference to iblock
$departmentIBlockID = 0;
if (CModule::IncludeModule("iblock")){

	$res = CIBlock::GetList(
	Array(), 
	Array(
		"CODE"=>"new_struct_".WIZARD_SITE_ID
	), true
	);
	if($ar_res = $res->Fetch())
	{
		$departmentIBlockID=$ar_res['ID'];
	}
}

$csvImport->ServiceBlockId = $service_block;

$csvImport->AttachUsersToIBlock($departmentIBlockID);
$csvImport->AttachIBlockSectors($sectors_block);
$csvImport->AttachIBlockShedules($shedules_block);
$csvImport->AttachIBlockStruc($struc_block);

$csvImport->SetImageFilePath(WIZARD_SERVICE_RELATIVE_PATH."/photos/");

$csvFile =& $csvImport->GetCsvObject();
$position = (isset($_SESSION["WIZARD_USER_IMPORT_POSITION"]) && intval($_SESSION["WIZARD_USER_IMPORT_POSITION"]) > 0 ? intval($_SESSION["WIZARD_USER_IMPORT_POSITION"]) : false);
if ($position !== false)
	$csvFile->SetPos($position);

$userImportCnt = 0;
while ($csvImport->ImportUser())
{
	$userImportCnt++;

	if ($userImportCnt >= 50)
	{
		$_SESSION["WIZARD_USER_IMPORT_POSITION"] = $csvFile->GetPos();
		return;
	}
}
?>