<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$arUser = $arParams['~USER'];
$name = CUser::FormatName($arParams['NAME_TEMPLATE'], $arUser, $arResult["bUseLogin"]);

$arUserData = array();
foreach ($arParams['USER_PROPERTY'] as $key) {
    if ($arUser[$key]) {
        $arUserData[$key] = $arUser[$key];
    }
}
?>
<?
if ($arUser['PERSONAL_PHOTO']) {
$rsFile = CFile::GetByID($arUser['PERSONAL_PHOTO']);
$arFile = $rsFile->Fetch();
if ($arFile) {
$wid = '100px';
$marg = '120px';
$img = '/upload/'.$arFile['SUBDIR'].'/'.$arFile['FILE_NAME'];
}
else {
$wid = '100px';
$img = '/bitrix/components/gosportal/staff.person/templates/.default/images/nopic_user_100_noborder.gif';
$marg = '120px';
}
}
else {
$wid = '100px';
$img = '/bitrix/components/gosportal/staff.person/templates/.default/images/nopic_user_100_noborder.gif';
$marg = '120px';
}
?>
<div class="content">
	<div class="col col-mb-5 col-5 equal" style="height: 175px;"><img alt="<?= GetMessage('ISL_FOTO') ?>" src="<?=$img?>">		</div>
	<div class="col col-mb-7 col-7 equal" style="height: 175px;">
		<div class="teacher-info">
			<h1 itemprop="fio" class="teacher-info-name"><?= CUser::FormatName($arParams['NAME_TEMPLATE'], $arUser, $arParams["SHOW_LOGIN"] != 'N'); ?></h1>
		</div>
	</div>
</div>
<table class="table table-striped teacher-table">
		<tbody>
		<?
		foreach ($arUserData as $key => $value):
		?>
			<tr>
		<?
			if ($value <> '') {
				echo '<td class="col col-mb-5 col-5 equal">',$arParams['USER_PROP'][$key] ? $arParams['USER_PROP'][$key] : GetMessage('ISL_'.$key),'</td>';
				switch ($key) {
					case 'PERSONAL_PHOTO':
						break;
					default:
						echo '<td itemprop="" class="col col-mb-7 col-7 equal">';
						if (substr($key, 0, 3) == 'UF_' && is_array($arResult['USER_PROP'][$key])) {
							$arResult['USER_PROP'][$key]['VALUE'] = $value;
							$APPLICATION->IncludeComponent(
								'bitrix:system.field.view',
								$arResult['USER_PROP'][$key]['USER_TYPE_ID'],
								array(
									'arUserField' => $arResult['USER_PROP'][$key],
								)
							);
						}
						else
							echo htmlspecialcharsbx($value);

						echo '</td>';
						break;
				}
			}
			?>
		</tr>
		<?endforeach;?>
		</tbody>
	</table>