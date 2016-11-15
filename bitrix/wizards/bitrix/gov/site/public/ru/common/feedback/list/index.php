<?
define("NEED_AUTH", true);
define('hide_official_menu',true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мои обращения и запросы ");
	$action = strtolower($_REQUEST['fb_action'] ? $_REQUEST['fb_action'] : 'list');

// или редактируем обращение или смотрим список	
	if ($action=='edit') {
	
		$APPLICATION->IncludeComponent(
			"bitrix:support.ticket.edit",
			"gp_feedback",
			Array(
				"ID" => $_REQUEST["ID"],
				"TICKET_LIST_URL" => "/feedback/list/",
				"MESSAGES_PER_PAGE" => "20",
				"SET_PAGE_TITLE" => "Y",
				"SHOW_COUPON_FIELD" => "N"
			),
		false
		);	
	} else {
		$APPLICATION->IncludeComponent(
			"gosportal:support.ticket.list",
			"",
			Array(
				"TICKET_EDIT_TEMPLATE" => "?ID=#ID#&fb_action=edit",
				"TICKETS_PER_PAGE" => "20",
				"SET_PAGE_TITLE" => "Y"
			),
		false
		);
	}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>