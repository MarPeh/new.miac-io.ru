<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)die();

$arGroups = Array(
    Array(
        "ACTIVE"       => "Y",
        "C_SORT"       => 6,
        "NAME"         => GetMessage("PORTAL_ADMINISTRATION_GROUP_NAME"),
        "DESCRIPTION"  => GetMessage("PORTAL_ADMINISTRATION_GROUP_DESC"),
        "STRING_ID"    => "PORTAL_ADMINISTRATION",
        "TASKS_MODULE" => Array("main_edit_subordinate_users"),
        "TASKS_FILE"   => Array(
            Array("fm_folder_access_full", "/"),
            Array("fm_folder_access_read", "/bitrix/admin/"),
        ),
    ),
    Array(
        "ACTIVE"       => "Y",
        "C_SORT"       => 10,
        "NAME"         => GetMessage("SUPPORT_GROUP_NAME"),
        "DESCRIPTION"  => GetMessage("SUPPORT_GROUP_DESC"),
        "STRING_ID"    => "SUPPORT",
        "TASKS_MODULE" => Array(),
        "TASKS_FILE"   => Array(
            Array("fm_folder_access_read", "/bitrix/admin/"),
        ),
    ),

);

$group = new CGroup;
foreach ($arGroups as $arGroup) {
    //Add Group
    $dbResult = CGroup::GetList($by, $order,
        Array("STRING_ID" => $arGroup["STRING_ID"], "STRING_ID_EXACT_MATCH" => "Y"));
    if ($arExistsGroup = $dbResult->Fetch()) {
        $groupID = $arExistsGroup["ID"];
    } else {
        $groupID = $group->Add($arGroup);
    }

    if ($groupID <= 0) {
        continue;
    }

    if (WIZARD_IS_RERUN === false) {
        if ($arGroup["STRING_ID"] == "EMPLOYEES") {
            COption::SetOptionString("main", "new_user_registration_def_group", $groupID);
        }

        //Set tasks binding to module
        $arTasksID = Array();
        foreach ($arGroup["TASKS_MODULE"] as $taskName) {
            $dbResult = CTask::GetList(Array(), Array("NAME" => $taskName));
            if ($arTask = $dbResult->Fetch()) {
                $arTasksID[] = $arTask["ID"];
            }
        }

        if (!empty($arTasksID)) {
            CGroup::SetTasks($groupID, $arTasksID, true);
        }

        //Set tasks binding to file
        foreach ($arGroup["TASKS_FILE"] as $arFile) {
            $taskName = $arFile[0];
            $filePath = $arFile[1];

            $dbResult = CTask::GetList(Array(), Array("NAME" => $taskName));
            if ($arTask = $dbResult->Fetch()) {
                WizardServices::SetFilePermission(Array(WIZARD_SITE_ID, $filePath),
                    Array($groupID => "T_" . $arTask["ID"]));
            }
        }
    }
}
?>