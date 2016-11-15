<?
IncludeModuleLangFile(__FILE__);

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included !== MODULE_DEMO_EXPIRED) {

    global $MESS;
    include(GetLangFileName($GLOBALS["DOCUMENT_ROOT"] . '/bitrix/modules/main/lang/', '/options.php'));

    include_once($GLOBALS["DOCUMENT_ROOT"] . '/bitrix/modules/bitrix.gossite/include.php');

    if (!$USER->CanDoOperation('view_other_settings') && !$USER->CanDoOperation('edit_other_settings')) {
        $APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
    }

    CModule::IncludeModule('iblock');

    if ($REQUEST_METHOD == "GET" && $USER->CanDoOperation('edit_other_settings') && strlen($RestoreDefaults) > 0 && check_bitrix_sessid()) {
        COption::RemoveOption('bitrix.gossite');
    }
    $arTicketStatus = array(
        "" => GetMessage('GOVERNMENT_OPTION_SELECT')
    );
    if (CModule::IncludeModule("support")) {
        $rsData = CTicketDictionary::GetList($by = "NAME", $order = "ASC", $arFilter = array("TYPE" => "S"),
            $is_filtered);
        while ($arData = $rsData->Fetch()) {
            $arTicketStatus[$arData['ID']] = $arData['NAME'];
        }
    }
    $arSites = array();
    $rsSites = CSite::GetList($by = "sort", $order = "desc", Array());
    $newSites = 0;

    while ($arSite = $rsSites->Fetch()) {
        if (COption::GetOptionString('bitrix.gossite', 'installed', "", $arSite['ID']) == "Y") {
            if (version_compare(COption::GetOptionString("bitrix.gossite", "template_version", false, $arSite['ID']), '4.0.0') >= 0) {
                $arSite["NEW_TEMPLATE"] = "Y";
                $newSites++;
            }
            $arSites[$arSite['ID']] = $arSite;
        }
    }

    CGovernment::InitNames();
    $dbIBlockType = CIBlockType::GetList();
    $arIBTypes    = array();
    $arIB         = array();
    while ($arIBType = $dbIBlockType->Fetch()) {
        if ($arIBTypeData = CIBlockType::GetByIDLang($arIBType["ID"], LANG)) {
            $arIB[$arIBType['ID']]      = array();
            $arIBTypes[$arIBType['ID']] = $arIBTypeData['NAME'];
        }
    }


    $dbIBlock = CIBlock::GetList(array('SORT' => 'ASC'), array('ACTIVE' => 'Y'));
    $arProps  = array();
    while ($arIBlock = $dbIBlock->Fetch()) {
        $arIB[$arIBlock['IBLOCK_TYPE_ID']][$arIBlock['ID']] = $arIBlock['NAME'];

        $properties               = CIBlockProperty::GetList(Array(),
            Array("ACTIVE" => "Y", "IBLOCK_ID" => $arIBlock['ID']));
        $arProps[$arIBlock['ID']] = Array();
        while ($prop_fields = $properties->GetNext()) {
            $arProps[$arIBlock['ID']][$prop_fields["ID"]] = $prop_fields["NAME"];
        }
    }

    $arForms               = array(
        "" => GetMessage('GOVERNMENT_OPTION_SELECT')
    );
    $arFormsFieldsInternet = array(
        "" => GetMessage('GOVERNMENT_OPTION_SELECT')
    );
    $arFormsFieldsReq      = array(
        "" => GetMessage('GOVERNMENT_OPTION_SELECT')
    );

    if (CModule::IncludeModule("form")) {
        $rsForms = CForm::GetList($by = "s_name", $order = "asc", $arFilter = array(), $is_filtered);
        while ($arForm = $rsForms->Fetch()) {
            $arForms[$arForm['ID']] = $arForm['NAME'];
        }
        foreach ($arSites as $arSite) {
            $FORM_ID = COption::GetOptionString('bitrix.gossite', "internet_reception_form_id", "", $arSite['ID']);
            if ($FORM_ID) {
                $rsQuestions = CFormField::GetList($FORM_ID, "N", $by = "s_title", $order = "asc", $arFilter = array(),
                    $is_filtered);
                while ($arQuestion = $rsQuestions->Fetch()) {
                    $arFormsFieldsInternet[$arSite['ID']][$arQuestion['ID']] = $arQuestion['TITLE'];
                }
            }
            $FORM_REQ_ID = COption::GetOptionString('bitrix.gossite', "request_information_form_id", "", $arSite['ID']);
            if ($FORM_REQ_ID) {
                $rsQuestions = CFormField::GetList($FORM_REQ_ID, "N", $by = "s_title", $order = "asc",
                    $arFilter = array(), $is_filtered);
                while ($arQuestion = $rsQuestions->Fetch()) {
                    $arFormsFieldsReq[$arSite['ID']][$arQuestion['ID']] = $arQuestion['TITLE'];
                }
            }
        }
    }

    $arIbSites     = array();
    $arPropsSitesR = array();
    $arPropsSitesO = array();
    $arPropsSitesE = array();
    foreach ($arSites as $arSite) {
        $current_info_ib_type     = COption::GetOptionString('bitrix.gossite', "info_ib_type", 0, $arSite['ID']);
        $arIBSites[$arSite['ID']] = $arIB[$current_info_ib_type];

        $current_objects_ib           = COption::GetOptionString('bitrix.gossite', "objects_ib", 0, $arSite['ID']);
        $arPropsSitesO[$arSite['ID']] = $arProps[$current_objects_ib];

        $current_routes_ib            = COption::GetOptionString('bitrix.gossite', "routes_ib", 0, $arSite['ID']);
        $arPropsSitesR[$arSite['ID']] = $arProps[$current_routes_ib];

        $current_events_ib            = COption::GetOptionString('bitrix.gossite', "events_ib", 0, $arSite['ID']);
        $arPropsSitesE[$arSite['ID']] = $arProps[$current_events_ib];
    }

    $module_id = "bitrix.gossite";

    $bannedOption = array(
        "animation",
        "text1",
        "text2",
        "region",
        "map_city"
    );
    $aTabs     = array(
        array(
            "DIV"     => "general_settings",
            "TAB"     => GetMessage("GOVERNMENT_TAB_SET"),
            "ICON"    => "gossite_settings",
            "TITLE"   => GetMessage("GOVERNMENT_TAB_SET_ALT"),
            "OPTIONS" => array(
                array(
                    "NAME"        => "animation",
                    "CAPTION"     => GetMessage("GOVERNMENT_OPTION_ANIMATION"),
                    "TYPE"        => "select",
                    "DEFAULT"     => 0,
                    "OPTIONS"     => array(
                        0 => GetMessage('GOVERNMENT_OPTION_ANIMATION_VAL_0'),
                        1 => GetMessage('GOVERNMENT_OPTION_ANIMATION_VAL_1'),
                        2 => GetMessage('GOVERNMENT_OPTION_ANIMATION_VAL_2'),
                    ),
                    "NEW_TAB"     => "Y",
                    "EXTRA_TITLE" => GetMessage('GS_COMMON_OPTIONS'),
                ),
                array(
                    "NAME"    => "text1",
                    "CAPTION" => GetMessage("GOVERNMENT_OPTION_TEXT1"),
                    "TYPE"    => "text",
                    "DEFAULT" => GetMessage('GOVERNMENT_M_EDUCATION')
                ),
                array(
                    "NAME"    => "text2",
                    "CAPTION" => GetMessage("GOVERNMENT_OPTION_TEXT2"),
                    "TYPE"    => "text",
                    "DEFAULT" => GetMessage('GOVERNMENT_OFICIAL_SITE')
                ),

                array(
                    "NAME"    => "map_city",
                    "CAPTION" => GetMessage("GOVERNMENT_OPTION_MAP_CITY"),
                    "TYPE"    => "text",
                    "DEFAULT" => ""
                ),
                array(
                    "NAME"    => "region",
                    "CAPTION" => GetMessage("GOVERNMENT_OPTION_REGION"),
                    "TYPE"    => "select",
                    "DEFAULT" => 43,
                    "OPTIONS" => (array("" => GetMessage('GOVERNMENT_OPTION_SELECT')) + CGovernment::GetRegions()),
                ),
                array(
                    "NAME"         => "internet_reception_form_id",
                    "CAPTION"      => GetMessage('GOVERNMENT_OPTION_FORM'),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "OPTIONS"      => $arForms,
                    "EXTRA_TITLE"  => GetMessage('GS_NEW_APPEAL_FORM'),
                    "CHECK_MODULE" => "form",
                ),
                array(
                    "NAME"         => "internet_reception_form_email",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_FORM_EMAIL"),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "OPTIONS"      => $arFormsFieldsInternet,
                    "CHECK_MODULE" => "form",
                    "ARR_BY_SITE"  => "Y"
                ),
                array(
                    "NAME"         => "internet_reception_register_user",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_REGISTER_USER"),
                    "TYPE"         => "checkbox",
                    "DEFAULT"      => "",
                    "VALUE"        => "Y",
                    "CHECK_MODULE" => "form",
                ),
                array(
                    "NAME"         => "internet_reception_support_statuse",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_SUPPORT_STATUSE"),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "CHECK_MODULE" => "support",
                    "OPTIONS"      => $arTicketStatus,
                ),
                array(
                    "NAME"         => "request_information_form_id",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_FORM_REQ"),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "OPTIONS"      => $arForms,
                    "EXTRA_TITLE"  => GetMessage('GS_NEW_REQUEST_FORM'),
                    "CHECK_MODULE" => "form",
                ),
                array(
                    "NAME"         => "request_information_form_email",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_FORM_REQ_EMAIL"),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "OPTIONS"      => $arFormsFieldsReq,
                    "CHECK_MODULE" => "form",
                    "ARR_BY_SITE"  => "Y"
                ),
                array(
                    "NAME"         => "request_information_register_user",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_REQ_REGISTER_USER"),
                    "TYPE"         => "checkbox",
                    "DEFAULT"      => "",
                    "CHECK_MODULE" => "form",
                ),
                array(
                    "NAME"         => "request_information_support_statuse",
                    "CAPTION"      => GetMessage("GOVERNMENT_OPTION_REQ_SUPPORT_STATUSE"),
                    "TYPE"         => "select",
                    "DEFAULT"      => "",
                    "CHECK_MODULE" => "support",
                    "OPTIONS"      => $arTicketStatus,
                ),
            )
        ),
        array(
            "DIV"     => "coat_settings",
            "TAB"     => GetMessage("GOVERNMENT_TAB_COAT"),
            "ICON"    => "gossite_settings",
            "TITLE"   => GetMessage("GOVERNMENT_TAB_COAT_ALT"),
            "OPTIONS" => array(
                array(
                    "NAME"    => "coat",
                    "CAPTION" => GetMessage("GOVERNMENT_OPTION_COAT_CUR"),
                    "TYPE"    => "coat",
                    "DEFAULT" => "/upload/coats/unknown.png",
                    "NEW_TAB" => "Y"
                ),
            )
        ),
    );

    if ($newSites != count($arSites)) {
        $aTabs[] = array(
            "DIV"     => "map_settings",
            "TAB"     => GetMessage("GOVERNMENT_TAB_OBJECTS"),
            "ICON"    => "gossite_settings",
            "TITLE"   => GetMessage("GOVERNMENT_TAB_OBJECTS_ALT"),
            "OPTIONS" => array(

                array(
                    "NAME"        => "info_ib_type",
                    "CAPTION"     => GetMessage("GS_info_iblock_type"),
                    "TYPE"        => "select",
                    "DEFAULT"     => 0,
                    "EXTRA_TITLE" => GetMessage('GOVERNMENT_OBJECTS_ALL_TITLE'),
                    "NEW_TAB"     => "Y",
                    "OPTIONS"     => $arIBTypes,
                    "IBLOCK_TYPE" => "Y"
                ),
                array(
                    "NAME"            => "objects_ib",
                    "CAPTION"         => GetMessage("GS_iblock_objects"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "EXTRA_TITLE"     => GetMessage('GOVERNMENT_OBJECTS_TITLE'),
                    "OPTIONS"         => $arIBSites,
                    "IBLOCK"          => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB'),
                    "INDEX"           => 0,
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "objects_address",
                    "CAPTION"         => GetMessage("GS_iblock_address"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesO,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_ADDRESS'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "objects_lat",
                    "CAPTION"         => GetMessage("GS_iblock_lat"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesO,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LAT'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "objects_lng",
                    "CAPTION"         => GetMessage("GS_iblock_lng"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesO,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LNG'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "routes_types_ib",
                    "CAPTION"         => GetMessage("GS_iblock_routes_types"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "EXTRA_TITLE"     => GetMessage('GOVERNMENT_ROUTES_TITLE'),
                    "OPTIONS"         => $arIBSites,
                    "IBLOCK"          => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "routes_ib",
                    "CAPTION"         => GetMessage("GS_iblock_routes"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arIBSites,
                    "IBLOCK"          => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB'),
                    "INDEX"           => 1,
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "routes_address",
                    "CAPTION"         => GetMessage("GS_iblock_address"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesR,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_ADDRESS'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "routes_lat",
                    "CAPTION"         => GetMessage("GS_iblock_lat"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesR,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LAT'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "routes_lng",
                    "CAPTION"         => GetMessage("GS_iblock_lng"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesR,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LNG'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "events_ib",
                    "CAPTION"         => GetMessage("GS_iblock_events"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arIBSites,
                    "IBLOCK"          => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB'),
                    "EXTRA_TITLE"     => GetMessage('GOVERNMENT_ROUTES_TITLE'),
                    "INDEX"           => 2,
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "events_address",
                    "CAPTION"         => GetMessage("GS_iblock_address"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesE,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_ADDRESS'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "events_lat",
                    "CAPTION"         => GetMessage("GS_iblock_lat"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesE,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LAT'),
                    "ARR_BY_SITE"     => "Y"
                ),
                array(
                    "NAME"            => "events_lng",
                    "CAPTION"         => GetMessage("GS_iblock_lng"),
                    "TYPE"            => "select",
                    "DEFAULT"         => 0,
                    "OPTIONS"         => $arPropsSitesE,
                    "IBLOCK_PROP"     => "Y",
                    "NOT_SELECT_TEXT" => GetMessage('GS_CHOOSE_IB_LNG'),
                    "ARR_BY_SITE"     => "Y"
                ),
            )
        );
    }

    $strWarning = "";
    if ($REQUEST_METHOD == "POST" && strlen($Update) > 0 && $USER->CanDoOperation('edit_other_settings') && check_bitrix_sessid()) {

        foreach ($arSites as $arSite) {
            $siteID = $arSite['ID'];
            foreach ($aTabs as $tapOptions) {
                if ($tab["DIV"] == "map_settings" && $arSite["NEW_TEMPLATE"] == "Y") {
                    continue;
                }
                foreach ($tapOptions["OPTIONS"] as $arOption) {
                    if ($arSite["NEW_TEMPLATE"] == "Y" && in_array($arOption["NAME"], $bannedOption)) {
                        continue;
                    }
                    $name    = $arOption["NAME"] . "_" . $siteID;
                    $nameOpt = $arOption["NAME"];
                    $val     = $$name;
                    if ($arOption["TYPE"] == "checkbox" && $val <> "Y") {
                        $val = "N";
                    }
                    COption::SetOptionString('bitrix.gossite', $nameOpt, $val, $siteID, $siteID);
                }
            }

            if (!empty($_FILES['USER_COAT_' . $siteID]['tmp_name'])) {
                if (!in_array(pathinfo($_FILES['USER_COAT_' . $siteID]['name'], PATHINFO_EXTENSION), array('png', 'jpg', 'jpeg', 'gif'))) {
                    $strWarning = GetMessage("GOVERNMENT_WRONG_COAT_IMAGE_TYPE") . " [" . $siteID . "]";
                } else {
                    move_uploaded_file($_FILES['USER_COAT_' . $siteID]['tmp_name'],
                        $_SERVER['DOCUMENT_ROOT'] . '/upload/coats/user/' . $_FILES['USER_COAT_' . $siteID]['name']);
                    //CGovernment::SaveAsCoat($_FILES['USER_COAT'], $strWarning);
                    COption::SetOptionString('bitrix.gossite', "coat", '/upload/coats/user/' . $_FILES['USER_COAT_' . $siteID]['name'], $siteID, $siteID);
                }
            }
        }
    }

    if (strlen($strWarning) > 0) {
        CAdminMessage::ShowMessage($strWarning);
    }

    $tabControl = new CAdminTabControl("tabControl", $aTabs);

    $tabControl->Begin();
    ?>
    <form method="POST" name="smedia_government_option_form" enctype="multipart/form-data"
          action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialchars($mid) ?>&lang=<?= LANGUAGE_ID ?>">
<?echo bitrix_sessid_post()?>
        <script type="text/javascript">
            var arIB = <?echo CUtil::PhpToJsObject($arIB)?>;
            var arIBProps = <?echo CUtil::PhpToJsObject($arProps)?>;

            // изменение типа инфоблока - изменение полей с ид инфоблоков
            function change_iblock_list(value, index, siteId) {
                if (null == index)
                    index = 0;

                if (value && (!arIB[value] || arIB[value].length <= 0)) return;

                var arControls = [
                    [
                        document.getElementById('objects_ib_' + siteId),
                        document.getElementById('routes_types_ib_' + siteId),
                        document.getElementById('routes_ib_' + siteId),
                        document.getElementById('events_ib_' + siteId)
                    ]
                ];
                for (var i = 0; i < arControls[index].length; i++) {
                    while (arControls[index][i].options.length > 0) arControls[index][i].remove(0);

                    if (value) {
                        for (var j in arIB[value]) {
                            arControls[index][i].options[arControls[index][i].options.length] = new Option(arIB[value][j], j);
                        }
                    }
                    else {
                        arControls[index][i].options[0] = new Option('<?echo GetMessage('GOSPORTAL_CHOOSE_IBTYPE')?>', '');
                    }
                }
            }

            function change_iblock_prop_list(value, index, siteId) {
                if (null == index)
                    index = 0;

                if (value && (!arIBProps[value] || arIBProps[value].length <= 0)) return;

                var arControls = [
                    [
                        document.getElementById('objects_address_' + siteId),
                        document.getElementById('objects_lat_' + siteId),
                        document.getElementById('objects_lng_' + siteId)
                    ],
                    [
                        document.getElementById('routes_address_' + siteId),
                        document.getElementById('routes_lat_' + siteId),
                        document.getElementById('routes_lng_' + siteId)
                    ],
                    [
                        document.getElementById('events_address_' + siteId),
                        document.getElementById('events_lat_' + siteId),
                        document.getElementById('events_lng_' + siteId)
                    ]
                ];

                for (var i = 0; i < arControls[index].length; i++) {
                    while (arControls[index][i].options.length > 0) arControls[index][i].remove(0);

                    if (value) {
                        for (var j in arIBProps[value]) {
                            arControls[index][i].options[arControls[index][i].options.length] = new Option(arIBProps[value][j], j);
                        }
                    }
                    else {
                        arControls[index][i].options[0] = new Option('<?echo GetMessage('GOSPORTAL_CHOOSE_IBTYPE')?>', '');
                    }
                }
            }

            setCoat = function (val, siteId) {
                var coatImg = document.getElementById('coatImg_' + siteId);
                var coatVal = document.getElementById('coatVal_' + siteId);

                if (coatImg && coatVal) {
                    coatImg.src = val;
                    coatVal.value = val;
                }

                return false;
            }
        </script>

        <?
        foreach ($aTabs as $tabIndex => $tab) {
            $tabControl->BeginNextTab();
            ?>
            <tr>
                <td colspan="2">
                    <?
                    $aSiteTabs = array();
                    foreach ($arSites as $arSite) {
                        if ($tab["DIV"] == "map_settings" && $arSite["NEW_TEMPLATE"] == "Y") {
                            continue;
                        }

                        $aSiteTabs[] = array(
                            "DIV"      => "opt_site_" . $arSite["ID"] . "_" . $tabIndex,
                            "TAB"      => '[' . $arSite["ID"] . '] ' . htmlspecialcharsbx($arSite["NAME"]),
                            'TITLE'    => GetMessage("gossite_sett_site") . ' [' . $arSite["ID"] . '] ' . htmlspecialcharsbx($arSite["NAME"]),
                            'ONSELECT' => "document.forms['smedia_government_option_form'].siteTabControl_active_tab.value='opt_site_" . $arSite["ID"] . "_" . $tabIndex . "'"
                        );
                    }

                    $siteTabControl = new CAdminViewTabControl("siteTabControl_" . $tabIndex, $aSiteTabs);
                    $siteTabControl->Begin();

                    foreach ($arSites as $arSite) {
                        if ($tab["DIV"] == "map_settings" && $arSite["NEW_TEMPLATE"] == "Y") {
                            continue;
                        }

                        $suffix = "_" . $arSite['ID'] . "_" . $tabIndex;
                        $siteTabControl->BeginNextTab();
                        ?>
                        <table cellpadding="0" cellspacing="0" border="0" class="edit-table" width="100%"
                               id="site_settings<?= $suffix ?>"<? if ($site <> '' && $arUseOnSites[$site] <> "Y") {
                            echo ' style="display:none"';
                        } ?>>
                            <?
                            foreach ($tab["OPTIONS"] as $arOption) {
                                if ($arSite["NEW_TEMPLATE"] == "Y" && in_array($arOption["NAME"], $bannedOption)) {
                                    continue;
                                }
                                $name = $arOption["NAME"]."_".$arSite["ID"];
                                $nameOpt = $arOption["NAME"];
                                $type = $arOption["TYPE"];
                                $val = COption::GetOptionString($module_id, $nameOpt, $arOption["DEFAULT"], $arSite["ID"]);

                                if ($arOption['EXTRA_TITLE']) {
                                    ?>
                                    <tr class="heading">
                                        <td valign="top" align="center" colspan="2">
                                            <?echo $arOption['EXTRA_TITLE']?>
                                        </td>
                                    </tr>
                                    <?
                                }

                                if($type!=="coat") {
                                    ?>
                                    <tr>
                                        <td width="40%" <? if($type[0]=="textarea" || $type[0]=="text-list") echo 'class="adm-detail-valign-top"'?>>
                                            <label for="<?echo htmlspecialcharsbx($name)?>"><?echo $arOption['CAPTION']?></label>
                                        </td>
                                        <td width="60%">
                                    <?
                                }

                                switch ($type) {
                                    case "coat":
                                        ?>
                                        <input id="coatVal_<?=$arSite["ID"]?>" type="hidden" name="<?=$name?>" value="<?echo $val?>" />
                                        <tr class="heading">
                                            <td valign="top" colspan="2" align="center"><b><?echo GetMessage("GOVERNMENT_OPTION_COAT_CUR")?></b></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" align="center"><img id="coatImg_<?=$arSite["ID"]?>" src="<?echo $val ?>" style="max-width:100%" alt="<?echo GetMessage("GOVERNMENT_OPTION_COAT_CUR")?>" /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr class="heading">
                                            <td valign="top" colspan="2" align="center"><b><?echo GetMessage("GOVERNMENT_OPTION_COAT_CITY")?></b></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2">
                                                <? CGovernment::showCoats('/upload/coats/city/', CGovernment::GetRegionCapitals (), $arSite["ID"]); ?>
                                            </td>
                                        </tr>
                                        <tr class="heading">
                                            <td valign="top" colspan="2" align="center"><b><?echo GetMessage("GOVERNMENT_OPTION_COAT_REGION")?></b></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2">
                                                <? CGovernment::showCoats('/upload/coats/region/', CGovernment::GetRegions(), $arSite["ID"]); ?>
                                            </td>
                                        </tr>
                                        <tr class="heading">
                                            <td valign="top" colspan="2" align="center"><b><?echo GetMessage("GOVERNMENT_OPTION_COAT_USER")?></b></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2">
                                                <? CGovernment::ScanCoats('/upload/coats/user/', $arSite["ID"]); ?>
                                            </td>
                                        </tr>
                                        <tr class="heading">
                                            <td valign="top" colspan="2" align="center"><b><?=GetMessage('GOVERNMENT_LOAD_GERB')?></b></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" align="center">
                                                <input name="USER_COAT_<?=$arSite["ID"]?>" size="20" type="file" />
                                            </td>
                                        </tr>
                                        <?
                                        break;

                                    case "select":
                                        if ($arOption['ARR_BY_SITE']=="Y") {
                                            $arOption["OPTIONS"]=$arOption["OPTIONS"][$arSite["ID"]];
                                        }
                                        ?>
                                        <select <?if($arOption["IBLOCK"]=="Y") { ?>onchange="change_iblock_prop_list(this.value, <?=$arOption['INDEX']?>, '<?=$arSite["ID"]?>');"<? } elseif ($arOption["IBLOCK_TYPE"]=="Y") { ?>onchange="change_iblock_list(this.value, 0, '<?=$arSite["ID"]?>')"<? } ?> id="<?echo htmlspecialcharsbx($name)?>" name="<?echo htmlspecialcharsbx($name)?>">
                                            <?
                                            if($arOption["OPTIONS"]) {
                                                foreach ($arOption["OPTIONS"] as $id=>$title) {
                                                    ?>
                                                    <option value="<?echo $id?>"<? if ($val==$id) { echo " selected"; } ?>>[<?=$id?>] <?echo htmlspecialcharsbx($title)?></option>
                                                    <?
                                                }
                                            } elseif($arOption["NOT_SELECT_TEXT"]) {
                                                ?>
                                                <option value=""><?echo $arOption["NOT_SELECT_TEXT"]?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                        <?
                                        break;
                                    case "checkbox":
                                        ?>
                                        <input type="checkbox" name="<?echo htmlspecialcharsbx($name)?>" id="<?echo htmlspecialcharsbx($name)?>" value="Y" <?if($val=="Y"){echo" checked";}?>>
                                        <?
                                        break;
                                    default:
                                        ?>
                                        <input type="text" value="<?=htmlspecialcharsbx($val)?>" id="<?echo htmlspecialcharsbx($name)?>" name="<?=htmlspecialcharsbx($name)?>" size="50"/>
                                        <?
                                }

                                if($type!=="coat") {
                                    ?>
                                        </td>
                                    </tr>
                                    <?
                                }
                            } // for

                            ?>
                        </table>
                        <?
                    }
                    $siteTabControl->End(); ?>
                </td>
            </tr>
            <?
        }

        $tabControl->Buttons();
        ?>
        <script language="JavaScript">
            function RestoreDefaults() {
                if (confirm('<?echo AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>'))
                    window.location = "<?echo $APPLICATION->GetCurPage()?>?RestoreDefaults=Y&lang=<?echo LANG?>&mid=<?echo urlencode($mid)?>";
            }
        </script>

        <input type="submit" <? if (!$USER->CanDoOperation('edit_other_settings'))
            echo "disabled" ?> name="Update" value="<? echo GetMessage("MAIN_SAVE") ?>">
        <input type="hidden" name="Update" value="Y">
        <input type="reset" name="reset" value="<? echo GetMessage("MAIN_RESET") ?>">
        <input type="button" <? if (!$USER->CanDoOperation('edit_other_settings'))
            echo "disabled" ?> title="<? echo GetMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>" OnClick="RestoreDefaults();"
               value="<? echo GetMessage("MAIN_RESTORE_DEFAULTS") ?>">
        <? $tabControl->End(); ?>
    </form>
    <?
} else {
    ?>
    <form method="post" name="smedia_government_option_form"
          action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&amp;lang=<? echo LANGUAGE_ID ?>">
        <? ShowError(GetMessage('GOVERNMENT_MODULE_DEMO_EXPIRED')) ?>
    </form>
    <?
}
?>