<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("user");
?><?$APPLICATION->IncludeComponent("bitrix:socialnetwork_user", "template1", array(
	"ITEM_DETAIL_COUNT" => "32",
	"ITEM_MAIN_COUNT" => "6",
	"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
	"NAME_TEMPLATE" => "#NOBR##LAST_NAME# #NAME##/NOBR#",
	"SHOW_LOGIN" => "Y",
	"CAN_OWNER_EDIT_DESKTOP" => "Y",
	"GROUP_USE_KEYWORDS" => "Y",
	"GROUP_THUMBNAIL_SIZE" => "",
	"LOG_THUMBNAIL_SIZE" => "",
	"LOG_COMMENT_THUMBNAIL_SIZE" => "",
	"LOG_NEW_TEMPLATE" => "N",
	"SM_THEME" => "blue",
	"USE_MAIN_MENU" => "N",
	"USE_SHARE" => "N",
	"SHOW_RATING" => "",
	"RATING_ID" => array(
	),
	"RATING_TYPE" => "",
	"PATH_TO_GROUP" => "",
	"PATH_TO_GROUP_SUBSCRIBE" => "",
	"PATH_TO_GROUP_SEARCH" => "",
	"PATH_TO_SEARCH_EXTERNAL" => "",
	"ALLOW_GROUP_CREATE_REDIRECT_REQUEST" => "Y",
	"GROUP_CREATE_REDIRECT_REQUEST" => "/workgroups/group/#group_id#/user_search/",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/about/rukovodstvo/",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CACHE_TIME_LONG" => "604800",
	"PATH_TO_SMILE" => "/bitrix/images/socialnetwork/smile/",
	"PATH_TO_BLOG_SMILE" => "/bitrix/images/blog/smile/",
	"PATH_TO_FORUM_SMILE" => "/bitrix/images/forum/smile/",
	"SONET_PATH_TO_FORUM_ICON" => "/bitrix/images/forum/icon/",
	"SET_TITLE" => "Y",
	"SET_NAV_CHAIN" => "Y",
	"USER_FIELDS_MAIN" => array(
		3 => "PERSONAL_GENDER",
		4 => "PERSONAL_NOTES",
		5 => "WORK_POSITION",
	),
	"USER_PROPERTY_MAIN" => array(
	),
	"USER_FIELDS_CONTACT" => array(
		0 => "WORK_PHONE",
	),
	"USER_PROPERTY_CONTACT" => array(
	),
	"USER_FIELDS_PERSONAL" => array(
	),
	"USER_PROPERTY_PERSONAL" => array(
	),
	"EDITABLE_FIELDS" => array(
		0 => "LOGIN",
		1 => "NAME",
		2 => "SECOND_NAME",
		3 => "LAST_NAME",
		4 => "EMAIL",
		5 => "TIME_ZONE",
		6 => "LAST_LOGIN",
		7 => "DATE_REGISTER",
		8 => "LID",
		9 => "PASSWORD",
		10 => "PERSONAL_BIRTHDAY",
		11 => "PERSONAL_BIRTHDAY_YEAR",
		12 => "PERSONAL_BIRTHDAY_DAY",
		13 => "PERSONAL_PROFESSION",
		14 => "PERSONAL_WWW",
		15 => "PERSONAL_ICQ",
		16 => "PERSONAL_GENDER",
		17 => "PERSONAL_PHOTO",
		18 => "PERSONAL_NOTES",
		19 => "PERSONAL_PHONE",
		20 => "PERSONAL_FAX",
		21 => "PERSONAL_MOBILE",
		22 => "PERSONAL_PAGER",
		23 => "PERSONAL_COUNTRY",
		24 => "PERSONAL_STATE",
		25 => "PERSONAL_CITY",
		26 => "PERSONAL_ZIP",
		27 => "PERSONAL_STREET",
		28 => "PERSONAL_MAILBOX",
		29 => "WORK_COMPANY",
		30 => "WORK_DEPARTMENT",
		31 => "WORK_POSITION",
		32 => "WORK_WWW",
		33 => "WORK_PROFILE",
		34 => "WORK_LOGO",
		35 => "WORK_NOTES",
		36 => "WORK_PHONE",
		37 => "WORK_FAX",
		38 => "WORK_PAGER",
		39 => "WORK_COUNTRY",
		40 => "WORK_STATE",
		41 => "WORK_CITY",
		42 => "WORK_ZIP",
		43 => "WORK_STREET",
		44 => "WORK_MAILBOX",
		45 => "FORUM_SHOW_NAME",
		46 => "FORUM_DESCRIPTION",
		47 => "FORUM_INTERESTS",
		48 => "FORUM_SIGNATURE",
		49 => "FORUM_AVATAR",
		50 => "FORUM_HIDE_FROM_ONLINE",
		51 => "FORUM_SUBSC_GET_MY_MESSAGE",
		52 => "BLOG_ALIAS",
		53 => "BLOG_DESCRIPTION",
		54 => "BLOG_INTERESTS",
		55 => "BLOG_AVATAR",
	),
	"SHOW_YEAR" => "Y",
	"USER_FIELDS_SEARCH_SIMPLE" => array(
		0 => "PERSONAL_GENDER",
		1 => "PERSONAL_CITY",
	),
	"USER_PROPERTIES_SEARCH_SIMPLE" => array(
	),
	"USER_FIELDS_SEARCH_ADV" => array(
		0 => "PERSONAL_GENDER",
		1 => "PERSONAL_COUNTRY",
		2 => "PERSONAL_CITY",
	),
	"USER_PROPERTIES_SEARCH_ADV" => array(
	),
	"SONET_USER_FIELDS_LIST" => array(
		0 => "PERSONAL_BIRTHDAY",
		1 => "PERSONAL_GENDER",
		2 => "PERSONAL_CITY",
	),
	"SONET_USER_PROPERTY_LIST" => array(
	),
	"SONET_USER_FIELDS_SEARCHABLE" => array(
	),
	"SONET_USER_PROPERTY_SEARCHABLE" => array(
	),
	"ALLOW_RATING_SORT" => "N",
	"BLOG_GROUP_ID" => "1",
	"ALLOW_POST_MOVE" => "N",
	"PATH_TO_GROUP_POST" => "/workgroups/group/#group_id#/blog/#post_id#/",
	"PATH_TO_GROUP_MICROBLOG" => "/workgroups/group/#group_id#/microblog/",
	"BLOG_IMAGE_MAX_WIDTH" => "800",
	"BLOG_IMAGE_MAX_HEIGHT" => "800",
	"BLOG_COMMENT_AJAX_POST" => "N",
	"BLOG_COMMENT_ALLOW_VIDEO" => "N",
	"BLOG_COMMENT_ALLOW_IMAGE_UPLOAD" => "A",
	"BLOG_SHOW_SPAM" => "N",
	"BLOG_NO_URL_IN_COMMENTS" => "",
	"BLOG_NO_URL_IN_COMMENTS_AUTHORITY" => "",
	"BLOG_ALLOW_POST_CODE" => "Y",
	"BLOG_USE_GOOGLE_CODE" => "Y",
	"BLOG_USE_CUT" => "N",
	"FORUM_ID" => "1",
	"FORUM_THEME" => "blue",
	"SHOW_VOTE" => "N",
	"FORUM_AJAX_POST" => "N",
	"PHOTO_USER_IBLOCK_TYPE" => "news",
	"PHOTO_USER_IBLOCK_ID" => "13",
	"PHOTO_MODERATION" => "N",
	"PHOTO_SECTION_PAGE_ELEMENTS" => "15",
	"PHOTO_ELEMENTS_PAGE_ELEMENTS" => "50",
	"PHOTO_ALBUM_PHOTO_THUMBS_SIZE" => "120",
	"PHOTO_THUMBNAIL_SIZE" => "100",
	"PHOTO_ORIGINAL_SIZE" => "1280",
	"PHOTO_UPLOADER_TYPE" => "applet",
	"PHOTO_WATERMARK_MIN_PICTURE_SIZE" => "400",
	"PHOTO_PATH_TO_FONT" => "",
	"PHOTO_SHOW_WATERMARK" => "Y",
	"PHOTO_WATERMARK_RULES" => "USER",
	"PHOTO_UPLOAD_MAX_FILESIZE" => "2",
	"PHOTO_USE_RATING" => "N",
	"PHOTO_USE_COMMENTS" => "N",
	"PATH_TO_GROUP_PHOTO" => "/workgroups/group/#group_id#/photo/",
	"PATH_TO_GROUP_PHOTO_SECTION" => "/workgroups/group/#group_id#/photo/album/#section_id#/",
	"PATH_TO_GROUP_PHOTO_ELEMENT" => "/workgroups/group/#group_id#/photo/#section_id#/#element_id#/",
	"LOG_PHOTO_COUNT" => "6",
	"LOG_PHOTO_THUMBNAIL_SIZE" => "48",
	"SEARCH_DEFAULT_SORT" => "rank",
	"SEARCH_PAGE_RESULT_COUNT" => "10",
	"SEARCH_TAGS_PAGE_ELEMENTS" => "100",
	"SEARCH_TAGS_PERIOD" => "",
	"SEARCH_TAGS_FONT_MAX" => "50",
	"SEARCH_TAGS_FONT_MIN" => "10",
	"SEARCH_TAGS_COLOR_NEW" => "3E74E6",
	"SEARCH_TAGS_COLOR_OLD" => "C0C0C0",
	"SEARCH_FILTER_NAME" => "sonet_search_filter",
	"SEARCH_FILTER_DATE_NAME" => "sonet_search_filter_date",
	"PHOTO_APPLET_LAYOUT" => "simple",
	"SEF_URL_TEMPLATES" => array(
		"index" => "index.php",
		"user_reindex" => "user_reindex.php",
		"user_content_search" => "user/#user_id#/search/",
		"user" => "user/#user_id#/",
		"user_friends" => "user/#user_id#/friends/",
		"user_friends_add" => "user/#user_id#/friends/add/",
		"user_friends_delete" => "user/#user_id#/friends/delete/",
		"user_groups" => "user/#user_id#/groups/",
		"user_groups_add" => "user/#user_id#/groups/add/",
		"group_create" => "user/#user_id#/groups/create/",
		"user_profile_edit" => "user/#user_id#/edit/",
		"user_settings_edit" => "user/#user_id#/settings/",
		"user_features" => "user/#user_id#/features/",
		"group_request_group_search" => "group/#user_id#/group_search/",
		"group_request_user" => "group/#group_id#/user/#user_id#/request/",
		"search" => "search.php",
		"message_form" => "messages/form/#user_id#/",
		"message_form_mess" => "messages/chat/#user_id#/#message_id#/",
		"user_ban" => "messages/ban/",
		"messages_chat" => "messages/chat/#user_id#/",
		"messages_input" => "messages/input/",
		"messages_input_user" => "messages/input/#user_id#/",
		"messages_output" => "messages/output/",
		"messages_output_user" => "messages/output/#user_id#/",
		"messages_users" => "messages/",
		"messages_users_messages" => "messages/#user_id#/",
		"log" => "log/",
		"activity" => "user/#user_id#/activity/",
		"subscribe" => "subscribe/",
		"user_subscribe" => "user/#user_id#/subscribe/",
		"user_photo" => "user/#user_id#/photo/",
		"user_calendar" => "user/#user_id#/calendar/",
		"user_files" => "user/#user_id#/files/lib/#path#",
		"user_blog" => "user/#user_id#/blog/",
		"user_blog_post_edit" => "user/#user_id#/blog/edit/#post_id#/",
		"user_blog_rss" => "user/#user_id#/blog/rss/#type#/",
		"user_blog_draft" => "user/#user_id#/blog/draft/",
		"user_blog_post" => "user/#user_id#/blog/#post_id#/",
		"user_blog_moderation" => "user/#user_id#/blog/moderation/",
		"user_microblog" => "user/#user_id#/microblog/",
		"user_microblog_post" => "user/#user_id#/microblog/#post_id#/",
		"user_forum" => "user/#user_id#/forum/",
		"user_forum_topic_edit" => "user/#user_id#/forum/edit/#topic_id#/",
		"user_forum_topic" => "user/#user_id#/forum/#topic_id#/",
		"bizproc" => "bizproc/",
		"bizproc_edit" => "bizproc/#task_id#/",
		"video_call" => "video/#user_id#/",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>