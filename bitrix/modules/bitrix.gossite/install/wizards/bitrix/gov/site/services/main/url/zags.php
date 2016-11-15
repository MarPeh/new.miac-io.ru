<?
$arNewUrlRewrite=array(
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'feedback/blanks.php#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'feedback/blanks.php',
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."info/videogallery/([0-9]+)/#",
		"RULE"	=>	"ELEMENT_ID=$1&",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."info/videogallery/index.php",
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/mun-order/selected/#',
		'RULE' => 'selected=Y&',
		'ID' => '',
		'PATH' => ''.WIZARD_SITE_DIR.'about/mun-order/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/photogallery/#',
		'RULE' => '',
		'ID' => 'bitrix:photogallery',
		'PATH' => ''.WIZARD_SITE_DIR.'info/photogallery/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/officials/blogs/#',
		'RULE' => '',
		'ID' => 'bitrix:blog',
		'PATH' => ''.WIZARD_SITE_DIR.'about/officials/blogs/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/officials/texts/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/officials/texts/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/massmedia/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/massmedia/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/visits/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/visits/index.php',
	),	
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/documents/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/documents/index.php',
	),	
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/mun-order/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/mun-order/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/officials/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/officials/index.php',
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."about/rukovodstvo/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:socialnetwork_user",
		"PATH"	=>	"".WIZARD_SITE_DIR."about/rukovodstvo/user.php",
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
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'info/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'info/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/inspections/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/inspections/index.php',
	),
);
 ?>