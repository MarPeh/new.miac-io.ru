<?
$arNewUrlRewrite=array(	
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/statistics/benefits/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/statistics/benefits/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/info/projects/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/info/projects/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/info/messages/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/info/messages/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/info/anounces/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/info/anounces/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/vacancies/job/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/vacancies/job/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/info/news/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/info/news/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'administration/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'administration/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'vacancies/list/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'vacancies/list/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/projects/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/projects/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/anounces/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/anounces/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/messages/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/messages/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/news/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/news/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'anounces/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'anounces/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'messages/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'messages/index.php',
	),
	array(
		"CONDITION"	=>	"#^'.WIZARD_SITE_DIR.'regulatory/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:news",
		"PATH"	=>	"'.WIZARD_SITE_DIR.'regulatory/index.php",
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'projects/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'projects/index.php',
	),		
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'events/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'events/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'news/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'news/index.php',
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/for/([0-9]+)/(.+?)/([0-9]+)/([0-9]+)/(.+?)/#",
		"RULE"	=>	"FOR=$1&MODE=$2&SECTION_ID=$3&ELEMENT_ID=$4&PROPERTY=$5&",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."gosserv/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/for/([0-9]+)/(.+?)/([0-9]+)/([0-9]+)/#",
		"RULE"	=>	"FOR=$1&MODE=$2&SECTION_ID=$3&ELEMENT_ID=$4&PROPERTY=MAIN_INFO&",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."gosserv/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/for/([0-9]+)/(.+?)/([0-9]+)/#",
		"RULE"	=>	"FOR=$1&MODE=$2&SECTION_ID=$3&ELEMENT_ID=0",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."blinds/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/for/([0-9]+)/(.+?)/#",
		"RULE"	=>	"FOR=$1&MODE=$2&SECTION_ID=0",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."gosserv/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/for/([0-9]+)/#",
		"RULE"	=>	"FOR=$1&MODE=category",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."gosserv/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."gosserv/#",
		"RULE"	=>	"FOR=0&MODE=category&SECTION_ID=0",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."gosserv/index.php",
	),

	);
 ?>