<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->AddHeadScript($this->GetFolder() . '/script.js');
?>
<?=ShowError($arResult["ERROR_MESSAGE"]);?>


<? if (!empty($arResult["TICKET"])) { ?>
    <? if (!empty($arResult["ONLINE"])) { ?>
        <div class="col-margin-bottom">
            <strong><?=GetMessage("SUP_SOURCE")." / ".GetMessage("SUP_FROM")?>:</strong>

            <?if (strlen($arResult["TICKET"]["SOURCE_NAME"])>0):?>
                [<?=$arResult["TICKET"]["SOURCE_NAME"]?>]
            <?else:?>
                [web]
            <?endif?>

            <?if (strlen($arResult["TICKET"]["OWNER_SID"])>0):?>
                <?=$arResult["TICKET"]["OWNER_SID"]?>
            <?endif?>

            <?if (intval($arResult["TICKET"]["OWNER_USER_ID"])>0):?>
                [<?=$arResult["TICKET"]["OWNER_USER_ID"]?>]
                (<?=$arResult["TICKET"]["OWNER_LOGIN"]?>)
                <?=$arResult["TICKET"]["OWNER_NAME"]?>
            <?endif?>

            <br/>
            <strong><?=GetMessage("SUP_CREATE")?>:</strong> <?=$arResult["TICKET"]["DATE_CREATE"]?>

            <?if (strlen($arResult["TICKET"]["CREATED_MODULE_NAME"])<=0 || $arResult["TICKET"]["CREATED_MODULE_NAME"]=="support"):?>
                [<?=$arResult["TICKET"]["CREATED_USER_ID"]?>]
                (<?=$arResult["TICKET"]["CREATED_LOGIN"]?>)
                <?=$arResult["TICKET"]["CREATED_NAME"]?>
            <?else:?>
                <?=$arResult["TICKET"]["CREATED_MODULE_NAME"]?>
            <?endif?>

            <?if ($arResult["TICKET"]["DATE_CREATE"]!=$arResult["TICKET"]["TIMESTAMP_X"]):?>
                <br/>
                    <strong><?=GetMessage("SUP_TIMESTAMP")?>:</strong> <?=$arResult["TICKET"]["TIMESTAMP_X"]?>

                    <?if (strlen($arResult["TICKET"]["MODIFIED_MODULE_NAME"])<=0 || $arResult["TICKET"]["MODIFIED_MODULE_NAME"]=="support"):?>
                        [<?=$arResult["TICKET"]["MODIFIED_USER_ID"]?>]
                        (<?=$arResult["TICKET"]["MODIFIED_BY_LOGIN"]?>)
                        <?=$arResult["TICKET"]["MODIFIED_BY_NAME"]?>
                    <?else:?>
                        <?=$arResult["TICKET"]["MODIFIED_MODULE_NAME"]?>
                    <?endif?>
            <?endif?>


            <? if (strlen($arResult["TICKET"]["DATE_CLOSE"])>0): ?>
                <br/><strong><?=GetMessage("SUP_CLOSE")?>:</strong> <?=$arResult["TICKET"]["DATE_CLOSE"]?>
            <?endif?>


            <?if (strlen($arResult["TICKET"]["STATUS_NAME"])>0) :?>
                <br/><strong><?=GetMessage("SUP_STATUS")?>:</strong> <span title="<?=$arResult["TICKET"]["STATUS_DESC"]?>"><?=$arResult["TICKET"]["STATUS_NAME"]?></span>
            <?endif;?>


            <?if (strlen($arResult["TICKET"]["CATEGORY_NAME"]) > 0):?>
                <br/><strong><?=GetMessage("SUP_CATEGORY")?>:</strong> <span title="<?=$arResult["TICKET"]["CATEGORY_DESC"]?>"><?=$arResult["TICKET"]["CATEGORY_NAME"]?></span>
            <?endif?>


            <?if(strlen($arResult["TICKET"]["CRITICALITY_NAME"])>0) :?>
                <br/><strong><?=GetMessage("SUP_CRITICALITY")?>:</strong> <span title="<?=$arResult["TICKET"]["CRITICALITY_DESC"]?>"><?=$arResult["TICKET"]["CRITICALITY_NAME"]?></span>
            <?endif?>


            <?if (intval($arResult["RESPONSIBLE_USER_ID"])>0):?>
                <br/><strong><?=GetMessage("SUP_RESPONSIBLE")?>:</strong> [<?=$arResult["TICKET"]["RESPONSIBLE_USER_ID"]?>]
                (<?=$arResult["TICKET"]["RESPONSIBLE_LOGIN"]?>) <?=$arResult["TICKET"]["RESPONSIBLE_NAME"]?>
            <?endif?>


            <?if (strlen($arResult["TICKET"]["SLA_NAME"])>0) :?>
                <br/>
                <strong><?=GetMessage("SUP_SLA")?>:</strong>
                <span title="<?=$arResult["TICKET"]["SLA_NAME"]?>"><?=$arResult["TICKET"]["SLA_NAME"]?></span>
            <?endif?>
        </div>
    <? } ?>

    <? foreach ($arResult["MESSAGES"] as $i => $arMessage) { ?>
        <div class="white-box padding-box<?echo $i != 0 ? " col-margin" : ""?>">
            <p>
                <b><?echo $arMessage["DATE_CREATE"]?></b>
                <?=$arMessage["OWNER_SID"]?>

                <? if (intval($arMessage["OWNER_USER_ID"])>0) { ?>
                    [<?=$arMessage["OWNER_USER_ID"]?>]
                    (<?=$arMessage["OWNER_LOGIN"]?>)
                    <?=$arMessage["OWNER_NAME"]?>
                <? } ?>
            </p>
            <hr>
            <?echo $arMessage["MESSAGE"]?>

            <? if (count($arMessage["FILES"]) > 0) { ?>
                <h6><?=GetMessage("SUP_ATTACHMENTS")?></h6>
                <ul>
                <? foreach ($arMessage["FILES"] as $arFile) { ?>
                    <li><a title="<?=str_replace("#FILE_NAME#", $arFile["NAME"], GetMessage("SUP_DOWNLOAD_ALT"))?>" href="<?=$componentPath?>/ticket_show_file.php?hash=<?=$arFile["HASH"]?>&amp;lang=<?=LANG?>&amp;action=download"><?echo $arFile["NAME"]?> (<?echo Bitrix\GosSite\Tools::readableFileSize($arFile["FILE_SIZE"])?>)</a></li>
                <? } ?>
                </ul>
            <? } ?>
        </div>
    <? } ?>

    <?=$arResult["NAV_STRING"]?>
<? } ?>

<div class="white-box padding-box col-margin">
    <form name="support_edit" method="post" action="<?=$APPLICATION->GetCurPageParam()?>" enctype="multipart/form-data">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="set_default" value="Y" />
        <input type="hidden" name="ID" value=<?=(empty($arResult["TICKET"]) ? 0 : $arResult["TICKET"]["ID"])?> />
        <input type="hidden" name="lang" value="<?=LANG?>" />

        <? if (strlen($arResult["TICKET"]["DATE_CLOSE"]) <= 0) { ?>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("SUP_MESSAGE")?><span class="required">*</span>:
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input" type="button" accesskey="b" value="<?=GetMessage("SUP_B")?>" onClick="insert_tag('B', document.forms['support_edit'].elements['MESSAGE'])"  name="B" title="<?=GetMessage("SUP_B_ALT")?> (alt + b)" />
                    <input class="input" type="button" accesskey="i" value="<?=GetMessage("SUP_I")?>" onClick="insert_tag('I', document.forms['support_edit'].elements['MESSAGE'])" name="I" title="<?=GetMessage("SUP_I_ALT")?> (alt + i)" />
                    <input class="input" type="button" accesskey="u" value="<?=GetMessage("SUP_U")?>" onClick="insert_tag('U', document.forms['support_edit'].elements['MESSAGE'])" name="U" title="<?=GetMessage("SUP_U_ALT")?> (alt + u)" />
                    <input class="input" type="button" accesskey="q" value="<?=GetMessage("SUP_QUOTE")?>" onClick="insert_tag('QUOTE', document.forms['support_edit'].elements['MESSAGE'])" name="QUOTE" title="<?=GetMessage("SUP_QUOTE_ALT")?> (alt + q)" />
                    <input class="input" type="button" accesskey="c" value="<?=GetMessage("SUP_CODE")?>" onClick="insert_tag('CODE', document.forms['support_edit'].elements['MESSAGE'])" name="CODE" title="<?=GetMessage("SUP_CODE_ALT")?> (alt + c)" />
                    <? if (LANG == "ru") { ?>
                        <input class="input" type="button" accesskey="t" value="<?=GetMessage("SUP_TRANSLIT")?>" onClick="translit(document.forms['support_edit'].elements['MESSAGE'])" name="TRANSLIT" title="<?=GetMessage("SUP_TRANSLIT_ALT")?> (alt + t)" />
                    <? } ?>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <textarea name="MESSAGE" id="MESSAGE" rows="8" class="input input-block"><?=htmlspecialchars($_REQUEST["MESSAGE"])?></textarea>
                </div>
            </div>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("SUP_ATTACH")?> (не более - <?=Bitrix\Gossite\Tools::readableFileSize($arResult["OPTIONS"]["MAX_FILESIZE"], 0, true)?>):
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?=($arResult["OPTIONS"]["MAX_FILESIZE"]*1024)?>">
                </div>
                <div class="col col-mb-12 col-7">
                    <input class="input input-block" name="FILE_0" size="30" type="file" /> <br />
                    <input class="input input-block" name="FILE_1" size="30" type="file" /> <br />
                    <input class="input input-block" name="FILE_2" size="30" type="file" /> <br />
                    <span id="files_table_2"></span>
                    <input class="input input-block" type="button" value="<?=GetMessage("SUP_MORE")?>" OnClick="AddFileInput('<?=GetMessage("SUP_MORE")?>')" />
                    <input type="hidden" name="files_counter" id="files_counter" value="2" />
                </div>
            </div>
        <? } ?>


        <div class="content form-control">
            <div class="col col-mb-12 col-5 form-label">
                <?=GetMessage("SUP_CRITICALITY")?>:
            </div>
            <div class="col col-mb-12 col-7">
                <?
                if (empty($arResult["TICKET"]) || strlen($arResult["ERROR_MESSAGE"]) > 0 )
                {
                    if (strlen($arResult["DICTIONARY"]["CRITICALITY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
                        $criticality = $arResult["DICTIONARY"]["CRITICALITY_DEFAULT"];
                    else
                        $criticality = htmlspecialchars($_REQUEST["CRITICALITY_ID"]);
                }
                else
                    $criticality = $arResult["TICKET"]["CRITICALITY_ID"];
                ?>
                <select data-search="false" class="styler input-block" name="CRITICALITY_ID" id="CRITICALITY_ID">
                    <option value="">&nbsp;</option>
                    <?foreach ($arResult["DICTIONARY"]["CRITICALITY"] as $value => $option):?>
                        <option value="<?=$value?>" <?if($criticality == $value):?>selected="selected"<?endif?>><?=$option?></option>
                    <?endforeach?>
                </select>
            </div>
        </div>

        <? if (empty($arResult["TICKET"])) { ?>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("SUP_CATEGORY")?>:
                </div>
                <div class="col col-mb-12 col-7">
                    <?
                    if (strlen($arResult["DICTIONARY"]["CATEGORY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
                        $category = $arResult["DICTIONARY"]["CATEGORY_DEFAULT"];
                    else
                        $category = htmlspecialchars($_REQUEST["CATEGORY_ID"]);
                    ?>
                    <select data-search="false" class="styler input-block" data-search="false" name="CATEGORY_ID" id="CATEGORY_ID">
                        <option value="">&nbsp;</option>
                        <?foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option):?>
                            <option value="<?=$value?>" <?if($category == $value):?>selected="selected"<?endif?>><?=$option?></option>
                        <?endforeach?>
                    </select>
                </div>
            </div>
        <? } else { ?>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                    <?=GetMessage("SUP_MARK")?>:
                </div>
                <div class="col col-mb-12 col-7">
                    <?$mark = (strlen($arResult["ERROR_MESSAGE"]) > 0 ? htmlspecialchars($_REQUEST["MARK_ID"]) : $arResult["TICKET"]["MARK_ID"]);?>
                    <select data-search="false" class="styler input-block" name="MARK_ID" id="MARK_ID">
                        <option value="">&nbsp;</option>
                        <?foreach ($arResult["DICTIONARY"]["MARK"] as $value => $option):?>
                            <option value="<?=$value?>" <?if($mark == $value):?>selected="selected"<?endif?>><?=$option?></option>
                        <?endforeach?>
                    </select>
                </div>
            </div>
        <? } ?>

        <?if (strlen($arResult["TICKET"]["DATE_CLOSE"])<=0):?>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <input type="checkbox" name="CLOSE" value="Y" <?if($arResult["TICKET"]["CLOSE"] == "Y"):?>checked="checked" <?endif?>/> &nbsp;<?=GetMessage("SUP_CLOSE_TICKET")?>
                </div>
            </div>
        <?else:?>
            <div class="content form-control">
                <div class="col col-mb-12 col-5 form-label">
                </div>
                <div class="col col-mb-12 col-7">
                    <input type="checkbox" name="OPEN" value="Y" <?if($arResult["TICKET"]["OPEN"] == "Y"):?>checked="checked" <?endif?>/> &nbsp;<?=GetMessage("SUP_OPEN_TICKET")?>
                </div>
            </div>
        <?endif;?>
    </form>
</div>



<!--
	<?if (strlen($arResult["TICKET"]["DATE_CLOSE"]) <= 0):?>
	<tr>
		<td class="field-name"><span class="starrequired">*</span><?=GetMessage("SUP_MESSAGE")?>:</td>
		<td>
			<input type="button" accesskey="b" value="<?=GetMessage("SUP_B")?>" onClick="insert_tag('B', document.forms['support_edit'].elements['MESSAGE'])"  name="B" title="<?=GetMessage("SUP_B_ALT")?> (alt + b)" />
			<input type="button" accesskey="i" value="<?=GetMessage("SUP_I")?>" onClick="insert_tag('I', document.forms['support_edit'].elements['MESSAGE'])" name="I" title="<?=GetMessage("SUP_I_ALT")?> (alt + i)" />
			<input type="button" accesskey="u" value="<?=GetMessage("SUP_U")?>" onClick="insert_tag('U', document.forms['support_edit'].elements['MESSAGE'])" name="U" title="<?=GetMessage("SUP_U_ALT")?> (alt + u)" />
			<input type="button" accesskey="q" value="<?=GetMessage("SUP_QUOTE")?>" onClick="insert_tag('QUOTE', document.forms['support_edit'].elements['MESSAGE'])" name="QUOTE" title="<?=GetMessage("SUP_QUOTE_ALT")?> (alt + q)" />
			<input type="button" accesskey="c" value="<?=GetMessage("SUP_CODE")?>" onClick="insert_tag('CODE', document.forms['support_edit'].elements['MESSAGE'])" name="CODE" title="<?=GetMessage("SUP_CODE_ALT")?> (alt + c)" />
			<?if (LANG == "ru"):?>
			<input type="button" accesskey="t" value="<?=GetMessage("SUP_TRANSLIT")?>" onClick="translit(document.forms['support_edit'].elements['MESSAGE'])" name="TRANSLIT" title="<?=GetMessage("SUP_TRANSLIT_ALT")?> (alt + t)" />
			<?endif?>
		</td>
	</tr>

	<tr>
		<td></td>
		<td><textarea name="MESSAGE" id="MESSAGE" rows="20" cols="45" wrap="virtual"><?=htmlspecialchars($_REQUEST["MESSAGE"])?></textarea></td>
	</tr>


	<tr>
		<td class="field-name">
			<?=GetMessage("SUP_ATTACH")?><br />
			(max - <?=$arResult["OPTIONS"]["MAX_FILESIZE"]?> <?=GetMessage("SUP_KB")?>):
			<input type="hidden" name="MAX_FILE_SIZE" value="<?=($arResult["OPTIONS"]["MAX_FILESIZE"]*1024)?>">
		</td>
			<td>
				<input name="FILE_0" size="30" type="file" /> <br />
				<input name="FILE_1" size="30" type="file" /> <br />
				<input name="FILE_2" size="30" type="file" /> <br />
				<span id="files_table_2"></span>
				<input type="button" value="<?=GetMessage("SUP_MORE")?>" OnClick="AddFileInput('<?=GetMessage("SUP_MORE")?>')" />
				<input type="hidden" name="files_counter" id="files_counter" value="2" />
			</td>
	</tr>
	<?endif?>

	
	<tr>
		<td class="field-name"><?=GetMessage("SUP_CRITICALITY")?>:</td>
		<td>
			<?
			if (empty($arResult["TICKET"]) || strlen($arResult["ERROR_MESSAGE"]) > 0 )
			{
				if (strlen($arResult["DICTIONARY"]["CRITICALITY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
					$criticality = $arResult["DICTIONARY"]["CRITICALITY_DEFAULT"];
				else
					$criticality = htmlspecialchars($_REQUEST["CRITICALITY_ID"]);
			}
			else
				$criticality = $arResult["TICKET"]["CRITICALITY_ID"];
			?>
			<select name="CRITICALITY_ID" id="CRITICALITY_ID">
				<option value="">&nbsp;</option>
			<?foreach ($arResult["DICTIONARY"]["CRITICALITY"] as $value => $option):?>
				<option value="<?=$value?>" <?if($criticality == $value):?>selected="selected"<?endif?>><?=$option?></option>
			<?endforeach?>
			</select>
		</td>
	</tr>

	<?if (empty($arResult["TICKET"])):?>
	<tr>
		<td class="field-name"><?=GetMessage("SUP_CATEGORY")?>:</td>
		<td>
			<?
			if (strlen($arResult["DICTIONARY"]["CATEGORY_DEFAULT"]) > 0 && strlen($arResult["ERROR_MESSAGE"]) <= 0)
				$category = $arResult["DICTIONARY"]["CATEGORY_DEFAULT"];
			else
				$category = htmlspecialchars($_REQUEST["CATEGORY_ID"]);
			?>
			<select name="CATEGORY_ID" id="CATEGORY_ID">
				<option value="">&nbsp;</option>
			<?foreach ($arResult["DICTIONARY"]["CATEGORY"] as $value => $option):?>
				<option value="<?=$value?>" <?if($category == $value):?>selected="selected"<?endif?>><?=$option?></option>
			<?endforeach?>
			</select>
		</td>
	</tr>
	<?else:?>
	<tr>
		<td class="field-name"><?=GetMessage("SUP_MARK")?>:</td>
		<td>
			<?$mark = (strlen($arResult["ERROR_MESSAGE"]) > 0 ? htmlspecialchars($_REQUEST["MARK_ID"]) : $arResult["TICKET"]["MARK_ID"]);?>
			<select name="MARK_ID" id="MARK_ID">
				<option value="">&nbsp;</option>
			<?foreach ($arResult["DICTIONARY"]["MARK"] as $value => $option):?>
				<option value="<?=$value?>" <?if($mark == $value):?>selected="selected"<?endif?>><?=$option?></option>
			<?endforeach?>
			</select>
		</td>
	</tr>
	<?endif?>



	<?if (strlen($arResult["TICKET"]["DATE_CLOSE"])<=0):?>
	<tr>
		<td class="field-name"><?=GetMessage("SUP_CLOSE_TICKET")?>:</td>
		<td><input type="checkbox" name="CLOSE" value="Y" <?if($arResult["TICKET"]["CLOSE"] == "Y"):?>checked="checked" <?endif?>/>
		</td>
	</tr>
	<?else:?>
	<tr>
		<td  class="field-name"><?=GetMessage("SUP_OPEN_TICKET")?>:</td>
		<td><input type="checkbox" name="OPEN" value="Y" <?if($arResult["TICKET"]["OPEN"] == "Y"):?>checked="checked" <?endif?>/>
		</td>
	</tr>
	<?endif;?>
	<?if ($arParams['SHOW_COUPON_FIELD'] == 'Y' && $arParams['ID'] <= 0){?>
	<tr>
		<td  class="field-name"><?=GetMessage("SUP_COUPON")?>:</td>
		<td><input type="text" name="COUPON" value="<?=htmlspecialchars($_REQUEST["COUPON"])?>" size="48" maxlength="255" />
		</td>
	</tr>
	<?}?>
	</tbody>
</table>
<br />
<input type="submit" name="save" value="<?=GetMessage("SUP_SAVE")?>" />&nbsp;
<input type="submit" name="apply" value=<?=GetMessage("SUP_APPLY")?> />&nbsp;
<input type="reset" value="<?=GetMessage("SUP_RESET")?>" />
<input type="hidden" value="Y" name="apply" />  -->

