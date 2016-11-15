<?
$arNewUrlRewrite=array(
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."program/videogallery/([0-9]+)/#",
		"RULE"	=>	"ELEMENT_ID=$1&",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."city/videogallery/index.php",
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/mun-order/selected/#',
		'RULE' => 'selected=Y&',
		'ID' => '',
		'PATH' => ''.WIZARD_SITE_DIR.'program/mun-order/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/photogallery/#',
		'RULE' => '',
		'ID' => 'bitrix:photogallery',
		'PATH' => ''.WIZARD_SITE_DIR.'program/photogallery/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/blogs//#',
		'RULE' => '',
		'ID' => 'bitrix:blog',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/blogs//index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/texts/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/texts/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/massmedia/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'program/massmedia/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/blogs/#',
		'RULE' => '',
		'ID' => 'bitrix:blog',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/blogs/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'photogallery/#',
		'RULE' => '',
		'ID' => 'bitrix:photogallery',
		'PATH' => ''.WIZARD_SITE_DIR.'photogallery/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/statistics/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'program/statistics/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'documents/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'documents/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/vacancies/job/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'program/vacancies/job/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'program/mun-order/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'program/mun-order/index.php',
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."program/rukovodstvo/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:socialnetwork_user",
		"PATH"	=>	"".WIZARD_SITE_DIR."program/rukovodstvo/user.php",
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/projects/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/projects/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/messages/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/messages/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/anounces/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/anounces/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/news/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/news/index.php',
	),
);
 ?>