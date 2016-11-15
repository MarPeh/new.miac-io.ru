<?
/**
 * @global CMain $APPLICATION
 *
 * @param array  $arParams
 * @param array  $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<? if ($arResult["strProfileError"]) { ?>
    <p class="alert alert-warning"><? echo $arResult["strProfileError"]; ?></p>
<? } ?>


<? if ($arResult['DATA_SAVED'] == 'Y') { ?>
    <p class="alert alert-success"><?= GetMessage('PROFILE_DATA_SAVED') ?></p>
<? } ?>

    <script type="text/javascript">
        <!--
        var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
$arResult["opened"] = "reg";
echo "'reg'";
}
?>];
        //-->

        var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
    </script>

    <form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
        <?= $arResult["BX_SESSION_CHECK"] ?>
        <input type="hidden" name="lang" value="<?= LANG ?>"/>
        <input type="hidden" name="ID" value=<?= $arResult["ID"] ?>/>

        <h2>
            <a title="<?= GetMessage("REG_SHOW_HIDE") ?>" href="javascript:void(0)"
               onclick="SectionClick('reg')"><?= GetMessage("REG_SHOW_HIDE") ?></a>
        </h2>

        <div <?= strpos($arResult["opened"], "reg") === false ? "hidden" : "" ?> id="user_div_reg">
            <?
            if ($arResult["ID"] > 0) {
                if (strlen($arResult["arUser"]["TIMESTAMP_X"]) > 0) {
                    ?>
                    <div class="content form-control">
                        <div class="col col-mb-12 col-5 form-label">
                            <? echo GetMessage("LAST_UPDATE") ?>
                        </div>
                        <div class="col col-mb-12 col-7">
                            <input class="input input-block" value="<?= $arResult["arUser"]["TIMESTAMP_X"] ?>" disabled/>
                        </div>
                    </div>
                    <?
                }
                if (strlen($arResult["arUser"]["LAST_LOGIN"]) > 0) {
                    ?>
                    <div class="content form-control">
                        <div class="col col-mb-12 col-5 form-label">
                            <? echo GetMessage("LAST_LOGIN") ?>
                        </div>
                        <div class="col col-mb-12 col-7">
                            <input class="input input-block" value="<?= $arResult["arUser"]["LAST_LOGIN"] ?>" disabled/>
                        </div>
                    </div>
                    <?
                }
            }
            ?>


            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <? echo GetMessage("main_profile_title") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="TITLE" value="<?= $arResult["arUser"]["TITLE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <? echo GetMessage("NAME") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["NAME"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <? echo GetMessage("LAST_NAME") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="LAST_NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["LAST_NAME"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <? echo GetMessage("SECOND_NAME") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="SECOND_NAME" maxlength="50"
                           value="<?= $arResult["arUser"]["SECOND_NAME"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <? echo GetMessage("EMAIL") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block"<? if ($arResult["EMAIL_REQUIRED"]) { ?> required<? } ?> type="text"
                           name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('LOGIN') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" required name="LOGIN" maxlength="50"
                           value="<? echo $arResult["arUser"]["LOGIN"] ?>"/>
                </div>
            </div>
            <? if ($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '') { ?>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('NEW_PASSWORD_REQ') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input class="input input-block" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off"
                               class="bx-auth-input"/>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('NEW_PASSWORD_CONFIRM') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input class="input input-block" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"/>
                    </div>
                </div>
                <p class="alert alert-info"><? echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></p>
            <? } ?>
            <? if ($arResult["TIME_ZONE_ENABLED"] == true) { ?>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('main_profile_time_zones_auto') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <select name="AUTO_TIME_ZONE" onchange="this.form.TIME_ZONE.disabled=(this.value != 'N')">
                            <option value=""><? echo GetMessage("main_profile_time_zones_auto_def") ?></option>
                            <option
                                value="Y"<?= ($arResult["arUser"]["AUTO_TIME_ZONE"] == "Y" ? ' SELECTED="SELECTED"' : '') ?>><? echo GetMessage("main_profile_time_zones_auto_yes") ?></option>
                            <option
                                value="N"<?= ($arResult["arUser"]["AUTO_TIME_ZONE"] == "N" ? ' SELECTED="SELECTED"' : '') ?>><? echo GetMessage("main_profile_time_zones_auto_no") ?></option>
                        </select>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('main_profile_time_zones_zones') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <select name="TIME_ZONE"<? if ($arResult["arUser"]["AUTO_TIME_ZONE"] <> "N")
                            echo ' disabled="disabled"' ?>>
                            <? foreach ($arResult["TIME_ZONE_LIST"] as $tz => $tz_name): ?>
                                <option
                                    value="<?= htmlspecialcharsbx($tz) ?>"<?= ($arResult["arUser"]["TIME_ZONE"] == $tz ? ' SELECTED="SELECTED"' : '') ?>><?= htmlspecialcharsbx($tz_name) ?></option>
                            <? endforeach ?>
                        </select>
                    </div>
                </div>
            <? } ?>
        </div>
        <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
               onclick="SectionClick('personal')"><?= GetMessage("USER_PERSONAL_INFO") ?></a></h2>

        <div id="user_div_personal" <?= strpos($arResult["opened"], "personal") === false ? "hidden" : "" ?>>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_PROFESSION') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_PROFESSION" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_PROFESSION"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_WWW') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_WWW" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_WWW"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_ICQ') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_ICQ" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_ICQ"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_GENDER') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <select data-search="false" class="styler input-block" name="PERSONAL_GENDER">
                        <option value=""><?= GetMessage("USER_DONT_KNOW") ?></option>
                        <option
                            value="M"<?= $arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : "" ?>><?= GetMessage("USER_MALE") ?></option>
                        <option
                            value="F"<?= $arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : "" ?>><?= GetMessage("USER_FEMALE") ?></option>
                    </select>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_BIRTHDAY_DT") ?> (<?= $arResult["DATE_FORMAT"] ?>):
                </div>
                <div class="col col-mb-12 col-7">
                    <?
                    $APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
                            'SHOW_INPUT'  => 'Y',
                            'FORM_NAME'   => 'form1',
                            'INPUT_NAME'  => 'PERSONAL_BIRTHDAY',
                            'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
                            'SHOW_TIME'   => 'N'
                        ), null, array('HIDE_ICONS' => 'Y'));
                    ?>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_PHOTO") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <?= str_replace("class=typefile", "class=\"styler input-block typefile\"", $arResult["arUser"]["PERSONAL_PHOTO_INPUT"]) ?>
                    <?
                    if (strlen($arResult["arUser"]["PERSONAL_PHOTO"]) > 0) {
                        ?>
                        <br/>
                        <?= $arResult["arUser"]["PERSONAL_PHOTO_HTML"] ?>
                        <?
                    }
                    ?>
                </div>
            </div>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <h3><?= GetMessage("USER_PHONES") ?></h3>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_PHONE') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_PHONE" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_FAX') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_FAX" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_FAX"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_MOBILE') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_MOBILE" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_MOBILE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_PAGER') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_PAGER" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_PAGER"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <h3><?= GetMessage("USER_POST_ADDRESS") ?></h3>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_COUNTRY') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <?= str_replace("typeselect", "styler input-block typeselect", $arResult["COUNTRY_SELECT"]) ?>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_STATE') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_STATE" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_STATE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_CITY') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_CITY" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_CITY"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_ZIP') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_ZIP" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_ZIP"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_STREET") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea class="input input-block" cols="30" rows="5"
                              name="PERSONAL_STREET"><?= $arResult["arUser"]["PERSONAL_STREET"] ?></textarea>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_MAILBOX') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="PERSONAL_MAILBOX" maxlength="255"
                           value="<?= $arResult["arUser"]["PERSONAL_MAILBOX"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_NOTES") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea class="input input-block" cols="30" rows="5"
                              name="PERSONAL_NOTES"><?= $arResult["arUser"]["PERSONAL_NOTES"] ?></textarea>
                </div>
            </div>
        </div>

        <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
               onclick="SectionClick('work')"><?= GetMessage("USER_WORK_INFO") ?></a></h2>

        <div id="user_div_work" <?= strpos($arResult["opened"], "work") === false ? "hidden" : "" ?>>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_COMPANY') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_COMPANY" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_COMPANY"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_WWW') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_WWW" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_WWW"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_DEPARTMENT') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_DEPARTMENT" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_DEPARTMENT"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_POSITION') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_POSITION" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_POSITION"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_WORK_PROFILE") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea class="input input-block" cols="30" rows="5"
                              name="WORK_PROFILE"><?= $arResult["arUser"]["WORK_PROFILE"] ?></textarea>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_LOGO") ?>
                </div>
                <div class="col col-mb-12 col-7">

                    <?= str_replace("class=typefile", "class=\"styler input-block typefile\"", $arResult["arUser"]["WORK_LOGO_INPUT"]) ?>
                    <?
                    if (strlen($arResult["arUser"]["WORK_LOGO"]) > 0) {
                        ?>
                        <br/><?= $arResult["arUser"]["WORK_LOGO_HTML"] ?>
                        <?
                    }
                    ?>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <h3><?= GetMessage("USER_PHONES") ?></h3>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_PHONE') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_PHONE" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_PHONE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_FAX') ?></font>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_FAX" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_FAX"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_PAGER') ?></font>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_PAGER" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_PAGER"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <h3><?= GetMessage("USER_POST_ADDRESS") ?></h3>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_COUNTRY') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <?= str_replace("typeselect", "styler input-block typeselect", $arResult["COUNTRY_SELECT_WORK"]) ?>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_STATE') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_STATE" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_STATE"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_CITY') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_CITY" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_CITY"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_ZIP') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_ZIP" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_ZIP"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_STREET") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea class="input input-block" cols="30" rows="5" name="WORK_STREET"><?= $arResult["arUser"]["WORK_STREET"] ?></textarea>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage('USER_MAILBOX') ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" type="text" name="WORK_MAILBOX" maxlength="255"
                           value="<?= $arResult["arUser"]["WORK_MAILBOX"] ?>"/>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?= GetMessage("USER_NOTES") ?>
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea class="input input-block" cols="30" rows="5" name="WORK_NOTES"><?= $arResult["arUser"]["WORK_NOTES"] ?></textarea>
                </div>
            </div>
        </div>
        <?
        if ($arResult["INCLUDE_FORUM"] == "Y") {
            ?>

            <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
                   onclick="SectionClick('forum')"><?= GetMessage("forum_INFO") ?></a></h2>
            <div id="user_div_forum" <?= strpos($arResult["opened"], "forum") === false ? "hidden" : "" ?>>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("forum_SHOW_NAME") ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input type="checkbox" name="forum_SHOW_NAME"
                               value="Y" <? if ($arResult["arForumUser"]["SHOW_NAME"] == "Y") {
                            echo "checked=\"checked\"";
                        } ?> />
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('forum_DESCRIPTION') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input class="input input-block" type="text" name="forum_DESCRIPTION" maxlength="255"
                               value="<?= $arResult["arForumUser"]["DESCRIPTION"] ?>"/>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('forum_INTERESTS') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <textarea class="input input-block" cols="30" rows="5"
                                  name="forum_INTERESTS"><?= $arResult["arForumUser"]["INTERESTS"]; ?></textarea>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("forum_SIGNATURE") ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <textarea class="input input-block" cols="30" rows="5"
                                  name="forum_SIGNATURE"><?= $arResult["arForumUser"]["SIGNATURE"]; ?></textarea>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("forum_AVATAR") ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <?= str_replace("class=typefile", "class=\"styler input-block typefile\"", $arResult["arForumUser"]["AVATAR_INPUT"]) ?>
                        <?
                        if (strlen($arResult["arForumUser"]["AVATAR"]) > 0) {
                            ?>
                            <br/><?= $arResult["arForumUser"]["AVATAR_HTML"] ?>
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?
        }
        ?>
        <?
        if ($arResult["INCLUDE_BLOG"] == "Y") {
            ?>
            <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
                   onclick="SectionClick('blog')"><?= GetMessage("blog_INFO") ?></a></h2>
            <div id="user_div_blog" <?= strpos($arResult["opened"], "blog") === false ? "hidden" : "" ?>>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('blog_ALIAS') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input class="input input-block" type="text" name="blog_ALIAS" maxlength="255"
                               value="<?= $arResult["arBlogUser"]["ALIAS"] ?>"/>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('blog_DESCRIPTION') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input class="input input-block" type="text" name="blog_DESCRIPTION" maxlength="255"
                               value="<?= $arResult["arBlogUser"]["DESCRIPTION"] ?>"/>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage('blog_INTERESTS') ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <textarea class="input input-block" cols="30" rows="5" class="typearea"
                                  name="blog_INTERESTS"><? echo $arResult["arBlogUser"]["INTERESTS"]; ?></textarea>
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("blog_AVATAR") ?>
                    </div>
                    <div class="col col-mb-12 col-7">
                        <?= str_replace("class=typefile", "class=\"styler input-block typefile\"", $arResult["arBlogUser"]["AVATAR_INPUT"]) ?>
                        <?
                        if (strlen($arResult["arBlogUser"]["AVATAR"]) > 0) {
                            ?>
                            <br/><?= $arResult["arBlogUser"]["AVATAR_HTML"] ?>
                            <?
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
        <? if ($arResult["INCLUDE_LEARNING"] == "Y"): ?>
        <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
                onclick="SectionClick('learning')"><?= GetMessage("learning_INFO") ?></a></h2>
            <div id="user_div_learning" <?= strpos($arResult["opened"], "learning") === false ? "hidden" : "" ?>>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("learning_PUBLIC_PROFILE"); ?>:
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input type="checkbox" name="student_PUBLIC_PROFILE"
                               value="Y" <? if ($arResult["arStudent"]["PUBLIC_PROFILE"] == "Y") {
                            echo "checked=\"checked\"";
                        } ?> />
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("learning_RESUME"); ?>:
                    </div>
                    <div class="col col-mb-12 col-7">
                        <textarea class="input input-block" cols="30" rows="5"
                                  name="student_RESUME"><?= $arResult["arStudent"]["RESUME"]; ?></textarea>
                    </div>
                </div>

                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?= GetMessage("learning_TRANSCRIPT"); ?>:
                    </div>
                    <div class="col col-mb-12 col-7">
                        <?= $arResult["arStudent"]["TRANSCRIPT"]; ?>-<?= $arResult["ID"] ?>
                    </div>
                </div>
            </div>
            <? endif; ?>
            <? if ($arResult["IS_ADMIN"]): ?>
                <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
                       onclick="SectionClick('admin')"><?= GetMessage("USER_ADMIN_NOTES") ?></a></h2>
                <div id="user_div_admin" <?= strpos($arResult["opened"], "admin") === false ? "hidden" : "" ?>>
                    <div class="content form-control">
                        <div class="col col-mb-12 col-5 form-label">
                            <?= GetMessage("USER_ADMIN_NOTES") ?>:
                        </div>
                        <div class="col col-mb-12 col-7">
                            <textarea class="input input-block" cols="30" rows="5"
                                      name="ADMIN_NOTES"><?= $arResult["arUser"]["ADMIN_NOTES"] ?></textarea>
                        </div>
                    </div>
                </div>
            <? endif; ?>
            <? // ********************* User properties ***************************************************?>
            <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
                <h2><a title="<?= GetMessage("USER_SHOW_HIDE") ?>" href="javascript:void(0)"
                       onclick="SectionClick('user_properties')"><?= strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB") ?></a>
                </h2>
                <div id="user_div_user_properties" <?= strpos($arResult["opened"], "user_properties") === false ? "hidden" : "" ?>>
                    <? $first = true; ?>
                    <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                        <div class="content form-control">
                            <div class="col col-mb-12 col-5 form-label">
                                <? if ($arUserField["MANDATORY"] == "Y"): ?>
                                    <span class="starrequired">*</span>
                                <? endif; ?>
                                <?= $arUserField["EDIT_FORM_LABEL"] ?>:
                            </div>
                            <div class="col col-mb-12 col-7">
                                <? $APPLICATION->IncludeComponent("bitrix:system.field.edit",
                                    $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                    array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField),
                                    null, array("HIDE_ICONS" => "Y")); ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
            <? // ******************** /User properties ***************************************************?>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="btn" type="submit" name="save"
                           value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
                </div>
            </div>
    </form>