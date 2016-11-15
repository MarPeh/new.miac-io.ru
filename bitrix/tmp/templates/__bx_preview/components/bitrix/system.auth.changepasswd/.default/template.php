<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if (is_array($arParams["~AUTH_RESULT"])) { ?>
    <p class="alert <?echo $arParams["~AUTH_RESULT"]["TYPE"] != "ERROR" ? "alert-success" : "alert-error" ?>"><?echo $arParams["~AUTH_RESULT"]["MESSAGE"];?></p>
<? } ?>

<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
    <?if (strlen($arResult["BACKURL"]) > 0): ?>
        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
    <? endif ?>
    <input type="hidden" name="AUTH_FORM" value="Y">
    <input type="hidden" name="TYPE" value="CHANGE_PWD">


    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_LOGIN")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="bx-auth-input" />
        </div>
    </div>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_CHECKWORD")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="text" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="bx-auth-input" />
        </div>
    </div>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
        </div>
    </div>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
            <?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>
        </div>
        <div class="col col-mb-12 col-7">
            <input class="input" type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="bx-auth-input" autocomplete="off" />
        </div>
    </div>

    <div class="content form-control">
        <div class="col col-mb-12 col-5 form-label">
        </div>
        <div class="col col-mb-12 col-7">
            <input class="btn" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
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


    <p class="alert alert-info"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>

</form>

<script type="text/javascript">
    document.bform.USER_LOGIN.focus();
</script>