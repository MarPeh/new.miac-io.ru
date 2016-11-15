<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Журнал операций");
$APPLICATION->AddChainItem("Журнал операций", "");
?><?$APPLICATION->IncludeComponent("bitrix:event_list", ".default", array(
	"USER_PATH" => "/bitrix/admin/user_edit.php?ID=#user_id#",
	"FORUM_PATH" => "",
	"FORUM_TOPIC_PATH" => "",
	"FORUM_MESSAGE_PATH" => "",
	"PAGE_NUM" => "10",
	"FILTER" => array(
		0 => "USERS",
		1 => "14",
		2 => "11",
		3 => "15",
		4 => "1",
		5 => "18",
		6 => "12",
		7 => "PAGE_EDIT",
		8 => "MENU_EDIT",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>