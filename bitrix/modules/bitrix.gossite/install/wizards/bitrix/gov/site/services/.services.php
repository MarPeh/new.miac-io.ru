<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();


$arServices                      = Array(

    "prepare_install" => array(
        "MODULE_ID" => "main",
        "NAME"      => GetMessage("SERVICE_PREPARE_INSTALL"),
    ),

    "search"         => Array(
        "MODULE_ID" => "search",
        "NAME"      => GetMessage("SERVICE_SEARCH"),
    ),
    "main"           => Array(
        "NAME"   => GetMessage("SERVICE_MAIN_SETTINGS"),
        "STAGES" => Array(
            "template.php",
            "theme.php",
            "groups.php",
            "files.php",
            "options.php",
        ),
    ),
    "advertising"    => Array(
        "NAME" => GetMessage("SERVICE_ADVERTISING"),
    ),
    "blog"           => Array(
        "NAME" => GetMessage("SERVICE_BLOG"),
    ),
    "forum"          => Array(
        "NAME" => GetMessage("SERVICE_FORUM"),
    ),
    "support"        => Array(
        "NAME" => GetMessage("SERVICE_SUPPORT"),
    ),
    "fileman"        => Array(
        "NAME" => GetMessage("SERVICE_FILEMAN"),
        "STAGES" => Array(
            'index.php',
            'menutypes.php',
        ),
    ),
    "statistic"      => Array(
        "NAME" => GetMessage("SERVICE_STATISTIC"),
    ),
    "vote"           => Array(
        "NAME" => GetMessage("SERVICE_VOTE"),
    ),
    "bitrix.gossite" => Array(
        "NAME" => GetMessage("SERVICE_GOVERNMENT"),
    ),
    "mail"           => Array(
        "NAME" => GetMessage("SERVICE_MAIL"),
    ),
    "form"           => Array(
        "NAME"   => GetMessage("SERVICE_FORM"),
        "STAGES" => Array(
            'index.php',
            'results.php',
        ),
    ),

);

$arServices["iblock_collection"] = Array(
    "MODULE_ID" => "iblock",
    "NAME"      => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
    "STAGES"    => Array(
        "types.php",
        "photogallery.php",
        "videogallery.php",
        "heads.php",
        "head_texts.php",
        "benefits.php",
        "documents.php",
        "feedback.php",
        "faq.php",
        "gosserv.php",
        "depart.php",
        "massmedia.php",
        "anounces.php",
        "projects.php",
        "news.php",
        "messages.php",
        "orders.php",
        "results.php",
        "vacancies.php",
        "visits.php",
        "structure.php",
        "normative.php",
        "new_structure.php",
        'request_themes.php',
        'request_info_themes.php',
        'traffic.php',
        'map_objects.php',
        'map_events.php',
        'map_routes.php',
        'iblock_rename.php',
        "slider.php",
        "external.php",
    ),
);

$arServices["users"] = Array(
    "MODULE_ID" => "main",
    "NAME"      => GetMessage("SERVICE_USERS"),
    "STAGES"    => Array(
        "import.php", //Start user import
        "steps/import_step_2.php",
        "steps/import_step_3.php",
        "steps/import_step_4.php",
        "steps/import_step_5.php",
        "steps/import_step_6.php",
        "steps/import_step_7.php",
        "steps/import_step_8.php",
        "steps/import_step_9.php",
        "steps/import_step_10.php",
        "steps/import_end.php", //End user import
    ),
);

$suffix = substr($_SESSION['gsTypeID'], 5);

switch ($suffix) {

    case 'prokuratura':
        $arServices["iblock_prokuratura"] = Array(
            "MODULE_ID" => "iblock",
            "NAME"      => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
            "STAGES"    => Array(
                "podrazdel.php",
                "opor.php",
                "territory_info.php",
                "uum.php",
                "iblock_rename.php",
            ),
        );
        $arServices["vote"]               = Array(
            "NAME" => GetMessage("SERVICE_VOTE"),
        );
        break;

    case 'progr':
        $arServices["iblock_progr"] = Array(
            "MODULE_ID" => "iblock",
            "NAME"      => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
            "STAGES"    => Array(
                "faq.php",
            ),
        );
        $arServices["vote_progr"]   = Array(
            "NAME" => GetMessage("SERVICE_VOTE"),
        );
        break;

    case 'zags':
        $arServices["iblock_zags"] = Array(
            "MODULE_ID" => "iblock",
            "NAME"      => GetMessage("SERVICE_IBLOCK_DEMO_DATA"),
            "STAGES"    => Array(
                "contacts.php",
                "contacts_en.php",
                "department.php",
                "marrige.php",
                "answer.php",
                "reestr.php",
                "blanks.php",
            ),
        );
        $arServices["vote"]        = Array(
            "NAME" => GetMessage("SERVICE_VOTE"),
        );
        break;
    case 'pov':
        $arServices["vote_pov"] = Array(
            "NAME" => GetMessage("SERVICE_VOTE"),
        );
        break;
    default:
        $arServices["vote"] = Array(
            "NAME" => GetMessage("SERVICE_VOTE"),
        );
        break;
}

$arServices["final"] = Array(
    "MODULE_ID" => "main",
    "NAME" => GetMessage("SERVICE_FINAL"),
    "STAGES" => Array(
        'iblock.php',
        'service_sets.php'
    )
);
?>