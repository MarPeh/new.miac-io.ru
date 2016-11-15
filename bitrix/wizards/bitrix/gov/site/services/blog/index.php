<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("blog"))
	return;

$dbGroup = CBlogGroup::GetList(Array(), Array("SITE_ID" => WIZARD_SITE_ID));
if($dbGroup->SelectedRowsCount() > 0)
	return;

COption::SetOptionString('blog','avatar_max_size','30000');
COption::SetOptionString('blog','avatar_max_width','100');
COption::SetOptionString('blog','avatar_max_height','100');
COption::SetOptionString('blog','image_max_width','600');
COption::SetOptionString('blog','image_max_height','600');
COption::SetOptionString('blog','allow_alias','Y');
COption::SetOptionString('blog','block_url_change','Y');
COption::SetOptionString('blog','GROUP_DEFAULT_RIGHT','D');
COption::SetOptionString('blog','show_ip','N');
COption::SetOptionString('blog','enable_trackback','N');
COption::SetOptionString('blog','allow_html','N');

$APPLICATION->SetGroupRight("blog", WIZARD_PORTAL_ADMINISTRATION_GROUP, "W");
COption::SetOptionString("blog", "GROUP_DEFAULT_RIGHT", "D");

$groupID = CBlogGroup::Add(Array("SITE_ID" => WIZARD_SITE_ID, "NAME" => GetMessage("BLOG_GROUP_NAME")));

$blogID = CBlog::Add(
	Array(
		"NAME" => GetMessage("BLOG_NAME"),
		"DESCRIPTION" => GetMessage("BLOG_DESCRIPTION"),
		"GROUP_ID" => $groupID,
		"ENABLE_IMG_VERIF" => 'Y',
		"EMAIL_NOTIFY" => 'Y',
		"ENABLE_RSS" => "Y",
		"URL" => "company_".WIZARD_SITE_ID,
		"ACTIVE" => "Y",
		"=DATE_CREATE" => $DB->GetNowFunction(),
		"=DATE_UPDATE" => $DB->GetNowFunction(),
		"OWNER_ID" => 1,
		"PERMS_POST" => Array("1" => BLOG_PERMS_READ, "2" => BLOG_PERMS_READ), 
		"PERMS_COMMENT" => array("1" => BLOG_PERMS_WRITE , "2" => BLOG_PERMS_WRITE),
	)
);

$postID = CBlogPost::Add(
	Array(
		"TITLE" => GetMessage("BLOG_POST_TITLE"),
		"DETAIL_TEXT" => GetMessage("BLOG_POST_BODY"),
		"DETAIL_TEXT_TYPE" => "text",
		"BLOG_ID" => $blogID,
		"AUTHOR_ID" => 1,
		"=DATE_CREATE" => $DB->GetNowFunction(),
		"=DATE_PUBLISH" => $DB->GetNowFunction(),
		"PUBLISH_STATUS" => BLOG_PUBLISH_STATUS_PUBLISH,
		"ENABLE_TRACKBACK" => 'N',
		"ENABLE_COMMENTS" => 'Y',
		"PERMS_P" => Array(1 => BLOG_PERMS_READ, 2 => BLOG_PERMS_READ),
		"PERMS_C" => Array(1 => BLOG_PERMS_WRITE, 2 => BLOG_PERMS_WRITE)
	)
);
?>