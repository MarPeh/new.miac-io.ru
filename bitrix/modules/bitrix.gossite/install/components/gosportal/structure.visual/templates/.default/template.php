<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!function_exists('__intr_vis_get_div'))
{
	function __intr_vis_get_div($arEntry, $arUsers, $arParams)
	{
		global $APPLICATION;
	
		$bHasChildren = ($arEntry['DEPTH_LEVEL'] == $arParams['MAX_DEPTH']) && ($arEntry['RIGHT_MARGIN']-$arEntry['LEFT_MARGIN'] > 1);
		$bNoHint = false;
		
		$name = $arEntry['NAME'];
		if (strlen($name) > 70) $name = substr($name, 0, 67).'...';
		
?>
				<div class="bx-main<?=$bHasChildren ? '' : ' bx-no-bottom'?>">
					<div class="bx-left"></div>
					<div class="bx-right"></div>
					<div class="bx-center">
<?
			if (is_array($arEntry['PICTURE']) || $arEntry['DESCRIPTION']):
				$descr = '';
				if (is_array($arEntry['PICTURE'])) $descr .= '<div class="bx-hint-picture">'.$arEntry['PICTURE']['IMG'].'</div>';
				if ($arEntry['DESCRIPTION']) $descr .= '<div class="bx-hint-descr">'.($arEntry['DESCRIPTION_TYPE'] == 'html' ? $arEntry['DESCRIPTION'] : htmlspecialchars($arEntry['DESCRIPTION'])).'</div>';
?>
						<div class="bx-hint"><img src="/bitrix/images/1.gif" height="14" width="14" border="0" onload="new BXHint('<?=htmlspecialchars(CUtil::JSEscape($descr))?>', this)" /></div>
<?
			else:
				$bNoHint = true;
			endif;
?>
						<div class="bx-info<?=$bNoHint ? ' bx-no-margin' : ''?>">
							<div class="bx-name">
							<?if(strlen($arEntry['UF_LINK'])>0):?>
							<a href="<?echo htmlspecialchars($arEntry['UF_LINK'])?>"><?echo $name?></a>
							<?else:?>
							<?echo $name?>
							<?endif;?>
							</div>
						</div>
					</div>
				</div>
<?
		if ($bHasChildren):
?>
				<div class="bx-bottom" onmouseover="this.className='bx-bottom bx-bottom-selected'" onmouseout="this.className='bx-bottom'" onclick="__entry_onclick('<?=$arEntry['ID']?>', '<?=$arEntry['DEPTH_LEVEL']?>')" title="<?=htmlspecialchars(GetMessage('ISV_SHOW_SUBTREE'))?>">
					<div class="bx-left"></div>
					<div class="bx-right"></div>
					<div class="bx-center"><img src="/bitrix/components/bitrix/intranet.structure.visual/templates/.default/images/arr.png" height="3" width="5" /></div>
				</div><?
		endif;
	}
}

if ($arResult['__SKIP_ROOT'] != 'Y')
{
	$arEntry = array_shift($arResult['ENTRIES']);
?>
<script type="text/javascript">
function __entry_onclick(section, level)
{
	var obTable = document.getElementById('bx_str_level2_table');
	var obSection = document.getElementById('bx_str_' + section);
	
	var url = '<?=CUtil::JSEscape($APPLICATION->GetCurPageParam('mode=subtree&section=#SECTION#&level=#LEVEL#', array('section', 'level')));?>'.replace('#SECTION#', section). replace('#LEVEL#', level);
	
	level -= <?echo $arParams['MAX_DEPTH']-1?>;
	
	jsAjaxUtil.ShowLocalWaitWindow(111, obSection, false);
	jsAjaxUtil.LoadData(url, function (data) {
		jsAjaxUtil.CloseLocalWaitWindow(111, obSection, false);
		var obPos = jsAjaxUtil.GetRealPos(obSection);
		
		if (obSection.clone || obPos.left == 0) return;
		
		var _obSection = obSection.cloneNode(true);
		obSection.clone = _obSection;
		
		_obSection.className = 'bx-str-l1 bx-current';
		_obSection.style.position = 'absolute';
		_obSection.style.zIndex = 50 * level;
		
		_obSection.style.top = (obPos.top - 5) + 'px';
		_obSection.style.left = obPos.left + 'px';
		_obSection.style.width = (obPos.right - obPos.left) + 'px';
		_obSection.style.height = (obPos.bottom - obPos.top) + 'px';

		document.body.appendChild(_obSection);
		
		var overlay = document.body.appendChild(document.createElement("DIV"));
		overlay.style.position = 'absolute';
		overlay.style.top = '0px';
		overlay.style.left = '0px';
		overlay.style.zIndex = 45 * level;

		var windowSize = jsUtils.GetWindowScrollSize();

		overlay.style.width = windowSize.scrollWidth + "px";
		overlay.style.height = windowSize.scrollHeight + "px";

		var f_onrresize = function() {
			var windowSize = jsUtils.GetWindowScrollSize();
			overlay.style.width = windowSize.scrollWidth + "px";
		};
		
		jsUtils.addEvent(window, "resize", f_onrresize);
		
		var obDiv = document.body.appendChild(document.createElement('DIV'));
		obDiv.className = 'bx-str-result';
		obDiv.innerHTML = data;
		obDiv.style.position = 'absolute';
		obDiv.style.zIndex = 48 * level;
		
		obDiv.style.padding = "109px 20px 20px 20px";
		
		var obPosSelf = jsAjaxUtil.GetRealPos(obDiv);
		
		var obStick = document.body.appendChild(document.createElement('DIV'));
		obStick.className = 'bx-str-stick';
		obStick.style.zIndex = 49 * level;
		obStick.style.top = (obPos.bottom - 3) + 'px';
		obStick.style.left = parseInt((obPos.right+obPos.left)/2) + 'px';
		
		obDiv.style.top = (obPos.top - 20) + 'px';

		var left = parseInt(obPos.left + (obPos.right-obPos.left)/2 - (obPosSelf.right-obPosSelf.left)/2);
		if (left < 0) left = 20;
		if (left > obPos.left)
			left = obPos.left-30;

		obDiv.style.left = left + 'px';
		
		obPosSelf = jsAjaxUtil.GetRealPos(obDiv);
		if (obPosSelf.right < obPos.right + 10)
		{
			obDiv.style.width = (obPos.right + 10 - left) + 'px';
		}
		
		obDiv.innerHTML += '<div class="bx-dark">'
				+ '<div class="bx-dark-lefttop"></div><div class="bx-dark-righttop"></div><div class="bx-dark-top"></div>'
				+ '<div class="bx-dark-left"></div><div class="bx-dark-center"></div><div class="bx-dark-right"></div>'
				+ '<div class="bx-dark-leftbottom"></div><div class="bx-dark-rightbottom"></div><div class="bx-dark-bottom"></div>'
				+ '<div class="bx-dark-close" id="bx_dark_close"></div>'
			+ '</div>';
		
		var clicker = _obSection.lastChild;
		
		obDiv.lastChild.onclick = clicker.onclick = overlay.onclick = function() {
			obDiv.parentNode.removeChild(obDiv); obDiv = null;
			clicker = null;
			_obSection.parentNode.removeChild(_obSection); _obSection = null;
			jsUtils.removeEvent(window, "resize", f_onrresize);
			
			if (null != overlay)
				overlay.parentNode.removeChild(overlay); overlay = null;
			if (null != obStick)
			obStick.parentNode.removeChild(obStick); obStick = null;
			
			obSection.clone = null;
		};
	});
}

</script>
<table cellpadding="0" cellspacing="0" border="0" align="center" id="bx_str_level1_table">
	<tr>
		<td colspan="3" class="bx-str-top">
			<div class="bx-str-l1" id="bx_str_<?=$arEntry['ID']?>"><?__intr_vis_get_div($arEntry, $arResult['USERS'], $arParams)?></div>
		</td>
	</tr>
<?
}

$arEntries = array();
$arSubEntries = array();

$q = $arResult['__SKIP_ROOT'] != 'Y' ? 2 : 1;
foreach ($arResult['ENTRIES'] as $key => $arEntry)
{
	if ($arEntry['DEPTH_LEVEL']-$arParams['LEVEL'] > $q)
	{
		if (!isset($arSubEntries[$arEntry['IBLOCK_SECTION_ID']]))
			$arSubEntries[$arEntry['IBLOCK_SECTION_ID']] = array($arEntry);
		else
			$arSubEntries[$arEntry['IBLOCK_SECTION_ID']][] = $arEntry;
	}
	else
	{
		$arEntries[] = $arEntry;
	}
}

if (($cnt = count($arEntries)) > 0)
{
?>
<table cellpadding="0" cellspacing="0" border="0" align="center" id="bx_str_level<?=$arParams['LEVEL']+2?>_table">
	<tr class="bx-str-l2">
<?
	foreach ($arEntries as $key => $arEntry)
	{
		$bSingle = $cnt == 1;
		
		$bFirst = !$bSingle && ($key == 0);
		$bLast = !$bSingle && ($key == $cnt-1);
?>
		<td<?echo $bFirst ? ' class="bx-str-first"' : ($bLast ? ' class="bx-str-last"' : ($bSingle ? ' class="bx-str-single"' : ''))?>><div class="bx-str-l2" id="bx_str_<?=$arEntry['ID']?>"><?__intr_vis_get_div($arEntry, $arResult['USERS'], $arParams)?></div></td>
<?
	}
?>
	</tr><tr>
<?
	foreach ($arEntries as $key => $arEntry)
	{
?>
		<td valign="top">
<?
	if (isset($arSubEntries[$arEntry['ID']]))
	{
?>
			<table id="bx_str_children_<?=$arEntry['ID']?>" cellspacing="0" cellpadding="0" border="0">
<?
		$cnt1 = count($arSubEntries[$arEntry['ID']]);
		foreach ($arSubEntries[$arEntry['ID']] as $key => $arSubEntry)
		{
			$bLast = $key==$cnt1-1;
?>
				<tr class="bx-str-l3">
					<td class="bx-str-l3-connector<?=$bLast ? ' bx-str-last' : ''?>"><img src="/bitrix/images/1.gif" height="1" width="17" border="0" /></td>
					<td><div class="bx-str-l3" id="bx_str_<?=$arSubEntry['ID']?>"><?__intr_vis_get_div($arSubEntry, $arResult['USERS'], $arParams)?></div></td>
				</tr>
<?
		}
?>
			</table>
<?
	}
?>
		</td>
<?
	}
?>
	</tr>
</table>
<div id="test"></div>
<?
}
?>
