<?
$arNewUrlRewrite=array(
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/inspections/result/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/inspections/index.php',
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."about/videogallery/([0-9]+)/#",
		"RULE"	=>	"ELEMENT_ID=$1&",
		"ID"	=>	"",
		"PATH"	=>	"".WIZARD_SITE_DIR."city/videogallery/index.php",
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/mun-order/selected/#',
		'RULE' => 'selected=Y&',
		'ID' => '',
		'PATH' => ''.WIZARD_SITE_DIR.'about/mun-order/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/photogallery/#',
		'RULE' => '',
		'ID' => 'bitrix:photogallery',
		'PATH' => ''.WIZARD_SITE_DIR.'about/photogallery/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/blogs/#',
		'RULE' => '',
		'ID' => 'bitrix:blog',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/blogs/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/texts/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/texts/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/massmedia/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/massmedia/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/blogs/#',
		'RULE' => '',
		'ID' => 'bitrix:blog',
		'PATH' => ''.WIZARD_SITE_DIR.'officials/blogs/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'exhibition/itogi/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'exhibition/itogi/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'about/mun-order/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'about/mun-order/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'vacancies/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'vacancies/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'documents/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => ''.WIZARD_SITE_DIR.'documents/index.php',
	),
	array(
		'CONDITION' => '#^'.WIZARD_SITE_DIR.'officials/#',
		'RULE' => '',
		'ID' => 'bitrix:news',
		'PATH' => "".WIZARD_SITE_DIR."officials/index.php",
	),
	array(
		"CONDITION"	=>	"#^".WIZARD_SITE_DIR."about/rukovodstvo/#",
		"RULE"	=>	"",
		"ID"	=>	"bitrix:socialnetwork_user",
		"PATH"	=>	"".WIZARD_SITE_DIR."about/rukovodstvo/user.php",
	),
);
 ?>