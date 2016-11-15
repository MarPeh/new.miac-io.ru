<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?
if (!function_exists('show_sub_struc')) {
	function show_sub_struc($sub_str,$obj,$apl,$arParams)
	{
		
		if (is_array($sub_str))
		{
			foreach ($sub_str as $pkey=>$pvalue)
			{
				echo '<div class="strct_item"></div>';
				
				$obj->AddEditAction('sec_'.$pvalue['ID'], $pvalue['BUTTONS']['edit_section']['ACTION_URL'], $pvalue['BUTTONS']['edit_section']['TITLE']);
				$obj->AddDeleteAction('sec_'.$pvalue['ID'], $pvalue['BUTTONS']['delete_section']['ACTION_URL'], $pvalue['BUTTONS']['delete_section']['TITLE'], array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
				if (((is_array($pvalue['users'])) and (count($pvalue['users'])>0)) or ((is_array($pvalue['sub_struct'])) and (count($pvalue['sub_struct'])>0)))
				{			
					echo '<h2 id="'.$obj->GetEditAreaId('sec_'.$pvalue['ID']).'">';
					echo '<span>'.$pvalue['NAME'].'</span>';
					echo '</h2>';
				}
				echo '<ul class="leadersLine leaderOther">';
				foreach ($pvalue['users'] as $ukey=>$uvalue)
				{
				echo '<li>';
					$apl->IncludeComponent(
					'gosportal:system.person',
					'leaders',
						array(
							'USER' => $uvalue,
							'USER_PROPERTY' => $arParams['USER_PROPERTY'],
							'PM_URL' => $arParams['PM_URL'],
							'STRUCTURE_PAGE' => $arParams['STRUCTURE_PAGE'],
							'STRUCTURE_FILTER' => $arParams['STRUCTURE_FILTER'],
							'USER_PROP' => $arResult['USER_PROP'],
							'NAME_TEMPLATE' => $arParams['NAME_TEMPLATE'],
							'SHOW_LOGIN' => $arParams['SHOW_LOGIN'],
							'LIST_OBJECT' => $arParams['LIST_OBJECT'],
							'SHOW_FIELDS_TOOLTIP' => $arParams['SHOW_FIELDS_TOOLTIP'],
							'USER_PROPERTY_TOOLTIP' => $arParams['USER_PROPERTY_TOOLTIP'],
							"DATE_FORMAT" => $arParams["DATE_FORMAT"],
							"DATE_FORMAT_NO_YEAR" => $arParams["DATE_FORMAT_NO_YEAR"],
							"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
							"SHOW_YEAR" => $arParams["SHOW_YEAR"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
							"PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
							"SHEDULES_BLOCK"=>$arParams["SHEDULES_BLOCK"],
							"SRVICES_BLOCK"=>$arParams["SRVICES_BLOCK"],
							"SHOW_SERVICES"=>$arParams["SHOW_SERVICES"],
							'USER_INFO_LINK'=>'/employees/personal_info.php',
						),
						null,
						array('HIDE_ICONS' => 'Y')
					);
				
				echo '</li>';
				}
				
				echo '</ul>';
				show_sub_struc($pvalue['sub_struct'],$obj,$apl,$arParams);
			}
		}
		else
		{ 
			return false;
		}
	}
}

?>

<div class="leaders">

<?foreach($arResult as $arItem):?>
	<?
		foreach ($arItem['PODR'] as $pkey=>$pvalue)
		{
			echo '<div class="strct_item"></div>';
			$this->AddEditAction('sec_'.$pvalue['ID'], $pvalue['BUTTONS']['edit_section']['ACTION_URL'], $pvalue['BUTTONS']['edit_section']['TITLE']);
			$this->AddDeleteAction('sec_'.$pvalue['ID'], $pvalue['BUTTONS']['delete_section']['ACTION_URL'], $pvalue['BUTTONS']['delete_section']['TITLE'], array("CONFIRM" => GetMessage('CT_BNL_SECTION_DELETE_CONFIRM')));
			if (((is_array($pvalue['users'])) and (count($pvalue['users'])>0)) or ((is_array($pvalue['sub_struct'])) and (count($pvalue['sub_struct'])>0)))
			{
			?>
						
			<h2 id="<?=$this->GetEditAreaId('sec_'.$pvalue['ID']);?>">
				<span><? echo$pvalue['NAME'];?></span>
			</h2>
			
			<?
			}?>
			<ul class="leadersLine leaderOther">
			<?
			foreach ($pvalue['users'] as $ukey=>$uvalue)
			{
			?>
				<li>
				<?
					$APPLICATION->IncludeComponent(
					'gosportal:system.person',
					'leaders',
					array(
						'USER' => $uvalue,
						'USER_PROPERTY' => $arParams['USER_PROPERTY'],
						'PM_URL' => $arParams['PM_URL'],
						'STRUCTURE_PAGE' => $arParams['STRUCTURE_PAGE'],
						'STRUCTURE_FILTER' => $arParams['STRUCTURE_FILTER'],
						'USER_PROP' => $arResult['USER_PROP'],
						'NAME_TEMPLATE' => $arParams['NAME_TEMPLATE'],
						'SHOW_LOGIN' => $arParams['SHOW_LOGIN'],
						'LIST_OBJECT' => $arParams['LIST_OBJECT'],
						'SHOW_FIELDS_TOOLTIP' => $arParams['SHOW_FIELDS_TOOLTIP'],
						'USER_PROPERTY_TOOLTIP' => $arParams['USER_PROPERTY_TOOLTIP'],
						"DATE_FORMAT" => $arParams["DATE_FORMAT"],
						"DATE_FORMAT_NO_YEAR" => $arParams["DATE_FORMAT_NO_YEAR"],
						"DATE_TIME_FORMAT" => $arParams["DATE_TIME_FORMAT"],
						"SHOW_YEAR" => $arParams["SHOW_YEAR"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"PATH_TO_CONPANY_DEPARTMENT" => $arParams["~PATH_TO_CONPANY_DEPARTMENT"],
						"PATH_TO_VIDEO_CALL" => $arParams["~PATH_TO_VIDEO_CALL"],
						"SHEDULES_BLOCK"=>$arParams["SHEDULES_BLOCK"],
						"SRVICES_BLOCK"=>$arParams["SRVICES_BLOCK"],
						"SHOW_SERVICES"=>$arParams["SHOW_SERVICES"],
						'USER_INFO_LINK'=>'/employees/personal_info.php',
						),
						null,
						array('HIDE_ICONS' => 'Y')
					);
					
				?>
					
				</li>
			<?}
			?>
				</ul>
			<?
			if ((is_array($pvalue['sub_struct']))and (count($pvalue['sub_struct'])>0))
			{
				show_sub_struc($pvalue['sub_struct'],$this,$APPLICATION,$arParams);
			}
		} 
	?>		

<?endforeach;?>
</div>
<div class="strct_item"></div>
<?if ((is_array($arResult['FREE_USERS']))and (count($arResult['FREE_USERS'])>0))
{?>
<div class="">
<a class="sect_capt" href="javascript:showusers('usr_free')"> <img style="padding:3px 0 0 0" src='/bitrix/images/sitemedicine_ext/down.png'> <?=GetMessage("T_FREE_USERS")?></a>
</div>
<div class="edit_users"  id="usr_free">

</div>
<?}?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
