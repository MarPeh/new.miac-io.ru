<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table class="table table-striped table-responsive">

    <tr>
        <th><?=GetMessage("SUP_CREATED")?><?=SortingEx("s_date_create")?></th>
        <th><?=GetMessage("SUP_TIMESTAMP")?><?=SortingEx("s_timestamp")?></th>
        <th><?=GetMessage("SUP_TITLE")?><?=SortingEx("s_title")?></th>
        <th><?=GetMessage("SUP_STATUS")?><?=SortingEx("s_status")?></th>
    </tr>

    <? foreach ($arResult["TICKETS"] as $arTicket) { ?>
        <tr>
            <td><?=$arTicket["DATE_CREATE"]?></td>
            <td><?=$arTicket["TIMESTAMP_X"]?></td>
            <td>
                <? if (strlen($arTicket["MODIFIED_MODULE_NAME"]) <= 0 || $arTicket["MODIFIED_MODULE_NAME"]=="support") { ?>
                    <a href="<?=$arTicket["TICKET_EDIT_URL"]?>" title="<?=GetMessage("SUP_EDIT_TICKET")?>"><?=$arTicket["TITLE"]?></a>
                <? } else { ?>
                    <?=$arTicket["TITLE"]?>
                <? } ?>
            </td>
            <td class="support-lamp-<?=$arTicket["STATUS_ID"]?>">
                <? if (strlen($arTicket["STATUS_NAME"])>0) { ?>
                    <?=$arTicket["STATUS_NAME"]?>
                <? } ?>
            </td>
        </tr>
    <? } ?>
    <tr>
        <th colspan="4"><?=GetMessage("SUP_TOTAL")?>: <?=$arResult["TICKETS_COUNT"]?></th>
    </tr>
</table>

<?=$arResult["NAV_STRING"]?>