<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<? if (is_array($arParams["~AUTH_RESULT"])) { ?>
    <p class="alert <?echo $arParams["~AUTH_RESULT"]["TYPE"] != "ERROR" ? "alert-success" : "alert-error" ?>"><?echo $arParams["~AUTH_RESULT"]["MESSAGE"];?></p>
<? } ?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
    <p class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></p>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
    <p><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
<?endif?>
    <noindex>
        <form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
            <?
            if (strlen($arResult["BACKURL"]) > 0)
            {
                ?>
                <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?
            }
            ?>
            <input type="hidden" name="AUTH_FORM" value="Y" />
            <input type="hidden" name="TYPE" value="REGISTRATION" />

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_NAME")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="bx-auth-input" />
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_LAST_NAME")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="bx-auth-input" />
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_LOGIN_MIN")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" required type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="bx-auth-input" />
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_PASSWORD_REQ")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" required type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_CONFIRM")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" required type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("AUTH_EMAIL")?>
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input"<? if ($arResult["EMAIL_REQUIRED"]) { ?> required<? } ?> type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="bx-auth-input" />
                </div>
            </div>

            <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y") { ?>

                <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField) { ?>
                    <div class="content form-control">
                        <div class="col col-mb-12 col-5 form-label">
                            <?=$arUserField["EDIT_FORM_LABEL"]?>
                        </div>
                        <div class="col col-mb-12 col-7">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:system.field.edit",
                                $arUserField["USER_TYPE"]["USER_TYPE_ID"],
                                array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
                        </div>
                    </div>
                <? } ?>
            <? } ?>

            <? if ($arResult["USE_CAPTCHA"] == "Y") { ?>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                        <?echo GetMessage("CAPTCHA_REGF_PROMT")?>:
                    </div>
                    <div class="col col-mb-12 col-7">
                        <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                        <input class="input" type="text" name="captcha_word" maxlength="50" value="" size="13" />
                    </div>
                </div>
                <div class="content form-control">
                    <div class="col col-mb-12 col-5 form-label">
                    </div>
                    <div class="col col-mb-12 col-7">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
                    </div>
                </div>
            <? } ?>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="btn" type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
                </div>
            </div>

            <hr>

            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <p><a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
                </div>
            </div>

        </form>
    </noindex>
    <script type="text/javascript">
        document.bform.USER_NAME.focus();
    </script>

<?endif?>