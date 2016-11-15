<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>

<table cellspacing="0" class="support-ticket-list data-table">
	
	<tr>
		<th>
			<?=GetMessage("SUP_TIMESTAMP")?><?=SortingEx("s_timestamp")?><br />
		</th>
		<th>
			<?=GetMessage("SUP_TITLE")?>
		</th>

		<th>
			<?=GetMessage("SUP_STATUS")?><br />
		</th>
	</tr>

	<?foreach ($arResult["TICKETS"] as $arTicket):?>
	<tr>
		
		
		<td>
			<?=$arTicket["DATE_CREATE"]?><br />

			<?if (strlen($arTicket["MODIFIED_MODULE_NAME"])<=0 || $arTicket["MODIFIED_MODULE_NAME"]=="support"):?>
      
			[&nbsp;<a href="<?=$arTicket["TICKET_EDIT_URL"]?>" title="<?=GetMessage("SUP_EDIT_TICKET")?>"><?=GetMessage("SUP_EDIT")?></a>&nbsp;]
			<?else:?>
				<?=$arTicket["MODIFIED_MODULE_NAME"]?>
			<?endif?>

		</td>

		<td>
			<?=$arTicket["TITLE"]?>
		</td>


<?$arFilter = Array(
	"NAME" => $arTicket["STATUS_NAME"],
);

//сортировка задется через переменные
$by = "s_id";
$sort = "asc";

//отбор и вывод
$rsStatus = CTicketDictionary::GetList($by, $sort, $arFilter, $is_filtered); 
while($arRes = $rsStatus->GetNext()) {
	$sid=$arRes["SID"];
}?>


		<td class="support-lamp-<?=$sid?>">


		<?if (strlen($arTicket["STATUS_NAME"])>0):?>
			<?=$arTicket["STATUS_NAME"]?>
		<? endif; ?>
		
		</td>
	</tr>
	<?endforeach?>


	
	<tr>
		<th colspan="6"><?=GetMessage("SUP_TOTAL")?>: <?=$arResult["TICKETS_COUNT"]?></th>
	</tr>
</table>

<?if (strlen($arResult["NAV_STRING"]) > 0):?>
	<br /><?=$arResult["NAV_STRING"]?><br />
<?endif?>
