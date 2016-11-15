<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("mail"))
	return;

$wizard =& $this->GetWizard();

$arEventTypeFields = array(
	"LID"           => "ru",
	"EVENT_NAME"    => "DOCUMENTS_SEND",
	"NAME"          => GetMessage("DOCUMENTS_SEND_TYPE_NAME"),
	"DESCRIPTION"   => GetMessage("DOCUMENTS_SEND_TYPE_DESC")
);
$obCEventType = new CEventType;

$rsET = CEventType::GetList(
    array(
        "TYPE_ID" => $arEventTypeFields['EVENT_NAME'],
        "LID"=> "ru"
    )
);
if (!$arET = $rsET->Fetch())
    $obCEventType->Add($arEventTypeFields);

$arMessageFields = array(
	"ACTIVE" => "Y",
	"EVENT_NAME" => "DOCUMENTS_SEND",
	"LID" => array(WIZARD_SITE_ID),
	"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
	"EMAIL_TO" => "#EMAIL_TO#",
	"BCC" => "",
	"SUBJECT" => "#SUBJECT#",
	"MESSAGE" => GetMessage('DOCUMENTS_SEND_MESSAGE'),
	"BODY_TYPE" => "text",
);
$obCEventMessage = new CEventMessage;
$rsMess = CEventMessage::GetList($by="site_id", $order="desc", array("TYPE_ID"=>$arMessageFields['EVENT_NAME'],"SITE_ID"=>WIZARD_SITE_ID));
if(!$rsMess->Fetch())
    $obCEventMessage->Add($arMessageFields);
	
if($wizard->GetVar("installSupport") != "Y")
	return;

$STATUS_IDAccept=8;
$STATUS_IDDec=9;
if(CModule::IncludeModule("support"))
{
    $rsStatus = CTicketDictionary::GetList($by="s_id", $sort="asc", $arFilter=array("TYPE"=>"S","LID"=>WIZARD_SITE_ID), $is_filtered);
    if($arRes = $rsStatus->Fetch()) {
        if($arRes['SID']=="processed")
            $STATUS_IDAccept=$arRes['ID'];
        elseif($arRes['SID']=="denied")
            $STATUS_IDDec=$arRes['ID'];
    }
}
$phpProcessor = '
if (CModule::IncludeModule("iblock") && CModule::IncludeModule("support")) {

    $arAnswer = array(
        "TEXT"      => "",
        "ID"        => 0,
    );   
    
    if (preg_match("#<TEXT>(.+)</TEXT>#isU", $arMessageFields["BODY"], $matches)) {
        $arAnswer["TEXT"] = str_replace(array(" ","(",")","<br />"),array(" ","(",")","\n"),$matches[1]);   
    }     
      
    if (preg_match("#<ID>(.+)</ID>#isU", $arMessageFields["BODY"], $matches)) {
        $arAnswer["ID"] = $matches[1];   
    }  
    $dbTicket = CTicket::GetByID($arAnswer["ID"],LANG,"N");
    if ($arTicket = $dbTicket->GetNext()) { 
            if(!$arMessageFields["FIELD_FROM"])
            	$STATUS_ID='.$STATUS_IDDec.';
            else 
            	$STATUS_ID='.$STATUS_IDAccept.';
                 
            $arFields = array(
                "MODIFIED_MODULE_NAME"      => "mail",
                "OWNER_SID"                 => $arTicket["OWNER_SID"],
                "SOURCE_SID"                => "email",
                "MESSAGE_AUTHOR_SID"        => "system",
                "MESSAGE_SOURCE_SID"        => "email",
                "TITLE"                     => "",
                "MESSAGE"                   => $arAnswer["TEXT"],
                "STATUS_ID" => $STATUS_ID,
            );            
            $tmp=CTicket::Set($arFields, $messageID, $arAnswer["ID"],"N");

        }
}
';

$arFields = array(
    "ACTIVE"          => "Y",
    "LID"             => WIZARD_SITE_ID,
    "NAME"            => GetMessage("MAIL_MAILBOX_NAME"),
    "SERVER"          => $wizard->GetVar("supportServer"), 
    "PORT"            => $wizard->GetVar("supportPort"),
    "RELAY"           => "N",
    "AUTH_RELAY"      => "N",
    "DOMAINS"         => "",
    "SERVER_TYPE"     => "pop7",
    "LOGIN"           => $wizard->GetVar("supportLogin"),
    "PASSWORD"        => $wizard->GetVar("supportPassword"),
    "CHARSET"         => "",
    "USE_MD5"         => "",
    "DELETE_MESSAGES" => "",
    "PERIOD_CHECK"    => "60",
    "DESCRIPTION"     => "",
    "MAX_MSG_COUNT"   => "50",
    "USE_TLS"         => "N",
);

if ($mailboxID = CMailbox::Add($arFields)) {
    $arFields = array(
        "ACTIVE"               => "Y",
        "MAILBOX_ID"           => $mailboxID,
        "PARENT_FILTER_ID"     => false,
        "NAME"                 => GetMessage("MAIL_RULE_NAME"),
        "SORT"                 => "500",
        "PHP_CONDITION"        => "",
        "WHEN_MAIL_RECEIVED"   => "Y",
        "WHEN_MANUALLY_RUN"    => "Y",
        "SPAM_RATING"          => "",
        "SPAM_RATING_TYPE"     => "<",
        "MESSAGE_SIZE"         => "",
        "MESSAGE_SIZE_TYPE"    => "<",
        "MESSAGE_SIZE_UNIT"    => "b",
        "DESCRIPTION"          => "",
        "CONDITIONS"           => array(
            "n1" => array(
                "TYPE"         => "SUBJECT",
                "COMPARE_TYPE" => "CONTAIN",
                "STRINGS"      => "SYS_ANSWER",
            ),
        ),
        "ACTION_STOP_EXEC"      => "Y",
        "ACTION_DELETE_MESSAGE" => "",
        "ACTION_READ"           => "Y",
        "ACTION_SPAM"           => "",
        "ACTION_PHP"            => $phpProcessor,
        "ACTION_TYPE"           => "",
    );

    CMailFilter::Add($arFields);
}

$phpProcessor='
if (CModule::IncludeModule("iblock") && CModule::IncludeModule("support")) {

    $arAnswer = array(
        "TEXT"      => "",
        "ID"        => 0,
    );

    if (preg_match("#<REGNOMER>(.+)</REGNOMER>#isU", $arMessageFields["BODY"], $matches)) {
        $arAnswer["REGNOMER"] = $matches[1];
    }

    if (preg_match("#<ID>(.+)</ID>#isU", $arMessageFields["BODY"], $matches)) {
        $arAnswer["ID"] = $matches[1];
    }

    $dbTicket = CTicket::GetByID($arAnswer["ID"],LANG,"N");
    //if ($dbTicket)
        if ($arTicket = $dbTicket->GetNext()) {

            $arFields = array(
                "MODIFIED_MODULE_NAME"      => "mail",
                "SUPPORT_COMMENTS"   => $arAnswer["REGNOMER"],
            );

            $tmp=CTicket::Set($arFields, $messageID, $arAnswer["ID"],"N");

        }
}
';

if ($mailboxID) {
    $arFields = array(
        "ACTIVE"               => "Y",
        "MAILBOX_ID"           => $mailboxID,
        "PARENT_FILTER_ID"     => false,
        "NAME"                 => GetMessage("MAIL_RULE_NAME_2"),
        "SORT"                 => "500",
        "PHP_CONDITION"        => "",
        "WHEN_MAIL_RECEIVED"   => "Y",
        "WHEN_MANUALLY_RUN"    => "Y",
        "SPAM_RATING"          => "",
        "SPAM_RATING_TYPE"     => "<",
        "MESSAGE_SIZE"         => "",
        "MESSAGE_SIZE_TYPE"    => "<",
        "MESSAGE_SIZE_UNIT"    => "b",
        "DESCRIPTION"          => "",
        "CONDITIONS"           => array(
            "n1" => array(
                "TYPE"         => "SUBJECT",
                "COMPARE_TYPE" => "CONTAIN",
                "STRINGS"      => "SYS_ADDED",
            ),
        ),
        "ACTION_STOP_EXEC"      => "Y",
        "ACTION_DELETE_MESSAGE" => "",
        "ACTION_READ"           => "Y",
        "ACTION_SPAM"           => "",
        "ACTION_PHP"            => $phpProcessor,
        "ACTION_TYPE"           => "",
    );

    CMailFilter::Add($arFields);
}


$arEventTypeFields = array(
    "LID"           => "ru",
    "EVENT_NAME"    => "TICKET_NEW_FOR_EXCHANGE",
    "NAME"          => GetMessage("MAIL_TYPE_NAME"),
    "DESCRIPTION"   => GetMessage("MAIL_TYPE_DESC")
);
$obCEventType = new CEventType;
$rsET = CEventType::GetList(
    array(
        "TYPE_ID" => $arEventTypeFields['EVENT_NAME'],
        "LID"=> "ru"
    )
);
if (!$arET = $rsET->Fetch())
    $obCEventType->Add($arEventTypeFields);

$arMessageFields = array(
    "ACTIVE" => "Y",
    "EVENT_NAME" => "TICKET_NEW_FOR_EXCHANGE",
    "LID" => array(WIZARD_SITE_ID),
    "EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
    "EMAIL_TO" => $wizard->GetVar("supportEMail"),
    "BCC" => "",
    "SUBJECT" => "SYS_SUPPORT",
    "MESSAGE" => "
<REQUEST>
<ID>#ID#</ID>
<DATETIME>#DATETIME#</DATETIME>
<NAME>#NAME#</NAME>
<TEXT>#TEXT#</TEXT>
<TYPE>#TYPE#</TYPE>
<ADDRESS>#ADDRESS#</ADDRESS>
<PHONE>#PHONE#</PHONE>
<EMAIL>#EMAIL#</EMAIL>
</REQUEST>", 
    "BODY_TYPE" => "text",
);
$obCEventMessage = new CEventMessage;
$obCEventMessage = new CEventMessage;
$rsMess = CEventMessage::GetList($by="site_id", $order="desc", array("TYPE_ID"=>$arMessageFields['EVENT_NAME'],"SITE_ID"=>WIZARD_SITE_ID));
if(!$rsMess->Fetch())
    $obCEventMessage->Add($arMessageFields);

?>