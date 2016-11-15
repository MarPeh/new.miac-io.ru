<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

// чем выше установен уровень отладки, тем больше информации в логе
define("LOG_LEVEL_RANGE",0);


if (LOG_LEVEL_RANGE>0) {
	$dt = getdate();
	define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/".
		sprintf("%4d-%02d-%02d.txt",$dt["year"],$dt["mon"],$dt["mday"]));
}

function myDbgLog($msg,$log_level = 5) {
	if ($log_level<LOG_LEVEL_RANGE) {
		$strFunctionStack = "";
		if (function_exists("debug_backtrace"))
		{
			$arBacktrace = debug_backtrace();
			$strFunctionStack = "called from:\n";
			$iterationsCount = min(count($arBacktrace), 4);
			for ($i = 1; $i < $iterationsCount; $i++)
			{
				if (strlen($strFunctionStack)>0)
				{
					$strFunctionStack .= "\n";
				}
				if (strlen($arBacktrace[$i]["class"])>0)
				{
					$strFunctionStack .= $arBacktrace[$i]["class"]."::";
				}
				$strFunctionStack .= $arBacktrace[$i]["function"]."\n";
				$strFunctionStack .= "	in file: ".$arBacktrace[$i]["file"]."\n";
				$strFunctionStack .= "	at line: ".$arBacktrace[$i]["line"]."\n";
			}
		} 	
		AddMessage2Log(
			"*** Log level: ".$log_level."\n"
			.$msg."\n"
			.$strFunctionStack
			);
	}
}

function showCounter()
{
	global $USER;
	$arGroups = $USER->GetUserGroupArray();
	$filter = Array
	(
	    "STRING_ID" => "PORTAL_ADMINISTRATION",    
	);
	$edit=false;
	$rsGroups = CGroup::GetList(($by="c_sort"), ($order="desc"), $filter); // выбираем группы
	if($arGropusVio=$rsGroups->GetNext()) 
	{
		if(in_array($arGropusVio['ID'],$arGroups))
			$edit=true;
	}
	if(in_array(1,$arGroups))
		$edit=true;
	return $edit;	
}

function jsTitle()
{
	return CUtil::JSEscape(htmlspecialcharsback($GLOBALS["APPLICATION"]->GetTitle()));
}

function enabledPulldown()
{
	//return "true";
	return $GLOBALS["APPLICATION"]->GetProperty("enable_pulldown") == "Y" ? "true" : "false";
}
?>