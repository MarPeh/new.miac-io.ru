<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<? if (is_array($arParams["~AUTH_RESULT"])) { ?>
    <p class="alert <?echo $arParams["~AUTH_RESULT"]["TYPE"] != "ERROR" ? "alert-success" : "alert-error" ?>"><?echo $arParams["~AUTH_RESULT"]["MESSAGE"];?></p>
<? } ?>
<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <?
    if (strlen($arResult["BACKURL"]) > 0)
    {
        ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?
    }
    ?>
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="SEND_PWD">
    <p>
        <?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
    </p>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_LOGIN")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" />
        </div>
    </div>
    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
        </div>
        <div class="col col-mb-12 col-7">
            <?=GetMessage("AUTH_OR")?>
        </div>
    </div>
    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_EMAIL")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="email" name="USER_EMAIL" maxlength="255" />
        </div>
    </div>
    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
        </div>
        <div class="col col-mb-12 col-7">
            <input class="btn" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
        </div>
    </div>
    <hr>
    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
        </div>
        <div class="col col-mb-12 col-7">
            <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
        </div>
    </div>
</form>
<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>
