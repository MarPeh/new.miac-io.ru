<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame()->begin();
?>

<? if ($arResult['ERROR_MESSAGE']) { ?>
    <p class="alert alert-warning"><?echo $arResult['ERROR_MESSAGE'];?></p>
<? } ?>

<? if (is_array($arParams["~AUTH_RESULT"])) { ?>
    <p class="alert <?echo $arParams["~AUTH_RESULT"]["TYPE"] != "ERROR" ? "alert-success" : "alert-error" ?>"><?echo $arParams["~AUTH_RESULT"]["MESSAGE"];?></p>
<? } ?>

<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

    <input type="hidden" name="AUTH_FORM" value="Y" />
    <input type="hidden" name="TYPE" value="AUTH" />
    <? if (strlen($arResult["BACKURL"]) > 0) { ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <? } ?>
    <? foreach ($arResult["POST"] as $key => $value) { ?>
        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
    <? } ?>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_LOGIN")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" />
        </div>
    </div>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_PASSWORD")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
        </div>
    </div>

    <? if ($arResult["CAPTCHA_CODE"]) { ?>
        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
                <?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:
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

    <?if ($arResult["STORE_PASSWORD"] == "Y") { ?>
        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
            </div>
            <div class="col col-mb-12 col-7">
                <input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><label for="USER_REMEMBER">&nbsp; <?=GetMessage("AUTH_REMEMBER_ME")?></label>
            </div>
        </div>
    <? } ?>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
        </div>
        <div class="col col-mb-12 col-7">
            <input class="btn" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
        </div>
    </div>

    <? if ($arParams["NOT_SHOW_LINKS"] != "Y") { ?>
        <hr>
        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
            </div>
            <div class="col col-mb-12 col-7">
                <a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
            </div>
        </div>
    <? } ?>

    <? if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y") { ?>
        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
            </div>
            <div class="col col-mb-12 col-7">
                <a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a><br />
                <?=GetMessage("AUTH_FIRST_ONE")?>
            </div>
        </div>
    <? } ?>
</form>

<script type="text/javascript">
    <?if (strlen($arResult["LAST_LOGIN"])>0):?>
    try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
    <?else:?>
    try{document.form_auth.USER_LOGIN.focus();}catch(e){}
    <?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
    <?
    $APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
        array(
            "AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
            "CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
            "AUTH_URL" => $arResult["AUTH_URL"],
            "POST" => $arResult["POST"],
            "SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
            "FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
            "AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
        ),
        $component,
        array("HIDE_ICONS"=>"Y")
    );
    ?>
<?endif?>
<? $frame->end();?>
